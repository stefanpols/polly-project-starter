<?php

namespace App\Models;

use Polly\Interfaces\IAuthenticationModel;
use Polly\ORM\AbstractEntity;
use App\Services\UserService;
use Polly\ORM\Annotations\Entity;
use Polly\ORM\Annotations\Variable;
use Polly\ORM\Validation\NotEmpty;
use Polly\ORM\Validation\Email;
use Polly\ORM\Validation\Unique;
use Polly\ORM\Types\DateTime;
use Polly\ORM\LazyLoader;
use Polly\ORM\Annotations\LazyMany;
use Polly\Support\Authorization\IRoleAuthorizationModel;
use Polly\Support\Authorization\RoleAuthorizationAgent;

#[Entity(UserService::class)]
class User extends AbstractEntity implements IAuthenticationModel, IRoleAuthorizationModel
{
	#[Variable]
	#[NotEmpty]
	private ?string $firstname = null;

	#[Variable]
	#[NotEmpty]
	private ?string $lastname = null;

	#[Variable]
	#[NotEmpty]
	#[Email]
	#[Unique]
	private ?string $username = null;

	#[Variable]
	#[NotEmpty]
	private ?string $password = null;

	#[Variable]
	#[NotEmpty]
	private ?DateTime $created = null;

	#[Variable]
	#[NotEmpty]
	private int $active = 1;

	#[LazyMany(Session::class)]
	private LazyLoader $sessions;

	public function getFirstname() : ?string
	{
		return $this->firstname;
	}

	public function setFirstname(?string $firstname)
	{
		$this->firstname = $firstname;
	}

	public function getLastname() : ?string
	{
		return $this->lastname;
	}

	public function setLastname(?string $lastname)
	{
		$this->lastname = $lastname;
	}

	public function getUsername() : ?string
	{
		return $this->username;
	}

	public function setUsername(?string $username)
	{
		$this->username = $username;
	}

	public function getPassword() : ?string
	{
		return $this->password;
	}

	public function setPassword(?string $password)
	{
		$this->password = $password;
	}

	public function getCreated() : ?DateTime
	{
		return $this->created;
	}

	public function setCreated(?DateTime $created)
	{
		$this->created = $created;
	}

	public function getActive() : int
	{
		return $this->active;
	}

	public function setActive(int $active)
	{
		$this->active = $active;
	}

	/**
	* @return Session[] 
	*/
	public function getSessions() : array
	{
		return $this->sessions->getResults();
	}

	public function setSessions(LazyLoader $sessions)
	{
		$this->sessions = $sessions;
	}

    public function verify(string $password): bool
    {
        return password_verify($password, $this->password);
    }

    public function getRole(): string
    {
        return RoleAuthorizationAgent::ADMINISTRATOR;
    }
}