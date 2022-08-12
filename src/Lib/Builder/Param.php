<?php

declare(strict_types=1);
/**
 * happy coding!!!
 */
namespace DevHelper\Lib\Builder;

class Param
{
    protected $type;

    protected string $name;

    protected $default;

    public function __construct(string $name)
    {
        $this->name = $name;
    }
}
