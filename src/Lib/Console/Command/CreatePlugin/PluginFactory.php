<?php

declare(strict_types=1);
/**
 * happy coding!!!
 */
namespace DevHelper\Lib\Console\Command\CreatePlugin;

use DevHelper\Lib\Console\AbstractCommand;
use DevHelper\Lib\Console\Command\CreatePlugin\Composer\Authors;
use DevHelper\Lib\Console\Command\CreatePlugin\Composer\ComposerFactory;
use DevHelper\Lib\File\Dir;
use DevHelper\Lib\File\FileWriter;
use DevHelper\Lib\File\JsonFile;
use PhpParser\BuilderFactory;
use PhpParser\Node;
use PhpParser\PrettyPrinter;

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
        $this->registerCommand();
    }

    protected function createDir()
    {
        Dir::makeDir($this->getPluginRootPath());
    }

    protected function createSrc()
    {
        Dir::makeDir($this->getPluginSrcPath());
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
        $className = sprintf('%sCommand', $this->plugin->getClassName());
        $fileName = $className . '.php';
        $filePath = $this->getPluginSrcPath() . DIRECTORY_SEPARATOR . $fileName;
        $factory = new BuilderFactory();
        $node = $factory->namespace($this->plugin->getNameSpace())
            ->addStmt($factory->use(AbstractCommand::class))
            ->addStmt(
                $factory->class($className)
                    ->extend('AbstractCommand')
                    ->addStmt($factory->method('handle')->makePublic())
                    ->addStmt($factory->method('configure')->makeProtected()->addStmt(
                        new Node\Expr\MethodCall(new Node\Expr\Variable('this'), 'setDescription', [
                            new Node\Arg(new Node\Scalar\String_($this->plugin->getComposerDesc())),
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

    protected function registerCommand()
    {
        $cmd = sprintf('php %s/compile %s dev-main', BIN_PATH, $this->plugin->getComposerName());
        exec($cmd, $output, $result);
        if ($result !== 0) {
            throw new \InvalidArgumentException('命令注册失败');
        }

        $plugins = JsonFile::read(CONFIG_PATH . DIRECTORY_SEPARATOR . 'plugins.json');
        if ($plugins && is_array($plugins)) {
            $className = sprintf('%sCommand', $this->plugin->getClassName());
            $plugins[] = [
                'name' => $this->plugin->getCommandName(),
                'command' => str_replace('\\', '\\', $this->plugin->getNameSpace() . '\\' . $className),
            ];
            JsonFile::write(CONFIG_PATH . DIRECTORY_SEPARATOR . 'plugins.json', $plugins);
        }
    }

    private function getPluginRootPath(): string
    {
        return $this->plugin->getPath() . DIRECTORY_SEPARATOR;
    }

    private function getPluginSrcPath(): string
    {
        return $this->getPluginRootPath() . 'src';
    }
}
