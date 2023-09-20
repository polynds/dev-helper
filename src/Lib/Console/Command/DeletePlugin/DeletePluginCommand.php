<?php

declare(strict_types=1);
/**
 * happy coding!!!
 */

namespace DevHelper\Lib\Console\Command\DeletePlugin;

use DevHelper\Lib\Collection;
use DevHelper\Lib\Console\AbstractCommand;
use DevHelper\Lib\Console\Command\CommandStatus;
use DevHelper\Lib\File\JsonFile;

class DeletePluginCommand extends AbstractCommand
{
    protected string $name = 'deletePlugin';

    public function handle()
    {
        $this->line('提示：插件名称是多个单词组成的需要以-或者_分隔；');
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
                    $plugin['status'] = CommandStatus::DISABLED;
                }
            })->toArray();
            JsonFile::write($this->getPluginPath(), $newPlugins);
        }
    }

    protected function configure()
    {
        $this->setDescription('删除插件');
    }
}
