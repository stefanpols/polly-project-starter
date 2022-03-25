<?php

namespace App\Services;

use App\Helpers\Mailer;
use App\Models\HistoryList;
use App\Models\Item;
use App\Models\User;
use App\Repositories\UserRepository;
use Polly\Core\Authentication;
use Polly\Core\Database;
use Polly\Helpers\Str;
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
        return Authentication::user()->getClient()->getUsers();
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

    public static function findByUsername(string $username) : ?User
    {
        return self::getRepository()->findByUsername($username);
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

    public static function save(User|AbstractEntity $entity): bool
    {
        $add = empty($entity->getId());
        if(!$entity->getId())
        {
            $entity->setCreated(new DateTime());
            $entity->setPassword(Str::random());
        }

        if(parent::save($entity))
        {
            if($add)
            {
                self::generateNewPassword($entity);
            }

            return true;
        }

        return false;
    }

    public static function generateNewPassword(User $user)
    {
        $user->hash($password = Str::randomPassword());
        if (UserService::save($user))
        {
            $mail = Mailer::make("Nieuwe accountgegevens beschikbaar",
                'Mails/Auth/AccountInformation', [
                    'user'=>$user,
                    'password'=>$password
                ]);
            $mail->addAddress($user->getUsername(), $user->getName());
            return Mailer::send($mail);
        }
        return false;
    }

    public static function delete(User|AbstractEntity $entity): bool
    {
        foreach ($entity->getSessions() as $session)
            SessionService::delete($session);

        $entity->setActive(0);
        $entity->setUsername((new DateTime())->format("d-m-Y_H-i-s")."@codens.deleted");
        return self::save($entity);
    }

}
