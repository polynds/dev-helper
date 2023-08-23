<?php

declare(strict_types=1);
/**
 * happy coding!!!
 */

namespace DevHelper\Plugin\GenDoc;

class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'commands' => [
                GenDocCommand::class
            ],
        ];
    }
}
