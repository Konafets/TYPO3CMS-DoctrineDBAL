<?php
namespace TYPO3\CMS\Extensionmanager\Utility;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2012-2013 Susanne Moog <susanne.moog@typo3.org>
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *  A copy is found in the text file GPL.txt and important notices to the license
 *  from the author is found in LICENSE.txt distributed with these scripts.
 *
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * Extension Manager Install Utility
 *
 * @author Susanne Moog <susanne.moog@typo3.org>
 */
class InstallUtility implements \TYPO3\CMS\Core\SingletonInterface {

	/**
	 * @var \TYPO3\CMS\Extbase\Object\ObjectManager
	 * @inject
	 */
	public $objectManager;

	/**
	 * @var \TYPO3\CMS\Install\Service\SqlSchemaMigrationService
	 * @inject
	 */
	public $installToolSqlParser;

	/**
	 * @var \TYPO3\CMS\Extensionmanager\Utility\DependencyUtility
	 * @inject
	 */
	protected $dependencyUtility;

	/**
	 * @var \TYPO3\CMS\Extensionmanager\Utility\FileHandlingUtility
	 * @inject
	 */
	protected $fileHandlingUtility;

	/**
	 * @var \TYPO3\CMS\Extensionmanager\Utility\ListUtility
	 * @inject
	 */
	protected $listUtility;

	/**
	 * @var \TYPO3\CMS\Extensionmanager\Utility\DatabaseUtility
	 * @inject
	 */
	protected $databaseUtility;

	/**
	 * @var \TYPO3\CMS\Extensionmanager\Domain\Repository\ExtensionRepository
	 * @inject
	 */
	public $extensionRepository;

	/**
	 * @var \TYPO3\CMS\Core\Package\PackageManager
	 * @inject
	 */
	protected $packageManager;

	/**
	 * @var \TYPO3\CMS\Core\Cache\CacheManager
	 * @inject
	 */
	protected $cacheManager;

	/**
	 * @var \TYPO3\CMS\Extbase\SignalSlot\Dispatcher
	 * @inject
	 */
	protected $signalSlotDispatcher;

	/**
	 * @var \TYPO3\CMS\Core\Registry
	 * @inject
	 */
	protected $registry;

	/**
	 * __construct
	 */
	public function __construct() {
		$this->objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
		/** @var $installToolSqlParser \TYPO3\CMS\Install\Service\SqlSchemaMigrationService */
		$this->installToolSqlParser = $this->objectManager->get('TYPO3\\CMS\\Install\\Service\\SqlSchemaMigrationService');
		$this->dependencyUtility = $this->objectManager->get('TYPO3\\CMS\\Extensionmanager\\Utility\\DependencyUtility');
	}

	/**
	 * Helper function to install an extension
	 * also processes db updates and clears the cache if the extension asks for it
	 *
	 * @param string $extensionKey
	 * @throws \TYPO3\CMS\Extensionmanager\Exception\ExtensionManagerException
	 * @return void
	 */
	public function install($extensionKey) {
		$extension = $this->enrichExtensionWithDetails($extensionKey);
		$this->processDatabaseUpdates($extension);
		$this->ensureConfiguredDirectoriesExist($extension);
		$this->importInitialFiles($extension['siteRelPath'], $extensionKey);
		if (!$this->isLoaded($extensionKey)) {
			$this->loadExtension($extensionKey);
		}
		$this->reloadCaches();
		$this->processRuntimeDatabaseUpdates($extensionKey);
		$this->saveDefaultConfiguration($extension['key']);
		if ($extension['clearcacheonload']) {
			$this->cacheManager->flushCaches();
		}
	}

