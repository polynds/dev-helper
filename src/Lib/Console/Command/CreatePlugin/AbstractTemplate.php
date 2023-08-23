<?php

declare(strict_types=1);
/**
 * happy coding!!!
 */

namespace DevHelper\Lib\Console\Command\CreatePlugin;

use DevHelper\Lib\Exception\FileNotWritableException;
use DevHelper\Lib\File\FileWriter;

abstract class AbstractTemplate
{
    protected string $path;

    protected string $fileName;

    protected string $content;

    public function write()
    {
        FileWriter::write($this->getPath() . DIRECTORY_SEPARATOR . $this->getFileName(), $this->getContent());
    }

    public function getPath(): string
    {
        return $this->path;
    }

    protected function setPath(string $path): self
    {
        if (!is_dir($path) || !is_writable($path)) {
            throw new FileNotWritableException();
        }
        $this->path = $path;
        return $this;
    }

    public function getFileName(): string
    {
        return $this->fileName;
    }

    protected function setFileName(string $fileName): self
    {
        $this->fileName = $fileName;
        return $this;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    protected function setContent(string $content): self
    {
        $this->content = $content;
        return $this;
    }
}
