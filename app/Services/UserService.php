<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;
use Polly\Core\Database;
use Polly\Interfaces\IAuthenticationModel;
use Polly\Interfaces\IAuthenticationService;
use Polly\ORM\AbstractEntity;
use Polly\ORM\EntityManager;
use Polly\ORM\RepositoryService;
use Polly\ORM\Types\DateTime;

class UserService extends RepositoryService implements IAuthenticationService
{
    public static function createRepository() : UserRepository { return new UserRepository(Database::default()); }
    public static function getRepository(): UserRepository { return EntityManager::getRepository(User::class); }

    /**
     * @return User|null
     */
    public static function findById(string $id) : ?User
    {
        return parent::findById($id);
    }

    /**
     * @return User[]
     */
    public static function all() : array
    {
        return parent::all();
    }


    public static function delete(User|AbstractEntity $entity) : bool
    {
        if(parent::delete($entity))
        {
            foreach($entity->getSessions() as $session)
                SessionService::delete($session);
        }
        return false;
    }

    /**
     * @param string $username
     * @param string $password
     * @return IAuthenticationModel|null
     */
    public static function verify(string $username, string $password) : ?IAuthenticationModel
    {
        $user = static::getRepository()->findByUsername($username);
        if(!$user) return null;

        if($user->verify($password))
        {
            return $user;
        }

        return null;
    }

    /**
     * @param string $token
     * @return IAuthenticationModel|null
     */
    public static function verifyByToken(string $token) : ?IAuthenticationModel
    {
        $userSession = SessionService::findByToken($token);
        if(!$userSession)
            return null;

        $userSession->setLastActivity(new DateTime());
        SessionService::save($userSession);

        return $userSession->getUser();
    }

    /**
     * @param IAuthenticationModel $user
     * @return string returning session token
     */
    public static function createSession(IAuthenticationModel $user) : string
    {
        $userSession = SessionService::make($user);
        return $userSession->getToken();
    }



}
