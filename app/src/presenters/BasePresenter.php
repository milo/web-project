<?php

namespace App\Presenters;

use App;
use Nette\Application\UI;
use Nette\Utils\Strings;


abstract class BasePresenter extends UI\Presenter
{
	/** @var App\UI\LatteFilters */
	protected $latteFilters;


	public function injectLatteFilters(App\UI\LatteFilters $latteFilters)
	{
		$this->latteFilters = $latteFilters;
	}


	public function formatTemplateFiles()
	{
		$name = $this->getName();
		$presenter = substr($name, strrpos(':' . $name, ':'));
		$presenterDir = dirname($this->getReflection()->getFileName());
		$view = $this->getView();

		return [
			"$presenterDir/templates/$presenter/$view.latte",
			"$presenterDir/$presenter.$view.latte",
		];
	}


	public function formatLayoutTemplateFiles()
	{
		$presenterDir = dirname($this->getReflection()->getFileName());

		return [
			"$presenterDir/templates/@layout.latte",
			"$presenterDir/@layout.latte",
			__DIR__ . '/templates/@layout.latte',
			__DIR__ . '/@layout.latte',
		];
	}


	/**
	 * @param  string
	 * @param  string
	 * @return bool
	 */
	public function isModuleCurrent($module, $presenter = NULL)
	{
		if (Strings::startsWith($name = $this->getName(), trim($module, ':') . ':')) {
			return $presenter === NULL
				? TRUE
				: Strings::endsWith($name, ':' . $presenter);
		}

		return FALSE;
	}


	protected function createTemplate($class = NULL)
	{
		$template = parent::createTemplate($class);
		$this->latteFilters->install($template->getLatte());
		return $template;
	}

}
