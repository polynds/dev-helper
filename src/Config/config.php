<?php

declare(strict_types=1);
/**
 * happy coding!!!
 */
use DevHelper\Plugin\CreatePlugin\CreatePluginCommand;
use DevHelper\Plugin\DicTree\GenerateDicTreeCommand;
use DevHelper\Plugin\PlantUML\GenerateClassDiagramCommand;

/*
 * 插件注册
 */
return [
    'plugins' => [
        [
            'name' => 'create-plugin',
            'command' => CreatePluginCommand::class,
        ],
        [
            'name' => 'plantuml',
            'command' => GenerateClassDiagramCommand::class,
        ],
        [
            'name' => 'dic-tree',
            'command' => GenerateDicTreeCommand::class,
        ],
    ],
];
