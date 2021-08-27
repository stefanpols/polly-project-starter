<?php

namespace App\Controllers\Api;


use Polly\Core\Config;

class Version extends ApiController
{
    public function index()
    {
        $this->response->version = Config::get('version');
    }
}