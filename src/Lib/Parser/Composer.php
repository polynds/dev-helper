<?php

declare(strict_types=1);
/**
 * happy coding!!!
 */
namespace DevHelper\Lib\Parser;

use Composer\Autoload\ClassLoader;

class Composer
{
    private static array $scripts = [];

    private static array $versions = [];

    private static ?ClassLoader $classLoader = null;

    public static function getLoader(): ClassLoader
    {
        if (! self::$classLoader) {
            self::$classLoader = self::findLoader();
        }
        return self::$classLoader;
    }

    public static function setLoader(ClassLoader $classLoader): ClassLoader
    {
        self::$classLoader = $classLoader;
        return $classLoader;
    }

    public static function getScripts(): array
    {
        return self::$scripts;
    }

    public static function getVersions(): array
    {
        return self::$versions;
    }

    private static function findLoader(): ClassLoader
    {
        $composerClass = '';
        foreach (get_declared_classes() as $declaredClass) {
            if (str_starts_with($declaredClass, 'ComposerAutoloaderInit') && method_exists($declaredClass, 'getLoader')) {
                $composerClass = $declaredClass;
                break;
            }
        }
        if (! $composerClass) {
            throw new \RuntimeException('Composer loader not found.');
        }
        return $composerClass::getLoader();
    }
}
