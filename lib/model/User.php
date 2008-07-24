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

	static public function logout(sfActions $context) {
		$context->getUser()->setAuthenticated(false);
		$context->getUser()->setUserId(false);

	}

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

	public function hasSpecificPermission($key) {
		$permissions = $this->getUserPermissions();
		foreach ($permissions as $p) {
			if ($p->getPermission() == $key)
				return true;
		}

		return false;
	}

	/**
	 * Return a string describing the recent activity of the user
	 */
	public function getRecentActivity() {

		if (!$this->recent_activity) {
			$c = new Criteria();
			$c->add(PurchasePeer::USER_ID, $this->getId());
			$c->add(PurchasePeer::CREATED_AT, date("Y-m-d", strtotime(sfConfig::get("app_user_recent", "-14 days"))), Criteria::GREATER_EQUAL);
			$c->addDescendingOrderByColumn(PurchasePeer::CREATED_AT);
			$c->setLimit(100);
			$this->recent_activity = PurchasePeer::doSelect($c);
		}

		$purchase = $credit = array("count" => 0, "value" => 0, "items" => 0);
		foreach ($this->recent_activity as $p) {
			if ($p->getQuantity() < 0) {
				$purchase["count"]++;
				$purchase["value"] += -$p->getQuantity() * $p->getPrice();
				$purchase["items"] += -$p->getQuantity();
			} else {
				$credit["count"]++;
				$credit["value"] += $p->getQuantity() * $p->getPrice();
				$credit["items"] += $p->getQuantity();
			}
		}

		$str = array();
		if ($purchase["count"]) {
			sfLoader::loadHelpers("Number");
			$str[] = number_format($purchase["count"]) . " purchases (" . number_format($purchase["items"]) . " items) : " . format_currency($purchase["value"]);
		}
		if ($credit["count"]) {
			sfLoader::loadHelpers("Number");
			$str[] = number_format($credit["count"]) . " credits (" . number_format($credit["items"]) . " items) : " . format_currency($credit["value"]);
		}

		return $str ? implode("; ", $str) : "-";

	}
	var $recent_activity;

}
