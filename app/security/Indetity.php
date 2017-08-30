<?php

namespace App\Security;

use App;
use Nette;


class Identity implements Nette\Security\IIdentity
{
	use App\Strict;

	/** @var string */
	private $username;

	/** @var string [] */
	private $roles;


	public function __construct(string $username, array $roles = [])
	{
		$this->username = $username;
		$this->roles = $roles;
	}


	public function getUsername(): string
	{
		return $this->username;
	}


	public function getId(): int
	{
		throw new \LogicException('Implement it!');
	}


	public function getRoles(): array
	{
		return $this->roles;
	}


	public function hasRole($role): bool
	{
		return in_array($role, $this->roles, true);
	}
}
