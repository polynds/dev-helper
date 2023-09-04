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

        if (!is_readable($path) || !is_file($path)) {
            throw new \RuntimeException(sprintf('File "%s" is not readable.', $path));
        }

        $file = fopen($path, 'rb');
        $buffer = "";
        while (!feof($file)) {
            $buffer .= fread($file, 4069);
        }
        fclose($file);

        return $buffer;
    }
}
