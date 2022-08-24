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

    /**
     * @var Class_[]|Interface_[]
     */
    protected array $classes = [];

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return Class_[]|Interface_[]
     */
    public function getClasses(): array
    {
        return $this->classes;
    }

    public function addStmt($stmt)
    {
        switch (get_class($stmt)) {
            case Class_::class:
            case Interface_::class:
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
