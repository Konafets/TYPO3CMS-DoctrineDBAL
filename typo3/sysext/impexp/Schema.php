<?php 

$schema = new Doctrine\DBAL\Schema\Schema();

$txImpexpPresets = $schema->createTable('tx_impexp_presets');
$txImpexpPresets->addColumn('uid', 'integer', array('autoincrement' => TRUE, 'notnull' => TRUE));
$txImpexpPresets->addColumn('user_uid', 'integer', array('default' => '0', 'notnull' => TRUE));
$txImpexpPresets->addColumn('title', 'string', array('length' => 255, 'default' => '', 'notnull' => TRUE));
$txImpexpPresets->addColumn('public', 'boolean', array('default' => '0', 'notnull' => TRUE));
$txImpexpPresets->addColumn('item_uid', 'integer', array('default' => '0', 'notnull' => TRUE));
$txImpexpPresets->addColumn('preset_data', 'blob', array('length' => 65535));
$txImpexpPresets->setPrimaryKey(array('uid'));
$txImpexpPresets->addIndex(array('item_uid'), 'tx_impexp_presets_lookup');

return $schema;
