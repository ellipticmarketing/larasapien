<?php

return [
    'token' => env('LARASAPIEN_TOKEN'),

    'checkers' => [
        EllipticMarketing\Larasapien\Checkers\GitChecker::class,
        EllipticMarketing\Larasapien\Checkers\CacheChecker::class,
        EllipticMarketing\Larasapien\Checkers\CpuLoadChecker::class,
        EllipticMarketing\Larasapien\Checkers\HorizonChecker::class,
        EllipticMarketing\Larasapien\Checkers\RedisChecker::class,
        EllipticMarketing\Larasapien\Checkers\ScheduleChecker::class,
    ],

    'options' => [
        'redis' => [
            'key' => '_larasapien.redischecktime'
        ],
        'schedule' => [
            'disk' => 'local',
            'filename' => '_larasapien.schedulechecktime',
            'valid_time_diff' => 60 * 5
        ]
    ]
];
