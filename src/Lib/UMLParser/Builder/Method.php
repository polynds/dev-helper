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

    protected Modifiers $flags;

    /**
     * @var Param[]
     */
    protected array $params = [];

    protected string $returnType = '';

    public function __construct(string $name)
    {
        $this->name = $name;
        $this->flags = (new Modifiers(Modifiers::MODIFIER_PUBLIC));
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getFlags(): Modifiers
    {
        return $this->flags;
    }

    public function setFlags(Modifiers $flags): self
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

    public function getReturnType(): string
    {
        return $this->returnType;
    }

    public function setReturnType(string $returnType): self
    {
        $this->returnType = $returnType;
        return $this;
    }

    public function getNodeType(): string
    {
        return 'Method';
    }
}
