<?php

declare(strict_types=1);
/**
 * happy coding!!!
 */
namespace DevHelper\Lib\Builder;

class Namespace_
{
    public string $name = '';

    /**
     * @var Class_[]|Interface_[]
     */
    public array $classes = [];

    public function __construct(string $name)
    {
        $this->name = $name;
    }
}
