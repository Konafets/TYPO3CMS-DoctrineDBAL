<?php

$schema = new \Doctrine\DBAL\Schema\Schema();

$txExtensionmanagerDomainModelRepository = $schema->createTable('tx_extensionmanager_domain_model_repository');
$txExtensionmanagerDomainModelRepository->addColumn('uid', 'integer', array('autoincrement' => TRUE, 'unsigned' => TRUE, 'notnull' => TRUE));
$txExtensionmanagerDomainModelRepository->addColumn('pid', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$txExtensionmanagerDomainModelRepository->addColumn('title', 'string', array('length' => 150, 'default' => '', 'notnull' => TRUE));
$txExtensionmanagerDomainModelRepository->addColumn('description', 'text', array('length' => 16777215));
$txExtensionmanagerDomainModelRepository->addColumn('wsdl_url', 'string', array('length' => 100, 'default' => '', 'notnull' => TRUE));
$txExtensionmanagerDomainModelRepository->addColumn('mirror_list_url', 'string', array('length' => 100, 'default' => '', 'notnull' => TRUE));
$txExtensionmanagerDomainModelRepository->addColumn('last_update', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$txExtensionmanagerDomainModelRepository->addColumn('extension_count', 'integer', array('default' => '0', 'notnull' => TRUE));
$txExtensionmanagerDomainModelRepository->setPrimaryKey(array('uid'));

$txExtensionmanagerDomainModelExtension = $schema->createTable('tx_extensionmanager_domain_model_extension');
$txExtensionmanagerDomainModelExtension->addColumn('uid', 'integer', array('autoincrement' => TRUE, 'unsigned' => TRUE, 'notnull' => TRUE));
$txExtensionmanagerDomainModelExtension->addColumn('pid', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$txExtensionmanagerDomainModelExtension->addColumn('extension_key', 'string', array('length' => 60, 'default' => TRUE, 'notnull' => TRUE));
$txExtensionmanagerDomainModelExtension->addColumn('repository', 'integer', array('unsigned' => TRUE, 'notnull' => TRUE, 'default' => '1'));
$txExtensionmanagerDomainModelExtension->addColumn('version', 'string', array('length' => 10, 'default' => TRUE, 'notnull' => TRUE));
$txExtensionmanagerDomainModelExtension->addColumn('alldownloadcounter', 'integer', array('unsigned' => TRUE, 'notnull' => TRUE, 'default' => '0'));
$txExtensionmanagerDomainModelExtension->addColumn('downloadcounter', 'integer', array('unsigned' => TRUE, 'notnull' => TRUE, 'default' => '0'));
$txExtensionmanagerDomainModelExtension->addColumn('title', 'string', array('length' => 150, 'default' => TRUE, 'notnull' => TRUE));
$txExtensionmanagerDomainModelExtension->addColumn('description', 'text', array('length' => 16777215));
$txExtensionmanagerDomainModelExtension->addColumn('state', 'integer', array('default' => '0', 'notnull' => TRUE));
$txExtensionmanagerDomainModelExtension->addColumn('review_state', 'integer', array('default' => '0', 'notnull' => TRUE));
$txExtensionmanagerDomainModelExtension->addColumn('category', 'integer', array('default' => '0', 'notnull' => TRUE));
$txExtensionmanagerDomainModelExtension->addColumn('last_updated', 'integer', array('unsigned' => TRUE, 'notnull' => TRUE, 'default' => '0'));
$txExtensionmanagerDomainModelExtension->addColumn('serialized_dependencies', 'text', array('length' => 16777215));
$txExtensionmanagerDomainModelExtension->addColumn('author_name', 'string', array('length' => 100, 'default' => TRUE, 'notnull' => TRUE));
$txExtensionmanagerDomainModelExtension->addColumn('author_email', 'string', array('length' => 100, 'default' => TRUE, 'notnull' => TRUE));
$txExtensionmanagerDomainModelExtension->addColumn('ownerusername', 'string', array('length' => 50, 'default' => TRUE, 'notnull' => TRUE));
$txExtensionmanagerDomainModelExtension->addColumn('md5hash', 'string', array('length' => 35, 'default' => TRUE, 'notnull' => TRUE));
$txExtensionmanagerDomainModelExtension->addColumn('update_comment', 'text', array('length' => 16777215));
$txExtensionmanagerDomainModelExtension->addColumn('authorcompany', 'string', array('length' => 100, 'default' => TRUE, 'notnull' => TRUE));
$txExtensionmanagerDomainModelExtension->addColumn('integer_version', 'integer', array('default' => '0', 'notnull' => TRUE));
$txExtensionmanagerDomainModelExtension->addColumn('current_version', 'integer', array('default' => '0', 'notnull' => TRUE));
$txExtensionmanagerDomainModelExtension->addColumn('lastreviewedversion', 'integer', array('default' => '0', 'notnull' => TRUE));
$txExtensionmanagerDomainModelExtension->setPrimaryKey(array('uid'));
$txExtensionmanagerDomainModelExtension->addIndex(array('repository', 'extension_key'), 'tx_em_domain_model_ext_index_extrepo');
$txExtensionmanagerDomainModelExtension->addIndex(array('repository', 'integer_version'), 'tx_em_domain_model_ext_index_versionrepo');
$txExtensionmanagerDomainModelExtension->addIndex(array('review_state', 'current_version'), 'tx_em_domain_model_ext_index_currentversions');
$txExtensionmanagerDomainModelExtension->addUniqueIndex(array('extension_key', 'version', 'repository'), 'tx_em_domain_model_ext_versionextrepo');

return $schema;
