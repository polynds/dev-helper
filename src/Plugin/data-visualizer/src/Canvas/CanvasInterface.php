<?php

namespace DevHelper\Plugin\DataVisualizer;

interface CanvasInterface
{
    public function init(int $width, int $height): void;

    public function draw(DataObject $object): void;

    public function output(?string $path = null): string;

}
