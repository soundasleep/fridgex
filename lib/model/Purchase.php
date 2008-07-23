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
	public function setuser($v) {
		return $this->setUserRelatedByUserId($v);
	}

	public function setVerifiedUser($v) {
		return $this->setUserRelatedByVerifiedById($v);
	}
}
