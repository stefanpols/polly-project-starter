<?php

namespace App\Controllers\Web;


class Index extends BaseController
{
    public function index()
    {
        $this->response->view('Index/Index');
    }
}