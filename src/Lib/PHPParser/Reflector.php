<?php

namespace DevHelper\Lib\PHPParser;

use ReflectionClass;

class Reflector
{
    private string $class;
    private array $attributes;
    private ReflectionClass $reflected;

    /**
     * @throws \ReflectionException
     */
    public function __construct(string $class)
    {
        $this->class = $class;
        $this->reflected = new ReflectionClass($class);
        $this->attributes = $this->reflected->getAttributes();
    }


    public static function getTypeName()
    {

    }

    public function getAttributes(): array
    {
        return $this->attributes;
    }
}
