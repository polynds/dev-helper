<?php

namespace DevHelper\Plugin\DataVisualizer;

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
        // TODO: Implement draw() method.
    }

    public function output(?string $path = null): string
    {
        $file = $path ?? md5(time()) . '.png';
        imagepng($this->canvas, $file);
        return $file;
    }
}
