<?php

$schema = new Doctrine\DBAL\Schema\Schema();
//
// Table structure for table 'index_fulltext'
//
// Differences compared to original definition in EXT:indexed_search are as follows:
// - Add new mediumtext field "metaphonedata"
// - Add new FULLTEXT index "fulltextdata"
// - Add new FULLTEXT index "metaphonedata"
// - Change table engine from InnoDB to MyISAM (required for FULLTEXT indexing)
$indexFulltext = $schema->createTable('index_fulltext');
$indexFulltext->addColumn('phash', 'integer', array('default' => '0', 'notnull' => TRUE));
$indexFulltext->addColumn('fulltextdata', 'text', array('length' => 16777215));
$indexFulltext->addColumn('metaphonedata', 'text', array('length' => 16777215));
$indexFulltext->setPrimaryKey(array('phash'));
$indexFulltext->addIndex(array('fulltextdata'), 'inxdex_fulltext_fulltextdata', array('fulltext'));
$indexFulltext->addIndex(array('metaphonedata'), 'inxdex_fulltext_metaphonedata', array('fulltext'));
$indexFulltext->addOption('engine', 'MyISAM');

return $schema;
