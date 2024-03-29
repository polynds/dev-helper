<?php

declare(strict_types=1);
/**
 * happy coding!!!
 */

namespace DevHelper\Lib;

class Config
{
    protected string $configPath = SRC_PATH . '/config/config.php';

    protected array $configs;

    public function __construct()
    {
        $this->readConfig();
    }

    protected function readConfig()
    {
        $this->configs = require $this->configPath;
    }

    public function get(string $key)
    {
        $key = explode('.', $key);
        while (!is_null($item = array_shift($key))) {
            if (array_key_exists($item, $this->configs)) {
                return $this->configs[$item];
            }
        }

        return null;
    }
}
