<?php

$schema = new Doctrine\DBAL\Schema\Schema();

$txLinkvalidatorLink = $schema->createTable('tx_linkvalidator_link');
$txLinkvalidatorLink->addColumn('uid', 'integer', array('autoincrement' => TRUE, 'notnull' => TRUE));
$txLinkvalidatorLink->addColumn('record_uid', 'integer', array('default' => '0', 'notnull' => TRUE));
$txLinkvalidatorLink->addColumn('record_pid', 'integer', array('default' => '0', 'notnull' => TRUE));
$txLinkvalidatorLink->addColumn('headline', 'string', array('length' => 255, 'default' => '', 'notnull' => TRUE));
$txLinkvalidatorLink->addColumn('field', 'string', array('length' => 255, 'default' => '', 'notnull' => TRUE));
$txLinkvalidatorLink->addColumn('table_name', 'string', array('length' => 255, 'default' => '', 'notnull' => TRUE));
$txLinkvalidatorLink->addColumn('link_title', 'text', array('length' => 65535));
$txLinkvalidatorLink->addColumn('url text', 'text', array('length' => 65535));
$txLinkvalidatorLink->addColumn('url_response', 'text', array('length' => 65535));
$txLinkvalidatorLink->addColumn('last_check', 'integer', array('default' => '0', 'notnull' => TRUE));
$txLinkvalidatorLink->addColumn('link_type', 'string', array('length' => 50, 'default' => '', 'notnull' => TRUE));
$txLinkvalidatorLink->setPrimaryKey(array('uid'));

return $schema;
