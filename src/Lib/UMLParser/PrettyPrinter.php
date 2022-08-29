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

    protected function pModifiers(Modifiers $modifiers): string
    {
        return ($modifiers->isFinal() ? 'final ' : '')
        . ($modifiers->isAbstract() ? 'abstract ' : '')
        . ($modifiers->isPublic() ? '+ public ' : '')
        . ($modifiers->isProtected() ? 'protected ' : '')
        . ($modifiers->isPrivate() ? '- private ' : '')
        . ($modifiers->isStatic() ? 'static ' : '')
        . ($modifiers->isReadonly() ? 'readonly ' : '');
    }

    protected function pExtends(array $extends): string
    {
        return implode(',', $extends);
    }

    protected function pImplements(array $implements): string
    {
//        switch (get_class($node)) {
//            case Class_::class:
//                /** @var Class_ $class */
//                $class = $node;
//                $implements = $class->getImplements();
//                break;
//            default:
//                throw new InvalidArgumentException('Other types cannot get implemented data.');
//        }
//        $set = [];
//        foreach ($implements as $implement) {
//            $set[] = $implement->getName();
//        }
        return implode(',', $implements);
    }

    protected function pStmts(array $stmts = []): string
    {
        return '';
    }

    protected function pClass(Class_ $class_): string
    {
        return self::space(4)
            . $this->pModifiers($class_->getFlags())
            . 'class ' . $class_->getName()
            . (! empty($class_->getExtends()) ? ' extends ' . $this->pExtends($class_->getExtends()) : '')
            . (! empty($class_->getImplements()) ? ' implements ' . $this->pImplements($class_->getImplements()) : '')
            . ' { '
            . $this->pConstants($class_->getConstant())
            . $this->pPropertys($class_->getProperty())
            . $this->pMethods($class_->getMethod())
            . self::space(4) . self::lf(' }');
    }

    protected function pClasses(array $classes): string
    {
        $data = [];
        foreach ($classes as $class) {
            $data[] = $this->pClass($class);
        }
        return self::wb(self::lf(implode(PHP_EOL, $data)));
    }

    protected function pConstants(array $constants): string
    {
        $data = [];
        foreach ($constants as $constant) {
            $data[] = $this->pConstant($constant);
        }
        return self::lf(implode(PHP_EOL, $data));
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

    protected function pInterfaces(array $interfaces): string
    {
        $data = [];
        foreach ($interfaces as $interface) {
            $data[] = $this->pInterface($interface);
        }
        if (empty($data)) {
            return '';
        }
        return self::wb(self::lf(implode(PHP_EOL, $data)));
    }

    protected function pInterface(Interface_ $interface): string
    {
        return self::space(4)
            . ' interface ' . $interface->getName()
            . (! empty($interface->getExtends()) ? ' extends ' . $this->pExtends($interface->getExtends()) : '')
            . ' { '
            . $this->pConstants($interface->getConstants())
            . $this->pMethods($interface->getMethods())
            . self::space(4) . self::lf(' }');
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
        return self::space(8)
            . $this->pModifiers($method->getFlags())
            . 'function ' . $method->getName()
            . '('
            . $this->pParams($method->getParams())
            . self::lf(')' . ($method->getReturnType() ? ": {$method->getReturnType()}" : '') . ';');
    }

    protected function pNamespace(Namespace_ $namespace_): string
    {
        return 'namespace ' . $namespace_->getName()
            . ' { '
            . $this->pInterfaces($namespace_->getInterfaces())
            . $this->pClasses($namespace_->getClasses())
            . self::lf('}');
    }

    protected function pNamespaces(array $namespaces): string
    {
        $data = [];
        foreach ($namespaces as $namespace) {
            $data[] = $this->pNamespace($namespace);
        }
        return self::lf(implode(PHP_EOL, $data));
    }

    protected function pParams(array $params): string
    {
        $data = [];
        foreach ($params as $param) {
            $data[] = $this->pParam($param);
        }
        return implode(', ', $data);
    }

    protected function pParam(Param $param): string
    {
        return ($param->getType() ? $param->getType() . self::space(1) : '')
            . self::dollar() . $param->getName()
            . ($param->getDefault() ? ' = ' . $param->getDefault() : '');
    }

    protected function pPropertys(array $properties): string
    {
        $data = [];
        foreach ($properties as $property) {
            $data[] = $this->pProperty($property);
        }
        return self::lf(implode(PHP_EOL, $data));
    }

    protected function pProperty(Property $property): string
    {
        return self::space(8)
            . $this->pModifiers($property->getFlags())
            . ($property->getType() ?: '')
            . ' ' . self::dollar() . $property->getName()
            . ($property->getDefault() ? ' = ' . $property->getDefault() : '')
            . ';';
    }

    protected static function dollar(): string
    {
        return '$';
    }

    protected function pUML(UML $UML): string
    {
        return self::lf('@startuml')
            . self::lf('scale ' . $UML->getScale())
            . self::lf('!theme ' . $UML->getTheme())
            . self::lf(self::lf('title:' . $UML->getTitle()))
            . self::lf($this->pNamespaces($UML->getNamespaces()))
            . self::lf($this->pInterfaces($UML->getInterfaces()))
            . self::lf($this->pClasses($UML->getClasses()))
            . '@enduml';
    }

    /**
     * Line feed.
     */
    protected static function lf(string $content): string
    {
        return $content . PHP_EOL;
    }

    /**
     * Wrap before.
     */
    protected static function wb(string $content): string
    {
        return PHP_EOL . $content;
    }

    protected static function space(int $length = 1): string
    {
        return str_pad('', $length, ' ');
    }
}
