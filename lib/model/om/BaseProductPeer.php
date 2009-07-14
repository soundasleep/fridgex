<?php


abstract class BaseProductPeer {

	
	const DATABASE_NAME = 'propel';

	
	const TABLE_NAME = 'product';

	
	const CLASS_DEFAULT = 'lib.model.Product';

	
	const NUM_COLUMNS = 10;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;


	
	const ID = 'product.ID';

	
	const TITLE = 'product.TITLE';

	
	const PRICE = 'product.PRICE';

	
	const INVENTORY = 'product.INVENTORY';

	
	const IMAGE_URL = 'product.IMAGE_URL';

	
	const SORT_ORDER = 'product.SORT_ORDER';

	
	const CREATED_AT = 'product.CREATED_AT';

	
	const UPDATED_AT = 'product.UPDATED_AT';

	
	const EXTRA_SURCHARGE = 'product.EXTRA_SURCHARGE';

	
	const IS_HIDDEN = 'product.IS_HIDDEN';

	
	private static $phpNameMap = null;


	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('Id', 'Title', 'Price', 'Inventory', 'ImageUrl', 'SortOrder', 'CreatedAt', 'UpdatedAt', 'ExtraSurcharge', 'IsHidden', ),
		BasePeer::TYPE_COLNAME => array (ProductPeer::ID, ProductPeer::TITLE, ProductPeer::PRICE, ProductPeer::INVENTORY, ProductPeer::IMAGE_URL, ProductPeer::SORT_ORDER, ProductPeer::CREATED_AT, ProductPeer::UPDATED_AT, ProductPeer::EXTRA_SURCHARGE, ProductPeer::IS_HIDDEN, ),
		BasePeer::TYPE_FIELDNAME => array ('id', 'title', 'price', 'inventory', 'image_url', 'sort_order', 'created_at', 'updated_at', 'extra_surcharge', 'is_hidden', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'Title' => 1, 'Price' => 2, 'Inventory' => 3, 'ImageUrl' => 4, 'SortOrder' => 5, 'CreatedAt' => 6, 'UpdatedAt' => 7, 'ExtraSurcharge' => 8, 'IsHidden' => 9, ),
		BasePeer::TYPE_COLNAME => array (ProductPeer::ID => 0, ProductPeer::TITLE => 1, ProductPeer::PRICE => 2, ProductPeer::INVENTORY => 3, ProductPeer::IMAGE_URL => 4, ProductPeer::SORT_ORDER => 5, ProductPeer::CREATED_AT => 6, ProductPeer::UPDATED_AT => 7, ProductPeer::EXTRA_SURCHARGE => 8, ProductPeer::IS_HIDDEN => 9, ),
		BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'title' => 1, 'price' => 2, 'inventory' => 3, 'image_url' => 4, 'sort_order' => 5, 'created_at' => 6, 'updated_at' => 7, 'extra_surcharge' => 8, 'is_hidden' => 9, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, )
	);

	
	public static function getMapBuilder()
	{
		include_once 'lib/model/map/ProductMapBuilder.php';
		return BasePeer::getMapBuilder('lib.model.map.ProductMapBuilder');
	}
	
	public static function getPhpNameMap()
	{
		if (self::$phpNameMap === null) {
			$map = ProductPeer::getTableMap();
			$columns = $map->getColumns();
			$nameMap = array();
			foreach ($columns as $column) {
				$nameMap[$column->getPhpName()] = $column->getColumnName();
			}
			self::$phpNameMap = $nameMap;
		}
		return self::$phpNameMap;
	}
	
	static public function translateFieldName($name, $fromType, $toType)
	{
		$toNames = self::getFieldNames($toType);
		$key = isset(self::$fieldKeys[$fromType][$name]) ? self::$fieldKeys[$fromType][$name] : null;
		if ($key === null) {
			throw new PropelException("'$name' could not be found in the field names of type '$fromType'. These are: " . print_r(self::$fieldKeys[$fromType], true));
		}
		return $toNames[$key];
	}

	

	static public function getFieldNames($type = BasePeer::TYPE_PHPNAME)
	{
		if (!array_key_exists($type, self::$fieldNames)) {
			throw new PropelException('Method getFieldNames() expects the parameter $type to be one of the class constants TYPE_PHPNAME, TYPE_COLNAME, TYPE_FIELDNAME, TYPE_NUM. ' . $type . ' was given.');
		}
		return self::$fieldNames[$type];
	}

	
	public static function alias($alias, $column)
	{
		return str_replace(ProductPeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(ProductPeer::ID);

		$criteria->addSelectColumn(ProductPeer::TITLE);

		$criteria->addSelectColumn(ProductPeer::PRICE);

		$criteria->addSelectColumn(ProductPeer::INVENTORY);

		$criteria->addSelectColumn(ProductPeer::IMAGE_URL);

		$criteria->addSelectColumn(ProductPeer::SORT_ORDER);

		$criteria->addSelectColumn(ProductPeer::CREATED_AT);

		$criteria->addSelectColumn(ProductPeer::UPDATED_AT);

		$criteria->addSelectColumn(ProductPeer::EXTRA_SURCHARGE);

		$criteria->addSelectColumn(ProductPeer::IS_HIDDEN);

	}

	const COUNT = 'COUNT(product.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT product.ID)';

	
	public static function doCount(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(ProductPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ProductPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = ProductPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}
	
	public static function doSelectOne(Criteria $criteria, $con = null)
	{
		$critcopy = clone $criteria;
		$critcopy->setLimit(1);
		$objects = ProductPeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, $con = null)
	{
		return ProductPeer::populateObjects(ProductPeer::doSelectRS($criteria, $con));
	}
	
	public static function doSelectRS(Criteria $criteria, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			ProductPeer::addSelectColumns($criteria);
		}

				$criteria->setDbName(self::DATABASE_NAME);

						return BasePeer::doSelect($criteria, $con);
	}
	
	public static function populateObjects(ResultSet $rs)
	{
		$results = array();
	
				$cls = ProductPeer::getOMClass();
		$cls = Propel::import($cls);
				while($rs->next()) {
		
			$obj = new $cls();
			$obj->hydrate($rs);
			$results[] = $obj;
			
		}
		return $results;
	}
	
	public static function getTableMap()
	{
		return Propel::getDatabaseMap(self::DATABASE_NAME)->getTable(self::TABLE_NAME);
	}

	
	public static function getOMClass()
	{
		return ProductPeer::CLASS_DEFAULT;
	}

	
	public static function doInsert($values, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} else {
			$criteria = $values->buildCriteria(); 		}

		$criteria->remove(ProductPeer::ID); 

				$criteria->setDbName(self::DATABASE_NAME);

		try {
									$con->begin();
			$pk = BasePeer::doInsert($criteria, $con);
			$con->commit();
		} catch(PropelException $e) {
			$con->rollback();
			throw $e;
		}

		return $pk;
	}

	
	public static function doUpdate($values, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		$selectCriteria = new Criteria(self::DATABASE_NAME);

		if ($values instanceof Criteria) {
			$criteria = clone $values; 
			$comparison = $criteria->getComparison(ProductPeer::ID);
			$selectCriteria->add(ProductPeer::ID, $criteria->remove(ProductPeer::ID), $comparison);

		} else { 			$criteria = $values->buildCriteria(); 			$selectCriteria = $values->buildPkeyCriteria(); 		}

				$criteria->setDbName(self::DATABASE_NAME);

		return BasePeer::doUpdate($selectCriteria, $criteria, $con);
	}

	
	public static function doDeleteAll($con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}
		$affectedRows = 0; 		try {
									$con->begin();
			ProductPeer::doOnDeleteSetNull(new Criteria(), $con);
			$affectedRows += BasePeer::doDeleteAll(ProductPeer::TABLE_NAME, $con);
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	
	 public static function doDelete($values, $con = null)
	 {
		if ($con === null) {
			$con = Propel::getConnection(ProductPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} elseif ($values instanceof Product) {

			$criteria = $values->buildPkeyCriteria();
		} else {
						$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(ProductPeer::ID, (array) $values, Criteria::IN);
		}

				$criteria->setDbName(self::DATABASE_NAME);

		$affectedRows = 0; 
		try {
									$con->begin();
			ProductPeer::doOnDeleteSetNull($criteria, $con);
			$affectedRows += BasePeer::doDelete($criteria, $con);
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	
	protected static function doOnDeleteSetNull(Criteria $criteria, Connection $con)
	{

				$objects = ProductPeer::doSelect($criteria, $con);
		foreach($objects as $obj) {

						$selectCriteria = new Criteria(ProductPeer::DATABASE_NAME);
			$updateValues = new Criteria(ProductPeer::DATABASE_NAME);
			$selectCriteria->add(PurchasePeer::PRODUCT_ID, $obj->getId());
			$updateValues->add(PurchasePeer::PRODUCT_ID, null);

			BasePeer::doUpdate($selectCriteria, $updateValues, $con); 
		}
	}

	
	public static function doValidate(Product $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(ProductPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(ProductPeer::TABLE_NAME);

			if (! is_array($cols)) {
				$cols = array($cols);
			}

			foreach($cols as $colName) {
				if ($tableMap->containsColumn($colName)) {
					$get = 'get' . $tableMap->getColumn($colName)->getPhpName();
					$columns[$colName] = $obj->$get();
				}
			}
		} else {

		}

		$res =  BasePeer::doValidate(ProductPeer::DATABASE_NAME, ProductPeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = ProductPeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
            $request->setError($col, $failed->getMessage());
        }
    }

    return $res;
	}

	
	public static function retrieveByPK($pk, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		$criteria = new Criteria(ProductPeer::DATABASE_NAME);

		$criteria->add(ProductPeer::ID, $pk);


		$v = ProductPeer::doSelect($criteria, $con);

		return !empty($v) > 0 ? $v[0] : null;
	}

	
	public static function retrieveByPKs($pks, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		$objs = null;
		if (empty($pks)) {
			$objs = array();
		} else {
			$criteria = new Criteria();
			$criteria->add(ProductPeer::ID, $pks, Criteria::IN);
			$objs = ProductPeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} 
if (Propel::isInit()) {
			try {
		BaseProductPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
			require_once 'lib/model/map/ProductMapBuilder.php';
	Propel::registerMapBuilder('lib.model.map.ProductMapBuilder');
}
