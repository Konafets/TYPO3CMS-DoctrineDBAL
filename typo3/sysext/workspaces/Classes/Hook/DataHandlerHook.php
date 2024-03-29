<?php
namespace TYPO3\CMS\Workspaces\Hook;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2010-2013 Workspaces Team (http://forge.typo3.org/projects/show/typo3v4-workspaces)
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

use TYPO3\CMS\Backend\Utility\BackendUtility;

/**
 * Tcemain service
 *
 * @author Workspaces Team (http://forge.typo3.org/projects/show/typo3v4-workspaces)
 */
class DataHandlerHook {

	/**
	 * In case a sys_workspace_stage record is deleted we do a hard reset
	 * for all existing records in that stage to avoid that any of these end up
	 * as orphan records.
	 *
	 * @param string $command
	 * @param string $table
	 * @param string $id
	 * @param string $value
	 * @param \TYPO3\CMS\Core\DataHandling\DataHandler $tcemain
	 * @return void
	 */
	public function processCmdmap_postProcess($command, $table, $id, $value, \TYPO3\CMS\Core\DataHandling\DataHandler $tcemain) {
		if ($command === 'delete') {
			if ($table === \TYPO3\CMS\Workspaces\Service\StagesService::TABLE_STAGE) {
				$this->resetStageOfElements($id);
			} elseif ($table === \TYPO3\CMS\Workspaces\Service\WorkspaceService::TABLE_WORKSPACE) {
				$this->flushWorkspaceElements($id);
			}
		}
	}

	/**
	 * hook that is called AFTER all commands of the commandmap was
	 * executed
	 *
	 * @param \TYPO3\CMS\Core\DataHandling\DataHandler $tcemainObj reference to the main tcemain object
	 * @return 	void
	 */
	public function processCmdmap_afterFinish(\TYPO3\CMS\Core\DataHandling\DataHandler $tcemainObj) {
		$this->flushWorkspaceCacheEntriesByWorkspaceId($tcemainObj->BE_USER->workspace);
	}

	/**
	 * In case a sys_workspace_stage record is deleted we do a hard reset
	 * for all existing records in that stage to avoid that any of these end up
	 * as orphan records.
	 *
	 * @param integer $stageId Elements with this stage are resetted
	 * @return void
	 */
	protected function resetStageOfElements($stageId) {
		foreach ($this->getTcaTables() as $tcaTable) {
			if (BackendUtility::isTableWorkspaceEnabled($tcaTable)) {
				$where = array(
					't3ver_stage' => (int)$stageId,

				);

				$query = $GLOBALS['TYPO3_DB']->createUpdateQuery();
				$query->update($tcaTable)
						->set('t3ver_stage', \TYPO3\CMS\Workspaces\Service\StagesService::STAGE_EDIT_ID)
						->where(
							$query->expr->equals('t3ver_stage', (int)$stageId),
							$query->expr->greaterThan('t3ver_wsid', 0),
							$query->expr->equals('pid', -1),
							BackendUtility::deleteClause($tcaTable, '', FALSE)
						)
						->execute();
			}
		}
	}

	/**
	 * Flushes elements of a particular workspace to avoid orphan records.
	 *
	 * @param integer $workspaceId The workspace to be flushed
	 * @return void
	 */
	protected function flushWorkspaceElements($workspaceId) {
		$command = array();
		foreach ($this->getTcaTables() as $tcaTable) {
			if (BackendUtility::isTableWorkspaceEnabled($tcaTable)) {
				$where = '1=1';
				$where .= BackendUtility::getWorkspaceWhereClause($tcaTable, $workspaceId);
				$where .= BackendUtility::deleteClause($tcaTable);
				$records = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows('uid', $tcaTable, $where, '', '', '', 'uid');
				if (is_array($records)) {
					foreach (array_keys($records) as $recordId) {
						$command[$tcaTable][$recordId]['version']['action'] = 'flush';
					}
				}
			}
		}
		if (count($command)) {
			$tceMain = $this->getTceMain();
			$tceMain->start(array(), $command);
			$tceMain->process_cmdmap();
		}
	}

	/**
	 * Gets all defined TCA tables.
	 *
	 * @return array
	 */
	protected function getTcaTables() {
		return array_keys($GLOBALS['TCA']);
	}

	/**
	 * @return \TYPO3\CMS\Core\DataHandling\DataHandler
	 */
	protected function getTceMain() {
		$tceMain = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\DataHandling\\DataHandler');
		$tceMain->stripslashes_values = 0;
		return $tceMain;
	}

	/**
	 * Flushes the workspace cache for current workspace and for the virtual "all workspaces" too.
	 *
	 * @param integer $workspaceId The workspace to be flushed in cache
	 * @return void
	 */
	protected function flushWorkspaceCacheEntriesByWorkspaceId($workspaceId) {
		$workspacesCache = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Cache\\CacheManager')->getCache('workspaces_cache');
		$workspacesCache->flushByTag($workspaceId);
		$workspacesCache->flushByTag(\TYPO3\CMS\Workspaces\Service\WorkspaceService::SELECT_ALL_WORKSPACES);
	}

}
