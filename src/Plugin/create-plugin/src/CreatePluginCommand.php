<?php

declare(strict_types=1);
/**
 * happy coding!!!
 */
namespace DevHelper\Plugin\CreatePlugin;

use DevHelper\Lib\Console\AbstractCommand;

class CreatePluginCommand extends AbstractCommand
{
    protected string $name = 'createPlugin';

    public function handle()
    {
        $this->ask('请输入插件名称：', '');
        $this->ask('请输入插件名称：', '');

        $plugin = new Plugin();
        $factory = new PluginFactory($plugin);
        $factory->create();
    }

    protected function configure()
    {
        parent::configure();
        $this->setDescription('创建插件');
    }
}
