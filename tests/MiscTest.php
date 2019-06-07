<?php

use PHPUnit\Framework\TestCase;
use Stiction\Dragon\Misc;

class MiscTest extends TestCase
{
    public function testCheckMobile()
    {
        $misc = new Misc;
        $this->assertFalse($misc->checkMobile(''));
        $this->assertFalse($misc->checkMobile('12800138000'));
        $this->assertFalse($misc->checkMobile('138001380001'));
        $this->assertFalse($misc->checkMobile('13800138000 '));
        $this->assertFalse($misc->checkMobile(' 13800138000'));
        $this->assertFalse($misc->checkMobile("\n13800138000"));
        $this->assertFalse($misc->checkMobile("13800138000\n"));
        $this->assertTrue($misc->checkMobile('13800138000'));
        $this->assertTrue($misc->checkMobile('19900138000'));
    }
}
