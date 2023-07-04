<?php

namespace DevHelper\Plugin\GenDoc;

use DevHelper\Lib\Console\AbstractCommand;

class GenDocCommand extends AbstractCommand
{
    protected string $name = 'genDoc';

    public function handle()
    {
        $this->line('欢迎使用自动化文档生成工具！');
        //        $path = BASE_PATH . '/src/Lib/';
        $path = $this->askAndValidate('请输入操作目录:', static function ($value) {
            if (!$value) {
                throw new \InvalidArgumentException(
                    '输入错误'
                );
            }
            if (!is_dir($value)) {
                throw new \InvalidArgumentException(
                    '不是一个正确的目录'
                );
            }
            if (!is_writeable($value)) {
                throw new \InvalidArgumentException(
                    '不是一个可操作的目录'
                );
            }
            return $value;
        }, 3);
        $this->line('开始生成，请稍等...');
        (new GenDoc($path))->build();
        $this->line('操作成功！UML文件已存放至根目录！');
    }

    protected function configure()
    {
        $this->setDescription('自动化文档生成');
    }
}
