<?php


abstract class BasePurchase extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $user_id;


	
	protected $product_id;


	
	protected $quantity;


	
	protected $price;


	
	protected $created_at;


	
	protected $verified_by_id;


	
	protected $verified_at;


	
	protected $notes;


	
	protected $surcharge;


	
	protected $cancelled_at;


	
	protected $cancelled_by_id;

	
	protected $aUserRelatedByUserId;

	
	protected $aProduct;

	
	protected $aUserRelatedByVerifiedById;

	
	protected $aUserRelatedByCancelledById;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getUserId()
	{

		return $this->user_id;
	}

	
	public function getProductId()
	{

		return $this->product_id;
	}

	
	public function getQuantity()
	{

		return $this->quantity;
	}

	
	public function getPrice()
	{

		return $this->price;
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

	
	public function getVerifiedById()
	{

		return $this->verified_by_id;
	}

	
	public function getVerifiedAt($format = 'Y-m-d H:i:s')
	{

		if ($this->verified_at === null || $this->verified_at === '') {
			return null;
		} elseif (!is_int($this->verified_at)) {
						$ts = strtotime($this->verified_at);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse value of [verified_at] as date/time value: " . var_export($this->verified_at, true));
			}
		} else {
			$ts = $this->verified_at;
		}
		if ($format === null) {
			return $ts;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $ts);
		} else {
			return date($format, $ts);
		}
	}

	
	public function getNotes()
	{

		return $this->notes;
	}

	
	public function getSurcharge()
	{

		return $this->surcharge;
	}

	
	public function getCancelledAt($format = 'Y-m-d H:i:s')
	{

		if ($this->cancelled_at === null || $this->cancelled_at === '') {
			return null;
		} elseif (!is_int($this->cancelled_at)) {
						$ts = strtotime($this->cancelled_at);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse value of [cancelled_at] as date/time value: " . var_export($this->cancelled_at, true));
			}
		} else {
			$ts = $this->cancelled_at;
		}
		if ($format === null) {
			return $ts;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $ts);
		} else {
			return date($format, $ts);
		}
	}

	
	public function getCancelledById()
	{

		return $this->cancelled_by_id;
	}

	
	public function setId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = PurchasePeer::ID;
		}

	} 
	
	public function setUserId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->user_id !== $v) {
			$this->user_id = $v;
			$this->modifiedColumns[] = PurchasePeer::USER_ID;
		}

		if ($this->aUserRelatedByUserId !== null && $this->aUserRelatedByUserId->getId() !== $v) {
			$this->aUserRelatedByUserId = null;
		}

	} 
	
	public function setProductId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->product_id !== $v) {
			$this->product_id = $v;
			$this->modifiedColumns[] = PurchasePeer::PRODUCT_ID;
		}

		if ($this->aProduct !== null && $this->aProduct->getId() !== $v) {
			$this->aProduct = null;
		}

	} 
	
	public function setQuantity($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->quantity !== $v) {
			$this->quantity = $v;
			$this->modifiedColumns[] = PurchasePeer::QUANTITY;
		}

	} 
	
	public function setPrice($v)
	{

		if ($this->price !== $v) {
			$this->price = $v;
			$this->modifiedColumns[] = PurchasePeer::PRICE;
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
			$this->modifiedColumns[] = PurchasePeer::CREATED_AT;
		}

	} 
	
	public function setVerifiedById($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->verified_by_id !== $v) {
			$this->verified_by_id = $v;
			$this->modifiedColumns[] = PurchasePeer::VERIFIED_BY_ID;
		}

		if ($this->aUserRelatedByVerifiedById !== null && $this->aUserRelatedByVerifiedById->getId() !== $v) {
			$this->aUserRelatedByVerifiedById = null;
		}

	} 
	
	public function setVerifiedAt($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse date/time value for [verified_at] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->verified_at !== $ts) {
			$this->verified_at = $ts;
			$this->modifiedColumns[] = PurchasePeer::VERIFIED_AT;
		}

	} 
	
	public function setNotes($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->notes !== $v) {
			$this->notes = $v;
			$this->modifiedColumns[] = PurchasePeer::NOTES;
		}

	} 
	
	public function setSurcharge($v)
	{

		if ($this->surcharge !== $v) {
			$this->surcharge = $v;
			$this->modifiedColumns[] = PurchasePeer::SURCHARGE;
		}

	} 
	
	public function setCancelledAt($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse date/time value for [cancelled_at] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->cancelled_at !== $ts) {
			$this->cancelled_at = $ts;
			$this->modifiedColumns[] = PurchasePeer::CANCELLED_AT;
		}

	} 
	
	public function setCancelledById($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->cancelled_by_id !== $v) {
			$this->cancelled_by_id = $v;
			$this->modifiedColumns[] = PurchasePeer::CANCELLED_BY_ID;
		}

		if ($this->aUserRelatedByCancelledById !== null && $this->aUserRelatedByCancelledById->getId() !== $v) {
			$this->aUserRelatedByCancelledById = null;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->user_id = $rs->getInt($startcol + 1);

			$this->product_id = $rs->getInt($startcol + 2);

			$this->quantity = $rs->getInt($startcol + 3);

			$this->price = $rs->getFloat($startcol + 4);

			$this->created_at = $rs->getTimestamp($startcol + 5, null);

			$this->verified_by_id = $rs->getInt($startcol + 6);

			$this->verified_at = $rs->getTimestamp($startcol + 7, null);

			$this->notes = $rs->getString($startcol + 8);

			$this->surcharge = $rs->getFloat($startcol + 9);

			$this->cancelled_at = $rs->getTimestamp($startcol + 10, null);

			$this->cancelled_by_id = $rs->getInt($startcol + 11);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 12; 
		} catch (Exception $e) {
			throw new PropelException("Error populating Purchase object", $e);
		}
	}

	
	public function delete($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(PurchasePeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			PurchasePeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	
	public function save($con = null)
	{
    if ($this->isNew() && !$this->isColumnModified(PurchasePeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(PurchasePeer::DATABASE_NAME);
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


												
			if ($this->aUserRelatedByUserId !== null) {
				if ($this->aUserRelatedByUserId->isModified()) {
					$affectedRows += $this->aUserRelatedByUserId->save($con);
				}
				$this->setUserRelatedByUserId($this->aUserRelatedByUserId);
			}

			if ($this->aProduct !== null) {
				if ($this->aProduct->isModified()) {
					$affectedRows += $this->aProduct->save($con);
				}
				$this->setProduct($this->aProduct);
			}

			if ($this->aUserRelatedByVerifiedById !== null) {
				if ($this->aUserRelatedByVerifiedById->isModified()) {
					$affectedRows += $this->aUserRelatedByVerifiedById->save($con);
				}
				$this->setUserRelatedByVerifiedById($this->aUserRelatedByVerifiedById);
			}

			if ($this->aUserRelatedByCancelledById !== null) {
				if ($this->aUserRelatedByCancelledById->isModified()) {
					$affectedRows += $this->aUserRelatedByCancelledById->save($con);
				}
				$this->setUserRelatedByCancelledById($this->aUserRelatedByCancelledById);
			}


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = PurchasePeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += PurchasePeer::doUpdate($this, $con);
				}
				$this->resetModified(); 			}

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


												
			if ($this->aUserRelatedByUserId !== null) {
				if (!$this->aUserRelatedByUserId->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aUserRelatedByUserId->getValidationFailures());
				}
			}

			if ($this->aProduct !== null) {
				if (!$this->aProduct->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aProduct->getValidationFailures());
				}
			}

			if ($this->aUserRelatedByVerifiedById !== null) {
				if (!$this->aUserRelatedByVerifiedById->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aUserRelatedByVerifiedById->getValidationFailures());
				}
			}

			if ($this->aUserRelatedByCancelledById !== null) {
				if (!$this->aUserRelatedByCancelledById->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aUserRelatedByCancelledById->getValidationFailures());
				}
			}


			if (($retval = PurchasePeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = PurchasePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getUserId();
				break;
			case 2:
				return $this->getProductId();
				break;
			case 3:
				return $this->getQuantity();
				break;
			case 4:
				return $this->getPrice();
				break;
			case 5:
				return $this->getCreatedAt();
				break;
			case 6:
				return $this->getVerifiedById();
				break;
			case 7:
				return $this->getVerifiedAt();
				break;
			case 8:
				return $this->getNotes();
				break;
			case 9:
				return $this->getSurcharge();
				break;
			case 10:
				return $this->getCancelledAt();
				break;
			case 11:
				return $this->getCancelledById();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = PurchasePeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getUserId(),
			$keys[2] => $this->getProductId(),
			$keys[3] => $this->getQuantity(),
			$keys[4] => $this->getPrice(),
			$keys[5] => $this->getCreatedAt(),
			$keys[6] => $this->getVerifiedById(),
			$keys[7] => $this->getVerifiedAt(),
			$keys[8] => $this->getNotes(),
			$keys[9] => $this->getSurcharge(),
			$keys[10] => $this->getCancelledAt(),
			$keys[11] => $this->getCancelledById(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = PurchasePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setUserId($value);
				break;
			case 2:
				$this->setProductId($value);
				break;
			case 3:
				$this->setQuantity($value);
				break;
			case 4:
				$this->setPrice($value);
				break;
			case 5:
				$this->setCreatedAt($value);
				break;
			case 6:
				$this->setVerifiedById($value);
				break;
			case 7:
				$this->setVerifiedAt($value);
				break;
			case 8:
				$this->setNotes($value);
				break;
			case 9:
				$this->setSurcharge($value);
				break;
			case 10:
				$this->setCancelledAt($value);
				break;
			case 11:
				$this->setCancelledById($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = PurchasePeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setUserId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setProductId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setQuantity($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setPrice($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setCreatedAt($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setVerifiedById($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setVerifiedAt($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setNotes($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setSurcharge($arr[$keys[9]]);
		if (array_key_exists($keys[10], $arr)) $this->setCancelledAt($arr[$keys[10]]);
		if (array_key_exists($keys[11], $arr)) $this->setCancelledById($arr[$keys[11]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(PurchasePeer::DATABASE_NAME);

		if ($this->isColumnModified(PurchasePeer::ID)) $criteria->add(PurchasePeer::ID, $this->id);
		if ($this->isColumnModified(PurchasePeer::USER_ID)) $criteria->add(PurchasePeer::USER_ID, $this->user_id);
		if ($this->isColumnModified(PurchasePeer::PRODUCT_ID)) $criteria->add(PurchasePeer::PRODUCT_ID, $this->product_id);
		if ($this->isColumnModified(PurchasePeer::QUANTITY)) $criteria->add(PurchasePeer::QUANTITY, $this->quantity);
		if ($this->isColumnModified(PurchasePeer::PRICE)) $criteria->add(PurchasePeer::PRICE, $this->price);
		if ($this->isColumnModified(PurchasePeer::CREATED_AT)) $criteria->add(PurchasePeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(PurchasePeer::VERIFIED_BY_ID)) $criteria->add(PurchasePeer::VERIFIED_BY_ID, $this->verified_by_id);
		if ($this->isColumnModified(PurchasePeer::VERIFIED_AT)) $criteria->add(PurchasePeer::VERIFIED_AT, $this->verified_at);
		if ($this->isColumnModified(PurchasePeer::NOTES)) $criteria->add(PurchasePeer::NOTES, $this->notes);
		if ($this->isColumnModified(PurchasePeer::SURCHARGE)) $criteria->add(PurchasePeer::SURCHARGE, $this->surcharge);
		if ($this->isColumnModified(PurchasePeer::CANCELLED_AT)) $criteria->add(PurchasePeer::CANCELLED_AT, $this->cancelled_at);
		if ($this->isColumnModified(PurchasePeer::CANCELLED_BY_ID)) $criteria->add(PurchasePeer::CANCELLED_BY_ID, $this->cancelled_by_id);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(PurchasePeer::DATABASE_NAME);

		$criteria->add(PurchasePeer::ID, $this->id);

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

		$copyObj->setUserId($this->user_id);

		$copyObj->setProductId($this->product_id);

		$copyObj->setQuantity($this->quantity);

		$copyObj->setPrice($this->price);

		$copyObj->setCreatedAt($this->created_at);

		$copyObj->setVerifiedById($this->verified_by_id);

		$copyObj->setVerifiedAt($this->verified_at);

		$copyObj->setNotes($this->notes);

		$copyObj->setSurcharge($this->surcharge);

		$copyObj->setCancelledAt($this->cancelled_at);

		$copyObj->setCancelledById($this->cancelled_by_id);


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
			self::$peer = new PurchasePeer();
		}
		return self::$peer;
	}

	
	public function setUserRelatedByUserId($v)
	{


		if ($v === null) {
			$this->setUserId(NULL);
		} else {
			$this->setUserId($v->getId());
		}


		$this->aUserRelatedByUserId = $v;
	}


	
	public function getUserRelatedByUserId($con = null)
	{
		if ($this->aUserRelatedByUserId === null && ($this->user_id !== null)) {
						include_once 'lib/model/om/BaseUserPeer.php';

			$this->aUserRelatedByUserId = UserPeer::retrieveByPK($this->user_id, $con);

			
		}
		return $this->aUserRelatedByUserId;
	}

	
	public function setProduct($v)
	{


		if ($v === null) {
			$this->setProductId(NULL);
		} else {
			$this->setProductId($v->getId());
		}


		$this->aProduct = $v;
	}


	
	public function getProduct($con = null)
	{
		if ($this->aProduct === null && ($this->product_id !== null)) {
						include_once 'lib/model/om/BaseProductPeer.php';

			$this->aProduct = ProductPeer::retrieveByPK($this->product_id, $con);

			
		}
		return $this->aProduct;
	}

	
	public function setUserRelatedByVerifiedById($v)
	{


		if ($v === null) {
			$this->setVerifiedById(NULL);
		} else {
			$this->setVerifiedById($v->getId());
		}


		$this->aUserRelatedByVerifiedById = $v;
	}


	
	public function getUserRelatedByVerifiedById($con = null)
	{
		if ($this->aUserRelatedByVerifiedById === null && ($this->verified_by_id !== null)) {
						include_once 'lib/model/om/BaseUserPeer.php';

			$this->aUserRelatedByVerifiedById = UserPeer::retrieveByPK($this->verified_by_id, $con);

			
		}
		return $this->aUserRelatedByVerifiedById;
	}

	
	public function setUserRelatedByCancelledById($v)
	{


		if ($v === null) {
			$this->setCancelledById(NULL);
		} else {
			$this->setCancelledById($v->getId());
		}


		$this->aUserRelatedByCancelledById = $v;
	}


	
	public function getUserRelatedByCancelledById($con = null)
	{
		if ($this->aUserRelatedByCancelledById === null && ($this->cancelled_by_id !== null)) {
						include_once 'lib/model/om/BaseUserPeer.php';

			$this->aUserRelatedByCancelledById = UserPeer::retrieveByPK($this->cancelled_by_id, $con);

			
		}
		return $this->aUserRelatedByCancelledById;
	}

} 