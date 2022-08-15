<?php

declare(strict_types=1);
/**
 * happy coding!!!
 */
namespace DevHelper\Lib\Builder;

class Interface_ extends Definition
{
    protected string $name;

    /**
     * @var Interface_[]
     */
    protected array $extends = [];

    /**
     * @var Constant[]
     */
    protected array $constants = [];

    /**
     * @var Method[]
     */
    protected array  $methods = [];

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return Interface_[]
     */
    public function getExtends(): array
    {
        return $this->extends;
    }

    /**
     * @param Interface_[] $extends
     */
    public function setExtends(array $extends): self
    {
        $this->extends = $extends;
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
}
