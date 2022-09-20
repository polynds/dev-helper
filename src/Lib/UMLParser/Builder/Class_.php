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

    protected string $color = '';

    protected Modifiers $flags;

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
     * @var string
     */
    protected array $extends = [];

    /**
     * @var string
     */
    protected array $implements = [];

    public function __construct(string $name)
    {
        $this->name = $name;
        $this->flags = (new Modifiers(Modifiers::NONE));
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

    public function getColor(): string
    {
        return $this->color;
    }

    public function setColor(string $color): self
    {
        $this->color = $color;
        return $this;
    }

    public function getFlags(): Modifiers
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

    public function setFlags(Modifiers $modifiers): self
    {
        $this->flags = $modifiers;
        return $this;
    }

    public function addExtend(string $extends): self
    {
        $this->extends[] = $extends;
        return $this;
    }

    public function addImplement(string $implements): self
    {
        $this->implements[] = $implements;
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
