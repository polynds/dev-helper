<?php

declare(strict_types=1);
/**
 * happy coding!!!
 */
namespace DevHelper\Lib\UMLParser;

use DevHelper\Lib\UMLParser\Builder\Class_;
use DevHelper\Lib\UMLParser\Builder\Constant;
use DevHelper\Lib\UMLParser\Builder\Interface_;
use DevHelper\Lib\UMLParser\Builder\Method;
use DevHelper\Lib\UMLParser\Builder\Modifiers;
use DevHelper\Lib\UMLParser\Builder\Namespace_;
use DevHelper\Lib\UMLParser\Builder\Param;
use DevHelper\Lib\UMLParser\Builder\Property;
use DevHelper\Lib\UMLParser\Builder\UML;
use InvalidArgumentException;

class PrettyPrinter
{
    protected UML $uml;

    public function __construct(UML $uml)
    {
        $this->uml = $uml;
    }

    public function print(): string
    {
        return $this->pUML($this->uml);
    }

    protected function dfs()
    {
        $stack = array_merge($this->uml->getClasses(), $this->uml->getNamespaces());
        while (count($stack) > 0) {
            /** @var ?Builder $def */
            $def = array_pop($stack);
            if (method_exists($this, "p{$def->getNodeType()}")) {
                $method = $this->{"p{$def->getNodeType()}"}();
            }
        }
    }

    protected function pModifiers(int $modifiers): string
    {
        return ($modifiers & Modifiers::MODIFIER_FINAL ? 'final ' : '')
        . ($modifiers & Modifiers::MODIFIER_ABSTRACT ? 'abstract ' : '')
        . ($modifiers & Modifiers::MODIFIER_PUBLIC ? 'public ' : '')
        . ($modifiers & Modifiers::MODIFIER_PROTECTED ? 'protected ' : '')
        . ($modifiers & Modifiers::MODIFIER_PRIVATE ? 'private ' : '')
        . ($modifiers & Modifiers::MODIFIER_STATIC ? 'static ' : '')
        . ($modifiers & Modifiers::MODIFIER_READONLY ? 'readonly ' : '');
    }

    protected function pExtends($node): string
    {
        switch (get_class($node)) {
            case Interface_::class:
                /** @var Interface_ $class */
                $class = $node;
                $extends = $class->getExtends();
                break;
            case Class_::class:
                /** @var Class_ $class */
                $class = $node;
                $extends = $class->getExtends();
                break;
            default:
                throw new InvalidArgumentException('Other types cannot get inherited data.');
        }
        $set = [];
        foreach ($extends as $extend) {
            $set[] = $extend->getName();
        }
        return implode(',', $set);
    }

    protected function pImplements($node): string
    {
        switch (get_class($node)) {
            case Class_::class:
                /** @var Class_ $class */
                $class = $node;
                $implements = $class->getImplements();
                break;
            default:
                throw new InvalidArgumentException('Other types cannot get implemented data.');
        }
        $set = [];
        foreach ($implements as $implement) {
            $set[] = $implement->getName();
        }
        return implode(',', $set);
    }

    protected function pStmts(array $stmts = []): string
    {
        return '';
    }

    protected function pClass(Class_ $class_): string
    {
        return $this->pModifiers($class_->getFlags())
            . ' class ' . $class_->getName()
            . (! empty($class_->getExtends()) ? ' extends ' . $this->pExtends($class_) : '')
            . (! empty($class_->getImplements()) ? ' implements ' . $this->pImplements($class_) : '')
            . ' { '
            . $this->pConstants($class_->getConstant())
            . $this->pPropertys($class_->getProperty())
            . $this->pMethods($class_->getMethod())
            . ' }';
    }

    protected function pClasses(array $classes): string
    {
        $data = [];
        foreach ($classes as $class) {
            $data[] = $this->pClass($class);
        }
        return PHP_EOL . implode(PHP_EOL, $data) . PHP_EOL;
    }

    protected function pConstants(array $constants): string
    {
        $data = [];
        foreach ($constants as $constant) {
            $data[] = $this->pConstant($constant);
        }
        return implode(PHP_EOL, $data) . PHP_EOL;
    }

    protected function pConstant(Constant $constant): string
    {
        return $this->pModifiers($constant->getFlags())
            . 'const' . ($constant->getValue() ? '=' . $constant->getValue() : '')
            . ';';
    }

    protected function pDir()
    {
    }

    protected function pInterface()
    {
    }

    protected function pMethods(array $methods): string
    {
        $data = [];
        foreach ($methods as $method) {
            $data[] = $this->pMethod($method);
        }
        return implode(PHP_EOL, $data);
    }

    protected function pMethod(Method $method): string
    {
        return $this->pModifiers($method->getFlags())
            . 'function ' . $method->getName()
            . '('
            . $this->pParams($method->getParams())
            . ');' . PHP_EOL;
    }

    protected function pNamespace(Namespace_ $namespace_): string
    {
        return 'namespace ' . $namespace_->getName()
            . ' { '
            . $this->pClasses($namespace_->getClasses())
            . ' }';
    }

    protected function pNamespaces(array $namespaces): string
    {
        $data = [];
        foreach ($namespaces as $namespace) {
            $data[] = $this->pNamespace($namespace);
        }
        return implode(PHP_EOL, $data) . PHP_EOL;
    }

    protected function pParams(array $params): string
    {
        $data = [];
        foreach ($params as $param) {
            $data[] = $this->pParam($param);
        }
        return implode(',', $data);
    }

    protected function pParam(Param $param): string
    {
        return $this->pModifiers($param->getFlags())
            . ($param->getType() ?: '')
            . ' ' . $param->getName()
            . ($param->getDefault() ? ' = ' . $param->getDefault() : '');
    }

    protected function pPropertys(array $properties)
    {
        $data = [];
        foreach ($properties as $property) {
            $data[] = $this->pProperty($property);
        }
        return implode(PHP_EOL, $data) . PHP_EOL;
    }

    protected function pProperty(Property $property): string
    {
        return $this->pModifiers($property->getFlags())
            . ($property->getType() ?: '')
            . ' ' . $property->getName()
            . ($property->getDefault() ? '=' . $property->getDefault() : '')
            . ';';
    }

    protected function pUML(UML $UML): string
    {
        return '@startuml' . PHP_EOL
            . 'scale ' . $UML->getScale() . PHP_EOL
            . 'title:' . $UML->getTitle() . PHP_EOL . PHP_EOL
            . $this->pNamespaces($UML->getNamespaces()) . PHP_EOL
            . $this->pClasses($UML->getClasses()) . PHP_EOL
            . '@enduml';
    }
}
