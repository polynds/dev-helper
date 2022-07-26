<?php

declare(strict_types=1);
/**
 * happy coding!!!
 */
namespace DevHelper\Utils;

trait StaticInstance
{
    protected static $instance;

    public static function getInstance()
    {
        if (! self::$instance) {
            self::$instance = new static();
        }
        return self::$instance;
    }
}
