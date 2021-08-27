<?php


use App\Controllers\Web\Login;
use App\Services\UserService;
use Polly\Database\PDODriver;
use Polly\Exceptions\AuthenticationException;
use Polly\Exceptions\AuthorizeException;
use Polly\Exceptions\InvalidRouteException;
use Polly\Support\Authentication\BasicAuthenticationAgent;
use Polly\Support\Authorization\RoleAuthorizationAgent;

return
    [

    //Name of the project
    'name' => 'Project name',

    //URL of the project
    'site_url' => env('APP_URL'),

    //Set debugging based on env's DEBUG value
    'debug' =>  (bool) env('DEBUG', false),

    //Current version. Also used for asset url's
    'version' => env('VERSION', 1),

    //Sets which PHP errors are reported
    'error_reporting' => (E_ALL | E_STRICT | E_PARSE),

    /*
     * Set the default startup locale for the app.
     * This locale determines which translation file is used.
     * For example when setting locale to 'nl', the translation file resources/locale/nl.json will be used.
     * On the other hand PHP's locale (LC_TIME) will be set. Since it's machine based which locales are installed it is optional to define "LOCALES" in the .env file.
     * An example for:
     *      LOCALES = "nl=nl_NL@utf8 | en=en_US@utf8"
     * The values "nl_NL@utf8" and "en_US@utf8" will be used for the 'setlocale' call, but "nl" and "en" are used for translation files.
     * When LOCALES is not defined in de .env file, the given local will be used.
     * App::getLocale() will also return the given locale name.
     */
    'locale' => 'nl',

    //Default timezone to load, @see https://www.php.net/manual/en/timezones.php
    'timezone' => 'Europe/Amsterdam',

    //Compressing the output by removing tabs and white spaces. Makes the output smaller and harder to read. Do not use with inline javascript.
    'compress_output' => false,

    //Class constant reference of the database driver to use.
    'db_driver' => PDODriver::class,

    /*
     * Log handler for saving log data to the file. Currently only one file, so one file_path config.
     */
    'log' =>
    [
        'file_path' => storage_path('logs/app.log')
    ],

    /*
     * Shutdown handler
     *      catch       Array of predefined constants the shutdown handler should catch. An exception will be thrown on catch.
     *      log         Array of predefined constants that needs to be logged. No error will be thrown.
     */
    'shutdown' =>
    [
        'catch' => [E_ERROR, E_PARSE], //[],
        'log' => [E_ALL] //[E_ALL, E_STRICT]
    ],


    /*
     * The routing is dividable into groups. A group represents a different (sub)system which has a different endpoint.
     * They can be used to separate routing and handler logics.
     * Use wildcard (*) as base URL to catch all URL's
     * If one group contains an other groups base URL it's important to first add the most specific.
     * For example when https://example.com and https://example.com/api are the base URL's, you need to add the api path first.
     *
     * Examples for group usage:
     * - System has a web environment (web.example.com) and an API (api.example.com)
     * - System has a front-end (example.com) and a back-end system (backend.example.com).
     *
     * Options:
     *      default_controller      Default controller to create when there could no controller be fetched from the URL. Default = index
     *      default_method          Default method to invoke when there could no method be fetched from the URL. Default = index
     *      groups                  array with group options:
     *          base_url                The base url that an URL need to contain to identify this group. A wildcard can be used to catch all URL's
     *          namespace               Namespace to find the controllers
     *          public                  array of class constant references that dont need authentication. A wildcard can be used as well if everything should be public available.
     *          authentication          An instance of IAuthenticationAgent that needs to handle the authentication of this group.
     *                                  Polly\Support\Authentication\BasicAuthenticationAgent facilitates a default cookie/database based authenthication
     *          authorization           An instance of IAuthorizationAgent that needs to handle the authorization of this group
     *                                  Polly\Support\Authorization\RoleAuthorizationAgent facilitates a default role based autorization.
     *
     * All controllers needs to extends from Polly\Core\Controller
     */
    'routing' =>
    [
        'groups' =>
        [
            [
                'base_url'          => env('API_URL'),
                'namespace'         => "App\Controllers\Api",
                'public'            => ['*'],
            ],
            [
                'base_url'          => env('APP_URL'),
                'namespace'         => "App\Controllers\Web",
                'public'            => [Login::class],
                'authentication'    => BasicAuthenticationAgent::getInstance(UserService::getInstance(), 0),
                'authorization'     => RoleAuthorizationAgent::getInstance()
            ]
        ],
    ],


    /*
     * Uncatched exceptions can be catched by defining exception handlers.
     * Each row in the 'exception_handlers' is a handler. The key should be the class constant reference. A wildcard can be used to catch all exceptions.
     * If using wildcard, make sure to place it as last, since the exception handling works from top to bottom.
     * Two types can be defined: 'view' and 'redirect'
     *
     * View options:
     *      type            view
     *      target          A relative path from the views directory of the view to display.
     *                      Use ! add the end to prevent the view from rendering through base (equivalent for setViewOnly)
     *
     * Redirect options:
     *      type            redirect
     *      add_origin      if true, HTTP GET 'origin' header will be added on redirect.
     *      target          the relative url from the current routing group's base URL to redirect.
     *
     * Universal options (work for view and redirect type)
     *      http_code       The http code to respond. Defining an http code will prevent returning data on XHR request
     *      headers         array of HTTP headers to add
     *      message         array of message options:
     *          type            A value of Message::SUCCESS/INFO/WARNING/DANGER;
     *          title           A string for the title of the message. Can be a closure that returns the title. Can be useful when translation is needed.
     *          description     A string for the description of the message. Can be a closure that returns the message. Can be useful when translation is needed.
     */
    'exception_handlers' =>
    [
        InvalidRouteException::class =>
            [
                'type' => 'view',
                'http_code' => 404,
                'target' => 'Error/404!'
            ],
        AuthorizeException::class =>
            [
                'type' => 'view',
                'http_code' => 403,
                'target' => 'Error/403!'
            ],
        AuthenticationException::class =>
            [
                'type' => 'redirect',
                'add_origin' => true,
                'target' => 'login',
                'http_code' => 401,
                'headers' => [ 'Polly-Require-Auth: true' ],
            ],
        '*' =>
            [
                'type' => 'view',
                'http_code' => 500,
                'target' => 'Error/500!'
            ]

    ],

    /*
     * ORM config to define how data is parsed to objects. Options:
     *      naming_strategy    Class constant reference of the class which defines the naming strategy.
     *                         The naming strategy defines the convention/translation for mapping a property to database column.
     *                         A naming strategy class needs to implement Polly\ORM\Interfaces\INamingStrategy.
     *                         Polly\Support\ORM\DefaultNamingStrategy facilitate a default naming strategy based on best practise naming convention for MySQL.
     *                         This one is also used when no strategy is specified.
     *      cache              Whenever to enable entity cache or not. Default = true.
     *      default_pk_type    The default primary key type of entities. Default = UUID.
     *
     */
    'orm' =>
    [

    ],

    'mailer' =>
    [
        'from_address'      => 'info@codens.nl',
        'from_name'         => 'Codens B.V.',
        'log_address'       => 'info@codens.nl',
        'log_name'          => 'Codens B.V.',
        'send_copy'         => ['info@codens.nl'],
    ]


];

