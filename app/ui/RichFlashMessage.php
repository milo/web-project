<?php

namespace App\UI;

use Nette\Utils\Html;


trait RichFlashMessage
{
	/**
	 * @param  string|array|\Throwable $message
	 * @param  string $type
	 * @param  string \Throwable|null $e
	 * @return \stdClass
	 */
	public function flashMessage($message, $type = 'info', $e = null)
	{
		if ($type === 'error') {
			$type = 'danger';
		}

		$outer = Html::el('div')->addAttributes(['class' => 'alert alert-' . $type])->addHtml(
			$inner = Html::el('p')
		);

		if (is_array($message)) {
			$parts = preg_split('/%([%sbi])/', array_shift($message), -1, PREG_SPLIT_DELIM_CAPTURE);
			foreach ($parts as $i => $part) {
				if ($i % 2) {
					if ($part === '%') {
						$inner->addText('%');
						continue;
					}

					if (count($message)) {
						switch ($part) {
							case 'b':
								$inner->addHtml(Html::el('strong')->setText(array_shift($message)));
								break;

							case 'i':
								$inner->addHtml(Html::el($part)->setText(array_shift($message)));
								break;

							default:
								$inner->addText(array_shift($message));
								break;
						}
					} else {
						$inner->addText("%$part");
					}

				} else {
					$inner->addText($part);
				}

			}

		} elseif ($message instanceof \Throwable) {
			$inner->addText($message->getMessage());

		} else {
			$inner->addText($message);
		}

		if ($e) {
			$outer->addHtml(
				Html::el('pre')->addHtml(
					Html::el('code')->setText($e->getMessage())
				)
			);
		}

		return parent::flashMessage($outer, $type);
	}
}
