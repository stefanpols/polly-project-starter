<?php

namespace App\Services;

use App\Models\Session;
use App\Models\User;
use App\Repositories\SessionRepository;
use Polly\Core\Database;
use Polly\Core\Request;
use Polly\Exceptions\InternalServerErrorException;
use Polly\Helpers\Str;
use Polly\ORM\EntityManager;
use Polly\ORM\RepositoryService;
use Polly\ORM\Types\DateTime;

class SessionService extends RepositoryService
{
    public static function createRepository() : SessionRepository { return new SessionRepository(Database::default()); }
    public static function getRepository(): SessionRepository { return EntityManager::getRepository(Session::class); }

    /**
     * @return Session|null
     */
    public static function findById(string $id) : ?Session
    {
        return parent::findById($id);
    }

    /**
     * @return Session[]
     */
    public static function all() : array
    {
        return parent::all();
    }

    /**
     * @return Session
     */
    public static function make(User $user) : Session
    {
        $userSession = new Session();
        $userSession->setUserId($user->getId());
        $userSession->setToken(Str::random(100));
        $userSession->setCreated(new DateTime());
        $userSession->setLastActivity(new DateTime());
        $userSession->setIpAddress(Request::server('REMOTE_ADDR'));
        $userSession->setUserAgent(Request::server('HTTP_USER_AGENT'));

        if(!parent::save($userSession))
            throw new InternalServerErrorException("Could not create user session.");

        return $userSession;
    }

    public static function findByToken(string $token) : ?Session
    {
        return static::getRepository()->findByToken($token);
    }

}
