<?php



class EmailMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.EmailMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('email');
		$tMap->setPhpName('Email');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addForeignKey('USER_ID', 'UserId', 'int', CreoleTypes::INTEGER, 'user', 'ID', false, null);

		$tMap->addColumn('TO_ADDRESS', 'ToAddress', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('TO_NAME', 'ToName', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('FROM_ADDRESS', 'FromAddress', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('FROM_NAME', 'FromName', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('SUBJECT', 'Subject', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('BODY', 'Body', 'string', CreoleTypes::CLOB, false, null);

		$tMap->addColumn('CREATED_AT', 'CreatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

		$tMap->addColumn('UPDATED_AT', 'UpdatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

		$tMap->addColumn('SENT_AT', 'SentAt', 'int', CreoleTypes::TIMESTAMP, false, null);

	} 
} 