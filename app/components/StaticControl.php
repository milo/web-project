<?php

namespace App\Controls;

use Nette\Forms\Controls\TextBase;
use Nette\Utils\Html;


class StaticControl extends TextBase
{
	/** @var bool */
	private $staticValue;


	public function __construct(string $caption = null)
	{
		parent::__construct($caption);
		$this->setOmitted();
		$this->control = Html::el('span')->setAttribute('class', 'static-form-control');
	}


	public function getControl()
	{
		$this->setOption('rendered', true);
		$control = clone $this->control;
		return $control->setText($this->value);
	}


	public function setValue($value): StaticControl
	{
		if ($value !== null && !$this->staticValue) {
			$this->staticValue = true;
			parent::setValue($value);
		}

		return $this;
	}
}
