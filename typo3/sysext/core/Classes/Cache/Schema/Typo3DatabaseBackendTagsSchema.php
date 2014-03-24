<?php
namespace TYPO3\CMS\Core\Cache\Schema;

class Typo3DatabaseBackendTagsSchema {

	protected $tableName = '';

	protected $indexIdentifier = '';

	protected $indexTag = '';

	public function __construct($tableName) {
		$this->tableName = $tableName;
		$this->indexIdentifier = $tableName . '_cache_id';
		$this->indexTag = $tableName . '_cache_tag';
	}

	public function getTagsSchemaFromTemplate() {
		$schema = new \Doctrine\DBAL\Schema\Schema();

		$tagsTable = $schema->createTable($this->tableName);
		$tagsTable->addColumn('id', 'integer', array('autoincrement' => TRUE, 'unsigned' => TRUE, 'notnull' => TRUE));
		$tagsTable->addColumn('identifier', 'string', array('length' => 250, 'default' => '', 'notnull' => TRUE));
		$tagsTable->addColumn('tag', 'string', array('length' => 250, 'default' => '', 'notnull' => TRUE));
		$tagsTable->setPrimaryKey(array('id'));
		$tagsTable->addIndex(array('identifier'), $this->indexIdentifier);
		$tagsTable->addIndex(array('tag'), $this->indexTag);
		
		return $schema;
	}
}
