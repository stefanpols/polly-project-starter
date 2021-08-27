<?php

namespace App\Controllers\Api;


use Polly\Core\Config;

class Index extends ApiController
{
    public function index()
    {
        $this->response->setHttpCode(401);
    }
}