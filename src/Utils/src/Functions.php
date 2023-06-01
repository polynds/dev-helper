<?php

declare(strict_types=1);


// 定义ANSI转义序列
const ANSI_RESET = "\033[0m";
const ANSI_RED = "\033[31m";
const ANSI_GREEN = "\033[32m";
const ANSI_YELLOW = "\033[33m";
const ANSI_BLUE = "\033[34m";
const ANSI_MAGENTA = "\033[35m";
const ANSI_CYAN = "\033[36m";

// 输出日志
function log_info($message)
{
    echo ANSI_GREEN . "[INFO] " . $message . ANSI_RESET . PHP_EOL;
}

function log_warning($message)
{
    echo ANSI_YELLOW . "[WARNING] " . $message . ANSI_RESET . PHP_EOL;
}

function log_error($message)
{
    echo ANSI_RED . "[ERROR] " . $message . ANSI_RESET . PHP_EOL;
}

/**
 * happy coding!!!
 */
if (!function_exists('call')) {
    /**
     * Call a callback with the arguments.
     *
     * @param mixed $callback
     * @return null|mixed
     */
    function call($callback, array $args = [])
    {
        $result = null;
        if ($callback instanceof \Closure) {
            $result = $callback(...$args);
        } elseif (is_object($callback) || (is_string($callback) && function_exists($callback))) {
            $result = $callback(...$args);
        } elseif (is_array($callback)) {
            [$object, $method] = $callback;
            $result = is_object($object) ? $object->{$method}(...$args) : $object::$method(...$args);
        } else {
            $result = call_user_func_array($callback, $args);
        }
        return $result;
    }
}

if (!function_exists('dd')) {
    function dd($data)
    {
        var_dump($data);
        die();
    }
}


if (!function_exists('varDump')) {
    function varDump($data)
    {
        echo '<pre/>';
        var_dump($data);
    }
}
