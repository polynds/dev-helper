<?php

namespace DevHelper\Plugin\DataVisualizer;

use DevHelper\Lib\Console\AbstractCommand;
use DevHelper\Lib\File\FileReader;

class DataVisualizerCommand extends AbstractCommand
{
    protected string $name = 'dataVisualizer';

    public function handle()
    {
        $path = $this->askAndValidate('请输入文件路径:', static function ($value) {
            if (!$value) {
                throw new \InvalidArgumentException(
                    '输入错误'
                );
            }

            if (!file_exists($value)) {
                throw new \InvalidArgumentException(
                    '输入错误,文件不存在'
                );
            }

            return $value;
        }, 3);

        $data = FileReader::read($path);
        (new DataVisualizer($data))->generate();

    }

    protected function configure()
    {
        $this->setDescription('数据可视化展示');
    }
}
