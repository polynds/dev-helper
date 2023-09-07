<?php

namespace DevHelper\Plugin\DataVisualizer\Canvas;

class RGB
{
    public static function mapHexToNumber($hex)
    {
        return min(round((hexdec($hex) / 255) * 255), 255);
    }

    public static function hex(int $number): array
    {
        $mappedNumber = round(($number / 255) * 255);

        $hex = str_pad(dechex($mappedNumber), 2, '0', STR_PAD_LEFT);

        return [
            'red' => self::mapHexToNumber($hex),
            'green' => self::mapHexToNumber($hex),
            'blue' => self::mapHexToNumber($hex),
        ];
    }

    public static function rand(int $number): array
    {
        return [
            'red' => mt_rand(0, $number),
            'green' => mt_rand(0, $number),
            'blue' => mt_rand(0, $number),
        ];
    }

    public static function char(int $number): array
    {
        return [
            'red' => $number,
            'green' => $number,
            'blue' => $number,
        ];
    }

    public static function ceil(int $number): array
    {
        $ceil = ceil($number / 3);
        return [
            'red' => $ceil,
            'green' => $ceil,
            'blue' => $ceil,
        ];
    }
}
