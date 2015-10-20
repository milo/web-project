<?php

namespace App\Controls;

//use Kdyby\Replicator;
use Nette\Application\UI;


///**
// * @method Replicator\Container addDynamic(string $name, callable $factory)
// */
class Form extends UI\Form
{

	/**
	 * @param  string
	 * @param  string|NULL
	 * @return StaticControl
	 */
	public function addStatic($name, $label = NULL)
	{
		return $this[$name] = new StaticControl($label);
	}

}
