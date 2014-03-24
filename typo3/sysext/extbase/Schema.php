<?php
$schema = new \Doctrine\DBAL\Schema\Schema();

$feUsers = $schema->createTable('fe_users');
$feUsers->addColumn('tx_extbase_type', 'string', array('length' => 255, 'default' => '', 'notnull' => TRUE));

$feGroups = $schema->createTable('fe_groups');
$feGroups->addColumn('tx_extbase_type', 'string', array('length' => 255, 'default' => '', 'notnull' => TRUE));

return $schema;
