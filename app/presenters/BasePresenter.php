<?php

namespace App;

use App;
use Nette;
use Nette\Application\UI;
use Nette\Utils\Strings;


/**
 * @property-read Nette\Bridges\ApplicationLatte\Template|\stdClass $template
 */
abstract class BasePresenter extends UI\Presenter
{
	/** @var App\UI\LatteFilters */
	protected $latteFilters;


	public function injectBasePresenter(App\UI\LatteFilters $latteFilters)
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


	public function isModuleCurrent(string $module, string $presenter = null): bool
	{
		if (Strings::startsWith($name = $this->getName(), trim($module, ':') . ':')) {
			return $presenter === null
				? true
				: Strings::endsWith($name, ':' . $presenter);
		}

		return false;
	}


	protected function createTemplate(): Nette\Bridges\ApplicationLatte\Template
	{
		/** @var Nette\Bridges\ApplicationLatte\Template $template */
		$template = parent::createTemplate();
		$this->latteFilters->install($template->getLatte());
		return $template;
	}
}
