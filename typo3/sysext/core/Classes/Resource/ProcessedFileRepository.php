<?php
namespace TYPO3\CMS\Core\Resource;
use \TYPO3\CMS\Core\Utility;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2012-2013 Benjamin Mack <benni@typo3.org>
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
 * Repository for accessing files
 * it also serves as the public API for the indexing part of files in general
 *
 * @author Benjamin Mack <benni@typo3.org>
 * @author Ingmar Schlecht <ingmar@typo3.org>
 */
class ProcessedFileRepository extends AbstractRepository {

	/**
	 * The main object type of this class. In some cases (fileReference) this
	 * repository can also return FileReference objects, implementing the
	 * common FileInterface.
	 *
	 * @var string
	 */
	protected $objectType = 'TYPO3\\CMS\\Core\\Resource\\ProcessedFile';

	/**
	 * Main File object storage table. Note that this repository also works on
	 * the sys_file_reference table when returning FileReference objects.
	 *
	 * @var string
	 */
	protected $table = 'sys_file_processedfile';

	/**
	 * @var ResourceFactory
	 */
	protected $resourceFactory;

	/**
	 * @var \TYPO3\CMS\Core\Database\DatabaseConnection
	 */
	protected $databaseConnection;

	/**
	 * Creates this object.
	 */
	public function __construct() {
		$this->resourceFactory = Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Resource\\ResourceFactory');
		$this->databaseConnection = $GLOBALS['TYPO3_DB'];
	}

	/**
	 * Creates a ProcessedFile object from a file object and a processing configuration
	 *
	 * @param FileInterface $originalFile
	 * @param string $taskType
	 * @param array $configuration
	 * @return ProcessedFile
	 */
	public function createNewProcessedFileObject(FileInterface $originalFile, $taskType, array $configuration) {
		return Utility\GeneralUtility::makeInstance(
			$this->objectType,
			$originalFile,
			$taskType,
			$configuration
		);
	}

	/**
	 * @param array $databaseRow
	 * @return ProcessedFile
	 */
	protected function createDomainObject(array $databaseRow) {
		$originalFile = $this->resourceFactory->getFileObject((int)$databaseRow['original']);
		$originalFile->setStorage($this->resourceFactory->getStorageObject($originalFile->getProperty('storage')));
		$taskType = $databaseRow['task_type'];
		$configuration = unserialize($databaseRow['configuration']);

		return Utility\GeneralUtility::makeInstance(
			$this->objectType,
			$originalFile,
			$taskType,
			$configuration,
			$databaseRow
		);
	}

	/**
	 * Adds a processedfile object in the database
	 *
	 * @param ProcessedFile $processedFile
	 * @return void
	 */
	public function add($processedFile) {
		if ($processedFile->isPersisted()) {
			$this->update($processedFile);
		} else {
			$insertFields = $processedFile->toArray();
			$insertFields['crdate'] = $insertFields['tstamp'] = time();
			$insertFields = $this->cleanUnavailableColumns($insertFields);
			$this->databaseConnection->executeInsertQuery($this->table, $insertFields);
			$uid = $this->databaseConnection->getLastInsertId();
			$processedFile->updateProperties(array('uid' => $uid));
		}
	}

	/**
	 * Updates an existing file object in the database
	 *
	 * @param ProcessedFile $processedFile
	 * @return void
	 */
	public function update($processedFile) {
		if ($processedFile->isPersisted()) {
			$uid = (int)$processedFile->getUid();
			$updateFields = $this->cleanUnavailableColumns($processedFile->toArray());
			$updateFields['tstamp'] = time();
			$GLOBALS['TYPO3_DB']->executeUpdateQuery($this->table, array('uid' => (int)$uid), $updateFields);
		}
	}

	/**
	 * @param \TYPO3\CMS\Core\Resource\File|\TYPO3\CMS\Core\Resource\FileInterface $file
	 * @param string $taskType The task that should be executed on the file
	 * @param array $configuration
	 *
	 * @return ProcessedFile
	 */
	public function findOneByOriginalFileAndTaskTypeAndConfiguration(FileInterface $file, $taskType, array $configuration) {
		$databaseRow = $this->databaseConnection->exec_SELECTgetSingleRow(
			'*',
			$this->table,
			'original=' . (int)$file->getUid() .
				' AND task_type=' . $this->databaseConnection->fullQuoteStr($taskType, $this->table) .
				' AND configurationsha1=' . $this->databaseConnection->fullQuoteStr(sha1(serialize($configuration)), $this->table)
		);

		if (is_array($databaseRow)) {
			$processedFile = $this->createDomainObject($databaseRow);
		} else {
			$processedFile = $this->createNewProcessedFileObject($file, $taskType, $configuration);
		}
		return $processedFile;
	}

	/**
	 * @param FileInterface $file
	 * @return ProcessedFile[]
	 * @throws \InvalidArgumentException
	 */
	public function findAllByOriginalFile(FileInterface $file) {
		if (!$file instanceof File) {
			throw new \InvalidArgumentException('Parameter is no File object but got type "'
				. (is_object($file) ? get_class($file) : gettype($file)) . '"', 1382006142);
		}
		$whereClause = 'original=' . (int)$file->getUid() . $this->getWhereClauseForEnabledFields();
		$rows = $this->databaseConnection->exec_SELECTgetRows('*', $this->table, $whereClause);

		$itemList = array();
		if ($rows !== NULL) {
			foreach ($rows as $row) {
				$itemList[] = $this->createDomainObject($row);
			}
		}
		return $itemList;
	}


	/**
	 * Removes all array keys which cannot be persisted
	 *
	 * @param array $data
	 *
	 * @return array
	 */
	protected function cleanUnavailableColumns(array $data) {
		return array_intersect_key($data, $this->databaseConnection->listFields($this->table));
	}
}
