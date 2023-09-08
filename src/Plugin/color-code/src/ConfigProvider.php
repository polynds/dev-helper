<?php

declare(strict_types=1);
/**
 * happy coding!!!
 */
namespace DevHelper\Plugin\ColorCode;

class ConfigProvider
{
    public function __invoke(): array
        {
            return [
                'commands' => [
                 ColorCodeCommand::class
                ],
            ];
        }
}
