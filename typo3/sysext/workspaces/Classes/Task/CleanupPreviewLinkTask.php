<?php
namespace TYPO3\CMS\Workspaces\Task;

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
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/
/**
 * This class provides a task to cleanup ol preview links.
 *
 * @author Timo Webler <timo.webler@dkd.de>
 */
class CleanupPreviewLinkTask extends \TYPO3\CMS\Scheduler\Task\AbstractTask {

	/**
	 * Cleanup old preview links.
	 * endtime < $GLOBALS['EXEC_TIME']
	 *
	 * @return 	boolean
	 */
	public function execute() {
		$query = $GLOBALS['TYPO3_DB']->createDeleteQuery();
		$query->delete('sys_preview')
				->where($query->expr->lessThan('endtime', $query->bindValue((int)$GLOBALS['EXEC_TIME'])))
				->execute();

		return TRUE;
	}

}
