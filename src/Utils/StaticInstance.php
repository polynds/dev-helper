<?php

declare(strict_types=1);
namespace DevHelper\Utils;

/**
 * happy coding!!!
 */
trait StaticInstance
{
    protected static $instance;

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new static();
        }
        return self::$instance;
    }
}
