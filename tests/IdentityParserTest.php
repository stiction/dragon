<?php

use PHPUnit\Framework\TestCase;
use Stiction\Dragon\IdentityParser;

class IdentityParserTest extends TestCase
{
    public function testCalcCheckChar()
    {
        $parser = new IdentityParser;
        $this->assertFalse($parser->calcCheckChar('3611231982072619'));
        $this->assertFalse($parser->calcCheckChar('361123r9820726197'));
        $this->assertEquals('X', $parser->calcCheckChar('36112319820726197'));
        $this->assertEquals('6', $parser->calcCheckChar('361123198207262526'));
    }

    public function testParse()
    {
        $parser = new IdentityParser;
        $this->assertEquals([
                'whole' => '36112319820726197X',
                'region' => '361123',
                'birthday' => '1982-07-26',
                'ordinal' => '197',
                'check' => 'X',
                'gender' => 'M',
            ],
            $parser->parse('36112319820726197x')
        );
        $this->assertEquals([
                'whole' => '361123198207262526',
                'region' => '361123',
                'birthday' => '1982-07-26',
                'ordinal' => '252',
                'check' => '6',
                'gender' => 'F',
            ],
            $parser->parse('361123198207262526')
        );
        $this->assertFalse($parser->parse('36112319820726252'));
        $this->assertFalse($parser->parse('361123198207262521'));
        $this->assertFalse($parser->parse('3611231982072625w6'));

        $numbers = [
            '36112319820631252',
            '36112319820229252',
        ];
        foreach ($numbers as $number) {
            $number .= $parser->calcCheckChar($number);
            $this->assertFalse($parser->parse($number));
        }
    }
}
