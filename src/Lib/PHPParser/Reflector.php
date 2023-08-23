<?php

namespace DevHelper\Lib\PHPParser;

use PhpParser\Node\Stmt;
use ReflectionClass;

class Reflector
{
    public const Stmt_Class = 'Stmt_Class';
    public const Stmt_ClassConst = 'Stmt_ClassConst';
    public const Stmt_ClassMethod = 'Stmt_ClassMethod';
    public const Stmt_Interface = 'Stmt_Interface';
    public const Stmt_Namespace = 'Stmt_Namespace';
    public const Stmt_Property = 'Stmt_Property';


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


    public static function getTypeName(Stmt $stmt)
    {
        switch ($stmt->getType()) {
            case self::Stmt_Class:
                return 'Class';
            case self::Stmt_ClassConst:
                return 'ClassConst';
            case self::Stmt_ClassMethod:
                return 'ClassMethod';
            case self::Stmt_Interface:
                return 'Interface';
            case self::Stmt_Namespace:
                return 'Namespace';
            case self::Stmt_Property:
                return 'Property';
            default:
                return 'Unknown';
        }
    }

    public function getAttributes(): array
    {
        return $this->attributes;
    }
}
