<?php

namespace DevHelper\Plugin\DataVisualizer;

use DevHelper\Lib\Console\AbstractCommand;
class DataVisualizerCommand extends AbstractCommand
{
    protected string $name = 'dataVisualizer';
    public function handle()
    {
        $str = $this->askAndValidate('请输入文件路径:', static function ($value) {
            if (!$value) {
                throw new \InvalidArgumentException(
                    '输入错误'
                );
            }

            return $value;
        }, 3);
    }
    protected function configure()
    {
        $this->setDescription('数据可视化展示');
    }
}