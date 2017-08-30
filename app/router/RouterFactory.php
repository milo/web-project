<?php

namespace App;

use Nette;
use Nette\Application\Routers\Route;
use Nette\Application\Routers\RouteList;


class RouterFactory
{
	use Nette\StaticClass;

	public static function createRouter(): Nette\Application\IRouter
	{
		$router = new RouteList;
		$router[] = new Route('<presenter>/<action>[/<id>]', 'Default:Homepage:default');
		return $router;
	}
}
