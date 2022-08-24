<?php

declare(strict_types=1);
/**
 * happy coding!!!
 */
namespace DevHelper\Lib\UMLParser\Builder;

use DevHelper\Lib\UMLParser\Builder;

class Method implements Builder
{
    protected string $name;

    protected int $flags = 0;

    /**
     * @var Param[]
     */
    protected array $params = [];

    /**
     * @var Class_|Interface_
     */
    protected $returnType;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getFlags(): int
    {
        return $this->flags;
    }

    public function setFlags(int $flags): self
    {
        $this->flags = $flags;
        return $this;
    }

    /**
     * @return Param[]
     */
    public function getParams(): array
    {
        return $this->params;
    }

    public function addParams(Param $param): self
    {
        $this->params[] = $param;
        return $this;
    }

    /**
     * @return Class_|Interface_
     */
    public function getReturnType()
    {
        return $this->returnType;
    }

    /**
     * @param Class_|Interface_ $returnType
     */
    public function setReturnType($returnType): self
    {
        $this->returnType = $returnType;
        return $this;
    }

    public function getNodeType(): string
    {
        return 'Method';
    }
}
