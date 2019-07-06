<?php

use PHPUnit\Framework\TestCase;
use Stiction\Dragon\LunarDate;

class LunarDateTest extends TestCase
{
    public function testInfoSuccess()
    {
        $items = $this->prepareItems();
        foreach ($items as $item) {
            $this->checkInfo($item['solar'], $item['info']);
        }
    }

    public function testInfoEarlier()
    {
        $this->expectException(InvalidArgumentException::class);
        $timestamp = $this->timestampForDate('1900-01-31') - 1;
        $date = new LunarDate($timestamp);
    }

    public function testInfoLater()
    {
        $this->expectException(InvalidArgumentException::class);
        $timestamp = $this->timestampForDate('2101-01-29');
        $date = new LunarDate($timestamp);
    }

    public function testToSolarSuccess()
    {
        $items = $this->prepareItems();
        foreach ($items as $item) {
            $this->checkToSolar($item['info'], $item['solar']);
        }
    }

    public function testToSolarInvalid()
    {
        $items = [
            [1899, 12, 1, false],
            [2101, 1, 1, false],
            [1999, 0, 3, false],
            [1999, 13, 3, false],
            [2020, 5, 3, true],
            [2019, 2, 3, true],
            [2019, 4, 30, true],
        ];
        $count = 0;
        foreach ($items as $item) {
            try {
                LunarDate::toSolar($item[0], $item[1], $item[2], $item[3]);
                $this->fail('should throws an InvalidArgumentException for inputs: '.implode(', ', $item));
            } catch (InvalidArgumentException $e) {
                $count += 1;
            }
        }
        $this->assertSame(count($items), $count);
    }

    protected function checkInfo(string $solar, array $expected)
    {
        $timestamp = $this->timestampForDate($solar);
        $date = new LunarDate($timestamp);
        $this->assertSame($expected, $date->info());
    }

    protected function checkToSolar(array $info, string $solar)
    {
        $timestamp = LunarDate::toSolar($info['year'], $info['month'], $info['day'], $info['leap']);
        $date = new DateTime('@'.$timestamp);
        $date->setTimeZone(new DateTimeZone('Asia/Shanghai'));
        $this->assertSame($solar, $date->format('Y-m-d'));
    }

    protected function prepareItems(): array
    {
        return [
            [
                'solar' => '2020-05-27',
                'info' => [
                    'year' => 2020,
                    'month' => 4,
                    'day' => 5,
                    'leap' => true,
                ],
            ],
            [
                'solar' => '2020-01-01',
                'info' => [
                    'year' => 2019,
                    'month' => 12,
                    'day' => 7,
                    'leap' => false,
                ],
            ],
            [
                'solar' => '1900-01-31',
                'info' => [
                    'year' => 1900,
                    'month' => 1,
                    'day' => 1,
                    'leap' => false,
                ],
            ],
            [
                'solar' => '2101-01-28',
                'info' => [
                    'year' => 2100,
                    'month' => 12,
                    'day' => 29,
                    'leap' => false,
                ],
            ],
            [
                'solar' => '1988-04-09',
                'info' => [
                    'year' => 1988,
                    'month' => 2,
                    'day' => 23,
                    'leap' => false,
                ],
            ],
            [
                'solar' => '1988-04-10',
                'info' => [
                    'year' => 1988,
                    'month' => 2,
                    'day' => 24,
                    'leap' => false,
                ],
            ],
        ];
    }

    protected function timestampForDate(string $str): int
    {
        $date = DateTime::createFromFormat('Y-m-d H:i:s', $str.' 00:00:00', new DateTimeZone('Asia/Shanghai'));
        return $date->getTimestamp();
    }
}
