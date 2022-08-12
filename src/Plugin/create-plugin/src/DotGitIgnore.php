<?php

declare(strict_types=1);
/**
 * happy coding!!!
 */
namespace DevHelper\Plugin\CreatePlugin;

use DevHelper\Lib\Exception\FileNotWritableException;
use DevHelper\Lib\File\FileWriter;

class DotGitIgnore
{
    protected string $fileName = '.gitignore';

    protected string $content = <<<'EOF'
.buildpath
.settings/
.project
*.patch
.idea/
.git/
vendor/
.phpintel/
.DS_Store
.phpunit*
*.lock
*.cache
.php-cs-fixer.php
phpstan.neon
EOF;

    public function write(string $path)
    {
        if (! is_dir($path) || ! is_writable($path)) {
            throw new FileNotWritableException();
        }
        FileWriter::write($path . $this->fileName, $this->content);
    }
}
