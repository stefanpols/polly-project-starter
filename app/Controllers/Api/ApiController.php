<?php

namespace App\Controllers\Api;

use Polly\Core\Controller;
use Polly\Core\Request;
use Polly\Core\Response;

abstract class ApiController extends Controller
{
    public function __construct(Response &$response)
    {
        parent::__construct($response);
        $this->response->json();

        $this->handleCors();
    }

    private function handleCors()
    {
        // Allow from any origin
        if (isset($_SERVER['HTTP_ORIGIN'])) {
            // Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one
            // you want to allow, and if so:
            header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
            header('Access-Control-Allow-Credentials: true');
            header('Access-Control-Max-Age: 86400');    // cache for 1 day
        }

        // Access-Control headers are received during OPTIONS requests
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
                // may also be using PUT, PATCH, HEAD etc
                header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
                header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

            exit(0);
        }
    }

    public function getRequestBody()
    {
        $body = Request::body();
        if(!$body)
        {
            $body = "{}";
        }
        return json_decode($body);

    }
}
