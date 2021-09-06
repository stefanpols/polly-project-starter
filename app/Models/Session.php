<?php

namespace App\Models;

use App\Services\SessionService;
use Polly\ORM\Annotations\Entity;
use Polly\ORM\Annotations\ForeignId;
use Polly\ORM\Annotations\LazyOne;
use Polly\ORM\Annotations\Variable;
use Polly\ORM\LazyLoader;
use Polly\ORM\Types\DateTime;
use Polly\ORM\Validation\Ip;
use Polly\ORM\Validation\NotEmpty;

#[Entity(SessionService::class)]
class Session extends BaseModel
{
	#[ForeignId]
	#[NotEmpty]
	private ?string $userId = null;

	#[Variable]
	#[NotEmpty]
	private ?string $token = null;

	#[Variable]
	#[NotEmpty]
	private ?DateTime $created = null;

	#[Variable]
	#[NotEmpty]
	private ?DateTime $lastActivity = null;

	#[Variable]
	#[NotEmpty]
	#[Ip]
	private ?string $ipAddress = null;

	#[Variable]
	#[NotEmpty]
	private ?string $userAgent = null;

	#[LazyOne(User::class)]
	private LazyLoader $user;

	public function getUserId() : ?string
	{
		return $this->userId;
	}

	public function setUserId(?string $userId)
	{
		$this->userId = $userId;
	}

	public function getToken() : ?string
	{
		return $this->token;
	}

	public function setToken(?string $token)
	{
		$this->token = $token;
	}

	public function getCreated() : ?DateTime
	{
		return $this->created;
	}

	public function setCreated(?DateTime $created)
	{
		$this->created = $created;
	}

	public function getLastActivity() : ?DateTime
	{
		return $this->lastActivity;
	}

	public function setLastActivity(?DateTime $lastActivity)
	{
		$this->lastActivity = $lastActivity;
	}

	public function getIpAddress() : ?string
	{
		return $this->ipAddress;
	}

	public function setIpAddress(?string $ipAddress)
	{
		$this->ipAddress = $ipAddress;
	}

	public function getUserAgent() : ?string
	{
		return $this->userAgent;
	}

	public function setUserAgent(?string $userAgent)
	{
		$this->userAgent = $userAgent;
	}

	public function getUser() : ?User
	{
		return $this->user->getResults();
	}

	public function setUser(LazyLoader $user)
	{
		$this->user = $user;
	}

}
