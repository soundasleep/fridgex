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

			// autologin?
			if ($context->getRequestParameter("autologin")) {
				// set it!
				$key = $user->createNewLoginKey();
				$context->getResponse()->setCookie("fridge_autologin", $key, time() + 60*60*24*15, '/');	// 15 days
				$context->getResponse()->setCookie("fridge_autologin_disable", 0, 0, '/');	// to end of session
			}


			return $user;
		}

		return false;
	}

	/**
	 * Login a user with a login key, instead of username/password.
	 * We use login keys so we don't have to store the username/password as a cookie.
	 */
	static public function loginWithLoginKey($key, sfContext $context) {
		// does such a user exist?
		$c = new Criteria();
		$c->add(UserPeer::LOGIN_KEY, $key);
		$user = UserPeer::doSelectOne($c);

		if (!$user) {
			$context->getRequest()->setError("key", "No such login key exists");
		} else {
			// ok
			$context->getUser()->setAuthenticated(true);
			$context->getUser()->setUserId($user->getId());
			$user->setLastLogin(time());
			$user->save();

			$context->getRequest()->setParameter("used_autologin", true);

			return $user;
		}

		return false;
	}

	public function createNewLoginKey() {
		$key_done = false;
		for ($i = 0; $i < 100; $i++) {
			// generate a new key (todo: make the login key an index in the db)
			$new_key = sprintf("%04x%04x%04x%04x", rand(0,0xffff), rand(0,0xffff), rand(0,0xffff), rand(0,0xffff));

			// does a user with such a key already exist?
			$c = new Criteria();
			$c->add(UserPeer::LOGIN_KEY, $new_key);
			if (!UserPeer::doSelectOne($c)) {
				$key_done = true;
				break;
			}
		}

		if (!$key_done)
			throw new sfException("failed to generate new login key after $i iterations");

		$this->setLoginKey($new_key);
		$this->save();

		return $new_key;
	}

	/**
	 * Log the current user out (not log out the user represented by this object)
	 */
	static public function logout(sfActions $context) {
		$context->getUser()->setAuthenticated(false);
		$context->getUser()->setUserId(false);

		// disable autologin for now
		$context->getResponse()->setCookie("fridge_autologin_disable", 1, 0, '/');	// to end of session

	}

	/**
	 * Get a user which can be used to perform stock losses, or false if there is none.
	 */
	static public function getStockLossUser() {
		$a = sfConfig::get("app_losses_users", array());
		if (!$a || !is_array($a))
			return false;

		$c = new Criteria();
		$c->add(UserPeer::NICKNAME, $a[0]);
		return UserPeer::doSelectOne($c);
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

	public function canChargeStockLosses() {
		return $this->hasSpecificPermission("stock");
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
	public function isStockLoss() {
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
			$c->add(PurchasePeer::CANCELLED_BY_ID, null);
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
