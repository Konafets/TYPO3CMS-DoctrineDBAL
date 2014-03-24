<?php

$schema = new Doctrine\DBAL\Schema\Schema();


// tx_rsaauth_keys
$txRsauthKeys = $schema->createTable('tx_rsaauth_keys');
$txRsauthKeys->addColumn('uid', 'integer', array('autoincrement' => TRUE, 'notnull' => TRUE));
$txRsauthKeys->addColumn('pid', 'integer', array('default' => '0', 'notnull' => TRUE));
$txRsauthKeys->addColumn('crdate', 'integer', array('default' => '0', 'notnull' => TRUE));
$txRsauthKeys->addColumn('key_value', 'text', array('length' => 65535));
$txRsauthKeys->setPrimaryKey(array('uid'));
$txRsauthKeys->addIndex(array('crdate'), 'tx_rsaauth_keys_crdate');

return $schema;
