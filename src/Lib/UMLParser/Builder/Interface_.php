<?php

declare(strict_types=1);
/**
 * happy coding!!!
 */

namespace DevHelper\Lib\UMLParser\Builder;

use LogicException;

class Interface_ extends Definition
{
    protected string $name;

    protected string $color = '';

    /**
     * @var string[]
     */
    protected array $extends = [];

    /**
     * @var Constant[]
     */
    protected array $constants = [];

    /**
     * @var Method[]
     */
    protected array $methods = [];

    public function __construct(string $name)
    {
        $this->name = $name;
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

    public function getExtends(): array
    {
        return $this->extends;
    }

    public function addExtend(string $extends): self
    {
        $this->extends[] = $extends;
        return $this;
    }

    /**
     * @return Constant[]
     */
    public function getConstants(): array
    {
        return $this->constants;
    }

    /**
     * @param Constant[] $constants
     */
    public function setConstants(array $constants): self
    {
        $this->constants = $constants;
        return $this;
    }

    /**
     * @return Method[]
     */
    public function getMethods(): array
    {
        return $this->methods;
    }

    /**
     * @param Method[] $methods
     */
    public function setMethods(array $methods): self
    {
        $this->methods = $methods;
        return $this;
    }

    public function addStmt($stmt)
    {
        switch (get_class($stmt)) {
            case Constant::class:
                $container = &$this->constants;
                break;
            case Method::class:
                $container = &$this->methods;
                break;
            default:
                throw new LogicException(sprintf('Unexpected node of type "%s"', get_class($stmt)));
        }

        $container[] = $stmt;
        return $this;
    }

    public function getNodeType(): string
    {
        return 'Interface';
    }
}
