<?php

use Polly\ORM\Annotations\LazyMany;
use Polly\ORM\Annotations\LazyOne;
use Polly\ORM\Annotations\Variable;
use Polly\ORM\Types\DateTime;
use Polly\ORM\Validation\Email;
use Polly\ORM\Validation\NotEmpty;
use Polly\ORM\Validation\Unique;

return
    [
        "entity" => "User",
        "fields" =>
            [
                "firstname" => [
                    'type' => 'string',
                    'annotations' => [Variable::class, NotEmpty::class]
                ],
                "lastname" => [
                    'type' => 'string',
                    'annotations' => [Variable::class, NotEmpty::class]
                ],
                "username" => [
                    'type' => 'string',
                    'annotations' => [Variable::class, NotEmpty::class, Email::class, Unique::class]
                ],
                "password" => [
                    'type' => 'string',
                    'annotations' => [Variable::class, NotEmpty::class]
                ],
                "created" => [
                    'type' => DateTime::class,
                    'annotations' => [Variable::class, NotEmpty::class]
                ],
                "active" => [
                    'type' => 'int',
                    'annotations' => [Variable::class, NotEmpty::class]
                ],
            ],
        "relations" =>
            [
                'sessions' => [
                    'type' => LazyMany::class,
                    'entity' => "Session"
                ]
            ],

        "model_dir" => '/Models',
        "repository_dir" => "/Repositories",
        "service_dir" => '/Services',
        "controller_dir" => '/Controllers/Web',
        "view_dir" => '/Views',
    ];


