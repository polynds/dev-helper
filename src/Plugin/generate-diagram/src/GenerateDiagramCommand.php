<?php

declare(strict_types=1);
/**
 * happy coding!!!
 */

namespace DevHelper\Plugin\GenerateDiagram;

use DevHelper\Lib\Console\AbstractCommand;

class GenerateDiagramCommand extends AbstractCommand
{
    protected string $name = 'generateDiagram';

    public function handle()
    {
        $this->line('欢迎使用自动生成UML类图工具！');
        //        $path = $this->askAndValidate('请输入操作目录:', static function ($value) {
        //            if (! $value) {
        //                throw new \InvalidArgumentException(
        //                    '输入错误'
        //                );
        //            }
        //            if (! is_dir($value)) {
        //                throw new \InvalidArgumentException(
        //                    '不是一个正确的目录'
        //                );
        //            }
        //            if (! is_writeable($value)) {
        //                throw new \InvalidArgumentException(
        //                    '不是一个可操作的目录'
        //                );
        //            }
        //            return $value;
        //        }, 3);
        $path = LIB_PATH . '/Console/Command/CreatePlugin';
        //        $path = '/mnt/d/phppro/kj/dev-helper/src';
        $this->line('开始生成，请稍等...');
        $uml = (new GenerateDiagram($path))->build();
        $this->line('操作成功！UML文件已存放至根目录！');
        $uml->output();
    }

    protected function configure()
    {
        $this->setDescription('生成类图');
    }
}
