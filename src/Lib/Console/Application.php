<?php

declare(strict_types=1);
/**
 * happy coding!!!
 */
namespace DevHelper\Lib\Console;

use DevHelper\Lib\File\JsonFile;
use DevHelper\Lib\Parser\Composer;
use Symfony\Component\Console\Application as BaseApplication;

final class Application extends BaseApplication
{
    public function __construct(string $name = 'DH Console', string $version = '1.0')
    {
        parent::__construct($name, $version);
        $this->registerCommand();
    }

    public function registerCommand()
    {
        $commands = [];
        $plugins = JsonFile::read(CONFIG_PATH . DIRECTORY_SEPARATOR . 'plugins.json');
        foreach ($plugins as $plugin) {
            $className = $plugin['command'];
            $file = Composer::getLoader()->findFile($className);
            if (! $file) {
                continue;
            }
            $commands[] = new $className();
        }
        $this->addCommands($commands);
    }
}
