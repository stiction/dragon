<?php

use PHPUnit\Framework\TestCase;
use Stiction\Dragon\LunarDate;

class LunarDateTest extends TestCase
{
    public function testInfoSuccess()
    {
        $items = [
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

    protected function checkInfo(string $solar, array $expected)
    {
        $timestamp = $this->timestampForDate($solar);
        $date = new LunarDate($timestamp);
        $this->assertSame($expected, $date->info());
    }

    protected function timestampForDate(string $str): int
    {
        $date = DateTime::createFromFormat('Y-m-d H:i:s', $str.' 00:00:00', new DateTimeZone('Asia/Shanghai'));
        return $date->getTimestamp();
    }
}
