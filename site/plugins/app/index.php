<?php

use Kirby\Cms\App as Kirby;

Kirby::plugin('beebmx/app', [
    'blueprints' => [
        // Icon picker shared by every blueprint: `extends: fields/icon`
        'fields/icon' => fn () => [
            'label' => 'Icono',
            'type' => 'select',
            'icon' => 'palette',
            'options' => array_map(
                fn (array $icon) => $icon[0],
                require dirname(__DIR__, 3).'/app/View/icons.php'
            ),
        ],
    ],
]);
