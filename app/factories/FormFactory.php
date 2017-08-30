<?php

namespace App\Factories;

use App;


class FormFactory
{
	use App\Strict;


	public function createContainer(): App\Controls\FormContainer
	{
		return new App\Controls\FormContainer;
	}


	public function create(): App\Controls\Form
	{
		$form = new App\Controls\Form;
		return $form;
	}
}
