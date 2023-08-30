<?php

namespace DevHelper\Plugin\DataVisualizer;

use DevHelper\Lib\Console\AbstractCommand;
use DevHelper\Lib\File\FileReader;

class DataVisualizerCommand extends AbstractCommand
{
    protected string $name = 'dataVisualizer';

    public function handle()
    {
        $data = $this->askAndValidate('请输入文件路径或者数据:', static function ($value) {
            if (!$value) {
                throw new \InvalidArgumentException(
                    '输入错误'
                );
            }

            return $value;
        }, 3);

        if (file_exists($data)) {
            $data = FileReader::read($data);
        }

        //        (new DataVisualizer($data))->generate()->save();
        (new Render())->setObject((new DataObject())->setData($data)->feed())->build();

    }

    protected function configure()
    {
        $this->setDescription('数据可视化展示');
    }
}
