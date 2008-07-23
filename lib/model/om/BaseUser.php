<?php


abstract class BaseUser extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $email;


	
	protected $name;


	
	protected $nickname;


	
	protected $password_hash;


	
	protected $created_at;


	
	protected $updated_at;


	
	protected $last_login;

	
	protected $collUserPermissions;

	
	protected $lastUserPermissionCriteria = null;

	
	protected $collPurchases;

	
	protected $lastPurchaseCriteria = null;

	
	protected $collCredits;

	
	protected $lastCreditCriteria = null;

	
	protected $collEmails;

	
	protected $lastEmailCriteria = null;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getEmail()
	{

		return $this->email;
	}

	
	public function getName()
	{

		return $this->name;
	}

	
	public function getNickname()
	{

		return $this->nickname;
	}

	
	public function getPasswordHash()
	{

		return $this->password_hash;
	}

	
	public function getCreatedAt($format = 'Y-m-d H:i:s')
	{

		if ($this->created_at === null || $this->created_at === '') {
			return null;
		} elseif (!is_int($this->created_at)) {
						$ts = strtotime($this->created_at);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse value of [created_at] as date/time value: " . var_export($this->created_at, true));
			}
		} else {
			$ts = $this->created_at;
		}
		if ($format === null) {
			return $ts;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $ts);
		} else {
			return date($format, $ts);
		}
	}

	
	public function getUpdatedAt($format = 'Y-m-d H:i:s')
	{

		if ($this->updated_at === null || $this->updated_at === '') {
			return null;
		} elseif (!is_int($this->updated_at)) {
						$ts = strtotime($this->updated_at);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse value of [updated_at] as date/time value: " . var_export($this->updated_at, true));
			}
		} else {
			$ts = $this->updated_at;
		}
		if ($format === null) {
			return $ts;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $ts);
		} else {
			return date($format, $ts);
		}
	}

	
	public function getLastLogin($format = 'Y-m-d H:i:s')
	{

		if ($this->last_login === null || $this->last_login === '') {
			return null;
		} elseif (!is_int($this->last_login)) {
						$ts = strtotime($this->last_login);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse value of [last_login] as date/time value: " . var_export($this->last_login, true));
			}
		} else {
			$ts = $this->last_login;
		}
		if ($format === null) {
			return $ts;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $ts);
		} else {
			return date($format, $ts);
		}
	}

	
	public function setId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = UserPeer::ID;
		}

	} 
	
	public function setEmail($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->email !== $v) {
			$this->email = $v;
			$this->modifiedColumns[] = UserPeer::EMAIL;
		}

	} 
	
	public function setName($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->name !== $v) {
			$this->name = $v;
			$this->modifiedColumns[] = UserPeer::NAME;
		}

	} 
	
	public function setNickname($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->nickname !== $v) {
			$this->nickname = $v;
			$this->modifiedColumns[] = UserPeer::NICKNAME;
		}

	} 
	
	public function setPasswordHash($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->password_hash !== $v) {
			$this->password_hash = $v;
			$this->modifiedColumns[] = UserPeer::PASSWORD_HASH;
		}

	} 
	
	public function setCreatedAt($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse date/time value for [created_at] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->created_at !== $ts) {
			$this->created_at = $ts;
			$this->modifiedColumns[] = UserPeer::CREATED_AT;
		}

	} 
	
	public function setUpdatedAt($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse date/time value for [updated_at] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->updated_at !== $ts) {
			$this->updated_at = $ts;
			$this->modifiedColumns[] = UserPeer::UPDATED_AT;
		}

	} 
	
	public function setLastLogin($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse date/time value for [last_login] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->last_login !== $ts) {
			$this->last_login = $ts;
			$this->modifiedColumns[] = UserPeer::LAST_LOGIN;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->email = $rs->getString($startcol + 1);

			$this->name = $rs->getString($startcol + 2);

			$this->nickname = $rs->getString($startcol + 3);

			$this->password_hash = $rs->getString($startcol + 4);

			$this->created_at = $rs->getTimestamp($startcol + 5, null);

			$this->updated_at = $rs->getTimestamp($startcol + 6, null);

			$this->last_login = $rs->getTimestamp($startcol + 7, null);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 8; 
		} catch (Exception $e) {
			throw new PropelException("Error populating User object", $e);
		}
	}

	
	public function delete($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(UserPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			UserPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	
	public function save($con = null)
	{
    if ($this->isNew() && !$this->isColumnModified(UserPeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

    if ($this->isModified() && !$this->isColumnModified(UserPeer::UPDATED_AT))
    {
      $this->setUpdatedAt(time());
    }

		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(UserPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			$affectedRows = $this->doSave($con);
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	
	protected function doSave($con)
	{
		$affectedRows = 0; 		if (!$this->alreadyInSave) {
			$this->alreadyInSave = true;


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = UserPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += UserPeer::doUpdate($this, $con);
				}
				$this->resetModified(); 			}

			if ($this->collUserPermissions !== null) {
				foreach($this->collUserPermissions as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collPurchases !== null) {
				foreach($this->collPurchases as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collCredits !== null) {
				foreach($this->collCredits as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collEmails !== null) {
				foreach($this->collEmails as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			$this->alreadyInSave = false;
		}
		return $affectedRows;
	} 
	
	protected $validationFailures = array();

	
	public function getValidationFailures()
	{
		return $this->validationFailures;
	}

	
	public function validate($columns = null)
	{
		$res = $this->doValidate($columns);
		if ($res === true) {
			$this->validationFailures = array();
			return true;
		} else {
			$this->validationFailures = $res;
			return false;
		}
	}

	
	protected function doValidate($columns = null)
	{
		if (!$this->alreadyInValidation) {
			$this->alreadyInValidation = true;
			$retval = null;

			$failureMap = array();


			if (($retval = UserPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collUserPermissions !== null) {
					foreach($this->collUserPermissions as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collPurchases !== null) {
					foreach($this->collPurchases as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collCredits !== null) {
					foreach($this->collCredits as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collEmails !== null) {
					foreach($this->collEmails as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}


			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = UserPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getEmail();
				break;
			case 2:
				return $this->getName();
				break;
			case 3:
				return $this->getNickname();
				break;
			case 4:
				return $this->getPasswordHash();
				break;
			case 5:
				return $this->getCreatedAt();
				break;
			case 6:
				return $this->getUpdatedAt();
				break;
			case 7:
				return $this->getLastLogin();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = UserPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getEmail(),
			$keys[2] => $this->getName(),
			$keys[3] => $this->getNickname(),
			$keys[4] => $this->getPasswordHash(),
			$keys[5] => $this->getCreatedAt(),
			$keys[6] => $this->getUpdatedAt(),
			$keys[7] => $this->getLastLogin(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = UserPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setEmail($value);
				break;
			case 2:
				$this->setName($value);
				break;
			case 3:
				$this->setNickname($value);
				break;
			case 4:
				$this->setPasswordHash($value);
				break;
			case 5:
				$this->setCreatedAt($value);
				break;
			case 6:
				$this->setUpdatedAt($value);
				break;
			case 7:
				$this->setLastLogin($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = UserPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setEmail($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setName($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setNickname($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setPasswordHash($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setCreatedAt($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setUpdatedAt($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setLastLogin($arr[$keys[7]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(UserPeer::DATABASE_NAME);

		if ($this->isColumnModified(UserPeer::ID)) $criteria->add(UserPeer::ID, $this->id);
		if ($this->isColumnModified(UserPeer::EMAIL)) $criteria->add(UserPeer::EMAIL, $this->email);
		if ($this->isColumnModified(UserPeer::NAME)) $criteria->add(UserPeer::NAME, $this->name);
		if ($this->isColumnModified(UserPeer::NICKNAME)) $criteria->add(UserPeer::NICKNAME, $this->nickname);
		if ($this->isColumnModified(UserPeer::PASSWORD_HASH)) $criteria->add(UserPeer::PASSWORD_HASH, $this->password_hash);
		if ($this->isColumnModified(UserPeer::CREATED_AT)) $criteria->add(UserPeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(UserPeer::UPDATED_AT)) $criteria->add(UserPeer::UPDATED_AT, $this->updated_at);
		if ($this->isColumnModified(UserPeer::LAST_LOGIN)) $criteria->add(UserPeer::LAST_LOGIN, $this->last_login);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(UserPeer::DATABASE_NAME);

		$criteria->add(UserPeer::ID, $this->id);

		return $criteria;
	}

	
	public function getPrimaryKey()
	{
		return $this->getId();
	}

	
	public function setPrimaryKey($key)
	{
		$this->setId($key);
	}

	
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setEmail($this->email);

		$copyObj->setName($this->name);

		$copyObj->setNickname($this->nickname);

		$copyObj->setPasswordHash($this->password_hash);

		$copyObj->setCreatedAt($this->created_at);

		$copyObj->setUpdatedAt($this->updated_at);

		$copyObj->setLastLogin($this->last_login);


		if ($deepCopy) {
									$copyObj->setNew(false);

			foreach($this->getUserPermissions() as $relObj) {
				$copyObj->addUserPermission($relObj->copy($deepCopy));
			}

			foreach($this->getPurchases() as $relObj) {
				$copyObj->addPurchase($relObj->copy($deepCopy));
			}

			foreach($this->getCredits() as $relObj) {
				$copyObj->addCredit($relObj->copy($deepCopy));
			}

			foreach($this->getEmails() as $relObj) {
				$copyObj->addEmail($relObj->copy($deepCopy));
			}

		} 

		$copyObj->setNew(true);

		$copyObj->setId(NULL); 
	}

	
	public function copy($deepCopy = false)
	{
				$clazz = get_class($this);
		$copyObj = new $clazz();
		$this->copyInto($copyObj, $deepCopy);
		return $copyObj;
	}

	
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new UserPeer();
		}
		return self::$peer;
	}

	
	public function initUserPermissions()
	{
		if ($this->collUserPermissions === null) {
			$this->collUserPermissions = array();
		}
	}

	
	public function getUserPermissions($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseUserPermissionPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collUserPermissions === null) {
			if ($this->isNew()) {
			   $this->collUserPermissions = array();
			} else {

				$criteria->add(UserPermissionPeer::USER_ID, $this->getId());

				UserPermissionPeer::addSelectColumns($criteria);
				$this->collUserPermissions = UserPermissionPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(UserPermissionPeer::USER_ID, $this->getId());

				UserPermissionPeer::addSelectColumns($criteria);
				if (!isset($this->lastUserPermissionCriteria) || !$this->lastUserPermissionCriteria->equals($criteria)) {
					$this->collUserPermissions = UserPermissionPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastUserPermissionCriteria = $criteria;
		return $this->collUserPermissions;
	}

	
	public function countUserPermissions($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseUserPermissionPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(UserPermissionPeer::USER_ID, $this->getId());

		return UserPermissionPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addUserPermission(UserPermission $l)
	{
		$this->collUserPermissions[] = $l;
		$l->setUser($this);
	}

	
	public function initPurchases()
	{
		if ($this->collPurchases === null) {
			$this->collPurchases = array();
		}
	}

	
	public function getPurchases($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BasePurchasePeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collPurchases === null) {
			if ($this->isNew()) {
			   $this->collPurchases = array();
			} else {

				$criteria->add(PurchasePeer::USER_ID, $this->getId());

				PurchasePeer::addSelectColumns($criteria);
				$this->collPurchases = PurchasePeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(PurchasePeer::USER_ID, $this->getId());

				PurchasePeer::addSelectColumns($criteria);
				if (!isset($this->lastPurchaseCriteria) || !$this->lastPurchaseCriteria->equals($criteria)) {
					$this->collPurchases = PurchasePeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastPurchaseCriteria = $criteria;
		return $this->collPurchases;
	}

	
	public function countPurchases($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BasePurchasePeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(PurchasePeer::USER_ID, $this->getId());

		return PurchasePeer::doCount($criteria, $distinct, $con);
	}

	
	public function addPurchase(Purchase $l)
	{
		$this->collPurchases[] = $l;
		$l->setUser($this);
	}


	
	public function getPurchasesJoinProduct($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BasePurchasePeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collPurchases === null) {
			if ($this->isNew()) {
				$this->collPurchases = array();
			} else {

				$criteria->add(PurchasePeer::USER_ID, $this->getId());

				$this->collPurchases = PurchasePeer::doSelectJoinProduct($criteria, $con);
			}
		} else {
									
			$criteria->add(PurchasePeer::USER_ID, $this->getId());

			if (!isset($this->lastPurchaseCriteria) || !$this->lastPurchaseCriteria->equals($criteria)) {
				$this->collPurchases = PurchasePeer::doSelectJoinProduct($criteria, $con);
			}
		}
		$this->lastPurchaseCriteria = $criteria;

		return $this->collPurchases;
	}

	
	public function initCredits()
	{
		if ($this->collCredits === null) {
			$this->collCredits = array();
		}
	}

	
	public function getCredits($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseCreditPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collCredits === null) {
			if ($this->isNew()) {
			   $this->collCredits = array();
			} else {

				$criteria->add(CreditPeer::USER_ID, $this->getId());

				CreditPeer::addSelectColumns($criteria);
				$this->collCredits = CreditPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(CreditPeer::USER_ID, $this->getId());

				CreditPeer::addSelectColumns($criteria);
				if (!isset($this->lastCreditCriteria) || !$this->lastCreditCriteria->equals($criteria)) {
					$this->collCredits = CreditPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastCreditCriteria = $criteria;
		return $this->collCredits;
	}

	
	public function countCredits($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseCreditPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(CreditPeer::USER_ID, $this->getId());

		return CreditPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addCredit(Credit $l)
	{
		$this->collCredits[] = $l;
		$l->setUser($this);
	}


	
	public function getCreditsJoinProduct($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseCreditPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collCredits === null) {
			if ($this->isNew()) {
				$this->collCredits = array();
			} else {

				$criteria->add(CreditPeer::USER_ID, $this->getId());

				$this->collCredits = CreditPeer::doSelectJoinProduct($criteria, $con);
			}
		} else {
									
			$criteria->add(CreditPeer::USER_ID, $this->getId());

			if (!isset($this->lastCreditCriteria) || !$this->lastCreditCriteria->equals($criteria)) {
				$this->collCredits = CreditPeer::doSelectJoinProduct($criteria, $con);
			}
		}
		$this->lastCreditCriteria = $criteria;

		return $this->collCredits;
	}

	
	public function initEmails()
	{
		if ($this->collEmails === null) {
			$this->collEmails = array();
		}
	}

	
	public function getEmails($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseEmailPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collEmails === null) {
			if ($this->isNew()) {
			   $this->collEmails = array();
			} else {

				$criteria->add(EmailPeer::USER_ID, $this->getId());

				EmailPeer::addSelectColumns($criteria);
				$this->collEmails = EmailPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(EmailPeer::USER_ID, $this->getId());

				EmailPeer::addSelectColumns($criteria);
				if (!isset($this->lastEmailCriteria) || !$this->lastEmailCriteria->equals($criteria)) {
					$this->collEmails = EmailPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastEmailCriteria = $criteria;
		return $this->collEmails;
	}

	
	public function countEmails($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseEmailPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(EmailPeer::USER_ID, $this->getId());

		return EmailPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addEmail(Email $l)
	{
		$this->collEmails[] = $l;
		$l->setUser($this);
	}

} 