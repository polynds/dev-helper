<?php

declare(strict_types=1);
/**
 * happy coding!!!
 */
namespace DevHelper\Lib\Builder;

class Property extends Definition
{
    protected string $name;

    protected int $flags = 0;

    protected $type;

    protected $default;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

}
