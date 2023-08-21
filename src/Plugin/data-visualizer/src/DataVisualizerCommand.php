<?php

namespace DevHelper\Plugin\DataVisualizer;

use DevHelper\Lib\Console\AbstractCommand;
class DataVisualizerCommand extends AbstractCommand
{
    protected string $name = 'dataVisualizer';
    public function handle()
    {
    }
    protected function configure()
    {
        $this->setDescription('数据可视化展示');
    }
}