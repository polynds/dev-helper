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
use DevHelper\Lib\UMLParser\Builder\Modifiers;
use DevHelper\Lib\UMLParser\Builder\Namespace_;
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
        $this->uml = (new BuilderFactory())->uml($umlName)->setTheme((new UMLTheme(UMLTheme::AWS_ORANGE)));
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
            $class = $this->phpParser->parseClassByStmts($stmts);
            if (empty($class)) {
                continue;
            }

            if (! empty($class['namespace'])) {
                $namespace = (new Namespace_($class['namespace']));
            }
            if (! empty($class['class']) && $namespace) {
                $namespace->addStmt(
                    (new Class_($class['class']))
                        ->addStmt(
                            (new Property('param1'))
                                ->setType('string')
                                ->setDefault(1)
                                ->setFlags(new Modifiers(Modifiers::MODIFIER_PUBLIC))
                        )
                );
            }

            if ($namespace) {
                $this->uml->addStmt($namespace);
            }
        }
    }
}
