<?php

declare(strict_types=1);
/**
 * happy coding!!!
 */
namespace DevHelper\Lib\File;

class Dir
{
    public static function makeDir(string $dir)
    {
        if (! is_dir($dir)) {
            if (file_exists($dir)) {
                throw new \InvalidArgumentException(
                    realpath($dir) . ' exists and is not a directory.'
                );
            }
            if (! @mkdir($dir, 0777, true)) {
                throw new \InvalidArgumentException(
                    $dir . ' does not exist and could not be created.'
                );
            }
        }
    }
}
