<?php

$schema = new Doctrine\DBAL\Schema\Schema();

$schema->dropTable('tx_extensionmanager_domain_model_repository');
$txExtensionmanagerDomainModelRepository = $schema->createTable('tx_extensionmanager_domain_model_repository');
$txExtensionmanagerDomainModelRepository->addColumn('uid', 'integer', array('autoincrement' TRUE, 'unsigned' => TRUE, 'notnull' => TRUE));
$txExtensionmanagerDomainModelRepository->addColumn('pid', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
$txExtensionmanagerDomainModelRepository->addColumn('title', 'string', array('length' => 250, 'default' => '', 'notnull' => TRUE));
$txExtensionmanagerDomainModelRepository->addColumn('description', 'text', array('length' => 16777215));
$txExtensionmanagerDomainModelRepository->addColumn('wsdl_url', 'string', array('length' => 100, 'default' => '', 'notnull' => TRUE));
$txExtensionmanagerDomainModelRepository->addColumn('mirror_list_url', 'string', array('length' => 100, 'default' => '', 'notnull' => TRUE));
$txExtensionmanagerDomainModelRepository->addColumn('last_update', 'integer', array('default' => '0', 'unsigned' => TRUE, 'notnull' => TRUE));
$txExtensionmanagerDomainModelRepository->addColumn('extension_count', 'integer', array('default' => '0', 'notnull' => TRUE));
$txExtensionmanagerDomainModelRepository->setPrimaryKey(array('uid'));


//INSERT INTO tx_extensionmanager_domain_model_repository VALUES ('1', '0', 'TYPO3.org Main Repository', 'Main repository on typo3.org. This repository has some mirrors configured which are available with the mirror url.', 'http://typo3.org/wsdl/tx_ter_wsdl.php', 'http://repositories.typo3.org/mirrors.xml.gz', '1346191200', '0');

return $schema;
