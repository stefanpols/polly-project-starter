<?php

use Polly\Core\App;

require('../vendor/autoload.php');

App::initialize(dirname(__DIR__,1));
App::handleRequest();