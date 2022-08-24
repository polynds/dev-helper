<?php

declare(strict_types=1);
/**
 * happy coding!!!
 */
namespace DevHelper\Plugin\GenerateDiagram;

use DevHelper\Lib\Console\AbstractCommand;
use DevHelper\Lib\File\FileFinder;
use DevHelper\Lib\PHPParser\ClassParser;

class GenerateDiagramCommand extends AbstractCommand
{
    protected string $name = 'generateDiagram';

    public function handle()
    {
        $path = SRC_PATH;
        $fileFinder = new FileFinder();
        $files = $fileFinder->findFiles($path);
        var_dump($files);

        $parser = new ClassParser();
        foreach ($files as $file) {
            $stmts = $parser->parse(file_get_contents($file));
            $data = $parser->parseClassByStmts($stmts);
            var_dump($data);
        }
    }

    protected function configure()
    {
        $this->setDescription('生成类图');
    }
}
