<?php

declare(strict_types=1);
/**
 * happy coding!!!
 */
namespace DevHelper\Plugin\Keccak256;

class ConfigProvider
{
    public function __invoke(): array
        {
            return [
                'commands' => [
                 Keccak256Command::class
                ],
            ];
        }
}
