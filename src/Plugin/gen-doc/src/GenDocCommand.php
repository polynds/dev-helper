<?php

namespace DevHelper\Plugin\GenDoc;

use DevHelper\Lib\Console\AbstractCommand;
class GenDocCommand extends AbstractCommand
{
    protected string $name = 'genDoc';
    public function handle()
    {
    }
    protected function configure()
    {
        $this->setDescription('自动化文档生成');
    }
}