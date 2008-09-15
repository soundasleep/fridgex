<?php

/**
 * Subclass for representing a row from the 'user' table.
 *
 *
 *
 * @package lib.model
 */
class User extends BaseUser
{

	/**
	 * Try to log in as a user with a given context
	 */
	static function login(sfActions $context)
	{
		// does such a user exist?
		$c = new Criteria();
		$c_q = $c->getNewCriterion(UserPeer::EMAIL, $context->getRequestParameter("email", ""));
		$c_q->addOr($c->getNewCriterion(UserPeer::NICKNAME, $context->getRequestParameter("email", "")));
		$c->add($c_q);
		$user = UserPeer::doSelectOne($c);

		if (!$user) {
			$context->getRequest()->setError("email", "No such user exists");
		} elseif ($user->getPasswordHash() != md5($context->getRequestParameter("password", "")) &&
			$user->getPasswordHash() != $context->getRequestParameter("password_hash", "")) {
			$context->getRequest()->setError("email", "Incorrect password");
		} else {
			// ok
			$context->getUser()->setAuthenticated(true);
			$context->getUser()->setUserId($user->getId());
			$user->setLastLogin(time());
			$user->save();

			return $user;
		}

		return false;
	}

	/**
	 * Log the current user out (not log out the user represented by this object)
	 */
	static public function logout(sfActions $context) {
		$context->getUser()->setAuthenticated(false);
		$context->getUser()->setUserId(false);

	}

	/**
	 * Some convenience functions to specify user permissions
	 */
	public function canCredit($product) {
		return true;		// currently all members can always credit new purchases
	}

	public function canAddProduct() {
		return $this->hasSpecificPermission("edit");
	}

	public function canEditProduct($product) {
		return $this->hasSpecificPermission("edit");
	}

	public function canDeleteProduct($product) {
		return $this->hasSpecificPermission("edit") && $this->hasSpecificPermission("delete");
	}

	public function canSetInventory($product) {
		return $this->hasSpecificPermission("edit") && $this->hasSpecificPermission("inventory");
	}

	public function canAddUser() {
		return $this->hasSpecificPermission("user");
	}

	public function canVerifyCredit() {
		return $this->hasSpecificPermission("verify");
	}

	public function canListUsers() {
		return $this->hasSpecificPermission("user");
	}

	public function canEditUser($user) {
		return $this->hasSpecificPermission("user");
	}

	public function canDeleteUser($user) {
		return $this->hasSpecificPermission("user") && $this->hasSpecificPermission("delete");
	}

	public function canSetCredit($user) {
		return $this->hasSpecificPermission("user") && $this->hasSpecificPermission("credit");
	}

	public function canViewSurcharge() {
		return $this->hasSpecificPermission("edit");
	}

	public function canViewActivity() {
		return $this->hasSpecificPermission("activity");
	}

	public function canAssignPermissions() {
		return $this->hasSpecificPermission("permission");
	}

	public function canCancelPurchases() {
		return $this->hasSpecificPermission("cancel");
	}

	public function canSeeStockLosses() {
		return $this->canViewSurcharge();
	}

	/**
	 * Does this user have a specific permission key?
	 * @see UserPermission
	 */
	public function hasSpecificPermission($key) {
		$permissions = $this->getUserPermissions();
		foreach ($permissions as $p) {
			if ($p->getPermission() == $key)
				return $p;
		}

		return false;
	}

	public function hasPermission($key) {
		return $this->hasSpecificPermission($key);
	}

	public function addPermission(UserPermission $p) {
		return $this->addUserPermission($p);
	}

	public function deletePermission($key) {
		$p = $this->hasPermission($key);
		if ($p) {
			$p->delete();
			$this->save();
		}
	}

	/**
	 * Are the purchases/credits from this user ignored for
	 * statistics purposes?
	 */
	public function isIgnored() {
		$ignore = sfConfig::get("app_ignore_users", array());
		if (!is_array($ignore))
			$ignore = array($ignore);
		foreach ($ignore as $i) {
			if ($i == $this->getNickname()) {
				return true;
			}
		}
		return false;
	}

