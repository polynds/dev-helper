<?php

namespace DevHelper\Plugin\DataVisualizer\Canvas\Draw;

class Random implements DrawInterface
{
    public function draw(array|string $imageData): void
    {
        $i = 0;
        for ($y = 0; $y < $this->height; $y++) {
            for ($x = 0; $x < $this->width; $x++) {
                $rgba = array();
                $rgba['red'] = rand(0, $imageData[$i] ?? 0);
                $rgba['green'] = rand(0, $imageData[$i] ?? 0);
                $rgba['blue'] = rand(0, $imageData[$i] ?? 0);
                $i += 3;
                $color = imagecolorallocate($this->image, $rgba['red'], $rgba['green'], $rgba['blue']);
                imagesetpixel($this->image, $x, $y, $color);
            }
        }
    }
}
