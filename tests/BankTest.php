<?php

use PHPUnit\Framework\TestCase;
use Stiction\Dragon\Bank;

class BankTest extends TestCase
{
    public function testCalcCheckNumber()
    {
        $bank = new Bank;
        $this->assertFalse($bank->calcCheckNumber(''));
        $this->assertFalse($bank->calcCheckNumber('1234q'));
        $this->assertEquals(7, $bank->calcCheckNumber('622841407026350141'));
    }
}
