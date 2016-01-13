<?php

namespace App;

use Nette;
use Nette\Application\Routers\RouteList;
use Nette\Application\Routers\Route;


class RouterFactory
{

	/**
	 * @return Nette\Application\IRouter
	 */
	public static function createRouter()
	{
		$router = new RouteList;

		$router[] = new Route('index.php', 'Homepage:default', Route::ONE_WAY);
		$router[] = new Route('admin/<presenter>/<action>[/<id>]', self::defaults('Admin'));
		$router[] = new Route('<presenter>/<action>/<id>', self::defaults('Default'));

		return $router;
	}


	private static function defaults($module, $presenter = 'Homepage', $action = 'default')
	{
		return [
			'module' => $module,
			'presenter' => $presenter,
			'action' => $action,
			'id' => NULL,
		];
	}

}
