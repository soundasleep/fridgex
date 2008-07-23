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

}
