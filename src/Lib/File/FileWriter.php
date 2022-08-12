<?php

declare(strict_types=1);
/**
 * happy coding!!!
 */
namespace DevHelper\Lib\File;

class FileWriter
{
    public static function write(string $fileName, string $contents)
    {
        $success = @file_put_contents($fileName, $contents);
        if ($success === false) {
            $error = error_get_last();

            throw new NotWriteFilesException(
                $fileName,
                $error !== null ? $error['message'] : 'unknown cause',
            );
        }
    }
}
