<?php

declare(strict_types=1);
/**
 * happy coding!!!
 */

namespace DevHelper\Lib\Console\Command\InstallPlugin;

use DevHelper\Lib\Collection;
use DevHelper\Lib\Console\AbstractCommand;
use DevHelper\Lib\Console\Command\CommandStatus;
use DevHelper\Lib\File\JsonFile;

class InstallPluginCommand extends AbstractCommand
{
    protected string $name = 'installPlugin';

    public function handle()
    {
        $pluginName = $this->askAndValidate('请输入插件名称:', static function ($value) {
            if (!$value) {
                throw new \InvalidArgumentException(
                    'The plugin name is invalid'
                );
            }
            return $value;
        });
        $plugins = JsonFile::read($this->getPluginPath());
        if ($plugins && is_array($plugins)) {
            $newPlugins = Collection::make($plugins)->map(function ($plugin) use ($pluginName) {
                if ($plugin['name'] == $pluginName) {
                    $plugin['status'] = CommandStatus::ENABLED;
                }
            })->toArray();
            if (!$newPlugins) {
                throw new \InvalidArgumentException("Error: 插件 {$pluginName} 不存在");
            }
            JsonFile::write($this->getPluginPath(), $newPlugins);
        }
    }

    protected function configure()
    {
        $this->setDescription('安装插件');
    }
}
