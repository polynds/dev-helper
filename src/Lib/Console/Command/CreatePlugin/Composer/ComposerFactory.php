<?php

declare(strict_types=1);
/**
 * happy coding!!!
 */
namespace DevHelper\Lib\Console\Command\CreatePlugin\Composer;

use DevHelper\Lib\File\JsonFile;

class ComposerFactory
{
    protected Composer $composer;

    protected string $path;

    protected string $fileName = 'composer.json';

    public function __construct(Composer $composer, string $path)
    {
        $this->composer = $composer;
        $this->path = $path;
    }

    public function writeComposerJSON()
    {
        JsonFile::write($this->path . DIRECTORY_SEPARATOR . $this->fileName, $this->composer->toArray());
    }
}
