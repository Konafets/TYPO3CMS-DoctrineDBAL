<?php

$schema = new Doctrine\DBAL\Schema\Schema();


// be_users
$beUsers = $schema->createTable('be_users');
$beUsers->addColumn('tx_openid_openid', 'string', array('length' => 255, 'default' => '', 'notnull' => TRUE));


// fe_users
$feUsers = $schema->createTable('fe_users');
$feUsers->addColumn('tx_openid_openid', 'string', array('length' => 255, 'default' => '', 'notnull' => TRUE));


// tx_openid_assoc_store
$txOpenidAssocStore = $schema->createTable('tx_openid_assoc_store');
$txOpenidAssocStore->addColumn('uid', 'integer', array('autoincrement' => TRUE, 'unsigned' => TRUE, 'notnull' => TRUE));
$txOpenidAssocStore->addColumn('pid', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$txOpenidAssocStore->addColumn('crdate', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$txOpenidAssocStore->addColumn('tstamp', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$txOpenidAssocStore->addColumn('expires', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$txOpenidAssocStore->addColumn('server_url', 'string', array('length' => 2047, 'default' => '', 'notnull' => TRUE));
$txOpenidAssocStore->addColumn('assoc_handle', 'string', array('length' => 255, 'default' => '', 'notnull' => TRUE));
$txOpenidAssocStore->addColumn('content', 'blob', array('length' => 65535));
$txOpenidAssocStore->setPrimaryKey(array('uid'));
$txOpenidAssocStore->addIndex(array('assoc_handle'), 'tx_openid_assoc_store_assoc_handle');
$txOpenidAssocStore->addIndex(array('expires'), 'expires');


// tx_openid_nonce_store
$txOpenidNonceStore = $schema->createTable('tx_openid_nonce_store');
$txOpenidNonceStore->addColumn('uid', 'integer', array('autoincrement' => TRUE, 'unsigned' => TRUE, 'notnull' => TRUE));
$txOpenidNonceStore->addColumn('pid', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$txOpenidNonceStore->addColumn('crdate', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$txOpenidNonceStore->addColumn('tstamp', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$txOpenidNonceStore->addColumn('server_url', 'string', array('length' => 2047, 'default' => '', 'notnull' => TRUE));
$txOpenidNonceStore->addColumn('salt', 'string', array('length' => 40, 'fixed' => TRUE, 'default' => '', 'notnull' => TRUE));
$txOpenidNonceStore->setPrimaryKey(array('uid'));
$txOpenidNonceStore->addUniqueIndex(array('server_url', 'tstamp', 'salt'), 'nonce');
$txOpenidNonceStore->addIndex(array('crdate'), 'tx_openid_nonce_store_crdate');

return $schema;
