<?php

namespace DevHelper\Lib;

/**
 * @method static static map(\Closure $callback)
 */
class Collection
{
    protected array $items;

    public function __construct($items = [])
    {
        $this->items = $items;
    }

    public static function make(array $arguments): static
    {
        return new static($arguments);
    }

    public function map(\Closure $callback): static
    {
        return new static(items: array_map($callback, $this->items));
    }

    public function all(): array
    {
        return $this->items;
    }

    public function toArray(): array
    {
        return $this->items;
    }
}
