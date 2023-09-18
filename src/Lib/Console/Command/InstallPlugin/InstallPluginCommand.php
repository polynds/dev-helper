<?php

declare(strict_types=1);
/**
 * happy coding!!!
 */

namespace DevHelper\Lib\Console\Command\InstallPlugin;

use DevHelper\Lib\Collection;
use DevHelper\Lib\Console\AbstractCommand;
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
        $plugins = JsonFile::read(CONFIG_PATH . DIRECTORY_SEPARATOR . 'plugins.json');
        if ($plugins && is_array($plugins)) {
            $newPlugins = Collection::make($plugins)->find(function ($plugin) use ($pluginName) {
                if ($plugin['name'] == $pluginName) {
                    return true;
                }
                return false;
            })->toArray();
            JsonFile::write(CONFIG_PATH . DIRECTORY_SEPARATOR . 'plugins.json', $newPlugins);
        }
    }

    protected function configure()
    {
        $this->setDescription('安装插件');
    }
}
