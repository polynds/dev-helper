<?php

declare(strict_types=1);
/**
 * happy coding!!!
 */
namespace DevHelper\Plugin\CreatePlugin;

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
        $this->createComposer();
        $this->createDotGitIgnore();
        $this->createCommand();
    }

    protected function createDir()
    {
    }

    protected function createComposer()
    {
    }

    protected function createDotGitIgnore()
    {
    }

    protected function createCommand()
    {
    }
}
