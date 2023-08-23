<?php

declare(strict_types=1);
/**
 * happy coding!!!
 */

namespace DevHelper\Lib\UMLParser\Builder;

use LogicException;

class Namespace_ extends Definition
{
    protected string $name = '';

    protected string $color = '';

    /**
     * @var Class_[]
     */
    protected array $classes = [];

    /**
     * @var Interface_[]
     */
    protected array $interfaces = [];

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return Class_[]
     */
    public function getClasses(): array
    {
        return $this->classes;
    }

    /**
     * @return Interface_[]
     */
    public function getInterfaces(): array
    {
        return $this->interfaces;
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

    public function addStmt($stmt)
    {
        switch (get_class($stmt)) {
            case Interface_::class:
                $container = &$this->interfaces;
                break;
            case Class_::class:
                $container = &$this->classes;
                break;
            default:
                throw new LogicException(sprintf('Unexpected node of type "%s"', get_class($stmt)));
        }

        $container[] = $stmt;
        return $this;
    }

    public function getNodeType(): string
    {
        return 'Namespace';
    }
}
