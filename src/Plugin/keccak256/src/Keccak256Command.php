<?php

namespace DevHelper\Plugin\Keccak256;

use DevHelper\Lib\Console\AbstractCommand;
class Keccak256Command extends AbstractCommand
{
    protected string $name = 'keccak256';
    public function handle()
    {
    }
    protected function configure()
    {
        $this->setDescription('keccak256');
    }
}