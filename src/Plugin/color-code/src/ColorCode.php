<?php

namespace DevHelper\Plugin\ColorCode;

class ColorCode
{
    public function __construct(
        protected string $data
    ) {
    }


    public function run()
    {

    }

    public function output(?string $path = null): string
    {
        $file = $path ?? md5(time()) . '.png';
        imagepng($this->canvas, $file);
        return $file;
    }
}
