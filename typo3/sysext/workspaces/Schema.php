<?php

$schema = new Doctrine\DBAL\Schema\Schema();

// sys_workspace
$sysWorkspace = $schema->createTable('sys_workspace');
$sysWorkspace->addColumn('uid', 'integer', array('autoincrement' => TRUE, 'notnull' => TRUE));
$sysWorkspace->addColumn('pid', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysWorkspace->addColumn('tstamp', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysWorkspace->addColumn('deleted', 'boolean', array('default' => '0', 'notnull' => TRUE));
$sysWorkspace->addColumn('title', 'string', array('length' => 30, 'default' => '', 'notnull' => TRUE));
$sysWorkspace->addColumn('description', 'string', array('length' => 255, 'default' => '', 'notnull' => TRUE));
$sysWorkspace->addColumn('adminusers', 'string', array('length' => 4000, 'default' => '', 'notnull' => TRUE));
$sysWorkspace->addColumn('members', 'string', array('length' => 4000, 'default' => '', 'notnull' => TRUE));
$sysWorkspace->addColumn('reviewers', 'string', array('length' => 4000, 'default' => '', 'notnull' => TRUE));
$sysWorkspace->addColumn('db_mountpoints', 'string', array('length' => 255, 'default' => '', 'notnull' => TRUE));
$sysWorkspace->addColumn('file_mountpoints', 'string', array('length' => 255, 'default' => '', 'notnull' => TRUE));
$sysWorkspace->addColumn('publish_time', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysWorkspace->addColumn('unpublish_time', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysWorkspace->addColumn('freeze', 'boolean', array('default' => '0', 'notnull' => TRUE));
$sysWorkspace->addColumn('live_edit', 'boolean', array('default' => '0', 'notnull' => TRUE));
$sysWorkspace->addColumn('vtypes', 'boolean', array('default' => '0', 'notnull' => TRUE));
$sysWorkspace->addColumn('disable_autocreate', 'boolean', array('default' => '0', 'notnull' => TRUE));
$sysWorkspace->addColumn('swap_modes', 'boolean', array('default' => '0', 'notnull' => TRUE));
$sysWorkspace->addColumn('publish_access', 'boolean', array('default' => '0', 'notnull' => TRUE));
$sysWorkspace->addColumn('custom_stages', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysWorkspace->addColumn('stagechg_notification', 'boolean', array('default' => '0', 'notnull' => TRUE));
$sysWorkspace->addColumn('edit_notification_mode', 'boolean', array('default' => '0', 'notnull' => TRUE));
$sysWorkspace->addColumn('edit_notification_defaults', 'string', array('length' => 255, 'default' => '', 'notnull' => TRUE));
$sysWorkspace->addColumn('edit_allow_notificaton_settings', 'boolean', array('default' => '0', 'notnull' => TRUE));
$sysWorkspace->addColumn('publish_notification_mode', 'boolean', array('default' => '0', 'notnull' => TRUE));
$sysWorkspace->addColumn('publish_notification_defaults', 'string', array('length' => 255, 'default' => '', 'notnull' => TRUE));
$sysWorkspace->addColumn('publish_allow_notificaton_settings', 'boolean', array('default' => '0', 'notnull' => TRUE));
$sysWorkspace->setPrimaryKey(array('uid'));
$sysWorkspace->addIndex(array('pid'), 'sys_workspace_pid');


// sys_workspace_stage
$sysWorkspaceStage = $schema->createTable('sys_workspace_stage');
$sysWorkspaceStage->addColumn('uid', 'integer', array('autoincrement' => TRUE, 'notnull' => TRUE));
$sysWorkspaceStage->addColumn('pid', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysWorkspaceStage->addColumn('tstamp', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysWorkspaceStage->addColumn('deleted', 'boolean', array('default' => '0', 'notnull' => TRUE));
$sysWorkspaceStage->addColumn('sorting', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$sysWorkspaceStage->addColumn('title', 'string', array('length' => 30, 'default' => '', 'notnull' => TRUE));
$sysWorkspaceStage->addColumn('responsible_persons', 'string', array('length' => 255, 'default' => '', 'notnull' => TRUE));
$sysWorkspaceStage->addColumn('default_mailcomment', 'text', array('length' => 65535));
$sysWorkspaceStage->addColumn('parentid', 'integer', array('default' => '0', 'notnull' => TRUE));
$sysWorkspaceStage->addColumn('parenttable', 'text', array('length' => 255));
$sysWorkspaceStage->addColumn('notification_mode', 'boolean', array('default' => '0', 'notnull' => TRUE));
$sysWorkspaceStage->addColumn('notification_defaults', 'string', array('length' => 255, 'default' => '', 'notnull' => TRUE));
$sysWorkspaceStage->addColumn('allow_notificaton_settings', 'boolean', array('default' => '0', 'notnull' => TRUE));
$sysWorkspaceStage->setPrimaryKey(array('uid'));
$sysWorkspaceStage->addIndex(array('pid'), 'sys_workspace_stage_pid');

return $schema;
