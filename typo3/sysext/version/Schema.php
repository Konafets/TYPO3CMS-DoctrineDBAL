<?php

$schema = new Doctrine\DBAL\Schema\Schema();

$sysPreview = $schema->createTable('sys_preview');
$sysPreview->addColumn('keyword', 'string', array('length' => 32, 'default' => '', 'notnull' => TRUE));
$sysPreview->addColumn('tstamp', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysPreview->addColumn('endtime', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysPreview->addColumn('config', 'text', array('length' => 65535));
$sysPreview->setPrimaryKey(array('keyword'));

return $schema;

