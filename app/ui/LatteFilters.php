<?php

namespace App\UI;

use App;
use Latte\Engine;
use Nette\Utils\Html;


class LatteFilters
{
	use App\Strict;

	/** @var string */
	private $wwwDir;


	public function __construct(string $wwwDir)
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

		$latte->addFilter('formatDateMinutes', function ($value) {
			return $value instanceof \DateTime ? $value->format('j.n.Y H:i') : $value;
		});

		$latte->addFilter('formatMicroDateTime', function ($value) {
			if ($value instanceof \DateTime) {
				$el = Html::el('small class=text-muted')->setText($value->format('.u'));
				return Html::el()->setText($value->format('j.n.Y H:i:s'))->addHtml($el);
			}

			return $value;
		});

		$latte->addFilter('formatNumber', function ($value) {
			if ($value === null) {
				return $value;
			}

			return str_replace('.', ',', $value);
		});

		$latte->addFilter('yesNo', function ($value, $yes = 'Ano', $no = 'Ne') {
			return Html::el('span')->setAttribute('class', $value ? 'text-success font-weight-bold' : 'text-muted')->setText($value ? $yes : $no);
		});

		$latte->addFilter('mTime', function ($path) {
			return filemtime($this->wwwDir . DIRECTORY_SEPARATOR . $path);
		});

		$latte->addFilter('age', function (\DateTimeInterface $time = null) {
			if ($time === null) {
				return null;
			}

			static $intervals = [
				60 * 60 * 24 * 30 * 12 => ['rok', 'roky', 'let'],
				60 * 60 * 24 * 30 => ['měsíc', 'měsíce', 'měsíců'],
				60 * 60 * 24 * 7 => ['týden', 'týdny', 'týdnů'],
				60 * 60 * 24 => ['den', 'dny', 'dní'],
				60 * 60 => ['hodina', 'hodiny', 'hodin'],
				60 => ['minuta', 'minuty', 'minut'],
			];

			$result = [];
			$diff = time() - $time->format('U');

			foreach ($intervals as $interval => $name) {
				if ($diff >= $interval) {
					$count = (int) floor($diff / $interval);
					$diff -= $count * $interval;
					$result[] = $count . ' '. ($count === 1 ? $name[0] : ($count < 5 ? $name[1] : $name[2]));
				}
			}
			if (count($result) === 0) {
				$result[] = $diff > 0 ? 'okamžik' : 'nyní';
			}

			return implode(' ', $result);
		});

		$latte->addFilter('progressBar', function ($value) {
			$p = floor($value);

			if ($p < 75) {
				$class = 'progress-bar-success';
			} elseif ($p < 90) {
				$class = 'progress-bar-warning';
			} else {
				$class = 'progress-bar-danger';
			}

			$div = Html::el('div')
				->addAttributes([
					'class' => "progress-bar $class",
					'role' => 'progress',
					'aria-valuenow' => $p,
					'aria-valuemin' => 0,
					'aria-valuemax' => 100,
					'style' => "min-width:2em; width:$p%"
				])
				->setText("$p%");

			return Html::el('div class=progress')->addHtml($div);
		});
	}
}
