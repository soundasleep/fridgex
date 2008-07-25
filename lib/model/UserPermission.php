<?php

/**
 * Subclass for representing a row from the 'user_permission' table.
 *
 *
 *
 * @package lib.model
 */
class UserPermission extends BaseUserPermission
{
	function __construct($permission = false) {
		$this->setPermission($permission);
	}

}
