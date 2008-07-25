<?php

/**
 * Subclass for representing a row from the 'purchase' table.
 *
 *
 *
 * @package lib.model
 */
class Purchase extends BasePurchase
{
	/**
	 * some helper functions
 	 */

	public function setUser($v) {
		return $this->setUserRelatedByUserId($v);
	}

	public function setVerifiedUser($v) {
		return $this->setUserRelatedByVerifiedById($v);
	}

	public function setVerifiedBy($v) {
		return $this->setUserRelatedByVerifiedById($v);
	}

	public function getUser() {
		return $this->getUserRelatedByUserId();
	}

	public function getVerifiedByUser() {
		return $this->getUserRelatedByVerifiedById();
	}

	public function getVerifiedBy() {
		return $this->getUserRelatedByVerifiedById();
	}
}
