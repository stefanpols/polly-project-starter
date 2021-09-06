<?php

namespace App\Controllers\Api;


use App\Agents\ApiAuthenticationAgent;
use App\Services\SessionService;
use Polly\Core\Authentication;
use Polly\ORM\Types\DateTime;

class Auth extends ApiController
{

    private function getAuthenticator() : ApiAuthenticationAgent
    {
        return Authentication::getHandler();
    }

    public function signIn()
    {
        $req = $this->getRequestBody();

        $username = $req->email ?? null;
        $password = $req->password ?? null;

        if(!empty($username) && !empty($password) && $this->getAuthenticator()->login($username,$password))
        {
            $this->response->user = $this->getAuthenticator()->user();
            $this->response->accessToken = $this->getAuthenticator()->getToken();
            return;
        }

        $this->response->setHttpCode(401);

    }

    public function refreshAccessToken()
    {
        $req = $this->getRequestBody();

        $token = $req->accessToken ?? null;

        if($token && $session = SessionService::findByToken($token))
        {
            //$session->generateToken();
            $session->setLastActivity(new DateTime());
            SessionService::save($session);

            $this->response->user = $session->getUser();
            $this->response->accessToken = $session->getToken();
            return;
        }

        $this->response->setHttpCode(401);

    }
}
