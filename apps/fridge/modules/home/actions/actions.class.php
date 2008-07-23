<?php

/**
 * home actions.
 *
 * @package    fridge
 * @subpackage home
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class homeActions extends myActions
{
  /**
   * Executes index action
   *
   */
  public function executeIndex()
  {
    	// redirect to shopping if we are already logged in
    	if ($this->getUserObject(false)) {
			return $this->redirect("product/list");
		}
  }
}
