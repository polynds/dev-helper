<?php

namespace DevHelper\Lib\Builder;

class Interface_
{
    protected string $name;
    /**
     * @var Interface_[]
     */
    protected array $extends = [];

    protected array $constants = [];

    protected array  $methods = [];


    public function __construct(string $name)
    {
        $this->name = $name;
    }
}