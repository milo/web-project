<?php

namespace App\Controls;

use Nette\Forms\Controls\TextBase;
use Nette\Utils\Html;


class StaticControl extends TextBase
{

	/**
	 * @param  string|NULL
	 */
	public function __construct($caption = NULL)
	{
		parent::__construct($caption);
		$this->setOmitted();
		$this->control = Html::el('span')->addClass('static-form-control');
	}


	public function getControl()
	{
		$this->setOption('rendered', TRUE);
		$control = clone $this->control;
		return $control->setText($this->value);
	}

}
