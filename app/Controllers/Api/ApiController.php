<?php

namespace App\Controllers\Api;

use Polly\Core\Controller;
use Polly\Core\Response;

abstract class ApiController extends Controller
{
    public function __construct(Response &$response)
    {
        parent::__construct($response);
        $this->response->json();
    }

}