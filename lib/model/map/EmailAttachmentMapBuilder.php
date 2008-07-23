<?php



class EmailAttachmentMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.EmailAttachmentMapBuilder';

	
	private $dbMap;

	
	public function isBuilt()
	{
		return ($this->dbMap !== null);
	}

	
	public function getDatabaseMap()
	{
		return $this->dbMap;
	}

	
	public function doBuild()
	{
		$this->dbMap = Propel::getDatabaseMap('propel');

		$tMap = $this->dbMap->addTable('email_attachment');
		$tMap->setPhpName('EmailAttachment');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addForeignKey('EMAIL_ID', 'EmailId', 'int', CreoleTypes::INTEGER, 'email', 'ID', false, null);

		$tMap->addColumn('FILENAME', 'Filename', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('MEDIA_TYPE', 'MediaType', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('CONTENT', 'Content', 'string', CreoleTypes::BLOB, false, null);

		$tMap->addColumn('CREATED_AT', 'CreatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

	} 
} 