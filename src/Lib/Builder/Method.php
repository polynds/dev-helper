<?php

declare(strict_types=1);
/**
 * happy coding!!!
 */
namespace DevHelper\Lib\Builder;

class Method
{
    public string $name;

    public int $flags = 0;

    /**
     * @var Param[]
     */
    public array $parameters = [];

    /**
     * @var Class_|Interface_
     */
    public $returnType;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function setFlags(int $flags): self
    {
        $this->flags = $flags;
        return $this;
    }

    public function addParameters(Param $param): self
    {
        $this->parameters[] = $param;
        return $this;
    }
}
