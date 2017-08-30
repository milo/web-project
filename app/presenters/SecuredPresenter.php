<?php

namespace App;

use Nette\Security;


abstract class SecuredPresenter extends BasePresenter
{
	public function startup()
	{
		parent::startup();

		if (!$this->getUser()->isLoggedIn()) {
			if ($this->getUser()->getLogoutReason() === Security\IUserStorage::INACTIVITY) {
				$this->flashMessage('User signed-out due to inactivity.', 'info');
			}

			$this->redirect(':Auth:Sign:in', [
				'backlink' => $this->isLinkCurrent('default') ? null : $this->storeRequest(),
			]);
			die();
		}
	}
}
