<?php

declare(strict_types=1);
/**
 * happy coding!!!
 */
namespace DevHelper\Lib\Builder;

class Class_ extends Definition
{
    protected string $name;

    protected int $flags = 0;

    /**
     * @var Property[]
     */
    protected array $property = [];

    /**
     * @var Method[]
     */
    protected array $method = [];

    protected array $constant = [];

    /**
     * @var Class_[]
     */
    protected array $extends = [];

    /**
     * @var Interface_[]
     */
    protected array $implements = [];

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

    public function getName(): string
    {
        return $this->name;
    }

    public function getFlags(): int
    {
        return $this->flags;
    }

    /**
     * @return Property[]
     */
    public function getProperty(): array
    {
        return $this->property;
    }

    /**
     * @return Method[]
     */
    public function getMethod(): array
    {
        return $this->method;
    }

    public function getConstant(): array
    {
        return $this->constant;
    }

    /**
     * @return Class_[]
     */
    public function getExtends(): array
    {
        return $this->extends;
    }

    /**
     * @return Interface_[]
     */
    public function getImplements(): array
    {
        return $this->implements;
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
