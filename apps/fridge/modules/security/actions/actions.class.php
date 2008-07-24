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

}
