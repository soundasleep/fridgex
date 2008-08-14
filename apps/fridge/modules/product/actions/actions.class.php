<?php
// auto-generated by sfPropelCrud
// date: 2008/07/23 15:51:32
?>
<?php

/**
 * product actions.
 *
 * @package    fridge
 * @subpackage product
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 3335 2007-01-23 16:19:56Z fabien $
 */
class productActions extends myActions
{

  public function executeIndex()
  {
    return $this->forward('product', 'list');
  }

  public function executeList()
  {
	$c = new Criteria();
	$c->addDescendingOrderByColumn(ProductPeer::SORT_ORDER);

    $this->products = ProductPeer::doSelect($c);

	$this->user = $this->getUserObject(false);

    // previous purchase
    $this->purchase = false;
    if ($this->getRequestParameter("purchase") && $this->user) {
		$c = new Criteria();
		$c->add(PurchasePeer::ID, $this->getRequestParameter("purchase"));
		$c->add(PurchasePeer::USER_ID, $this->user->getId());
		$this->purchase = PurchasePeer::doSelectOne($c);
	}

    // previous credit
    $this->credit = false;
    if ($this->getRequestParameter("credit") && $this->user) {
		$c = new Criteria();
		$c->add(PurchasePeer::ID, $this->getRequestParameter("credit"));
		$c->add(PurchasePeer::USER_ID, $this->user->getId());
		$this->credit = PurchasePeer::doSelectOne($c);
	}

	$this->list = $this->getRequestParameter("list", false);
	$this->gallery_size = sfConfig::get("app_product_gallerysize", 5);
  }

  public function executeShow()
  {
    $this->product = ProductPeer::retrieveByPk($this->getRequestParameter('id'));
    $this->forward404Unless($this->product);

    $this->user = $this->getUserObject(false);
  }

  public function executePurchase() {
	  // user needs to be logged in
	  $this->user = $this->getUserObject();

	  // how much do we need?
	  try {
		  sfLoader::loadHelpers("My");

		  $this->product = ProductPeer::retrieveByPk($this->getRequestParameter('id'));
		  $this->forward404Unless($this->product, "no product specified");
		  $this->quantity = (int) $this->getRequestParameter('quantity');
		  $this->forward404Unless($this->quantity > 0, "no quantity specified");
		  $surcharge = get_surcharge_for($this->product->getPrice());
		  $total = apply_surcharge($this->product->getPrice()) * $this->quantity;
		  $this->forward404Unless($this->product->getInventory() >= $this->quantity, "insufficient quantites available");

		  // do we have enough credit?
		  if (($this->user->getAccountCredit() - $total) < sfConfig::get("app_credit_minimum", 0)) {
			  // no we don't; display an error message
			  sfLoader::loadHelpers('Url');
			  throw new sfError404Exception("You don't have enough credit in your account. You need to credit your account.");
		  }

		  // execute purchase
		  $purchase = new Purchase();
		  $purchase->setUser($this->user);
		  $purchase->setProduct($this->product);
		  $purchase->setQuantity(-$this->quantity);
		  $purchase->setPrice($total);
		  $purchase->setSurcharge($surcharge);
		  $purchase->save();

		  // deduct balance
		  $this->user->setAccountCredit($this->user->getAccountCredit() - $total);
		  $this->user->save();

		  // update product
		  $this->product->setInventory($this->product->getInventory() - $this->quantity);
		  $this->product->save();

		  // redirect to ok page
		  return $this->redirect("product/list?purchase=".$purchase->getId());

	  } catch (sfError404Exception $e) {
		  $this->getRequest()->setError("exception", $e->getMessage());
		  return sfView::ERROR;
	  }

  }

  public function executeCredit() {
	  // user needs to be logged in
	  $this->user = $this->getUserObject();

	  try {
		  $this->product = ProductPeer::retrieveByPk($this->getRequestParameter('id'));
		  $this->forward404Unless($this->product, "no product specified");
		  $this->quantity = (int) $this->getRequestParameter('quantity');
		  $this->forward404Unless($this->quantity > 0, "no quantity specified");
		  $this->price = $this->getRequestParameter('price');
		  $this->forward404Unless($this->price > 0, "no price specified");
		  $total = $this->price * $this->quantity;
		  $this->forward404Unless($this->user->canCredit($this->product), "user cannot credit this product");

		  // execute credit
		  $purchase = new Purchase();
		  $purchase->setUser($this->user);
		  $purchase->setProduct($this->product);
		  $purchase->setQuantity($this->quantity);
		  $purchase->setPrice($this->price);
		  $purchase->setSurcharge(0);
		  $purchase->save();

		  // add balance
		  $this->user->setAccountCredit($this->user->getAccountCredit() + $total);
		  $this->user->save();

		  // update product
		  // some interesting logic goes here, to update the new product price
		  // new product price = ((old price * old quantity) + (new price * added quantity)) / total new quantity
		  $this->product->setPrice(
			  (($this->product->getPrice() * $this->product->getInventory()) +
			  ($this->price * $this->quantity)) / ($this->product->getInventory() + $this->quantity));

		  // now we have set the price, we can set the inventory
		  $this->product->setInventory($this->product->getInventory() + $this->quantity);

		  $this->product->save();

		  // redirect to ok page
		  return $this->redirect("product/list?credit=".$purchase->getId());

	  } catch (sfError404Exception $e) {
		  $this->getRequest()->setError("exception", $e->getMessage());
		  return sfView::ERROR;
	  }

  }

}
