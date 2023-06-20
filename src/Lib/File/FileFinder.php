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
            $pathArr = explode('/', $fileInfo->getFilename());
            array_shift($pathArr);
            $last = array_pop($pathArr);
            foreach (array_reverse($pathArr) as $pathName) {
                $last = [$pathName => $last];
            }
            $result = array_merge_recursive($result, $last);
        }
        return $result;
    }

    public function tree2(string $path): array
    {
        $finder = new Finder();
        $finder->followLinks();
        $files = $finder->in($path)->ignoreDotFiles(true)->getIterator();
        $result = [];
        /** @var SplFileInfo $fileInfo */
        foreach ($files as $fileInfo) {
            $result = array_merge_recursive($result, $this->parsePath($fileInfo));
        }
        natsort($result);
        return $result;
    }

    protected function parsePath(SplFileInfo $fileInfo): array
    {
        $result = [];
        if ($fileInfo->isDir()) {
            if (empty($fileInfo->getRelativePath())) {
                return $result;
            }
            $result = array_merge_recursive($result, [$fileInfo->getRelativePath() => []]);
        } elseif ($fileInfo->isFile()) {
            if (empty($fileInfo->getRelativePath())) {
                $file = [$fileInfo->getFilename()];
            } else {
                $file = [$fileInfo->getRelativePath() => $fileInfo->getFilename()];
            }
            $result = array_merge_recursive($result, $file);
        }
        return $result;
    }
}
