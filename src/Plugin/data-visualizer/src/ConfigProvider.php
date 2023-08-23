<?php

declare(strict_types=1);
/**
 * happy coding!!!
 */

namespace DevHelper\Plugin\DataVisualizer;

class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'commands' => [
                DataVisualizerCommand::class
            ],
        ];
    }
}
