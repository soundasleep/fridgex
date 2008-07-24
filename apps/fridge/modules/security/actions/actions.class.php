<?php

/**
 * security actions.
 *
 * @package    ticket-symfony
 * @subpackage security
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class securityActions extends myActions
{
  /**
   * Executes index action
   *
   */
  public function executeIndex()
  {

  }

	public function handleErrorLogin() {
		// error in form => redirect to login page
		return $this->forward("security", "index");
	}

	public function executeLogin()
	{
		$user = User::login($this);

		if ($user) {
			return $this->redirect("product/list");
		} else {
			return $this->forward("security", "index");
		}

	}

	public function executeLogout() {
		User::logout($this);
	}

	public function executeRights() {
		// user does not have sufficient rights
	}

	public function executeSignup() {
		// signup form
	}

	public function executeForgot() {
		// user has forgotten password
	}

	public function validatePassword() {
		$c = new Criteria();
		$c->add(UserPeer::EMAIL, $this->getRequestParameter("email"));
		$user = UserPeer::doSelectOne($c);
		if (!$user) {
			$this->getRequest()->setError("email", "no such email address in system");
		}

		return !$this->getRequest()->hasErrors();
	}

	public function handleErrorPassword() {
		// error in form => redirect to forgot form
		return $this->forward("security", "forgot");
	}

	public function executePassword() {
		// reset password

		try {
			$c = new Criteria();
			$c->add(UserPeer::EMAIL, $this->getRequestParameter("email"));
			$this->user = UserPeer::doSelectOne($c);
			$this->forward404Unless($this->user, "no such email address in system");

			$password = sprintf("%04x%04x%04x", rand(0,0xffff), rand(0,0xffff), rand(0,0xffff));
			$this->user->setPasswordHash(md5($password));
			$this->user->save();

			$this->getRequest()->setParameter("user", $this->user->getId());
			$this->getRequest()->setParameter("password", $password);

			$raw_email = $this->sendEmail('mail', 'password');
			$this->logMessage($raw_email, "debug");

		} catch (sfError404Exception $e) {
			$this->getRequest()->setError("exception", $e->getMessage());
			return $this->handleErrorPassword();
		}

	}

}
