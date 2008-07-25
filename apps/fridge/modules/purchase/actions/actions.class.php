<?php
// auto-generated by sfPropelCrud
// date: 2008/07/25 14:15:28
?>
<?php

/**
 * purchase actions.
 *
 * @package    fridge
 * @subpackage purchase
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 3335 2007-01-23 16:19:56Z fabien $
 */
class purchaseActions extends myActions
{
	/**
	 * Only users are allowed to access pages in here.
	 * that have the appropriate permissions
	 */
	public function preExecute() {
		parent::preExecute();

		// get the user object
		$this->user = $this->getUserObject();

		if (!($this->user->canVerifyCredit()))
			$this->insufficientRights();
	}

  public function executeIndex()
  {
    return $this->forward('purchase', 'list');
  }

  public function executeList()
  {
	$c = new Criteria();
	$c->add(PurchasePeer::QUANTITY, 0, Criteria::GREATER_THAN);
	$c->add(PurchasePeer::VERIFIED_BY_ID, null);
	$c->addAscendingOrderByColumn(PurchasePeer::CREATED_AT);
    $this->purchases = PurchasePeer::doSelect($c);
  }

  public function executeUpdate()
  {
    $purchase = PurchasePeer::retrieveByPk($this->getRequestParameter('id'));
    $this->forward404Unless($purchase);

    if ($this->getRequestParameter("verify")) {
		$purchase->setVerifiedBy($this->user);
		$purchase->setVerifiedAt(time());
	}
    $purchase->setNotes($this->getRequestParameter('notes'));

    $purchase->save();

    return $this->redirect('purchase/list');
  }

}
