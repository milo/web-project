<?php

namespace App\UI;

use Latte\Engine;
use Nette;
use Nette\Utils\Html;


class LatteFilters extends Nette\Object
{
	/** @var string */
	private $wwwDir;


	/**
	 * @param  string
	 */
	public function __construct($wwwDir)
	{
		$this->wwwDir = $wwwDir;
	}


	public function install(Engine $latte)
	{
		$latte->addFilter('formatTime', function ($value) {
			return $value instanceof \DateTime ? $value->format('H:i:s') : $value;
		});

		$latte->addFilter('formatDate', function ($value) {
			return $value instanceof \DateTime ? $value->format('j.n.Y') : $value;
		});

		$latte->addFilter('formatDateTime', function ($value) {
			return $value instanceof \DateTime ? $value->format('j.n.Y H:i:s') : $value;
		});

		$latte->addFilter('formatNumber', function ($value) {
			if ($value === NULL) {
				return $value;
			}

			return str_replace('.', ',', $value);
		});

		$latte->addFilter('yesNo', function ($value, $yes = 'Ano', $no = 'Ne') {
			return $value ? $yes : $no;
		});

		$latte->addFilter('mTime', function ($path) {
			return filemtime($this->wwwDir . DIRECTORY_SEPARATOR . $path);
		});
	}

}
