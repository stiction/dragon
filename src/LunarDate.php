<?php

namespace Stiction\Dragon;

use DateTime;
use DateTimeZone;
use InvalidArgumentException;

/**
 * 农历计算
 * 支持公历时间范围：1900-01-31（含） - 2101-01-28（含）
 * 支持农历范围：1900年正月初一（含） - 2100年12月29日（含）
 */
class LunarDate
{
    const DATE_TIME_ZONE = 'Asia/Shanghai';

    const MIN_YEAR = 1900;
    const MAX_YEAR = 2100;

    const MIN_MONTH = 1;
    const MAX_MONTH = 12;

    const BIG_MONTH_DAYS = 30;
    const SMALL_MONTH_DAYS = 29;

    const SECONDS_PER_DAY = 3600 * 24;

    const FIRST_DAY = '1900-01-31';
    const LAST_DAY = '2101-01-28';

    protected $timestamp;
    protected $info = null;

    public function __construct(int $timestamp)
    {
        $this->timestamp = $timestamp;
        $this->parse();
    }

    public function info(): array
    {
        return $this->info;
    }

    /**
     * 转为公历
     */
    public static function toSolar(int $year, int $month, int $day, bool $leap = false): int
    {
        if ($year < self::MIN_YEAR || $year > self::MAX_YEAR) {
            throw new InvalidArgumentException("invalid $year $month $day $leap");
        }
        if ($month < self::MIN_MONTH || $month > self::MAX_MONTH) {
            throw new InvalidArgumentException("invalid $year $month $day $leap");
        }
        $yearInfo = self::yearInfo($year);
        if ($leap) {
            $leapMonth = $yearInfo['leap_month'];
            if ($leapMonth !== $month) {
                throw new InvalidArgumentException("invalid $year $month $day $leap");
            }
            $monthDays = $yearInfo['leap_month_days'];
        } else {
            $monthDays = $yearInfo[$month];
        }
        if ($day < 1 || $day > $monthDays) {
            throw new InvalidArgumentException("invalid $year $month $day $leap");
        }

        $days = 0;
        for ($y = self::MIN_YEAR; $y < $year; ++$y) {
            $yInfo = self::yearInfo($y);
            $days += $yInfo['total_days'];
        }
        $leapMonth = $yearInfo['leap_month'];
        if ($leapMonth && $leapMonth < $month) {
            $days += $yearInfo['leap_month_days'];
        }
        if ($leap) {
            $toMonth = $month;
        } else {
            $toMonth = $month - 1;
        }
        for ($m = self::MIN_MONTH; $m <= $toMonth; ++$m) {
            $days += $yearInfo[$m];
        }
        $days += $day - 1;
        $from = self::timestampForDate(self::FIRST_DAY);
        $timestamp = $from + self::SECONDS_PER_DAY * $days;
        $timestamp += 3600; // some time points are weird
        return $timestamp;
    }

    protected function parse()
    {
        $from = self::timestampForDate(self::FIRST_DAY);
        if ($this->timestamp < $from) {
            throw new InvalidArgumentException(self::FIRST_DAY . ' - ' . self::LAST_DAY);
        }
        $end = self::timestampForDate(self::LAST_DAY) + self::SECONDS_PER_DAY;
        if ($this->timestamp >= $end) {
            throw new InvalidArgumentException(self::FIRST_DAY . ' - ' . self::LAST_DAY);
        }

        $days = (int)round(($this->dayStartAt($this->timestamp) - $from) / self::SECONDS_PER_DAY);
        for ($year = self::MIN_YEAR; $year <= self::MAX_YEAR; $year += 1) {
            $info = self::yearInfo($year);
            if ($days >= $info['total_days']) {
                $days -= $info['total_days'];
            } else {
                break;
            }
        }

        $months = [];
        for ($month = self::MIN_MONTH; $month <= self::MAX_MONTH; $month += 1) {
            $months[$month] = [
                'month' => $month,
                'days' => $info[$month],
                'leap' => false,
            ];
        }
        $leapMonth = $info['leap_month'];
        if ($leapMonth) {
            $key = (string)($leapMonth + 0.5);
            $months[$key] = [
                'month' => $leapMonth,
                'days' => $info['leap_month_days'],
                'leap' => true,
            ];
        }
        ksort($months, SORT_NUMERIC);

        foreach ($months as $monthInfo) {
            if ($days >= $monthInfo['days']) {
                $days -= $monthInfo['days'];
            } else {
                $month = $monthInfo['month'];
                $day = $days + 1;
                $leap = $monthInfo['leap'];
                break;
            }
        }

        $this->info = [
            'year' => $year,
            'month' => $month,
            'day' => $day,
            'leap' => $leap,
        ];
    }

    protected function dayStartAt(int $timestamp): int
    {
        $date = new DateTime('@' . $timestamp);
        $date->setTimeZone(new DateTimeZone(self::DATE_TIME_ZONE));
        $date->setTime(0, 0, 0);
        return $date->getTimestamp();
    }

