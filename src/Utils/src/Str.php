<?php

declare(strict_types=1);
/**
 * happy coding!!!
 */
namespace DevHelper\Utils;

class Str
{
    public static function length(string $value)
    {
        return mb_strlen($value);
    }

    public static function endsWith(string $haystack, $needles): bool
    {
        foreach ((array) $needles as $needle) {
            if (substr($haystack, -strlen($needle)) === (string) $needle) {
                return true;
            }
        }
        return false;
    }
}
