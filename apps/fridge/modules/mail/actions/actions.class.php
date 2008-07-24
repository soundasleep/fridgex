<?php

/**
 * mail actions.
 *
 * @package    fridge
 * @subpackage mail
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class mailActions extends sfActions
{
  /**
   * Executes index action
   *
   */
  public function executeIndex()
  {
    $this->forward('@homepage');
  }

	public function executePassword() {
		// send reset password e-mail
		$this->user = UserPeer::retrieveByPk($this->getRequestParameter("user"));		// alternative would be to use sfUser::setParameter
		$this->forward404Unless($this->user, "no such user to mail");
		$this->password = $this->getRequestParameter("password");		// alternative would be to use sfUser::setParameter

		$e = new Email();
		$e->initialise($this->user->getName(), $this->user->getEmail());
		$e->setSubject("Password Reset");
		$e->setUser($this->user);

		$this->mail = $e->getMailer();

	}

	public function executeChangeEmail() {
		// send changed address e-mail
		$this->user = UserPeer::retrieveByPk($this->getRequestParameter("user"));		// alternative would be to use sfUser::setParameter
		$this->forward404Unless($this->user, "no such user to mail");

		$e = new Email();
		$e->initialise($this->user->getName(), $this->user->getEmail());
		$e->setSubject("Email Address Changed");
		$e->setUser($this->user);

		$this->mail = $e->getMailer();

	}

	public function executeSignup() {
		// send signup e-mail
		$this->user = UserPeer::retrieveByPk($this->getRequestParameter("user"));		// alternative would be to use sfUser::setParameter
		$this->forward404Unless($this->user, "no such user to mail");

		$e = new Email();
		$e->initialise($this->user->getName(), $this->user->getEmail());
		$e->setSubject("New Account");
		$e->setUser($this->user);

		$this->mail = $e->getMailer();

	}

}
