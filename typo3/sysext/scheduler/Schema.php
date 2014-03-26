<?php

$schema = new Doctrine\DBAL\Schema\Schema();


// tx_scheduler_task
$txSchedulerTask = $schema->createTable('tx_scheduler_task');
$txSchedulerTask->addColumn('uid', 'integer', array('autoincrement' => TRUE, 'unsigned' => TRUE, 'notnull' => TRUE));
$txSchedulerTask->addColumn('crdate', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$txSchedulerTask->addColumn('disable', 'boolean', array('default' => '0', 'notnull' => TRUE));
$txSchedulerTask->addColumn('description', 'text', array('length' => 65535));
$txSchedulerTask->addColumn('nextexecution', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$txSchedulerTask->addColumn('lastexecution_time', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$txSchedulerTask->addColumn('lastexecution_failure', 'text', array('length' => 65535));
$txSchedulerTask->addColumn('lastexecution_context', 'string', array('length' => 3, 'fixed' => TRUE, 'default' => '', 'notnull' => TRUE));
$txSchedulerTask->addColumn('serialized_task_object', 'blob', array('length' => 65535));
$txSchedulerTask->addColumn('serialized_executions', 'blob', array('length' => 65535));
$txSchedulerTask->addColumn('task_group', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$txSchedulerTask->setPrimaryKey(array('uid'));
$txSchedulerTask->addIndex(array('nextexecution'), 'tx_scheduler_task_index_nextexecution');


// tx_scheduler_task_group
$txSchedulerTaskGroup = $schema->createTable('tx_scheduler_task_group');
$txSchedulerTaskGroup->addColumn('uid', 'integer', array('autoincrement' => TRUE, 'unsigned' => TRUE, 'notnull' => TRUE));
$txSchedulerTaskGroup->addColumn('pid', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$txSchedulerTaskGroup->addColumn('tstamp', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$txSchedulerTaskGroup->addColumn('crdate', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$txSchedulerTaskGroup->addColumn('cruser_id', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$txSchedulerTaskGroup->addColumn('deleted', 'boolean', array('default' => '0', 'notnull' => TRUE));
$txSchedulerTaskGroup->addColumn('sorting', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$txSchedulerTaskGroup->addColumn('hidden', 'boolean', array('default' => '0', 'notnull' => TRUE));
$txSchedulerTaskGroup->addColumn('groupName', 'string', array('length' => 80, 'default' => '', 'notnull' => TRUE));
$txSchedulerTaskGroup->addColumn('description', 'text', array('length' => 65535));
$txSchedulerTaskGroup->setPrimaryKey(array('uid'));
$txSchedulerTaskGroup->addIndex(array('pid'), 'tx_scheduler_task_group_idx');

return $schema;
