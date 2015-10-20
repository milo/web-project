<?php

namespace App\Security;

use Nette;


class Identity extends Nette\Object implements Nette\Security\IIdentity
{

	/**
	 * @return int
	 */
	public function getId()
	{
		throw new \LogicException('Implement it!');
	}


	/**
	 * @return string[]
	 */
	public function getRoles()
	{
		throw new \LogicException('Implement it!');
	}

}
