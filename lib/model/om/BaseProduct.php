<?php


abstract class BaseProduct extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $title;


	
	protected $price;


	
	protected $inventory;


	
	protected $image_url;


	
	protected $sort_order;


	
	protected $created_at;


	
	protected $updated_at;

	
	protected $collPurchases;

	
	protected $lastPurchaseCriteria = null;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getTitle()
	{

		return $this->title;
	}

	
	public function getPrice()
	{

		return $this->price;
	}

	
	public function getInventory()
	{

		return $this->inventory;
	}

	
	public function getImageUrl()
	{

		return $this->image_url;
	}

	
	public function getSortOrder()
	{

		return $this->sort_order;
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

	
	public function setId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = ProductPeer::ID;
		}

	} 
	
	public function setTitle($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->title !== $v) {
			$this->title = $v;
			$this->modifiedColumns[] = ProductPeer::TITLE;
		}

	} 
	
	public function setPrice($v)
	{

		if ($this->price !== $v) {
			$this->price = $v;
			$this->modifiedColumns[] = ProductPeer::PRICE;
		}

	} 
	
	public function setInventory($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->inventory !== $v) {
			$this->inventory = $v;
			$this->modifiedColumns[] = ProductPeer::INVENTORY;
		}

	} 
	
	public function setImageUrl($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->image_url !== $v) {
			$this->image_url = $v;
			$this->modifiedColumns[] = ProductPeer::IMAGE_URL;
		}

	} 
	
	public function setSortOrder($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->sort_order !== $v) {
			$this->sort_order = $v;
			$this->modifiedColumns[] = ProductPeer::SORT_ORDER;
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
			$this->modifiedColumns[] = ProductPeer::CREATED_AT;
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
			$this->modifiedColumns[] = ProductPeer::UPDATED_AT;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->title = $rs->getString($startcol + 1);

			$this->price = $rs->getFloat($startcol + 2);

			$this->inventory = $rs->getInt($startcol + 3);

			$this->image_url = $rs->getString($startcol + 4);

			$this->sort_order = $rs->getInt($startcol + 5);

			$this->created_at = $rs->getTimestamp($startcol + 6, null);

			$this->updated_at = $rs->getTimestamp($startcol + 7, null);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 8; 
		} catch (Exception $e) {
			throw new PropelException("Error populating Product object", $e);
		}
	}

	
	public function delete($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(ProductPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			ProductPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	
	public function save($con = null)
	{
    if ($this->isNew() && !$this->isColumnModified(ProductPeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

    if ($this->isModified() && !$this->isColumnModified(ProductPeer::UPDATED_AT))
    {
      $this->setUpdatedAt(time());
    }

		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(ProductPeer::DATABASE_NAME);
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
					$pk = ProductPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += ProductPeer::doUpdate($this, $con);
				}
				$this->resetModified(); 			}

			if ($this->collPurchases !== null) {
				foreach($this->collPurchases as $referrerFK) {
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


			if (($retval = ProductPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collPurchases !== null) {
					foreach($this->collPurchases as $referrerFK) {
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
		$pos = ProductPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getTitle();
				break;
			case 2:
				return $this->getPrice();
				break;
			case 3:
				return $this->getInventory();
				break;
			case 4:
				return $this->getImageUrl();
				break;
			case 5:
				return $this->getSortOrder();
				break;
			case 6:
				return $this->getCreatedAt();
				break;
			case 7:
				return $this->getUpdatedAt();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = ProductPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getTitle(),
			$keys[2] => $this->getPrice(),
			$keys[3] => $this->getInventory(),
			$keys[4] => $this->getImageUrl(),
			$keys[5] => $this->getSortOrder(),
			$keys[6] => $this->getCreatedAt(),
			$keys[7] => $this->getUpdatedAt(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = ProductPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setTitle($value);
				break;
			case 2:
				$this->setPrice($value);
				break;
			case 3:
				$this->setInventory($value);
				break;
			case 4:
				$this->setImageUrl($value);
				break;
			case 5:
				$this->setSortOrder($value);
				break;
			case 6:
				$this->setCreatedAt($value);
				break;
			case 7:
				$this->setUpdatedAt($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = ProductPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setTitle($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setPrice($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setInventory($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setImageUrl($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setSortOrder($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setCreatedAt($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setUpdatedAt($arr[$keys[7]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(ProductPeer::DATABASE_NAME);

		if ($this->isColumnModified(ProductPeer::ID)) $criteria->add(ProductPeer::ID, $this->id);
		if ($this->isColumnModified(ProductPeer::TITLE)) $criteria->add(ProductPeer::TITLE, $this->title);
		if ($this->isColumnModified(ProductPeer::PRICE)) $criteria->add(ProductPeer::PRICE, $this->price);
		if ($this->isColumnModified(ProductPeer::INVENTORY)) $criteria->add(ProductPeer::INVENTORY, $this->inventory);
		if ($this->isColumnModified(ProductPeer::IMAGE_URL)) $criteria->add(ProductPeer::IMAGE_URL, $this->image_url);
		if ($this->isColumnModified(ProductPeer::SORT_ORDER)) $criteria->add(ProductPeer::SORT_ORDER, $this->sort_order);
		if ($this->isColumnModified(ProductPeer::CREATED_AT)) $criteria->add(ProductPeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(ProductPeer::UPDATED_AT)) $criteria->add(ProductPeer::UPDATED_AT, $this->updated_at);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(ProductPeer::DATABASE_NAME);

		$criteria->add(ProductPeer::ID, $this->id);

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

		$copyObj->setTitle($this->title);

		$copyObj->setPrice($this->price);

		$copyObj->setInventory($this->inventory);

		$copyObj->setImageUrl($this->image_url);

		$copyObj->setSortOrder($this->sort_order);

		$copyObj->setCreatedAt($this->created_at);

		$copyObj->setUpdatedAt($this->updated_at);


		if ($deepCopy) {
									$copyObj->setNew(false);

			foreach($this->getPurchases() as $relObj) {
				$copyObj->addPurchase($relObj->copy($deepCopy));
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
			self::$peer = new ProductPeer();
		}
		return self::$peer;
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

				$criteria->add(PurchasePeer::PRODUCT_ID, $this->getId());

				PurchasePeer::addSelectColumns($criteria);
				$this->collPurchases = PurchasePeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(PurchasePeer::PRODUCT_ID, $this->getId());

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

		$criteria->add(PurchasePeer::PRODUCT_ID, $this->getId());

		return PurchasePeer::doCount($criteria, $distinct, $con);
	}

	
	public function addPurchase(Purchase $l)
	{
		$this->collPurchases[] = $l;
		$l->setProduct($this);
	}


	
	public function getPurchasesJoinUserRelatedByUserId($criteria = null, $con = null)
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

				$criteria->add(PurchasePeer::PRODUCT_ID, $this->getId());

				$this->collPurchases = PurchasePeer::doSelectJoinUserRelatedByUserId($criteria, $con);
			}
		} else {
									
			$criteria->add(PurchasePeer::PRODUCT_ID, $this->getId());

			if (!isset($this->lastPurchaseCriteria) || !$this->lastPurchaseCriteria->equals($criteria)) {
				$this->collPurchases = PurchasePeer::doSelectJoinUserRelatedByUserId($criteria, $con);
			}
		}
		$this->lastPurchaseCriteria = $criteria;

		return $this->collPurchases;
	}


	
	public function getPurchasesJoinUserRelatedByVerifiedById($criteria = null, $con = null)
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

				$criteria->add(PurchasePeer::PRODUCT_ID, $this->getId());

				$this->collPurchases = PurchasePeer::doSelectJoinUserRelatedByVerifiedById($criteria, $con);
			}
		} else {
									
			$criteria->add(PurchasePeer::PRODUCT_ID, $this->getId());

			if (!isset($this->lastPurchaseCriteria) || !$this->lastPurchaseCriteria->equals($criteria)) {
				$this->collPurchases = PurchasePeer::doSelectJoinUserRelatedByVerifiedById($criteria, $con);
			}
		}
		$this->lastPurchaseCriteria = $criteria;

		return $this->collPurchases;
	}


	
	public function getPurchasesJoinUserRelatedByCancelledById($criteria = null, $con = null)
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

				$criteria->add(PurchasePeer::PRODUCT_ID, $this->getId());

				$this->collPurchases = PurchasePeer::doSelectJoinUserRelatedByCancelledById($criteria, $con);
			}
		} else {
									
			$criteria->add(PurchasePeer::PRODUCT_ID, $this->getId());

			if (!isset($this->lastPurchaseCriteria) || !$this->lastPurchaseCriteria->equals($criteria)) {
				$this->collPurchases = PurchasePeer::doSelectJoinUserRelatedByCancelledById($criteria, $con);
			}
		}
		$this->lastPurchaseCriteria = $criteria;

		return $this->collPurchases;
	}


	
	public function getPurchasesJoinUserRelatedByCreditedBy($criteria = null, $con = null)
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

				$criteria->add(PurchasePeer::PRODUCT_ID, $this->getId());

				$this->collPurchases = PurchasePeer::doSelectJoinUserRelatedByCreditedBy($criteria, $con);
			}
		} else {
									
			$criteria->add(PurchasePeer::PRODUCT_ID, $this->getId());

			if (!isset($this->lastPurchaseCriteria) || !$this->lastPurchaseCriteria->equals($criteria)) {
				$this->collPurchases = PurchasePeer::doSelectJoinUserRelatedByCreditedBy($criteria, $con);
			}
		}
		$this->lastPurchaseCriteria = $criteria;

		return $this->collPurchases;
	}

} 