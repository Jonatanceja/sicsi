<?php

return [
    'format' => 'webp',
    'quality' => 80,
    'srcsets' => [
        // Full-width backgrounds (heroes)
        'default' => [
            '480w' => ['width' => 480],
            '768w' => ['width' => 768],
            '1024w' => ['width' => 1024],
            '1280w' => ['width' => 1280],
            '1536w' => ['width' => 1536],
            '1920w' => ['width' => 1920],
        ],
        // Half-width cards and side images
        'card' => [
            '400w' => ['width' => 400],
            '600w' => ['width' => 600],
            '800w' => ['width' => 800],
            '1000w' => ['width' => 1000],
            '1200w' => ['width' => 1200],
        ],
    ],
];
