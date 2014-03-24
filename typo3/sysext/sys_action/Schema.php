<?php

$schema = new Doctrine\DBAL\Schema\Schema();

// sys_action
$sysAction = $schema->createTable('sys_action');
$sysAction->addColumn('uid', 'integer', array('autoincrement' => TRUE, 'unsigned' => TRUE, 'notnull' => TRUE));
$sysAction->addColumn('pid', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$sysAction->addColumn('tstamp', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$sysAction->addColumn('crdate', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$sysAction->addColumn('cruser_id', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$sysAction->addColumn('sorting', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysAction->addColumn('title', 'string', array('length' => 255, 'default' => '', 'notnull' => TRUE));
$sysAction->addColumn('description', 'text', array('length' => 65535));
$sysAction->addColumn('type', 'boolean', array('default' => '0', 'notnull' => TRUE));
$sysAction->addColumn('t1_userprefix', 'string', array('length' => 20, 'default' => '', 'notnull' => TRUE));
$sysAction->addColumn('t1_copy_of_user', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysAction->addColumn('t1_allowed_groups', 'text', array('length' => 255));
$sysAction->addColumn('t2_data', 'blob', array('length' => 65535));
$sysAction->addColumn('assign_to_groups', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysAction->addColumn('hidden', 'boolean', array('default' => '0', 'notnull' => TRUE));
$sysAction->addColumn('t1_create_user_dir', 'boolean', array('default' => '0', 'notnull' => TRUE));
$sysAction->addColumn('t3_listPid', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysAction->addColumn('t3_tables', 'string', array('length' => 255, 'default' => '', 'notnull' => TRUE));
$sysAction->addColumn('t4_recordsToEdit', 'text', array('length' => 65535));
$sysAction->setPrimaryKey(array('uid'));
$sysAction->addIndex(array('cruser_id'), 'sys_action_cruser_id');
$sysAction->addIndex(array('pid'), 'sys_action_pid_idx');

// sys_action_asgr_mm
$sysActionAsgrMm = $schema->createTable('sys_action_asgr_mm');
$sysActionAsgrMm->addColumn('uid_local', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$sysActionAsgrMm->addColumn('uid_foreign', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$sysActionAsgrMm->addColumn('sorting', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$sysActionAsgrMm->addIndex(array('uid_local'), 'sys_action_asgr_mm_uid_local');
$sysActionAsgrMm->addIndex(array('uid_foreign'), 'sys_action_asgr_mm_uid_foreign');

return $schema;
