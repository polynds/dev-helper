<?php

declare(strict_types=1);
/**
 * happy coding!!!
 */

namespace DevHelper\Lib\Console\Command\CreatePlugin;

use Composer\Pcre\Preg;
use DevHelper\Lib\Console\AbstractCommand;
use DevHelper\Utils\Str;

class CreatePluginCommand extends AbstractCommand
{
    protected string $name = 'createPlugin';

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
        $composerName = 'devhelper-plugin/' . $pluginName;
        if (!Preg::isMatch('{^[a-z0-9_.-]+/[a-z0-9_.-]+$}D', $composerName)) {
            throw new \InvalidArgumentException(
                'The package name ' . $composerName . ' is invalid, it should be lowercase and have a vendor name, a forward slash, and a package name, matching: [a-z0-9_.-]+/[a-z0-9_.-]+'
            );
        }
        $composerDesc = $this->askAndValidate('请输入插件描述:', static function ($value) {
            if (!$value) {
                throw new \InvalidArgumentException(
                    'The plugin desc is invalid'
                );
            }
            return Str::convert2utf8($value);
        });
        $authorName = $this->askAndValidate('请输入作者姓名:', static function ($value) {
            return $value ? Str::convert2utf8($value) : $value;
        }, null, '');
        $authorEmail = $this->askAndValidate('请输入作者邮箱:', null, null, '');
        $NameSpace = 'DevHelper\\Plugin\\' . Str::bigCamel($pluginName);
        $plugin = (new Plugin())
            ->setPath(PLUGIN_PATH . '/' . $pluginName)
            ->setPluginName($pluginName)
            ->setComposerName($composerName)
            ->setComposerDesc($composerDesc)
            ->setComposerLicense('Apache-2.0')
            ->setAuthorName($authorName)
            ->setAuthorEmail($authorEmail)
            ->setNameSpace($NameSpace)
            ->setClassName(Str::bigCamel($pluginName))
            ->setCommandName(Str::camel($pluginName));
        $factory = new PluginFactory($plugin);
        $factory->create();
    }

    protected function configure()
    {
        $this->setDescription('创建插件');
    }
}
