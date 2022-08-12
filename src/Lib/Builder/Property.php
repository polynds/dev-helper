<?php

declare(strict_types=1);
/**
 * happy coding!!!
 */
namespace DevHelper\Lib\Builder;

class Property
{
    public int $flags = 0;

    public string $name;

    protected $type;

    protected $default;

    public function __construct(string $name)
    {
        $this->name = $name;
    }


}