	/**
	 * Are the purchases/credits from this user considered as stock losses?
	 */
	public function isIgnored() {
		$ignore = sfConfig::get("app_losses_users", array());
		if (!is_array($ignore))
			$ignore = array($ignore);
		foreach ($ignore as $i) {
			if ($i == $this->getNickname()) {
				return true;
			}
		}
		return false;
	}

	/**
	 * Return a string describing the recent activity of the user
	 * eg. "5 purchases ($10); 12 credits ($8.50)".
	 */
	public function getRecentActivity() {

		if (!$this->recent_activity) {
			$c = new Criteria();
			$c->add(PurchasePeer::USER_ID, $this->getId());
			$c->add(PurchasePeer::CREATED_AT, date("Y-m-d", strtotime(sfConfig::get("app_user_recent", "-90 days"))), Criteria::GREATER_EQUAL);
			$c->addDescendingOrderByColumn(PurchasePeer::CREATED_AT);
			$c->setLimit(300);
			$this->recent_activity = PurchasePeer::doSelect($c);
		}

		$purchase = $credit = array("count" => 0, "value" => 0, "items" => 0, "verified" => 0);
		foreach ($this->recent_activity as $p) {
			if ($p->getQuantity() < 0) {
				$purchase["count"]++;
				$purchase["value"] += -$p->getQuantity() * $p->getPrice();
				$purchase["items"] += -$p->getQuantity();
				$purchase["verified"] += $p->getVerifiedBy() ? 1 : 0;
			} else {
				$credit["count"]++;
				$credit["value"] += $p->getQuantity() * $p->getPrice();
				$credit["items"] += $p->getQuantity();
				$credit["verified"] += $p->getVerifiedBy() ? 1 : 0;
			}
		}

		$str = array();
		if ($purchase["count"]) {
			sfLoader::loadHelpers("My");
			$str[] = number_format($purchase["count"]) . " purchases (" . number_format($purchase["items"]) . " items) : " . my_format_currency($purchase["value"]);
		}
		if ($credit["count"]) {
			sfLoader::loadHelpers("My");
			$str[] = number_format($credit["count"]) . " credits (" . number_format($credit["items"]) . " items) : " . my_format_currency($credit["value"]) . ", " . number_format(($credit["verified"] / $credit["count"]) * 100) . "% verified";
		}

		$this->recent_purchases = $purchase;
		$this->recent_credits = $credit;

		return $str ? implode("; ", $str) : "-";

	}
	var $recent_activity;
	var $recent_purchases;
	var $recent_credits;

	protected function getPurchaseVariable($key) {
		if (!$this->recent_purchases)
			$this->getRecentActivity();
		return $this->recent_purchases[$key];
	}

	protected function getCreditVariable($key) {
		if (!$this->recent_purchases)
			$this->getRecentActivity();
		return $this->recent_credits[$key];
	}

	public function getPurchaseCount() { return $this->getPurchaseVariable("count"); }
	public function getPurchaseItems() { return $this->getPurchaseVariable("items"); }
	public function getPurchaseValue() { return -$this->getPurchaseVariable("value"); }
	public function getPurchaseVerified() { return $this->getPurchaseVariable("verified"); }
	public function getPurchasePercent() { return $this->getPurchaseCount() ? ($this->getPurchaseVariable("verified") / $this->getPurchaseVariable("count")) * 100 : 0; }

	public function getCreditCount() { return $this->getCreditVariable("count"); }
	public function getCreditItems() { return $this->getCreditVariable("items"); }
	public function getCreditValue() { return $this->getCreditVariable("value"); }
	public function getCreditVerified() { return $this->getCreditVariable("verified"); }
	public function getCreditPercent() { return $this->getCreditCount() ? ($this->getCreditVariable("verified") / $this->getCreditVariable("count")) * 100 : 0; }

}