    protected static function timestampForDate(string $str): int
    {
        $date = DateTime::createFromFormat('Y-m-d H:i:s', $str . ' 00:00:00', new DateTimeZone(self::DATE_TIME_ZONE));
        return $date->getTimestamp();
    }

    protected static function yearInfo(int $year): array
    {
        $raw = self::yearRawInfo($year);
        $info = [];
        $info['leap_month'] = $raw & 0x0F;
        if ($info['leap_month']) {
            $info['leap_month_days'] = ($raw & 0x10000) ? self::BIG_MONTH_DAYS : self::SMALL_MONTH_DAYS;
        } else {
            $info['leap_month_days'] = 0;
        }
        for ($month = self::MIN_MONTH; $month <= self::MAX_MONTH; $month += 1) {
            $info[$month] = ($raw & (0x10000 >> $month)) ? self::BIG_MONTH_DAYS : self::SMALL_MONTH_DAYS;
        }

        $totalDays = $info['leap_month_days'];
        for ($month = self::MIN_MONTH; $month <= self::MAX_MONTH; $month += 1) {
            $totalDays += $info[$month];
        }
        $info['total_days'] = $totalDays;

        return $info;
    }

    protected static function yearRawInfo(int $year): int
    {
        $yearList = [
            0x04bd8, 0x04ae0, 0x0a570, 0x054d5, 0x0d260, 0x0d950, 0x16554, 0x056a0, 0x09ad0, 0x055d2,
            0x04ae0, 0x0a5b6, 0x0a4d0, 0x0d250, 0x1d255, 0x0b540, 0x0d6a0, 0x0ada2, 0x095b0, 0x14977,
            0x04970, 0x0a4b0, 0x0b4b5, 0x06a50, 0x06d40, 0x1ab54, 0x02b60, 0x09570, 0x052f2, 0x04970,
            0x06566, 0x0d4a0, 0x0ea50, 0x06e95, 0x05ad0, 0x02b60, 0x186e3, 0x092e0, 0x1c8d7, 0x0c950,
            0x0d4a0, 0x1d8a6, 0x0b550, 0x056a0, 0x1a5b4, 0x025d0, 0x092d0, 0x0d2b2, 0x0a950, 0x0b557,
            0x06ca0, 0x0b550, 0x15355, 0x04da0, 0x0a5b0, 0x14573, 0x052b0, 0x0a9a8, 0x0e950, 0x06aa0,
            0x0aea6, 0x0ab50, 0x04b60, 0x0aae4, 0x0a570, 0x05260, 0x0f263, 0x0d950, 0x05b57, 0x056a0,
            0x096d0, 0x04dd5, 0x04ad0, 0x0a4d0, 0x0d4d4, 0x0d250, 0x0d558, 0x0b540, 0x0b6a0, 0x195a6,
            0x095b0, 0x049b0, 0x0a974, 0x0a4b0, 0x0b27a, 0x06a50, 0x06d40, 0x0af46, 0x0ab60, 0x09570,
            0x04af5, 0x04970, 0x064b0, 0x074a3, 0x0ea50, 0x06b58, 0x055c0, 0x0ab60, 0x096d5, 0x092e0,
            0x0c960, 0x0d954, 0x0d4a0, 0x0da50, 0x07552, 0x056a0, 0x0abb7, 0x025d0, 0x092d0, 0x0cab5,
            0x0a950, 0x0b4a0, 0x0baa4, 0x0ad50, 0x055d9, 0x04ba0, 0x0a5b0, 0x15176, 0x052b0, 0x0a930,
            0x07954, 0x06aa0, 0x0ad50, 0x05b52, 0x04b60, 0x0a6e6, 0x0a4e0, 0x0d260, 0x0ea65, 0x0d530,
            0x05aa0, 0x076a3, 0x096d0, 0x04bd7, 0x04ad0, 0x0a4d0, 0x1d0b6, 0x0d250, 0x0d520, 0x0dd45,
            0x0b5a0, 0x056d0, 0x055b2, 0x049b0, 0x0a577, 0x0a4b0, 0x0aa50, 0x1b255, 0x06d20, 0x0ada0,
            0x14b63, 0x09370, 0x049f8, 0x04970, 0x064b0, 0x168a6, 0x0ea50, 0x06b20, 0x1a6c4, 0x0aae0,
            0x0a2e0, 0x0d2e3, 0x0c960, 0x0d557, 0x0d4a0, 0x0da50, 0x05d55, 0x056a0, 0x0a6d0, 0x055d4,
            0x052d0, 0x0a9b8, 0x0a950, 0x0b4a0, 0x0b6a6, 0x0ad50, 0x055a0, 0x0aba4, 0x0a5b0, 0x052b0,
            0x0b273, 0x06930, 0x07337, 0x06aa0, 0x0ad50, 0x14b55, 0x04b60, 0x0a570, 0x054e4, 0x0d160,
            0x0e968, 0x0d520, 0x0daa0, 0x16aa6, 0x056d0, 0x04ae0, 0x0a9d4, 0x0a2d0, 0x0d150, 0x0f252,
            0x0d520,
        ];
        return $yearList[$year - self::MIN_YEAR];
    }
}
