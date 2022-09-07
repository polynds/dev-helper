<?php

declare(strict_types=1);
/**
 * happy coding!!!
 */
namespace DevHelper\Lib\Console\Command\CreatePlugin\Composer;

interface TestInterface
{
    public const HH = 'hh';

    public function hh(string $name): string;
}
