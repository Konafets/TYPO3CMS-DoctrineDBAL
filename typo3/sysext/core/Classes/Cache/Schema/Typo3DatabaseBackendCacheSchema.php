<?php
namespace TYPO3\CMS\Core\Cache\Schema;

class Typo3DatabaseBackendCacheSchema {

	protected $tableName = '';

	protected $indexCache = '';

	public function __construct($tableName) {
		$this->tableName = $tableName;
		$this->indexCache = $tableName . '_cache_id';
	}

	public function getCacheSchemaFromTemplate() {
		// ###CACHE_TABLE###
		$schema = new \Doctrine\DBAL\Schema\Schema();
		
		$cacheTable = $schema->createTable($this->tableName);
		$cacheTable->addColumn('id', 'integer', array('autoincrement' => TRUE, 'unsigned' => TRUE, 'notnull' => TRUE));
		$cacheTable->addColumn('identifier', 'string', array('length' => 250, 'default' => '', 'notnull' => TRUE));
		$cacheTable->addColumn('expires', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
		$cacheTable->addColumn('content', 'blob', array('length' => 16777215));
		$cacheTable->setPrimaryKey(array('id'));
		$cacheTable->addIndex(array('identifier', 'expires'), $this->indexCache);
		
		return $schema;
	}
}
