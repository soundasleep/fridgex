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

	// stock loss applied
	$this->stock = $this->getRequestParameter("stock");

	$this->list = $this->getRequestParameter("list", false);
	$this->gallery_size = sfConfig::get("app_product_gallerysize", 5);

	// get statistics
	$this->stat = $this->getStatistics();
	$this->stock_losses = $this->getStockLosses();
  }

  protected function getStatistics() {
	  $con = Propel::getConnection(PurchasePeer::DATABASE_NAME);

	  $not_in = sfConfig::get("app_ignore_users", array());
	  $not_in[] = "__ignored__";		// special one so we don't have lots of logic below
	  $not_in_inserts = implode(",", array_fill(0, count($not_in), "?"));

	  $sql = "SELECT COUNT(".PurchasePeer::CREATED_AT.") AS count,
	  		SUM(".PurchasePeer::QUANTITY.") AS sum_quantity,
	  		SUM(".PurchasePeer::QUANTITY." * ".PurchasePeer::PRICE.") AS sum_total,
	  		SUM(".PurchasePeer::QUANTITY." * ".PurchasePeer::SURCHARGE.") AS sum_surcharge,
	  		SUM(IF(".PurchasePeer::QUANTITY."<0, ".PurchasePeer::QUANTITY.", 0)) AS sum_quantity_debit,
	  		SUM(IF(".PurchasePeer::QUANTITY.">0, ".PurchasePeer::QUANTITY.", 0)) AS sum_quantity_credit,
	  		SUM(IF(".PurchasePeer::QUANTITY."<0, ".PurchasePeer::QUANTITY." * ".PurchasePeer::PRICE.", 0)) AS sum_total_debit,
	  		SUM(IF(".PurchasePeer::QUANTITY.">0, ".PurchasePeer::QUANTITY." * ".PurchasePeer::PRICE.", 0)) AS sum_total_credit,
	  		SUM(IF(".PurchasePeer::QUANTITY."<0, ".PurchasePeer::QUANTITY." * ".PurchasePeer::SURCHARGE.", 0)) AS sum_surcharge_debit,
	  		SUM(IF(".PurchasePeer::QUANTITY.">0, ".PurchasePeer::QUANTITY." * ".PurchasePeer::SURCHARGE.", 0)) AS sum_surcharge_credit,
	  		DATEDIFF(".PurchasePeer::CREATED_AT.", NOW()) AS diff_days,
	  		DATE(".PurchasePeer::CREATED_AT.") AS date_formatted
	  	FROM ".PurchasePeer::TABLE_NAME."
	  	LEFT JOIN ".UserPeer::TABLE_NAME."
	  		ON ".PurchasePeer::USER_ID." = ".UserPeer::ID."
	  	WHERE ".PurchasePeer::CANCELLED_AT." IS NULL
	  		AND ".UserPeer::NICKNAME." NOT IN(".$not_in_inserts.")
	  		AND ".PurchasePeer::CREATED_AT." >= ?
	  	GROUP BY date_formatted
	  	ORDER BY date_formatted DESC";

	  $stmt = $con->prepareStatement($sql);
	  foreach ($not_in as $i => $v) {
		  $stmt->setString($i + 1, $v);
	  }
	  // another query parameter: the date limit
	  $stmt->setDate(count($not_in) + 1, date("Y-m-d", strtotime("-1 month")));

	  $rs = $stmt->executeQuery();
	  $empty = array("count" => 0, "sum_quantity" => 0, "sum_total" => 0, "sum_surcharge" => 0,
			"sum_quantity_debit" => 0, "sum_quantity_credit" => 0,
			"sum_total_debit" => 0, "sum_total_credit" => 0,
			"sum_surcharge_debit" => 0, "sum_surcharge_credit" => 0,
	  	);
	  $s = array(
		  "today" => $empty,
		  "week" => $empty,
		  "month" => $empty,
		  "year" => $empty,
		  "all" => $empty,
		  );
	  while ($rs->next()) {
		  $days = $rs->getInt("diff_days");
		  if ($days == 0) {
			  $s["today"] = $this->addStatistics($rs, $s["today"]);
		  }
		  if ($days >= -7) {
			  $s["week"] = $this->addStatistics($rs, $s["week"]);
		  }
		  if ($days >= -31) {
			  $s["month"] = $this->addStatistics($rs, $s["month"]);
		  }
		  $s["all"] = $this->addStatistics($rs, $s["all"]);
	  }

	  // we also want to get statistics for the calendar year, but we don't want to have to parse 365 rows of data
	  $sql = "SELECT COUNT(".PurchasePeer::CREATED_AT.") AS count,
	  		SUM(".PurchasePeer::QUANTITY.") AS sum_quantity,
	  		SUM(".PurchasePeer::QUANTITY." * ".PurchasePeer::PRICE.") AS sum_total,
	  		SUM(".PurchasePeer::QUANTITY." * ".PurchasePeer::SURCHARGE.") AS sum_surcharge,
	  		SUM(IF(".PurchasePeer::QUANTITY."<0, ".PurchasePeer::QUANTITY.", 0)) AS sum_quantity_debit,
	  		SUM(IF(".PurchasePeer::QUANTITY.">0, ".PurchasePeer::QUANTITY.", 0)) AS sum_quantity_credit,
	  		SUM(IF(".PurchasePeer::QUANTITY."<0, ".PurchasePeer::QUANTITY." * ".PurchasePeer::PRICE.", 0)) AS sum_total_debit,
	  		SUM(IF(".PurchasePeer::QUANTITY.">0, ".PurchasePeer::QUANTITY." * ".PurchasePeer::PRICE.", 0)) AS sum_total_credit,
	  		SUM(IF(".PurchasePeer::QUANTITY."<0, ".PurchasePeer::QUANTITY." * ".PurchasePeer::SURCHARGE.", 0)) AS sum_surcharge_debit,
	  		SUM(IF(".PurchasePeer::QUANTITY.">0, ".PurchasePeer::QUANTITY." * ".PurchasePeer::SURCHARGE.", 0)) AS sum_surcharge_credit,
	  		DATEDIFF(".PurchasePeer::CREATED_AT.", NOW()) AS diff_days,
	  		DATE(".PurchasePeer::CREATED_AT.") AS date_formatted,
	  		YEAR(".PurchasePeer::CREATED_AT.") AS purchase_year
	  	FROM ".PurchasePeer::TABLE_NAME."
	  	LEFT JOIN ".UserPeer::TABLE_NAME."
	  		ON ".PurchasePeer::USER_ID." = ".UserPeer::ID."
	  	WHERE ".PurchasePeer::CANCELLED_AT." IS NULL
	  		AND ".UserPeer::NICKNAME." NOT IN(".$not_in_inserts.")
	  		AND YEAR(".PurchasePeer::CREATED_AT.") = ?
	  	GROUP BY purchase_year
	  	ORDER BY date_formatted DESC";

	  $stmt = $con->prepareStatement($sql);
	  foreach ($not_in as $i => $v) {
		  $stmt->setString($i + 1, $v);
	  }
	  // another query parameter: the date limit (we want everything from this calendar year)
	  $stmt->setInt(count($not_in) + 1, date("Y"));
	  $rs = $stmt->executeQuery();

	  if ($rs->next()) {
	  	$s["year"] = $this->addStatistics($rs, $s["year"]);
	  }

	  return $s;
  }

  /**
   * Add statistics from $rs into the $init array and return the new stats
   * uses the keys in $keys
   */
  private function addStatistics($rs, $init) {
	  $init["count"] += $rs->getInt("count");
	  $init["sum_quantity"] += $rs->getInt("sum_quantity");
	  $init["sum_quantity_debit"] += $rs->getInt("sum_quantity_debit");
	  $init["sum_quantity_credit"] += $rs->getInt("sum_quantity_credit");
	  $init["sum_total"] += $rs->getFloat("sum_total");
	  $init["sum_total_debit"] += $rs->getFloat("sum_total_debit");
	  $init["sum_total_credit"] += $rs->getFloat("sum_total_credit");
	  $init["sum_surcharge"] += $rs->getFloat("sum_surcharge");
	  $init["sum_surcharge_debit"] += $rs->getFloat("sum_surcharge_debit");
	  $init["sum_surcharge_credit"] += $rs->getFloat("sum_surcharge_credit");
	  return $init;
  }

  protected function getStockLosses() {
	  $con = Propel::getConnection(PurchasePeer::DATABASE_NAME);

	  $not_in = sfConfig::get("app_losses_users", array());
	  $not_in[] = "__ignored__";		// special one so we don't have lots of logic below
	  $not_in_inserts = implode(",", array_fill(0, count($not_in), "?"));

	  $sql = "SELECT COUNT(".PurchasePeer::CREATED_AT.") AS count,
	  		SUM(".PurchasePeer::QUANTITY.") AS sum_quantity,
	  		SUM(".PurchasePeer::QUANTITY." * ".PurchasePeer::PRICE.") AS sum_total,
	  		SUM(".PurchasePeer::QUANTITY." * ".PurchasePeer::SURCHARGE.") AS sum_surcharge,
	  		SUM(IF(".PurchasePeer::QUANTITY."<0, ".PurchasePeer::QUANTITY.", 0)) AS sum_quantity_debit,
	  		SUM(IF(".PurchasePeer::QUANTITY.">0, ".PurchasePeer::QUANTITY.", 0)) AS sum_quantity_credit,
	  		SUM(IF(".PurchasePeer::QUANTITY."<0, ".PurchasePeer::QUANTITY." * ".PurchasePeer::PRICE.", 0)) AS sum_total_debit,
	  		SUM(IF(".PurchasePeer::QUANTITY.">0, ".PurchasePeer::QUANTITY." * ".PurchasePeer::PRICE.", 0)) AS sum_total_credit,
	  		SUM(IF(".PurchasePeer::QUANTITY."<0, ".PurchasePeer::QUANTITY." * ".PurchasePeer::SURCHARGE.", 0)) AS sum_surcharge_debit,
	  		SUM(IF(".PurchasePeer::QUANTITY.">0, ".PurchasePeer::QUANTITY." * ".PurchasePeer::SURCHARGE.", 0)) AS sum_surcharge_credit,
	  		DATEDIFF(".PurchasePeer::CREATED_AT.", NOW()) AS diff_days,
	  		DATE(".PurchasePeer::CREATED_AT.") AS date_formatted
	  	FROM ".PurchasePeer::TABLE_NAME."
	  	LEFT JOIN ".UserPeer::TABLE_NAME."
	  		ON ".PurchasePeer::USER_ID." = ".UserPeer::ID."
	  	WHERE ".PurchasePeer::CANCELLED_AT." IS NULL
	  		AND ".UserPeer::NICKNAME." IN(".$not_in_inserts.")
	  		AND ".PurchasePeer::CREATED_AT." >= ?
	  	GROUP BY date_formatted
	  	ORDER BY date_formatted DESC";

	  $stmt = $con->prepareStatement($sql);
	  foreach ($not_in as $i => $v) {
		  $stmt->setString($i + 1, $v);
	  }
	  // another query parameter: the date limit
	  $stmt->setDate(count($not_in) + 1, date("Y-m-d", strtotime("-1 month")));

	  $rs = $stmt->executeQuery();
	  $empty = array("count" => 0, "sum_quantity" => 0, "sum_total" => 0, "sum_surcharge" => 0,
			"sum_quantity_debit" => 0, "sum_quantity_credit" => 0,
			"sum_total_debit" => 0, "sum_total_credit" => 0,
			"sum_surcharge_debit" => 0, "sum_surcharge_credit" => 0,
	  	);
	  $s = array(
		  "today" => $empty,
		  "week" => $empty,
		  "month" => $empty,
		  "year" => $empty,
		  "all" => $empty,
		  );
	  while ($rs->next()) {
		  $days = $rs->getInt("diff_days");
		  if ($days == 0) {
			  $s["today"] = $this->addStatistics($rs, $s["today"]);
		  }
		  if ($days >= -7) {
			  $s["week"] = $this->addStatistics($rs, $s["week"]);
		  }
		  if ($days >= -31) {
			  $s["month"] = $this->addStatistics($rs, $s["month"]);
		  }
		  $s["all"] = $this->addStatistics($rs, $s["all"]);
	  }

	  // we also want to get statistics for the calendar year, but we don't want to have to parse 365 rows of data
	  $sql = "SELECT COUNT(".PurchasePeer::CREATED_AT.") AS count,
	  		SUM(".PurchasePeer::QUANTITY.") AS sum_quantity,
	  		SUM(".PurchasePeer::QUANTITY." * ".PurchasePeer::PRICE.") AS sum_total,
	  		SUM(".PurchasePeer::QUANTITY." * ".PurchasePeer::SURCHARGE.") AS sum_surcharge,
	  		SUM(IF(".PurchasePeer::QUANTITY."<0, ".PurchasePeer::QUANTITY.", 0)) AS sum_quantity_debit,
	  		SUM(IF(".PurchasePeer::QUANTITY.">0, ".PurchasePeer::QUANTITY.", 0)) AS sum_quantity_credit,
	  		SUM(IF(".PurchasePeer::QUANTITY."<0, ".PurchasePeer::QUANTITY." * ".PurchasePeer::PRICE.", 0)) AS sum_total_debit,
	  		SUM(IF(".PurchasePeer::QUANTITY.">0, ".PurchasePeer::QUANTITY." * ".PurchasePeer::PRICE.", 0)) AS sum_total_credit,
	  		SUM(IF(".PurchasePeer::QUANTITY."<0, ".PurchasePeer::QUANTITY." * ".PurchasePeer::SURCHARGE.", 0)) AS sum_surcharge_debit,
	  		SUM(IF(".PurchasePeer::QUANTITY.">0, ".PurchasePeer::QUANTITY." * ".PurchasePeer::SURCHARGE.", 0)) AS sum_surcharge_credit,
	  		DATEDIFF(".PurchasePeer::CREATED_AT.", NOW()) AS diff_days,
	  		DATE(".PurchasePeer::CREATED_AT.") AS date_formatted,
	  		YEAR(".PurchasePeer::CREATED_AT.") AS purchase_year
	  	FROM ".PurchasePeer::TABLE_NAME."
	  	LEFT JOIN ".UserPeer::TABLE_NAME."
	  		ON ".PurchasePeer::USER_ID." = ".UserPeer::ID."
	  	WHERE ".PurchasePeer::CANCELLED_AT." IS NULL
	  		AND ".UserPeer::NICKNAME." IN(".$not_in_inserts.")
	  		AND YEAR(".PurchasePeer::CREATED_AT.") = ?
	  	GROUP BY purchase_year
	  	ORDER BY date_formatted DESC";

	  $stmt = $con->prepareStatement($sql);
	  foreach ($not_in as $i => $v) {
		  $stmt->setString($i + 1, $v);
	  }
	  // another query parameter: the date limit (we want everything from this calendar year)
	  $stmt->setInt(count($not_in) + 1, date("Y"));
	  $rs = $stmt->executeQuery();

	  if ($rs->next()) {
	  	$s["year"] = $this->addStatistics($rs, $s["year"]);
	  }

	  return $s;
  }

  /**
   * Add statistics from $rs into the $init array and return the new stats
   * uses the keys in $keys
   */
  private function addStockLosses($rs, $init) {
	  $init["count"] += $rs->getInt("count");
	  $init["sum_quantity"] += $rs->getInt("sum_quantity");
	  $init["sum_quantity_debit"] += $rs->getInt("sum_quantity_debit");
	  $init["sum_quantity_credit"] += $rs->getInt("sum_quantity_credit");
	  $init["sum_total"] += $rs->getFloat("sum_total");
	  $init["sum_total_debit"] += $rs->getFloat("sum_total_debit");
	  $init["sum_total_credit"] += $rs->getFloat("sum_total_credit");
	  $init["sum_surcharge"] += $rs->getFloat("sum_surcharge");
	  $init["sum_surcharge_debit"] += $rs->getFloat("sum_surcharge_debit");
	  $init["sum_surcharge_credit"] += $rs->getFloat("sum_surcharge_credit");
	  return $init;
  }

  public function executeShow()
  {
    $this->product = ProductPeer::retrieveByPk($this->getRequestParameter('id'));
    $this->forward404Unless($this->product);

    $this->user = $this->getUserObject(false);

    // recent activity?
    $this->activity = false;
    if ($this->user && $this->user->canViewActivity()) {
		$c = new Criteria();
		$c->addDescendingOrderByColumn(PurchasePeer::CREATED_AT);
		$c->add(PurchasePeer::PRODUCT_ID, $this->product->getId());
		$c->setLimit(30);
		$this->activity = PurchasePeer::doSelect($c);
	}
  }

  public function executePurchase() {
	  // user needs to be logged in
	  $this->user = $this->getUserObject();

	  // how much do we need?
	  try {
		  sfLoader::loadHelpers("My");

		  $stock_loss = $this->getRequestParameter("stock_loss") && $this->user->canChargeStockLosses();
		  if ($stock_loss) {
			  // get the stock loss user
			  $stock_user = User::getStockLossUser();
			  $this->forward404Unless($stock_user);
		  }

		  $this->product = ProductPeer::retrieveByPk($this->getRequestParameter('id'));
		  $this->forward404Unless($this->product, "no product specified");
		  $this->quantity = (int) $this->getRequestParameter('quantity');
		  $this->forward404Unless($this->quantity > 0, "no quantity specified");
		  $surcharge = get_surcharge_for($this->product->getPrice());
		  $total = apply_surcharge($this->product->getPrice()) * $this->quantity;
		  $this->forward404Unless($this->product->getInventory() >= $this->quantity, "insufficient quantites available");

		  if (!$stock_loss) {
			  // do we have enough credit?
			  if (($this->user->getAccountCredit() - $total) < sfConfig::get("app_credit_minimum", 0)) {
				  // no we don't; display an error message
				  sfLoader::loadHelpers('Url');
				  throw new sfError404Exception("You don't have enough credit in your account. You need to credit your account.");
			  }
		  }

		  // execute purchase
		  $purchase = new Purchase();
		  $purchase->setUser($stock_loss ? $stock_user : $this->user);
		  $purchase->setProduct($this->product);
		  $purchase->setQuantity(-$this->quantity);
		  $purchase->setPrice($this->product->getPrice());
		  $purchase->setSurcharge($surcharge);
		  $purchase->save();

		  // deduct balance
		  if (!$stock_loss) {
			  $this->user->setAccountCredit($this->user->getAccountCredit() - $total);
			  $this->user->save();
		  }

		  // update product
		  $this->product->setInventory($this->product->getInventory() - $this->quantity);
		  $this->product->save();

		  // redirect to ok page
		  return $this->redirect("product/list?purchase=".$purchase->getId() . ($stock_loss ? "&stock=1" : "") );

	  } catch (sfError404Exception $e) {
		  $this->getRequest()->setError("exception", $e->getMessage());
		  return sfView::ERROR;
	  }

  }

  public function executeCredit() {
	  // user needs to be logged in
	  $this->user = $this->getUserObject();

	  try {
		  sfLoader::loadHelpers("My");

		  $this->product = ProductPeer::retrieveByPk($this->getRequestParameter('id'));
		  $this->forward404Unless($this->product, "no product specified");
		  $this->quantity = (int) $this->getRequestParameter('quantity');
		  $this->forward404Unless($this->quantity > 0, "no quantity specified");
		  $this->price = $this->getRequestParameter('price');
		  $this->forward404Unless($this->price > 0, "no price specified");
		  $total = $this->price * $this->quantity;
		  $this->forward404Unless($this->user->canCredit($this->product), "user cannot credit this product");

		  $max_credit = sfConfig::get("app_credit_max", 50);
		  if ($total > $max_credit) {
			  throw new sfError404Exception("You cannot credit more than " . my_format_currency($max_credit) . ".");
		  }

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
