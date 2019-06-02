<?php

use PHPUnit\Framework\TestCase;
use Stiction\Dragon\Region;

class RegionTest extends TestCase
{
    public function testAll()
    {
        $region = new Region;
        $this->assertIsArray($region->all());
    }

    public function testProvinces()
    {
        $region = new Region;
        $this->assertIsArray($region->provinces());
    }

    public function testFind()
    {
        $region = new Region;
        $this->assertIsArray($region->find('440300'));
        $this->assertFalse($region->find('hello'));
    }

    public function testSubregions()
    {
        $region = new Region;
        $this->assertIsArray($region->subregions('440300'));
        $this->assertIsArray($region->subregions('hello'));
        $this->assertEmpty($region->subregions('hello'));
    }
}
