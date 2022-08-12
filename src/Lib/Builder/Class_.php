<?php

declare(strict_types=1);
/**
 * happy coding!!!
 */
namespace DevHelper\Lib\Builder;

class Class_
{
    public string $name;

    public int $flags = 0;

    /**
     * @var Property[]
     */
    public array $property = [];

    /**
     * @var Method[]
     */
    public array $method = [];

    public array $constant = [];

    /**
     * @var Class_[]
     */
    public array $extends = [];

    /**
     * @var Interface_[]
     */
    public array $implements = [];

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function isAbstract(): bool
    {
        return (bool) ($this->flags & Modifiers::MODIFIER_ABSTRACT);
    }

    public function isFinal(): bool
    {
        return (bool) ($this->flags & Modifiers::MODIFIER_FINAL);
    }

    public function isReadonly(): bool
    {
        return (bool) ($this->flags & Modifiers::MODIFIER_READONLY);
    }

    public function isAnonymous(): bool
    {
        return $this->name === null;
    }

    public function setFlags(int $flags): self
    {
        $this->flags = $flags;
        return $this;
    }

    public function setFlagsName(string $flagsName): self
    {
        $this->flagsName = $flagsName;
        return $this;
    }

    public function setProperty(array $property): self
    {
        $this->property = $property;
        return $this;
    }

    public function setMethod(array $method): self
    {
        $this->method = $method;
        return $this;
    }

    public function setConstant(array $constant): self
    {
        $this->constant = $constant;
        return $this;
    }

    public function setExtends(Class_ $extends): self
    {
        $this->extends[] = $extends;
        return $this;
    }

    /**
     * @param array $implements
     */
    public function setImplements(string $implements): self
    {
        $this->implements[] = $implements;
        return $this;
    }
}
