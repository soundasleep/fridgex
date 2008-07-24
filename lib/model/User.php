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
		$c->add(UserPeer::EMAIL, $context->getRequestParameter("email", ""));
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
		return $this->hasSpecificPermission("inventory");
	}

	public function canAddUser() {
		return $this->hasSpecificPermission("user");
	}

	public function canVerifyCredit() {
		return $this->hasSpecificPermission("verify");
	}

	public function canEditUser($user) {
		return $this->hasSpecificPermission("user");
	}

	public function canDeleteUser($product) {
		return $this->hasSpecificPermission("user") && $this->hasSpecificPermission("delete");
	}

	public function hasSpecificPermission($key) {
		$permissions = $this->getUserPermissions();
		foreach ($permissions as $p) {
			if ($p->getPermission() == $key)
				return true;
		}

		return false;
	}

}
