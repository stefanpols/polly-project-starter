<?php

namespace App\Controllers\Api;


class Index extends ApiController
{
    public function index()
    {
        $this->response->setHttpCode(401);
    }
}
