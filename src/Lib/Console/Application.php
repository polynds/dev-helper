<?php

declare(strict_types=1);
/**
 * happy coding!!!
 */

namespace DevHelper\Lib\Console;

use DevHelper\Lib\Console\Command\CreatePlugin\CreatePluginCommand;
use DevHelper\Lib\Console\Command\DeletePlugin\DeletePluginCommand;
use DevHelper\Lib\File\JsonFile;
use DevHelper\Lib\PHPParser\Composer;
use DevHelper\Utils\StaticInstance;
use Symfony\Component\Console\Application as BaseApplication;

final class Application extends BaseApplication
{
    use StaticInstance;

    public function __construct(string $name = 'DH Console', string $version = '1.0')
    {
        parent::__construct($name, $version);
        $this->registerLibCommand();
        $this->registerCommand();
        Application::$instance = $this;
    }

    protected function registerLibCommand()
    {
        $this->addCommands([
            new CreatePluginCommand(),
            new DeletePluginCommand(),
        ]);
    }

    public function registerCommand()
    {
        $commands = [];
        $plugins = JsonFile::read(CONFIG_PATH . DIRECTORY_SEPARATOR . 'plugins.json');
        foreach ($plugins as $plugin) {
            if($plugin['status'] == 'disabled') {
                continue;
            }
            $className = $plugin['command'];
            $file = Composer::getLoader()->findFile($className);
            if (!$file) {
                continue;
            }
            $commands[] = new $className();
        }
        $this->addCommands($commands);
    }

    public function plugins(): array
    {
        return JsonFile::read(CONFIG_PATH . DIRECTORY_SEPARATOR . 'plugins.json');
    }

}
