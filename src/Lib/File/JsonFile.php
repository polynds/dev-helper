<?php

declare(strict_types=1);
/**
 * happy coding!!!
 */

namespace DevHelper\Lib\File;

use DevHelper\Lib\Exception\NotWriteFilesException;
use Exception;
use InvalidArgumentException;

class JsonFile
{
    public static function write(string $path, array $content, int $options = JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
    {
        if ($path === 'php://memory') {
            file_put_contents($path, static::encode($content, $options));

            return 0;
        }

        $retries = 3;
        while ($retries--) {
            try {
                self::filePutContentsIfModified($path, static::encode($content, $options) . ($options & JSON_PRETTY_PRINT ? "\n" : ''));
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

    public static function encode($data, int $options = 448)
    {
        $json = json_encode($data, $options);
        if ($json === false) {
            self::throwJsonError(json_last_error());
        }

        return $json;
    }

    private static function throwJsonError(int $code): void
    {
        switch ($code) {
            case JSON_ERROR_DEPTH:
                $msg = 'Maximum stack depth exceeded';
                break;
            case JSON_ERROR_STATE_MISMATCH:
                $msg = 'Underflow or the modes mismatch';
                break;
            case JSON_ERROR_CTRL_CHAR:
                $msg = 'Unexpected control character found';
                break;
            case JSON_ERROR_UTF8:
                $msg = 'Malformed UTF-8 characters, possibly incorrectly encoded';
                break;
            default:
                $msg = 'Unknown error';
        }

        throw new \RuntimeException('JSON encoding failed: ' . $msg);
    }

    public static function filePutContentsIfModified(string $path, string $content): int
    {
        $success = true;
        $currentContent = @file_get_contents($path);
        if ($currentContent === false || $currentContent !== $content) {
            $success = file_put_contents($path, $content);
        }
        if ($success === false) {
            $error = error_get_last();

            throw new NotWriteFilesException(
                $path,
                $error !== null ? $error['message'] : 'unknown cause',
            );
        }
        return $success;
    }

    public static function read(string $path)
    {
        try {
            $json = file_get_contents($path);
        } catch (Exception $e) {
            throw new InvalidArgumentException('Could not read ' . $path . "\n\n" . $e->getMessage());
        }

        if ($json === false) {
            throw new InvalidArgumentException('Could not read ' . $path);
        }

        return self::decode($json);
    }

    public static function decode(?string $json)
    {
        if (is_null($json)) {
            return null;
        }

        $data = json_decode($json, true);
        if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
            self::throwJsonError(json_last_error());
        }

        return $data;
    }
}
