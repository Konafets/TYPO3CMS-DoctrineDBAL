<?php

$schema = new Doctrine\DBAL\Schema\Schema();

$sysNote = $schema->createTable('sys_note');
$sysNote->addColumn('uid', 'integer', array('autoincrement' => TRUE, 'unsigned' => TRUE, 'notnull' => TRUE));
$sysNote->addColumn('pid', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$sysNote->addColumn('deleted', 'boolean', array('default' => '0', 'notnull' => TRUE));
$sysNote->addColumn('tstamp', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$sysNote->addColumn('crdate', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$sysNote->addColumn('cruser', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$sysNote->addColumn('subject', 'string', array('length' => 255, 'default' => '', 'notnull' => TRUE));
$sysNote->addColumn('message', 'text', array('length' => 65535));
$sysNote->addColumn('personal', 'boolean', array('default' => '0', 'notnull' => TRUE));
$sysNote->addColumn('category', 'boolean', array('default' => '0', 'notnull' => TRUE));
$sysNote->addColumn('sorting', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysNote->setPrimaryKey(array('uid'));
$sysNote->addIndex(array('pid'), 'sys_note_pid_idx');

return $schema;
