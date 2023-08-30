<?php

namespace DevHelper\Plugin\DataVisualizer\Canvas\Draw;

interface DrawInterface
{
    public function draw(array|string $imageData): void;
}
