<?php

return [

    'root' => 'public',

    'directory' => [
        'banner' => 'banner',
        'news' => 'news',
        'page' => 'page',
        'setting' => 'setting'
    ],

    'size' => [
        'banner' => [
            'width' => 1400,
            'height' => 533,
            'mobile' => [
                'postfix' => '-mb',
                'width' => 600,
                'height' => 600,
            ],
            'thumbnail' => [
                'postfix' => '-t',
                'width' => 150,
                'height' => 150
            ]
        ],
        'news' => [
            'width' => 1920,
            'height' => 1080
        ],
        'page' => [
            'width' => 1920,
            'height' => 1080
        ]
    ]

];
