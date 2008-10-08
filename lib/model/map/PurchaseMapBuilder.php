<?php



class PurchaseMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.PurchaseMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('purchase');
		$tMap->setPhpName('Purchase');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addForeignKey('USER_ID', 'UserId', 'int', CreoleTypes::INTEGER, 'user', 'ID', false, null);

		$tMap->addForeignKey('PRODUCT_ID', 'ProductId', 'int', CreoleTypes::INTEGER, 'product', 'ID', false, null);

		$tMap->addColumn('QUANTITY', 'Quantity', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('PRICE', 'Price', 'double', CreoleTypes::DECIMAL, false, 9);

		$tMap->addColumn('CREATED_AT', 'CreatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

		$tMap->addForeignKey('VERIFIED_BY_ID', 'VerifiedById', 'int', CreoleTypes::INTEGER, 'user', 'ID', false, null);

		$tMap->addColumn('VERIFIED_AT', 'VerifiedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

		$tMap->addColumn('NOTES', 'Notes', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('SURCHARGE', 'Surcharge', 'double', CreoleTypes::DECIMAL, false, 9);

		$tMap->addColumn('CANCELLED_AT', 'CancelledAt', 'int', CreoleTypes::TIMESTAMP, false, null);

		$tMap->addForeignKey('CANCELLED_BY_ID', 'CancelledById', 'int', CreoleTypes::INTEGER, 'user', 'ID', false, null);

		$tMap->addColumn('IS_DIRECT_CREDIT', 'IsDirectCredit', 'boolean', CreoleTypes::BOOLEAN, false, null);

		$tMap->addForeignKey('CREDITED_BY', 'CreditedBy', 'int', CreoleTypes::INTEGER, 'user', 'ID', false, null);

	} 
} 