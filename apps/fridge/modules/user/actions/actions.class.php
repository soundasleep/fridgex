<?php

/**
 * user actions.
 *
 * @package    fridge
 * @subpackage user
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class userActions extends myActions
{

	/**
	 * Only users are allowed to access pages in here.
	 */
	public function preExecute() {
		parent::preExecute();

		// get the user object
		$this->user = $this->getUserObject();
	}

  /**
   * Executes index action
   *
   */
  public function executeIndex()
  {
	  	$c = new Criteria();
	  	$c->add(PurchasePeer::USER_ID, $this->user->getId());
		$c->addDescendingOrderByColumn(PurchasePeer::CREATED_AT);
	  	$c->setLimit(20);
		$this->purchases = PurchasePeer::doSelect($c);
  }

  public function executeEdit() {
	  // edit profile
  }

	public function validateUpdate() {
		$this->preExecute();

		// emails should match
		if ($this->getRequestParameter("email_confirm") && $this->getRequestParameter("email") != $this->getRequestParameter("email_confirm")) {
			$this->getRequest()->setError("email_confirm", "email addresses do not match");
		}

		if ($this->getRequestParameter("password")) {
			if (strlen($this->getRequestParameter("password")) < sfConfig::get("app_password_min", 3)) {
				$this->getRequest()->setError("password", "password is too short");
			}

			if ($this->getRequestParameter("password") != $this->getRequestParameter("password_confirm")) {
				$this->getRequest()->setError("password_confirm", "passwords do not match");
			}
		}

		// new email address should not exist
		if ($this->getRequestParameter("email_confirm") && $this->getRequestParameter("email_confirm") != $this->user->getEmail()) {
			$c = new Criteria();
			$c->add(UserPeer::EMAIL, trim($this->getRequestParameter("email")));
			$user = UserPeer::doSelectOne($c);

			if ($user) {
				$this->getRequest()->setError("email", "e-mail address already signed up");
			}

		}

		return !$this->getRequest()->hasErrors();
	}

	public function handleErrorUpdate() {
		// error in form => redirect to original form
		return $this->forward("user", "edit");
	}

  public function executeUpdate() {

    $this->forward404Unless($this->user);

	if ($this->getRequestParameter("email_confirm")) {
    	$this->user->setEmail($this->getRequestParameter('email'));
	}
    $this->user->setName($this->getRequestParameter('name'));
    $this->user->setNickname($this->getRequestParameter('nickname'));

    if ($this->getRequestParameter("password") && $this->getRequestParameter("password_confirm")) {
		$this->user->setPasswordHash(md5($this->getRequestParameter("password")));
	}

    $this->user->save();

    // if changing email addresses, send an email
    if ($this->getRequestParameter("email_confirm")) {
		$this->getRequest()->setParameter("user", $this->user->getId());

		$raw_email = $this->sendEmail('mail', 'changeEmail');
		$this->logMessage($raw_email, "debug");
	}

    return $this->redirect('user/index');

  }

}
