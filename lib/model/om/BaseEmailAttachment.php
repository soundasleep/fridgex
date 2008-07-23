<?php


abstract class BaseEmailAttachment extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $email_id;


	
	protected $filename;


	
	protected $media_type;


	
	protected $content;


	
	protected $created_at;

	
	protected $aEmail;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getEmailId()
	{

		return $this->email_id;
	}

	
	public function getFilename()
	{

		return $this->filename;
	}

	
	public function getMediaType()
	{

		return $this->media_type;
	}

	
	public function getContent()
	{

		return $this->content;
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

	
	public function setId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = EmailAttachmentPeer::ID;
		}

	} 
	
	public function setEmailId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->email_id !== $v) {
			$this->email_id = $v;
			$this->modifiedColumns[] = EmailAttachmentPeer::EMAIL_ID;
		}

		if ($this->aEmail !== null && $this->aEmail->getId() !== $v) {
			$this->aEmail = null;
		}

	} 
	
	public function setFilename($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->filename !== $v) {
			$this->filename = $v;
			$this->modifiedColumns[] = EmailAttachmentPeer::FILENAME;
		}

	} 
	
	public function setMediaType($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->media_type !== $v) {
			$this->media_type = $v;
			$this->modifiedColumns[] = EmailAttachmentPeer::MEDIA_TYPE;
		}

	} 
	
	public function setContent($v)
	{

								if ($v instanceof Lob && $v === $this->content) {
			$changed = $v->isModified();
		} else {
			$changed = ($this->content !== $v);
		}
		if ($changed) {
			if ( !($v instanceof Lob) ) {
				$obj = new Blob();
				$obj->setContents($v);
			} else {
				$obj = $v;
			}
			$this->content = $obj;
			$this->modifiedColumns[] = EmailAttachmentPeer::CONTENT;
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
			$this->modifiedColumns[] = EmailAttachmentPeer::CREATED_AT;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->email_id = $rs->getInt($startcol + 1);

			$this->filename = $rs->getString($startcol + 2);

			$this->media_type = $rs->getString($startcol + 3);

			$this->content = $rs->getBlob($startcol + 4);

			$this->created_at = $rs->getTimestamp($startcol + 5, null);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 6; 
		} catch (Exception $e) {
			throw new PropelException("Error populating EmailAttachment object", $e);
		}
	}

	
	public function delete($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(EmailAttachmentPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			EmailAttachmentPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	
	public function save($con = null)
	{
    if ($this->isNew() && !$this->isColumnModified(EmailAttachmentPeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(EmailAttachmentPeer::DATABASE_NAME);
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


												
			if ($this->aEmail !== null) {
				if ($this->aEmail->isModified()) {
					$affectedRows += $this->aEmail->save($con);
				}
				$this->setEmail($this->aEmail);
			}


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = EmailAttachmentPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += EmailAttachmentPeer::doUpdate($this, $con);
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


												
			if ($this->aEmail !== null) {
				if (!$this->aEmail->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aEmail->getValidationFailures());
				}
			}


			if (($retval = EmailAttachmentPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = EmailAttachmentPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getEmailId();
				break;
			case 2:
				return $this->getFilename();
				break;
			case 3:
				return $this->getMediaType();
				break;
			case 4:
				return $this->getContent();
				break;
			case 5:
				return $this->getCreatedAt();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = EmailAttachmentPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getEmailId(),
			$keys[2] => $this->getFilename(),
			$keys[3] => $this->getMediaType(),
			$keys[4] => $this->getContent(),
			$keys[5] => $this->getCreatedAt(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = EmailAttachmentPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setEmailId($value);
				break;
			case 2:
				$this->setFilename($value);
				break;
			case 3:
				$this->setMediaType($value);
				break;
			case 4:
				$this->setContent($value);
				break;
			case 5:
				$this->setCreatedAt($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = EmailAttachmentPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setEmailId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setFilename($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setMediaType($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setContent($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setCreatedAt($arr[$keys[5]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(EmailAttachmentPeer::DATABASE_NAME);

		if ($this->isColumnModified(EmailAttachmentPeer::ID)) $criteria->add(EmailAttachmentPeer::ID, $this->id);
		if ($this->isColumnModified(EmailAttachmentPeer::EMAIL_ID)) $criteria->add(EmailAttachmentPeer::EMAIL_ID, $this->email_id);
		if ($this->isColumnModified(EmailAttachmentPeer::FILENAME)) $criteria->add(EmailAttachmentPeer::FILENAME, $this->filename);
		if ($this->isColumnModified(EmailAttachmentPeer::MEDIA_TYPE)) $criteria->add(EmailAttachmentPeer::MEDIA_TYPE, $this->media_type);
		if ($this->isColumnModified(EmailAttachmentPeer::CONTENT)) $criteria->add(EmailAttachmentPeer::CONTENT, $this->content);
		if ($this->isColumnModified(EmailAttachmentPeer::CREATED_AT)) $criteria->add(EmailAttachmentPeer::CREATED_AT, $this->created_at);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(EmailAttachmentPeer::DATABASE_NAME);

		$criteria->add(EmailAttachmentPeer::ID, $this->id);

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

		$copyObj->setEmailId($this->email_id);

		$copyObj->setFilename($this->filename);

		$copyObj->setMediaType($this->media_type);

		$copyObj->setContent($this->content);

		$copyObj->setCreatedAt($this->created_at);


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
			self::$peer = new EmailAttachmentPeer();
		}
		return self::$peer;
	}

	
	public function setEmail($v)
	{


		if ($v === null) {
			$this->setEmailId(NULL);
		} else {
			$this->setEmailId($v->getId());
		}


		$this->aEmail = $v;
	}


	
	public function getEmail($con = null)
	{
		if ($this->aEmail === null && ($this->email_id !== null)) {
						include_once 'lib/model/om/BaseEmailPeer.php';

			$this->aEmail = EmailPeer::retrieveByPK($this->email_id, $con);

			
		}
		return $this->aEmail;
	}

} 