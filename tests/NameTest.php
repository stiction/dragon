<?php

use PHPUnit\Framework\TestCase;
use Stiction\Dragon\Name;

class NameTest extends TestCase
{
    public function testRandomSurname()
    {
        $name = new Name;
        $this->assertIsString($name->randomSurname());
    }

    public function testRandomFirstName()
    {
        $name = new Name;
        $this->assertIsString($name->randomFirstName());
    }

    public function testRandomFullName()
    {
        $name = new Name;
        $this->assertIsString($name->randomFullName());
    }
}
