<?php

declare(strict_types=1);
/**
 * happy coding!!!
 */

namespace DevHelper\Lib\File;

class FileReader
{
    public static function read(string $path): string
    {
        if ($path === 'php://memory') {
            return file_get_contents($path);
        }

        $file = fopen($path, 'rb');
        $buffer = "";
        while (($line = fgets($file, 1024)) != false) {
            $buffer .= $line;
        }

        return $buffer;
    }
}
