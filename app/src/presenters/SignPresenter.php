<?php

namespace App\Presenters;

use App;
use App\Factories;
use App\Model;
use App\Security;
use Nette\Application\UI;


class SignPresenter extends BasePresenter
{
	/** @persistent */
	public $backlink;

	/** @var Factories\FormFactory  @inject */
	public $formFactory;


	protected function createComponentForm()
	{
		$this->terminateLogin(new \LogicException('Implement it!'));

		$form = $this->formFactory->create();

		$form
			->addText('username', 'Login:')
			->setRequired('Vyplňte prosím login.')
			->getControlPrototype()
				->autofocus(TRUE);

		$form
			->addPassword('password', 'Heslo:')
			->setRequired('Vyplňte prosím heslo.');
//			->setOption('help-bottom', '(stejné jako ...)');

		$form
			->addSubmit('send', 'Přihlásit');

		$form->onSuccess[] = [$this, 'formSubmitted'];

		return $form;
	}


	public function formSubmitted(UI\Form $form, $values)
	{


		$identity = new Security\Identity;

		$this->getUser()->login($identity);
		$this->getUser()->setExpiration(0, TRUE, TRUE);

		$this->restoreRequest($this->backlink);
		$this->forward(':Homepage:default');
		die();
	}


	public function actionOut()
	{
		if ($this->getUser()->isLoggedIn()) {
			$this->getUser()->logout(TRUE);
			$this->flashMessage('Odhlášeno.', 'success');
		}

		$this->redirect('in');
		die();
	}


	/**
	 * @param string
	 */
	private function terminateLogin($message)
	{
		$message = $message instanceof \Exception
			? $message = $message->getMessage()
			: $message;

		$this->flashMessage($message, 'danger');
		$this->redirect('this');
		die();
	}

}
