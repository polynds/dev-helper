<?php

namespace DevHelper\Plugin\DataVisualizer\Canvas;

use DevHelper\Plugin\DataVisualizer\Canvas\Draw\DrawInterface;
use DevHelper\Plugin\DataVisualizer\DataObject;

interface CanvasInterface
{
    public function init(int $width, int $height): void;

//    public function pencil(DrawInterface $pencil): void;

    public function draw(DataObject $object): void;

    public function output(?string $path = null): string;

}
