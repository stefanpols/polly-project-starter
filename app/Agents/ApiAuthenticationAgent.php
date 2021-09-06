<?php

namespace App\Agents;

use App\Services\SessionService;
use Polly\Core\Request;
use Polly\Exceptions\AuthenticationException;
use Polly\Interfaces\IAuthenticationAgent;
use Polly\Interfaces\IAuthenticationModel;
use Polly\Interfaces\IAuthenticationService;

class ApiAuthenticationAgent implements IAuthenticationAgent
{
    private static ?ApiAuthenticationAgent $instance = null;

    private ?IAuthenticationModel $user = null;
    private IAuthenticationService $userService;
    private ?string $token = null;

    private function __construct(IAuthenticationService $userService)
    {
        $this->userService = $userService;
    }

    public static function getInstance(IAuthenticationService $userService): IAuthenticationAgent
    {
        if(is_null(static::$instance))
            static::$instance = new ApiAuthenticationAgent($userService);

        return static::$instance;
    }

    public function check(): bool
    {
        return static::user() != null;
    }

    public function user() : ?IAuthenticationModel
    {
        if(!$this->user)
            $this->fetchUser();

        return $this->user;
    }

    private function fetchUser() : void
    {
        $token = Request::headers()['Authorization'] ?? null;
        if(!empty($token))
        {
            $token = str_replace("Bearer ", "",$token);
            $this->user = $this->userService::verifyByToken($token);
        }
    }

    public function login(string $username, string $password): bool
    {
        $user = $this->userService::verify($username, $password);
        if (!$user)
            return false;

        $token = $this->userService::createSession($user);

        $this->token = $token;
        $this->user = $user;

        return true;
    }

    public function logout(): bool
    {
        if(!empty($token = (Request::headers()['Authorization'] ?? null)) && $session = SessionService::findByToken($token))
            SessionService::delete($session);
    }

    public function getToken(): ?string
    {
        return $this->token;
    }


    public function unauthenticated()
    {
        throw new AuthenticationException();
    }
}
