<?php

declare(strict_types=1);
/**
 * happy coding!!!
 */
namespace DevHelper\Lib\File;

class FileWriter
{
    public static function filePutContentsIfModified(string $path, string $content): int
    {
        $success = @file_put_contents($path, $content);
        if ($success === false) {
            $error = error_get_last();

            throw new NotWriteFilesException(
                $path,
                $error !== null ? $error['message'] : 'unknown cause',
            );
        }
        return $success;
    }

    public static function write(string $path, string $content)
    {
        if ($path === 'php://memory') {
            file_put_contents($path, $content);

            return 0;
        }

        $retries = 3;
        while ($retries--) {
            try {
                self::filePutContentsIfModified($path, $content);
                break;
            } catch (\Exception $e) {
                if ($retries > 0) {
                    usleep(500000);
                    continue;
                }

                throw $e;
            }
        }

        return 0;
    }
}
