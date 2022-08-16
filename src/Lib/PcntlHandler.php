<?php

declare(strict_types=1);
/**
 * happy coding!!!
 */
namespace DevHelper\Lib;

use Closure;
use DevHelper\Lib\Exception\ProcessException;

class PcntlHandler
{
    public function __construct()
    {
        if (! extension_loaded('pcntl')) {
            throw new ProcessException('Missing pcntl extension.');
        }
    }

    public function handler(Closure $closure)
    {
        $pid = pcntl_fork();
        if ($pid == -1) {
            throw new ProcessException('The process fork failed');
        }
        if ($pid) {
            pcntl_wait($status);
            return true;
        }
        return $closure();
    }
}
