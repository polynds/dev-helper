<?php

namespace DevHelper\Plugin\Keccak256;

use DevHelper\Lib\Console\AbstractCommand;

class Keccak256Command extends AbstractCommand
{
    protected string $name = 'keccak256';

    public function handle()
    {
        $str = $this->askAndValidate('请输入带加密字符串:', static function ($value) {
            if (!$value) {
                throw new \InvalidArgumentException(
                    '输入错误'
                );
            }

            return $value;
        }, 3);
        var_dump(Keccak256::hash($str, 256));
    }

    protected function configure()
    {
        $this->setDescription('keccak256');
    }
}
