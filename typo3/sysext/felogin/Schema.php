<?php

$schema = new Doctrine\DBAL\Schema\Schema();

// fe_groups
$feGroups = $schema->createTable('fe_groups');
$feGroups->addColumn('felogin_redirectPid', 'text', array('length' => 255));

// fe_users
$feUsers = $schema->createTable('fe_users');
$feUsers->addColumn('felogin_redirectPid', 'text', array('length' => 255));
$feUsers->addColumn('felogin_forgotHash', 'string', array('length' => 80, 'default' => ''));

return $schema;
