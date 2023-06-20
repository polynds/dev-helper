<?php

declare(strict_types=1);
/**
 * happy coding!!!
 */

namespace DevHelper\Plugin\GenerateDirTree;

use DevHelper\Lib\Console\AbstractCommand;

class GenerateDirTreeCommand extends AbstractCommand
{
    protected string $name = 'generateDirTree';

    public function handle()
    {
        $this->line('欢迎使用自动生成目录树形图工具！');
        $path = BASE_PATH . '/src/Lib';
        //        $path = $this->askAndValidate('请输入操作目录:', static function ($value) {
        //            if (!$value) {
        //                throw new \InvalidArgumentException(
        //                    '输入错误'
        //                );
        //            }
        //            if (!is_dir($value)) {
        //                throw new \InvalidArgumentException(
        //                    '不是一个正确的目录'
        //                );
        //            }
        //            if (!is_writeable($value)) {
        //                throw new \InvalidArgumentException(
        //                    '不是一个可操作的目录'
        //                );
        //            }
        //            return $value;
        //        }, 3);

        (new GenerateDirTree($path))->generate();
    }

    protected function configure()
    {
        $this->setDescription('生成目录树结构，输出美观的文本');
    }
}
