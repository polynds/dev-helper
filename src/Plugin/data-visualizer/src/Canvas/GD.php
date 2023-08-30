<?php

namespace DevHelper\Plugin\DataVisualizer\Canvas;

class GD extends AbstractCanvas implements CanvasInterface
{
    public function init(int $width, int $height): void
    {
        if (!extension_loaded('gd')) {
            throw new \Exception('GD extension is not loaded');
        }
        $this->canvas = imagecreatetruecolor($this->width, $this->height);
    }

    public function draw(DataObject $object): void
    {
        $i = 0;
        for ($y = 0; $y < $this->height; $y++) {
            for ($x = 0; $x < $this->width; $x++) {
                $rgba = array();
                $rgba['red'] = rand(0, $imageData[$i] ?? 0);
                $rgba['green'] = rand(0, $imageData[$i] ?? 0);
                $rgba['blue'] = rand(0, $imageData[$i] ?? 0);
                $i++;
                $color = imagecolorallocate($this->canvas, $rgba['red'], $rgba['green'], $rgba['blue']);
                imagesetpixel($this->canvas, $x, $y, $color);
            }
        }
    }

    public function output(?string $path = null): string
    {
        $file = $path ?? md5(time()) . '.png';
        imagepng($this->canvas, $file);
        return $file;
    }
}
