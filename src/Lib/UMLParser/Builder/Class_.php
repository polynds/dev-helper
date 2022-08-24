<?php

declare(strict_types=1);
/**
 * happy coding!!!
 */
namespace DevHelper\Lib\UMLParser\Builder;

use LogicException;

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
        return empty($this->name);
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

    public function addStmt($stmt)
    {
        switch (get_class($stmt)) {
            case Constant::class:
                $container = &$this->constant;
                break;
            case Property::class:
                $container = &$this->property;
                break;
            case Method::class:
                $container = &$this->method;
                break;
            case Interface_::class:
                $container = &$this->implements;
                break;
            case Class_::class:
                $container = &$this->extends;
                break;
            default:
                throw new LogicException(sprintf('Unexpected node of type "%s"', get_class($stmt)));
        }

        $container[] = $stmt;
        return $this;
    }

    public function getNodeType(): string
    {
        return 'Class';
    }
}
