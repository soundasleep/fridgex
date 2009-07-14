<?php



class ProductMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.ProductMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('product');
		$tMap->setPhpName('Product');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('TITLE', 'Title', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('PRICE', 'Price', 'double', CreoleTypes::DECIMAL, false, 9);

		$tMap->addColumn('INVENTORY', 'Inventory', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('IMAGE_URL', 'ImageUrl', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('SORT_ORDER', 'SortOrder', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('CREATED_AT', 'CreatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

		$tMap->addColumn('UPDATED_AT', 'UpdatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

		$tMap->addColumn('EXTRA_SURCHARGE', 'ExtraSurcharge', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('IS_HIDDEN', 'IsHidden', 'boolean', CreoleTypes::BOOLEAN, true, null);

	} 
} 