	/**
	 * Helper function to uninstall an extension
	 *
	 * @param string $extensionKey
	 * @throws \TYPO3\CMS\Extensionmanager\Exception\ExtensionManagerException
	 * @return void
	 */
	public function uninstall($extensionKey) {
		$dependentExtensions = $this->dependencyUtility->findInstalledExtensionsThatDependOnMe($extensionKey);
		if (is_array($dependentExtensions) && count($dependentExtensions) > 0) {
			throw new \TYPO3\CMS\Extensionmanager\Exception\ExtensionManagerException(
				\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
					'extensionList.uninstall.dependencyError',
					'extensionmanager',
					array($extensionKey, implode(',', $dependentExtensions))
				),
				1342554622
			);
		} else {
			$this->unloadExtension($extensionKey);
		}
	}

	/**
	 * Wrapper function to check for loaded extensions
	 *
	 * @param string $extensionKey
	 * @return boolean TRUE if extension is loaded
	 */
	public function isLoaded($extensionKey) {
		return $this->packageManager->isPackageActive($extensionKey);
	}

	/**
	 * Wrapper function for loading extensions
	 *
	 * @param string $extensionKey
	 * @return void
	 */
	protected function loadExtension($extensionKey) {
		$this->packageManager->activatePackage($extensionKey);
	}

	/**
	 * Wrapper function for unloading extensions
	 *
	 * @param string $extensionKey
	 * @return void
	 */
	protected function unloadExtension($extensionKey) {
		$this->packageManager->deactivatePackage($extensionKey);
		$this->reloadCaches();
	}

	/**
	 * Checks if an extension is available in the system
	 *
	 * @param $extensionKey
	 * @return boolean
	 */
	public function isAvailable($extensionKey) {
		return $this->packageManager->isPackageAvailable($extensionKey);
	}

	/**
	 * Fetch additional information for an extension key
	 *
	 * @param string $extensionKey
	 * @access private
	 * @return array
	 * @throws \TYPO3\CMS\Extensionmanager\Exception\ExtensionManagerException
	 */
	public function enrichExtensionWithDetails($extensionKey) {
		$availableExtensions = $this->listUtility->getAvailableExtensions();
		if (isset($availableExtensions[$extensionKey])) {
			$extension = $availableExtensions[$extensionKey];
		} else {
			throw new \TYPO3\CMS\Extensionmanager\Exception\ExtensionManagerException('Extension ' . $extensionKey . ' is not available', 1342864081);
		}
		$availableAndInstalledExtensions = $this->listUtility->enrichExtensionsWithEmConfAndTerInformation(array($extensionKey => $extension));

		if (!isset($availableAndInstalledExtensions[$extensionKey])) {
			throw new \TYPO3\CMS\Extensionmanager\Exception\ExtensionManagerException(
				'Please check your uploaded extension "' . $extensionKey . '". The configuration file "ext_emconf.php" seems to be invalid.',
				1391432222
			);
		}

		return $availableAndInstalledExtensions[$extensionKey];
	}

	/**
	 * Creates directories as requested in ext_emconf.php
	 *
	 * @param array $extension
	 */
	protected function ensureConfiguredDirectoriesExist(array $extension) {
		$this->fileHandlingUtility->ensureConfiguredDirectoriesExist($extension);
	}

	/**
	 * Gets the content of the ext_tables.sql and ext_tables_static+adt.sql files
	 * Additionally adds the table definitions for the cache tables
	 *
	 * @param array $extension
	 */
	public function processDatabaseUpdates(array $extension) {
		$extTablesSqlFile = PATH_site . $extension['siteRelPath'] . '/ext_tables.sql';
		$extTablesSqlContent = '';
		if (file_exists($extTablesSqlFile)) {
			$extTablesSqlContent .= \TYPO3\CMS\Core\Utility\GeneralUtility::getUrl($extTablesSqlFile);
		}
		if ($extTablesSqlContent !== '') {
			$this->updateDbWithExtTablesSql($extTablesSqlContent);
		}

		$this->importStaticSqlFile($extension['siteRelPath']);
		$this->importT3DFile($extension['siteRelPath']);
	}

	/**
	 * Gets all database updates due to runtime configuration, like caching framework or
	 * category api for example
	 *
	 * @param string $extensionKey
	 */
	protected function processRuntimeDatabaseUpdates($extensionKey) {
		$sqlString = $this->emitTablesDefinitionIsBeingBuiltSignal($extensionKey);
		if (!empty($sqlString)) {
			$this->updateDbWithExtTablesSql(implode(LF . LF . LF . LF, $sqlString));
		}
	}

	/**
	 * Emits a signal to manipulate the tables definitions
	 *
	 * @param string $extensionKey
	 * @return mixed
	 * @throws \TYPO3\CMS\Extensionmanager\Exception\ExtensionManagerException
	 */
	protected function emitTablesDefinitionIsBeingBuiltSignal($extensionKey) {
		$signalReturn = $this->signalSlotDispatcher->dispatch(__CLASS__, 'tablesDefinitionIsBeingBuilt', array('sqlString' => array(), 'extensionKey' => $extensionKey));
		$sqlString = $signalReturn['sqlString'];
		if (!is_array($sqlString)) {
			throw new \TYPO3\CMS\Extensionmanager\Exception\ExtensionManagerException(
				sprintf(
					'The signal %s of class %s returned a value of type %s, but array was expected.',
					'tablesDefinitionIsBeingBuilt',
					__CLASS__,
					gettype($sqlString)
				),
				1382360258
			);
		}
		return $sqlString;
	}

	/**
	 * Reload Cache files and Typo3LoadedExtensions
	 *
	 * @return void
	 */
	public function reloadCaches() {
		$this->cacheManager->flushCachesInGroup('system');
		\TYPO3\CMS\Core\Core\Bootstrap::getInstance()->reloadTypo3LoadedExtAndClassLoaderAndExtLocalconf()->loadExtensionTables();
	}

	/**
	 * Save default configuration of an extension
	 *
	 * @param string $extensionKey
	 * @return void
	 */
	protected function saveDefaultConfiguration($extensionKey) {
		/** @var $configUtility \TYPO3\CMS\Extensionmanager\Utility\ConfigurationUtility */
		$configUtility = $this->objectManager->get('TYPO3\\CMS\\Extensionmanager\\Utility\\ConfigurationUtility');
		$configUtility->saveDefaultConfiguration($extensionKey);
	}

	/**
	 * Update database / process db updates from ext_tables
	 *
	 * @param string $rawDefinitions The raw SQL statements from ext_tables.sql
	 * @return void
	 */
	public function updateDbWithExtTablesSql($rawDefinitions) {
		$fieldDefinitionsFromFile = $this->installToolSqlParser->getFieldDefinitions_fileContent($rawDefinitions);
		if (count($fieldDefinitionsFromFile)) {
			$fieldDefinitionsFromCurrentDatabase = $this->installToolSqlParser->getFieldDefinitions_database();
			$diff = $this->installToolSqlParser->getDatabaseExtra($fieldDefinitionsFromFile, $fieldDefinitionsFromCurrentDatabase);
			$updateStatements = $this->installToolSqlParser->getUpdateSuggestions($diff);
			foreach ((array) $updateStatements['add'] as $string) {
				$GLOBALS['TYPO3_DB']->adminQuery($string);
			}
			foreach ((array) $updateStatements['change'] as $string) {
				$GLOBALS['TYPO3_DB']->adminQuery($string);
			}
			foreach ((array) $updateStatements['create_table'] as $string) {
				$GLOBALS['TYPO3_DB']->adminQuery($string);
			}
		}
	}

	/**
	 * Import static SQL data (normally used for ext_tables_static+adt.sql)
	 *
	 * @param string $rawDefinitions
	 * @return void
	 */
	public function importStaticSql($rawDefinitions) {
		$statements = $this->installToolSqlParser->getStatementarray($rawDefinitions, 1);
		list($statementsPerTable, $insertCount) = $this->installToolSqlParser->getCreateTables($statements, 1);
		// Traverse the tables
		foreach ($statementsPerTable as $table => $query) {
			$GLOBALS['TYPO3_DB']->adminQuery('DROP TABLE IF EXISTS ' . $table);
			$GLOBALS['TYPO3_DB']->adminQuery($query);
			if ($insertCount[$table]) {
				$insertStatements = $this->installToolSqlParser->getTableInsertStatements($statements, $table);
				foreach ($insertStatements as $statement) {
					$GLOBALS['TYPO3_DB']->adminQuery($statement);
				}
			}
		}
	}

	/**
	 * Remove an extension (delete the directory)
	 *
	 * @param string $extension
	 * @throws \TYPO3\CMS\Extensionmanager\Exception\ExtensionManagerException
	 * @return void
	 */
	public function removeExtension($extension) {
		$absolutePath = $this->fileHandlingUtility->getAbsoluteExtensionPath($extension);
		if ($this->fileHandlingUtility->isValidExtensionPath($absolutePath)) {
			$this->fileHandlingUtility->removeDirectory($absolutePath);
		} else {
			throw new \TYPO3\CMS\Extensionmanager\Exception\ExtensionManagerException('No valid extension path given.', 1342875724);
		}
	}

	/**
	 * Get the data dump for an extension
	 *
	 * @param string $extension
	 * @return array
	 */
	public function getExtensionSqlDataDump($extension) {
		$extension = $this->enrichExtensionWithDetails($extension);
		$filePrefix = PATH_site . $extension['siteRelPath'];
		$sqlData['extTables'] = $this->getSqlDataDumpForFile($filePrefix . '/ext_tables.sql');
		$sqlData['staticSql'] = $this->getSqlDataDumpForFile($filePrefix . '/ext_tables_static+adt.sql');
		return $sqlData;
	}

	/**
	 * Gets the sql data dump for a specific sql file (for example ext_tables.sql)
	 *
	 * @param string $sqlFile
	 * @return string
	 */
	protected function getSqlDataDumpForFile($sqlFile) {
		$sqlData = '';
		if (file_exists($sqlFile)) {
			$sqlContent = \TYPO3\CMS\Core\Utility\GeneralUtility::getUrl($sqlFile);
			$fieldDefinitions = $this->installToolSqlParser->getFieldDefinitions_fileContent($sqlContent);
			$sqlData = $this->databaseUtility->dumpStaticTables($fieldDefinitions);
		}
		return $sqlData;
	}

	/**
	 * Checks if an update for an extension is available
	 *
	 * @internal
	 * @param \TYPO3\CMS\Extensionmanager\Domain\Model\Extension $extensionData
	 * @return boolean
	 */
	public function isUpdateAvailable(\TYPO3\CMS\Extensionmanager\Domain\Model\Extension $extensionData) {
		$isUpdateAvailable = FALSE;
		// Only check for update for TER extensions
		$version = $extensionData->getIntegerVersion();
		/** @var $highestTerVersionExtension \TYPO3\CMS\Extensionmanager\Domain\Model\Extension */
		$highestTerVersionExtension = $this->extensionRepository->findHighestAvailableVersion($extensionData->getExtensionKey());
		if ($highestTerVersionExtension instanceof \TYPO3\CMS\Extensionmanager\Domain\Model\Extension) {
			$highestVersion = $highestTerVersionExtension->getIntegerVersion();
			if ($highestVersion > $version) {
				try {
					$this->dependencyUtility->buildExtensionDependenciesTree($highestTerVersionExtension);
					$isUpdateAvailable = TRUE;
				} catch (\TYPO3\CMS\Extensionmanager\Exception\ExtensionManagerException $e) {
				}
			}
		}
		return $isUpdateAvailable;
	}

	/**
	 * Uses the export import extension to import a T3DFile to PID 0
	 * Execution state is saved in the this->registry, so it only happens once
	 *
	 * @param string $extensionSiteRelPath
	 * @return void
	 */
	protected function importT3DFile($extensionSiteRelPath) {
		$t3dImportRelFile = $extensionSiteRelPath . '/Initialisation/data.t3d';
		if (!$this->registry->get('extensionDataImport', $t3dImportRelFile)) {
			$t3dImportFile = PATH_site . $t3dImportRelFile;
			if (file_exists($t3dImportFile)) {
				$importExportUtility = $this->objectManager->get('TYPO3\\CMS\\Impexp\\Utility\\ImportExportUtility');
				try {
					$importResult = $importExportUtility->importT3DFile($t3dImportFile, 0);
					$this->registry->set('extensionDataImport', $t3dImportRelFile, 1);
					$this->signalSlotDispatcher->dispatch(__CLASS__, 'afterExtensionT3DImport', array($t3dImportRelFile, $importResult, $this));
				} catch (\ErrorException $e) {
					/** @var \TYPO3\CMS\Core\Log\Logger $logger */
					$logger = $this->objectManager->get('TYPO3\\CMS\\Core\\Log\\LogManager')->getLogger(__CLASS__);
					$logger->log(\TYPO3\CMS\Core\Log\LogLevel::WARNING, $e->getMessage());
				}
			}
		}
	}

	/**
	 * Imports a static tables SQL File (ext_tables_static+adt)
	 * Execution state is saved in the this->registry, so it only happens once
	 *
	 * @param string $extensionSiteRelPath
	 * @return void
	 */
	protected function importStaticSqlFile($extensionSiteRelPath) {
		$extTablesStaticSqlRelFile = $extensionSiteRelPath . '/ext_tables_static+adt.sql';
		if (!$this->registry->get('extensionDataImport', $extTablesStaticSqlRelFile)) {
			$extTablesStaticSqlFile = PATH_site . $extTablesStaticSqlRelFile;
			if (file_exists($extTablesStaticSqlFile)) {
				$extTablesStaticSqlContent = \TYPO3\CMS\Core\Utility\GeneralUtility::getUrl($extTablesStaticSqlFile);
				$this->importStaticSql($extTablesStaticSqlContent);
			}
			$this->registry->set('extensionDataImport', $extTablesStaticSqlRelFile, 1);
			$this->signalSlotDispatcher->dispatch(__CLASS__, 'afterExtensionStaticSqlImport', array($extTablesStaticSqlRelFile, $this));
		}
	}

	/**
	 * Imports files from Initialisation/Files to fileadmin
	 * via lowlevel copy directory method
	 *
	 * @param string $extensionSiteRelPath relative path to extension dir
	 * @param string $extensionKey
	 */
	protected function importInitialFiles($extensionSiteRelPath, $extensionKey) {
		$importRelFolder = $extensionSiteRelPath . '/Initialisation/Files';
		if (!$this->registry->get('extensionDataImport', $importRelFolder)) {
			$importFolder = PATH_site . $importRelFolder;
			if (file_exists($importFolder)) {
				$destinationRelPath = $GLOBALS['TYPO3_CONF_VARS']['BE']['fileadminDir'] . $extensionKey;
				$destinationAbsolutePath = PATH_site . $destinationRelPath;
				if (!file_exists($destinationAbsolutePath) &&
					\TYPO3\CMS\Core\Utility\GeneralUtility::isAllowedAbsPath($destinationAbsolutePath)
				) {
					\TYPO3\CMS\Core\Utility\GeneralUtility::mkdir($destinationAbsolutePath);
				}
				\TYPO3\CMS\Core\Utility\GeneralUtility::copyDirectory($importRelFolder, $destinationRelPath);
				$this->registry->set('extensionDataImport', $importRelFolder, 1);
				$this->signalSlotDispatcher->dispatch(__CLASS__, 'afterExtensionFileImport', array($destinationAbsolutePath, $this));
			}
		}
	}
}
