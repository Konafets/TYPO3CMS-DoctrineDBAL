<?php
namespace TYPO3\CMS\Extensionmanager\Schema;

use TYPO3\DoctrineDbal\Persistence\Legacy\DatabaseConnectionLegacy;
use TYPO3\DoctrineDbal\Persistence\Exception\InvalidArgumentException;

class DefaultData {
	/**
	 * @var \TYPO3\DoctrineDbal\Persistence\Doctrine\DatabaseConnection
	 */
	protected $connection;

	/**
	 * @param $connection \TYPO3\DoctrineDbal\Persistence\Legacy\DatabaseConnectionLegacy
	 *
	 * @throws \TYPO3\DoctrineDbal\Persistence\Exception\InvalidArgumentException
	 */
	public function __construct($connection) {
		if (!$connection instanceof DatabaseConnectionLegacy) {
			throw new InvalidArgumentException('Constructor must be called with type \TYPO3\DoctrineDbal\Persistence\Legacy\DatabaseConnectionLegacy');
		}

		$this->connection = $connection;
	}

	/**
	 * @return int
	 */
	public function insertDefaultData() {
		return $this->connection->executeInsertQuery(
				'tx_extensionmanager_domain_model_repository',
				array(
					'uid' => 1,
					'pid' => 0,
					'title' => 'TYPO3.org Main Repository',
					'description' => 'Main repository on typo3.org. This repository has some mirrors configured which are available with the mirror url.',
					'wsdl_url' => 'http://typo3.org/wsdl/tx_ter_wsdl.php',
					'mirror_list_url' => 'http://repositories.typo3.org/mirrors.xml.gz',
					'last_update' => 1346191200,
					'extension_count' => 0
				),
				array(
					\PDO::PARAM_INT,
					\PDO::PARAM_INT,
					\PDO::PARAM_STR,
					\PDO::PARAM_STR,
					\PDO::PARAM_STR,
					\PDO::PARAM_STR,
					\PDO::PARAM_INT,
					\PDO::PARAM_INT,
				)
		);
	}
}

