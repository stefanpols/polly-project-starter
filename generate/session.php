<?php

use Polly\ORM\Annotations\ForeignId;
use Polly\ORM\Annotations\LazyMany;
use Polly\ORM\Annotations\LazyOne;
use Polly\ORM\Annotations\Variable;
use Polly\ORM\Types\DateTime;
use Polly\ORM\Validation\Email;
use Polly\ORM\Validation\Ip;
use Polly\ORM\Validation\NotEmpty;
use Polly\ORM\Validation\Unique;

return
    [
        "entity" => "Session",
        "fields" =>
            [
                "userId" => [
                    'type' => 'string',
                    'annotations' => [ForeignId::class, NotEmpty::class]
                ],
                "token" => [
                    'type' => 'string',
                    'annotations' => [Variable::class, NotEmpty::class]
                ],
                "created" => [
                    'type' => DateTime::class,
                    'annotations' => [Variable::class, NotEmpty::class]
                ],
                "lastActivity" => [
                    'type' => DateTime::class,
                    'annotations' => [Variable::class, NotEmpty::class]
                ],
                "ipAddress" => [
                    'type' => 'string',
                    'annotations' => [Variable::class, NotEmpty::class, Ip::class]
                ],
                "userAgent" => [
                    'type' => 'string',
                    'annotations' => [Variable::class, NotEmpty::class]
                ],
            ],
        "relations" =>
            [
                'user' => [
                    'type' => LazyOne::class,
                    'entity' => "User"
                ]
            ],

        "model_dir" => '/Models',
        "repository_dir" => "/Repositories",
        "service_dir" => '/Services',
        "controller_dir" => '/Controllers/Web',
        "view_dir" => '/Views',
    ];


