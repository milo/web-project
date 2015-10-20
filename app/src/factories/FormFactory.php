<?php

namespace App\Factories;

use App;
use Nette;


class FormFactory extends Nette\Object
{

	/**
	 * @return Nette\Forms\Container
	 */
	public function createContainer()
	{
		return new Nette\Forms\Container;
	}


	/**
	 * @return App\Controls\Form
	 */
	public function create()
	{
		$form = new App\Controls\Form;
//		$form->setRenderer(new App\UI\BootstrapRenderer);
		return $form;
	}

}
