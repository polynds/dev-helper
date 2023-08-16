<?php

namespace Tests;

use DevHelper\Plugin\Keccak256\Keccak256;
use PHPUnit\Framework\TestCase;

class Keccak256Test extends TestCase
{

    public function testHash()
    {
        $hash = Keccak256::hash("hello", 256);
        self::assertEquals(Keccak256::hash("hello", 256),"1c8aff950685c2ed4bc3174f3472287b56d9517b9c948127319a09a7a36deac8");
    }
}
