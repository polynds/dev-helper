<?php

declare(strict_types=1);
/**
 * happy coding!!!
 */

namespace DevHelper\Lib\Console\Command\CreatePlugin;

class ConfigProvider extends AbstractTemplate
{
    protected string $fileName = 'ConfigProvider.php';

    public function __construct(string $srcPath, string $name, string $commandClass)
    {
        $this->setPath($srcPath);
        $this->setContent($this->buildClass($name, $commandClass));
    }

    protected function buildClass(string $name, string $commandClass): string
    {
        $stub = file_get_contents(__DIR__ . '/stubs/ConfigProvider.stub');

        return $this->replaceNameSpace($stub, $name)
            ->replaceCommandClass($stub, $commandClass);
    }

    protected function replaceCommandClass(string $stub, string $commandClass): string
    {
        return str_replace(
            ['%COMMANDCLASS%'],
            [$commandClass],
            $stub
        );
    }

    protected function replaceNameSpace(string &$stub, string $name): self
    {
        $stub = str_replace(
            ['%NAMESPACE%'],
            [$name],
            $stub
        );

        return $this;
    }

    protected function replaceUses(string &$stub, string $uses): self
    {
        $stub = str_replace(
            ['%USES%'],
            [$uses],
            $stub
        );

        return $this;
    }
}
