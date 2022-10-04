<?php

declare(strict_types=1);
/**
 * happy coding!!!
 */
namespace DevHelper\Plugin\GenerateDiagram;

use DevHelper\Lib\File\FileFinder;
use DevHelper\Lib\File\FileWriter;
use DevHelper\Lib\PHPParser\ClassParser;
use DevHelper\Lib\UMLParser\Builder\Class_;
use DevHelper\Lib\UMLParser\Builder\Constant;
use DevHelper\Lib\UMLParser\Builder\Interface_;
use DevHelper\Lib\UMLParser\Builder\Method;
use DevHelper\Lib\UMLParser\Builder\Modifiers;
use DevHelper\Lib\UMLParser\Builder\Namespace_;
use DevHelper\Lib\UMLParser\Builder\Param;
use DevHelper\Lib\UMLParser\Builder\Property;
use DevHelper\Lib\UMLParser\Builder\UML;
use DevHelper\Lib\UMLParser\Builder\UMLTheme;
use DevHelper\Lib\UMLParser\BuilderFactory;
use DevHelper\Lib\UMLParser\PrettyPrinter;
use InvalidArgumentException;

class GenerateDiagram
{
    protected string $path;

    protected array $files;

    protected ClassParser $phpParser;

    protected UML $uml;

    public function __construct(string $path, string $umlName = '')
    {
        if (empty($path)) {
            throw new InvalidArgumentException('missing directory address.');
        }

        if (empty($umlName)) {
            $umlName = sprintf('dh_uml_%s', date('YmdHis'));
        }

        $this->path = $path;
        $this->phpParser = new ClassParser();
        $fileFinder = new FileFinder();
        $this->files = $fileFinder->findFiles($path);
        $this->uml = (new BuilderFactory())->uml($umlName)->setTheme((new UMLTheme(UMLTheme::CYBORG)));
    }

    public function build(): GenerateDiagram
    {
        $this->traverse();
        return $this;
    }

    public function output()
    {
        $p = new PrettyPrinter($this->uml);
        FileWriter::write($this->uml->getFileName(), $p->print());
    }

    protected function traverse()
    {
        foreach ($this->files as $file) {
            $stmts = $this->phpParser->parse(file_get_contents($file));
            $data = $this->phpParser->parseClassByStmts($stmts);
            if (empty($data)) {
                continue;
            }

            $namespace = (new Namespace_($data['namespace']['name']));
            if (! empty($data['classes'])) {
                foreach ($data['classes'] as $class) {
                    $class_ = (new Class_($class['name']));
                    foreach ($class['constants'] as $constant) {
                        $class_->addStmt(
                            (new Constant($constant['name']))->setValue($constant['value'])->setFlags((new Modifiers((int) $constant['flags'])))
                        );
                    }

                    foreach ($class['propertes'] as $property) {
                        $class_->addStmt(
                            (new Property($property['name']))
                                ->setType($property['type'])
                                ->setFlags(new Modifiers((int) $property['flags']))
                        );
                    }

                    foreach ($class['methods'] as $method) {
                        $method_ = (new Method($method['name']))->setFlags((new Modifiers((int) $method['flags'])));
                        foreach ($method['params'] as $param) {
                            $method_->addParams((new Param($param['name']))->setType($param['type']));
                        }
                        $class_->addStmt($method_);
                    }
                    $namespace->addStmt($class_);
                }
            }

            if (! empty($data['interfaces'])) {
                foreach ($data['interfaces'] as $interface) {
                    $interface_ = (new Interface_($interface['name']));
                    foreach ($interface['constants'] as $constant) {
                        $interface_->addStmt(
                            (new Constant($constant['name']))->setValue($constant['value'])->setFlags((new Modifiers((int) $constant['flags'])))
                        );
                    }

                    foreach ($interface['methods'] as $method) {
                        $method_ = (new Method($method['name']))->setFlags((new Modifiers((int) $method['flags'])));
                        foreach ($method['params'] as $param) {
                            $method_->addParams((new Param($param['name']))->setType($param['type']));
                        }
                        $interface_->addStmt($method_);
                    }
                    $namespace->addStmt($interface_);
                }
            }
            $this->uml->addStmt($namespace);
        }
    }
}
