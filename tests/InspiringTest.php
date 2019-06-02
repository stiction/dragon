<?php

use PHPUnit\Framework\TestCase;
use Stiction\Dragon\Inspiring;

class InspiringTest extends TestCase
{
    public function testOne()
    {
        $inspiring = new Inspiring;
        $this->assertIsString($inspiring->one());
    }

    public function testAll()
    {
        $inspiring = new Inspiring;
        $this->assertIsArray($inspiring->all());
    }
}
