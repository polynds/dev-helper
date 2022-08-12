<?php

declare(strict_types=1);
/**
 * happy coding!!!
 */
namespace DevHelper\Lib;

use DevHelper\Lib\Builder\Class_;
use DevHelper\Lib\Builder\Interface_;
use DevHelper\Lib\Builder\Method;
use DevHelper\Lib\Builder\Namespace_;
use DevHelper\Lib\Builder\Param;
use DevHelper\Lib\Builder\Property;

class BuilderFactory
{
    public function class(string $name): Class_
    {
        return new Class_($name);
    }

    public function interface(string $name): Interface_
    {
        return new Interface_($name);
    }

    public function method(string $name): Method
    {
        return new Method($name);
    }

    public function namespace(string $name): Namespace_
    {
        return new Namespace_($name);
    }

    public function param(string $name): Param
    {
        return new Param($name);
    }

    public function property(string $name): Property
    {
        return new Property($name);
    }
}
