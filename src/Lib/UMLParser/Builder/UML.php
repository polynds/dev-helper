<?php

declare(strict_types=1);
/**
 * happy coding!!!
 */
namespace DevHelper\Lib\UMLParser\Builder;

use LogicException;

class UML extends Definition
{
    protected string $ext = '.puml';

    protected string $name;

    /**
     * @var Class_[]
     */
    protected array $classes = [];

    /**
     * @var Namespace_[]
     */
    protected array $namespaces = [];

    protected float $scale;

    protected string $title;

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
     * @return Namespace_[]
     */
    public function getNamespaces(): array
    {
        return $this->namespaces;
    }

    public function getScale(): float
    {
        return $this->scale;
    }

    public function setScale(float $scale): self
    {
        $this->scale = $scale;
        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function addStmt($stmt)
    {
        switch (get_class($stmt)) {
            case Class_::class:
                $container = &$this->classes;
                break;
            case Namespace_::class:
                $container = &$this->namespaces;
                break;
            default:
                throw new LogicException(sprintf('Unexpected node of type "%s"', get_class($stmt)));
        }

        $container[] = $stmt;
        return $this;
    }

    public function getNodeType(): string
    {
        return 'UML';
    }

    public function getFileName(): string
    {
        return $this->name . $this->ext;
    }
}
