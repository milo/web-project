<?php

namespace App\Presenters;

use App;
use Nette\Security;



abstract class SecuredPresenter extends BasePresenter
{

	public function startup()
	{
		parent::startup();

		if (!$this->getUser()->isLoggedIn()) {
			if ($this->getUser()->getLogoutReason() === Security\IUserStorage::INACTIVITY) {
				$this->flashMessage('Uživatel byl odhlášen kvůli neaktivitě.', 'info');
			}

			$this->redirect(':Sign:in', [
				'backlink' => $this->isLinkCurrent('default') ? NULL : $this->storeRequest(),
			]);
			die();
		}
	}


	/**
	 * @return App\Security\Identity
	 */
	protected function getIdentity()
	{
		return $this->getUser()->getIdentity();
	}

}
