<?php

namespace DevHelper\Utils;

class Json
{
    public static function jsonEncoder($data): string
    {
        $json = json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return json_last_error_msg();
        }
        return $json;
    }
}