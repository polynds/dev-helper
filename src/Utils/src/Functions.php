<?php

declare(strict_types=1);
/**
 * happy coding!!!
 */
if (! function_exists('call')) {
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
