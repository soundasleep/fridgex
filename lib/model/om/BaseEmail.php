<?php


abstract class BaseEmail extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $user_id;


	
	protected $to_address;


	
	protected $to_name;


	
	protected $from_address;


	
	protected $from_name;


	
	protected $subject;


	
	protected $body;


	
	protected $created_at;


	
	protected $updated_at;


	
	protected $sent_at;

	
	protected $aUser;

	
	protected $collEmailAttachments;

	
	protected $lastEmailAttachmentCriteria = null;

	
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

	
	public function getToAddress()
	{

		return $this->to_address;
	}

	
	public function getToName()
	{

		return $this->to_name;
	}

	
	public function getFromAddress()
	{

		return $this->from_address;
	}

	
	public function getFromName()
	{

		return $this->from_name;
	}

	
	public function getSubject()
	{

		return $this->subject;
	}

	
	public function getBody()
	{

		return $this->body;
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

	
	public function getSentAt($format = 'Y-m-d H:i:s')
	{

		if ($this->sent_at === null || $this->sent_at === '') {
			return null;
		} elseif (!is_int($this->sent_at)) {
						$ts = strtotime($this->sent_at);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse value of [sent_at] as date/time value: " . var_export($this->sent_at, true));
			}
		} else {
			$ts = $this->sent_at;
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
			$this->modifiedColumns[] = EmailPeer::ID;
		}

	} 
	
	public function setUserId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->user_id !== $v) {
			$this->user_id = $v;
			$this->modifiedColumns[] = EmailPeer::USER_ID;
		}

		if ($this->aUser !== null && $this->aUser->getId() !== $v) {
			$this->aUser = null;
		}

	} 
	
	public function setToAddress($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->to_address !== $v) {
			$this->to_address = $v;
			$this->modifiedColumns[] = EmailPeer::TO_ADDRESS;
		}

	} 
	
	public function setToName($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->to_name !== $v) {
			$this->to_name = $v;
			$this->modifiedColumns[] = EmailPeer::TO_NAME;
		}

	} 
	
	public function setFromAddress($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->from_address !== $v) {
			$this->from_address = $v;
			$this->modifiedColumns[] = EmailPeer::FROM_ADDRESS;
		}

	} 
	
	public function setFromName($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->from_name !== $v) {
			$this->from_name = $v;
			$this->modifiedColumns[] = EmailPeer::FROM_NAME;
		}

	} 
	
	public function setSubject($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->subject !== $v) {
			$this->subject = $v;
			$this->modifiedColumns[] = EmailPeer::SUBJECT;
		}

	} 
	
	public function setBody($v)
	{

								if ($v instanceof Lob && $v === $this->body) {
			$changed = $v->isModified();
		} else {
			$changed = ($this->body !== $v);
		}
		if ($changed) {
			if ( !($v instanceof Lob) ) {
				$obj = new Clob();
				$obj->setContents($v);
			} else {
				$obj = $v;
			}
			$this->body = $obj;
			$this->modifiedColumns[] = EmailPeer::BODY;
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
			$this->modifiedColumns[] = EmailPeer::CREATED_AT;
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
			$this->modifiedColumns[] = EmailPeer::UPDATED_AT;
		}

	} 
	
	public function setSentAt($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse date/time value for [sent_at] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->sent_at !== $ts) {
			$this->sent_at = $ts;
			$this->modifiedColumns[] = EmailPeer::SENT_AT;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->user_id = $rs->getInt($startcol + 1);

			$this->to_address = $rs->getString($startcol + 2);

			$this->to_name = $rs->getString($startcol + 3);

			$this->from_address = $rs->getString($startcol + 4);

			$this->from_name = $rs->getString($startcol + 5);

			$this->subject = $rs->getString($startcol + 6);

			$this->body = $rs->getClob($startcol + 7);

			$this->created_at = $rs->getTimestamp($startcol + 8, null);

			$this->updated_at = $rs->getTimestamp($startcol + 9, null);

			$this->sent_at = $rs->getTimestamp($startcol + 10, null);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 11; 
		} catch (Exception $e) {
			throw new PropelException("Error populating Email object", $e);
		}
	}

	
	public function delete($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(EmailPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			EmailPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	
	public function save($con = null)
	{
    if ($this->isNew() && !$this->isColumnModified(EmailPeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

    if ($this->isModified() && !$this->isColumnModified(EmailPeer::UPDATED_AT))
    {
      $this->setUpdatedAt(time());
    }

		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(EmailPeer::DATABASE_NAME);
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


												
			if ($this->aUser !== null) {
				if ($this->aUser->isModified()) {
					$affectedRows += $this->aUser->save($con);
				}
				$this->setUser($this->aUser);
			}


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = EmailPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += EmailPeer::doUpdate($this, $con);
				}
				$this->resetModified(); 			}

			if ($this->collEmailAttachments !== null) {
				foreach($this->collEmailAttachments as $referrerFK) {
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


												
			if ($this->aUser !== null) {
				if (!$this->aUser->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aUser->getValidationFailures());
				}
			}


			if (($retval = EmailPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collEmailAttachments !== null) {
					foreach($this->collEmailAttachments as $referrerFK) {
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
		$pos = EmailPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getToAddress();
				break;
			case 3:
				return $this->getToName();
				break;
			case 4:
				return $this->getFromAddress();
				break;
			case 5:
				return $this->getFromName();
				break;
			case 6:
				return $this->getSubject();
				break;
			case 7:
				return $this->getBody();
				break;
			case 8:
				return $this->getCreatedAt();
				break;
			case 9:
				return $this->getUpdatedAt();
				break;
			case 10:
				return $this->getSentAt();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = EmailPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getUserId(),
			$keys[2] => $this->getToAddress(),
			$keys[3] => $this->getToName(),
			$keys[4] => $this->getFromAddress(),
			$keys[5] => $this->getFromName(),
			$keys[6] => $this->getSubject(),
			$keys[7] => $this->getBody(),
			$keys[8] => $this->getCreatedAt(),
			$keys[9] => $this->getUpdatedAt(),
			$keys[10] => $this->getSentAt(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = EmailPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setToAddress($value);
				break;
			case 3:
				$this->setToName($value);
				break;
			case 4:
				$this->setFromAddress($value);
				break;
			case 5:
				$this->setFromName($value);
				break;
			case 6:
				$this->setSubject($value);
				break;
			case 7:
				$this->setBody($value);
				break;
			case 8:
				$this->setCreatedAt($value);
				break;
			case 9:
				$this->setUpdatedAt($value);
				break;
			case 10:
				$this->setSentAt($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = EmailPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setUserId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setToAddress($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setToName($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setFromAddress($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setFromName($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setSubject($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setBody($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setCreatedAt($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setUpdatedAt($arr[$keys[9]]);
		if (array_key_exists($keys[10], $arr)) $this->setSentAt($arr[$keys[10]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(EmailPeer::DATABASE_NAME);

		if ($this->isColumnModified(EmailPeer::ID)) $criteria->add(EmailPeer::ID, $this->id);
		if ($this->isColumnModified(EmailPeer::USER_ID)) $criteria->add(EmailPeer::USER_ID, $this->user_id);
		if ($this->isColumnModified(EmailPeer::TO_ADDRESS)) $criteria->add(EmailPeer::TO_ADDRESS, $this->to_address);
		if ($this->isColumnModified(EmailPeer::TO_NAME)) $criteria->add(EmailPeer::TO_NAME, $this->to_name);
		if ($this->isColumnModified(EmailPeer::FROM_ADDRESS)) $criteria->add(EmailPeer::FROM_ADDRESS, $this->from_address);
		if ($this->isColumnModified(EmailPeer::FROM_NAME)) $criteria->add(EmailPeer::FROM_NAME, $this->from_name);
		if ($this->isColumnModified(EmailPeer::SUBJECT)) $criteria->add(EmailPeer::SUBJECT, $this->subject);
		if ($this->isColumnModified(EmailPeer::BODY)) $criteria->add(EmailPeer::BODY, $this->body);
		if ($this->isColumnModified(EmailPeer::CREATED_AT)) $criteria->add(EmailPeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(EmailPeer::UPDATED_AT)) $criteria->add(EmailPeer::UPDATED_AT, $this->updated_at);
		if ($this->isColumnModified(EmailPeer::SENT_AT)) $criteria->add(EmailPeer::SENT_AT, $this->sent_at);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(EmailPeer::DATABASE_NAME);

		$criteria->add(EmailPeer::ID, $this->id);

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

		$copyObj->setToAddress($this->to_address);

		$copyObj->setToName($this->to_name);

		$copyObj->setFromAddress($this->from_address);

		$copyObj->setFromName($this->from_name);

		$copyObj->setSubject($this->subject);

		$copyObj->setBody($this->body);

		$copyObj->setCreatedAt($this->created_at);

		$copyObj->setUpdatedAt($this->updated_at);

		$copyObj->setSentAt($this->sent_at);


		if ($deepCopy) {
									$copyObj->setNew(false);

			foreach($this->getEmailAttachments() as $relObj) {
				$copyObj->addEmailAttachment($relObj->copy($deepCopy));
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
			self::$peer = new EmailPeer();
		}
		return self::$peer;
	}

	
	public function setUser($v)
	{


		if ($v === null) {
			$this->setUserId(NULL);
		} else {
			$this->setUserId($v->getId());
		}


		$this->aUser = $v;
	}


	
	public function getUser($con = null)
	{
		if ($this->aUser === null && ($this->user_id !== null)) {
						include_once 'lib/model/om/BaseUserPeer.php';

			$this->aUser = UserPeer::retrieveByPK($this->user_id, $con);

			
		}
		return $this->aUser;
	}

	
	public function initEmailAttachments()
	{
		if ($this->collEmailAttachments === null) {
			$this->collEmailAttachments = array();
		}
	}

	
	public function getEmailAttachments($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseEmailAttachmentPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collEmailAttachments === null) {
			if ($this->isNew()) {
			   $this->collEmailAttachments = array();
			} else {

				$criteria->add(EmailAttachmentPeer::EMAIL_ID, $this->getId());

				EmailAttachmentPeer::addSelectColumns($criteria);
				$this->collEmailAttachments = EmailAttachmentPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(EmailAttachmentPeer::EMAIL_ID, $this->getId());

				EmailAttachmentPeer::addSelectColumns($criteria);
				if (!isset($this->lastEmailAttachmentCriteria) || !$this->lastEmailAttachmentCriteria->equals($criteria)) {
					$this->collEmailAttachments = EmailAttachmentPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastEmailAttachmentCriteria = $criteria;
		return $this->collEmailAttachments;
	}

	
	public function countEmailAttachments($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseEmailAttachmentPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(EmailAttachmentPeer::EMAIL_ID, $this->getId());

		return EmailAttachmentPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addEmailAttachment(EmailAttachment $l)
	{
		$this->collEmailAttachments[] = $l;
		$l->setEmail($this);
	}

} 