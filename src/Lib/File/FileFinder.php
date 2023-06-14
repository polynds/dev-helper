<?php

declare(strict_types=1);
/**
 * happy coding!!!
 */

namespace DevHelper\Lib\File;

use SplFileInfo;
use Symfony\Component\Finder\Finder;

class FileFinder
{
    protected string $fileExtensions;

    public function __construct(string $fileExtensions = 'php')
    {
        $this->fileExtensions = $fileExtensions;
    }

    public function findFiles(string $path): array
    {
        $files = [];
        if (is_file($path)) {
            if (!file_exists($path)) {
                throw new PathNotFoundException($path);
            }
            $files[] = $path;
        } else {
            $finder = new Finder();
            $finder->followLinks();
            /** @var SplFileInfo $fileInfo */
            foreach ($finder->files()
                         ->name('*.{' . $this->fileExtensions . '}')
                         ->ignoreDotFiles(true)
                         ->in($path) as $fileInfo) {
                $files[] = $fileInfo->getPathname();
            }
        }
        return $files;
    }

    public function tree(string $path): array
    {
        $finder = new Finder();
        $finder->followLinks();
        $files = $finder->in($path)->ignoreDotFiles(true)->getIterator();
        $result = [];
        /** @var SplFileInfo $fileInfo */
        foreach ($files as $fileInfo) {
            $result[] = $fileInfo->getPathname();
        }
        return $result;
    }
}
