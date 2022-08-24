<?php

declare(strict_types=1);
/**
 * happy coding!!!
 */
namespace DevHelper\Lib\UMLParser\Builder;

use DevHelper\Lib\UMLParser\Builder;
use InvalidArgumentException;

class Constant implements Builder
{
    protected string $name;

    protected int $flags = 0;

    /**
     * @var bool|float|int|string
     */
    protected $value;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return bool|float|int|string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param bool|float|int|string $value
     */
    public function setValue($value): self
    {
        if (! in_array(gettype($value), ['bool', 'float', 'int', 'string'])) {
            throw new InvalidArgumentException('Constant value type must be bool|float|int|string.');
        }
        $this->value = $value;
        return $this;
    }

    public function getFlags(): int
    {
        return $this->flags;
    }

    public function setFlags(int $flags): self
    {
        $this->flags = $flags;
        return $this;
    }

    public function getNodeType(): string
    {
        return 'Constant';
    }
}
