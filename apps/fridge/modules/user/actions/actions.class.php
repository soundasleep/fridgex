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
}
