<?php

declare(strict_types=1);
/**
 * happy coding!!!
 */
namespace DevHelper\Plugin\CreatePlugin\Composer;

use DevHelper\Lib\File\FileWriter;

class ComposerFactory
{
    protected Composer $composer;

    protected string $fileName;

    public function __construct(Composer $composer, string $fileName)
    {
        $this->composer = $composer;
        $this->fileName = $fileName;
    }

    public static function with(Composer $composer, string $fileName): self
    {
        return new static($composer,$fileName);
    }

    public function writeComposerJSON()
    {
        FileWriter::write($this->fileName, json_encode($this->composer));
    }
}
