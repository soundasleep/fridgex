<?php

class myUser extends sfBasicSecurityUser
{
	function getUserObject() {
		if (!$this->isAuthenticated()) {
			return false;
		}
		if ($this->getAttribute("user_id"))
			return UserPeer::retrieveByPk($this->getAttribute("user_id"));
		return false;
	}

	function getUserId() {
		return $this->getAttribute("user_id");
	}
	function setUserId($id) {
		$this->setAttribute("user_id", $id);
	}

}
