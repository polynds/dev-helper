<?php

namespace DevHelper\Plugin\ColorCode;

use DevHelper\Lib\Console\AbstractCommand;
use DevHelper\Lib\File\FileReader;

class ColorCodeCommand extends AbstractCommand
{
    protected string $name = 'colorCode';

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
        (new ColorCode($data))->run();
    }

    protected function configure()
    {
        $this->setDescription('给代码上色');
    }
}
