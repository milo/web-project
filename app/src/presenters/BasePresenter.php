<?php

namespace App\Presenters;

use App;
use Nette\Application\UI;
use Nette\Utils\Html;
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


	/**
	 * @param  string|array
	 * @param  string
	 * @param  \Exception|NULL $e
	 * @return \stdClass
	 */
	public function flashMessage($message, $type = 'info', \Exception $e = NULL)
	{
		if (is_array($message)) {
			$el = (string) Html::el()->setHtml(array_shift($message));
			if (strpos($el, '%') !== FALSE) {
				$el = preg_replace_callback('/%([bius])%/', function ($m) use (& $message) {
					if (count($message)) {
						return (string) Html::el($m[1] === 's' ? NULL : $m[1])->setText(array_shift($message));
					}
				}, $el);
			}
			$el = Html::el()->setHtml($el);
		} else {
			$el = Html::el()->setText($message);
		}

		if ($e) {
			$el = Html::el()
				->add($el)
				->add(Html::el('br'))
				->add(Html::el('small')->setText($e->getMessage()));
		}

		return parent::flashMessage($el, $type);
	}


	/**
	 * @return \Nette\Bridges\ApplicationLatte\Template
	 */
	protected function createTemplate()
	{
		/** @var \Nette\Bridges\ApplicationLatte\Template $template */
		$template = parent::createTemplate();
		$this->latteFilters->install($template->getLatte());
		return $template;
	}

}
