<?php

declare(strict_types=1);
/**
 * happy coding.
 */

namespace DevHelper\Lib\UMLParser;

use DevHelper\Lib\UMLParser\Builder\Class_;
use DevHelper\Lib\UMLParser\Builder\Constant;
use DevHelper\Lib\UMLParser\Builder\Definition;
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
    protected const CLASS_NAME = 'class';

    protected const METHOD_NAME = 'function';

    protected const NAMESPACE_NAME = 'namespace';

    protected const EXTENDS_NAME = 'extends';

    protected const IMPLEMENTS_NAME = 'implements';

    protected const CONST_NAME = 'const';

    protected const INTERFACE_NAME = 'interface';

    protected UML $uml;

    public function __construct(UML $uml)
    {
        $this->uml = $uml;
    }

    public function print(): string
    {
        return $this->pUML($this->uml);
    }

    protected function pModifiers(Modifiers $modifiers): string
    {
        return ($modifiers->isFinal() ? 'final ' : '')
            . ($modifiers->isAbstract() ? 'abstract ' : '')
            . ($modifiers->isPublic() ? '+ public ' : '')
            . ($modifiers->isProtected() ? '- protected ' : '')
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
            . 'class ' . $class_->getName() . self::pColors($class_)
            . (!empty($class_->getExtends()) ? ' extends ' . $this->pExtends($class_->getExtends()) : '')
            . (!empty($class_->getImplements()) ? ' implements ' . $this->pImplements($class_->getImplements()) : '')
            . '{ '
            . $this->pConstants($class_->getConstant())
            . $this->pPropertys($class_->getProperty())
            . $this->pMethods($class_->getMethod())
            . self::wb(self::space(4) . '}');
    }

    protected function pClasses(array $classes): string
    {
        $data = [];
        foreach ($classes as $class) {
            $data[] = $this->pClass($class);
        }
        return self::lf(self::wb(implode(PHP_EOL, $data)));
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
        return self::space(8)
            . $this->pModifiers($constant->getFlags())
            . 'const' . ($constant->getName() ? ' = ' . $constant->getValue() : '')
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
            . 'interface' . self::space() . $interface->getName() . self::pColors($interface)
            . (!empty($interface->getExtends()) ? ' extends ' . $this->pExtends($interface->getExtends()) : '')
            . self::lf('{')
            . $this->pConstants($interface->getConstants())
            . $this->pMethods($interface->getMethods())
            . self::wb(self::space(4) . '}');
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
            . ')' . ($method->getReturnType() ? ": {$method->getReturnType()}" : '') . ';';
    }

    protected static function pColors(Definition $definition): string
    {
        if (method_exists($definition, 'getColor')) {
            return self::space() . $definition->getColor();
        }
        return '';
    }

    protected function pNamespace(Namespace_ $namespace_): string
    {
        return 'namespace ' . $namespace_->getName() . self::pColors($namespace_)
            . '{'
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
        return ($param->getType() ? $param->getType() . self::space() : '')
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
            . self::space() . self::dollar() . $property->getName()
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
            . ($UML->getTheme() ? self::lf('!theme ' . $UML->getTheme()) : '')
            . self::lf(self::lf('title:' . $UML->getTitle()))
            . self::lf($this->pNamespaces($UML->getNamespaces()))
            . self::lf($this->pInterfaces($UML->getInterfaces()))
            . self::lf($this->pClasses($UML->getClasses()))
            . '@enduml';
    }

    protected static function leftParenthesis(): string
    {
        return '(';
    }

    protected static function rightParenthesis(): string
    {
        return ')';
    }

    protected static function leftBrace(): string
    {
        return '{';
    }

    protected static function rightBrace(): string
    {
        return '}';
    }

    /**
     * Line feed.
     */
    protected static function lf(string $content = ''): string
    {
        return $content . PHP_EOL;
    }

    /**
     * Wrap before.
     */
    protected static function wb(string $content = ''): string
    {
        return PHP_EOL . $content;
    }

    protected static function space(int $length = 1): string
    {
        return str_pad('', $length, ' ');
    }
}
