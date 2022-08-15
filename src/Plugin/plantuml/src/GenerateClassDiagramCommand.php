<?php

declare(strict_types=1);
/**
 * happy coding!!!
 */
namespace DevHelper\Plugin\PlantUML;

use DevHelper\Lib\Console\AbstractCommand;
use DevHelper\Lib\File\FileFinder;
use DevHelper\Lib\Parser\ClassParser;

class GenerateClassDiagramCommand extends AbstractCommand
{

    protected string $name = 'classDiagram';

    public function show()
    {
        $path = APP_PATH;
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

    public function handle()
    {
        $this->show();
    }

    protected function configure()
    {
        parent::configure();
        $this->setDescription('生成领域类图');
    }
}
