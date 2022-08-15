<?php

declare(strict_types=1);
/**
 * happy coding!!!
 */
namespace DevHelper\Plugin\CreatePlugin;

use DevHelper\Lib\Console\AbstractCommand;
use DevHelper\Lib\File\Dir;
use DevHelper\Lib\File\FileWriter;
use DevHelper\Plugin\CreatePlugin\Composer\Authors;
use DevHelper\Plugin\CreatePlugin\Composer\ComposerFactory;
use PhpParser\BuilderFactory;
use PhpParser\Node;
use PhpParser\PrettyPrinter;
use PHPStan\Type\StringType;

class PluginFactory
{
    protected Plugin $plugin;

    public function __construct(Plugin $plugin)
    {
        $this->plugin = $plugin;
    }

    public function create()
    {
        $this->createDir();
        $this->createSrc();
        $this->createComposer();
        $this->createDotGitIgnore();
        $this->createCommand();
    }

    protected function createDir()
    {
        Dir::makeDir($this->getRootPath());
    }

    protected function createSrc()
    {
        Dir::makeDir($this->getSrcPath());
    }

    protected function createComposer()
    {
        $composer = (new Composer\Composer())
            ->setName($this->plugin->getComposerName())
            ->setDescription($this->plugin->getComposerDesc())
            ->setLicense($this->plugin->getComposerLicense())
            ->setAuthors([new Authors($this->plugin->getAuthorName(), $this->plugin->getAuthorEmail())])
            ->setAutoload($this->plugin->getNameSpace());
        ComposerFactory::with($composer, $this->plugin->getPath())->writeComposerJSON();
    }

    protected function createDotGitIgnore()
    {
        (new DotGitIgnore())->write($this->plugin->getPath());
    }

    protected function createCommand()
    {
        $srcPath = $this->getSrcPath();
        $className = sprintf('%sCommand', $this->plugin->getClassName());
        $fileName = $className . '.php';
        $filePath = $srcPath . DIRECTORY_SEPARATOR . $fileName;
        $factory = new BuilderFactory();
        $node = $factory->namespace($this->plugin->getNameSpace())
            ->addStmt($factory->use(AbstractCommand::class))
            ->addStmt(
                $factory->class($className)
                    ->extend('AbstractCommand')
                    ->addStmt($factory->method('handle')->makePublic())
                    ->addStmt($factory->method('configure')->makeProtected()->addStmt(
                        new Node\Expr\MethodCall(new Node\Expr\Variable('this'), 'setDescription', [
                            new Node\Arg(new Node\Scalar\MagicConst\Class_()),
                        ])
                    ))
                    ->addStmt($factory->property('name')->setType('string')->makeProtected()->setDefault($this->plugin->getCommandName()))
            )
            ->getNode();
        $stmts = [$node];
        $prettyPrinter = new PrettyPrinter\Standard();
        $command = $prettyPrinter->prettyPrintFile($stmts);

        FileWriter::write($filePath, $command);
    }

    private function getRootPath(): string
    {
        return $this->plugin->getPath() . DIRECTORY_SEPARATOR;
    }

    private function getSrcPath(): string
    {
        return $this->plugin->getPath() . DIRECTORY_SEPARATOR . 'src';
    }
}
