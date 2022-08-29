<?php

declare(strict_types=1);
/**
 * happy coding!!!
 */
namespace DevHelper\Lib\UMLParser\Builder;

use DevHelper\Lib\UMLParser\Builder;

class Property implements Builder
{
    protected string $name;

    protected Modifiers $flags;

    protected $type;

    protected $default;

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

    public function setFlags(Modifiers $modifiers): self
    {
        $this->flags = $modifiers;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type): self
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDefault()
    {
        return $this->default;
    }

    /**
     * @param mixed $default
     */
    public function setDefault($default): self
    {
        $this->default = $default;
        return $this;
    }

    public function getNodeType(): string
    {
        return 'Property';
    }
}
