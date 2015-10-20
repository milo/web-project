<?php

namespace App\UI;

use Nette\Forms;
use Nette\Forms\Controls;
use Nette\Utils\Html;


/**
 * Simple Bootstrap3 renderer for Nette Framework forms.
 *
 * Based on:
 * https://github.com/nette/forms/blob/ece128d1c527d07e705145a30422e7510b3e857c/examples/bootstrap3-rendering.php
 */
class BootstrapRenderer extends Forms\Rendering\DefaultFormRenderer
{

	public function __construct()
	{
		$this->wrappers['controls']['container'] = NULL;
		$this->wrappers['pair']['container'] = 'div class=form-group';
		$this->wrappers['pair']['.error'] = 'has-error';
		$this->wrappers['control']['container'] = 'div class=col-sm-9';
		$this->wrappers['label']['container'] = 'div class="col-sm-3 control-label"';
		$this->wrappers['control']['description'] = 'span class=help-block';
		$this->wrappers['control']['errorcontainer'] = 'span class=help-block';
	}


	public function render(Forms\Form $form, $mode = NULL)
	{
		$form->getElementPrototype()->class('form-horizontal')->novalidate(TRUE);
		foreach ($form->getControls() as $control) {
			if ($control instanceof Controls\Button) {
				$control->getControlPrototype()->addClass(empty($usedPrimary) ? 'btn btn-primary' : 'btn btn-default');
				$usedPrimary = TRUE;

			} elseif ($control instanceof Controls\TextBase || $control instanceof Controls\SelectBox || $control instanceof Controls\MultiSelectBox) {
				$control->getControlPrototype()->addClass('form-control');

			} elseif ($control instanceof Controls\Checkbox || $control instanceof Controls\CheckboxList || $control instanceof Controls\RadioList) {
				$control->getSeparatorPrototype()->setName('div')->addClass($control->getControlPrototype()->type);
			}
		}

		return parent::render($form, $mode);
	}


	public function renderControl(Forms\IControl $control)
	{
		$result = parent::renderControl($control);
		if ($control instanceof Controls\TextBase && $control->getOption('help-bottom') !== NULL) {
			$result->add(Html::el('p class=help-block')->setText($control->getOption('help-bottom')));
		}

		return $result;
	}

}
