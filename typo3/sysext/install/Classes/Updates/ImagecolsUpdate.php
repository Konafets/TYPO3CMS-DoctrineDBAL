<?php
namespace TYPO3\CMS\Install\Updates;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2008-2013 Steffen Kamper <info@sk-typo3.de>
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
 * Contains the update class for merging advanced and normal pagetype.
 *
 * @author Steffen Kamper <info@sk-typo3.de>
 */
class ImagecolsUpdate extends AbstractUpdate {

	/**
	 * @var string
	 */
	protected $title = 'Update Existing Text with Image Content Elements';

	/**
	 * Checks if an update is needed
	 *
	 * @param string &$description The description for the update
	 * @return boolean Whether an update is needed (TRUE) or not (FALSE)
	 */
	public function checkForUpdate(&$description) {
		$result = FALSE;
		$description = 'Sets tt_content.imagecols = 1 to all entries having "0". This is needed to have a valid value for imagecols.';
		if ($this->versionNumber >= 4003000) {
			$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery('uid', 'tt_content', 'CTYPE IN (\'textpic\', \'image\') AND imagecols=0', '', '', '1');
			if ($GLOBALS['TYPO3_DB']->sql_num_rows($res)) {
				$result = TRUE;
			}
			$GLOBALS['TYPO3_DB']->sql_free_result($res);
		}
		return $result;
	}

	/**
	 * Performs the database update. Changes the doktype from 2 (advanced) to 1 (standard)
	 *
	 * @param array &$dbQueries Queries done in this update
	 * @param mixed &$customMessages Custom messages
	 * @return boolean Whether it worked (TRUE) or not (FALSE)
	 */
	public function performUpdate(array &$dbQueries, &$customMessages) {
		$result = FALSE;
		if ($this->versionNumber >= 4003000) {
			$query = $GLOBALS['TYPO3_DB']->createUpdateQuery();
			$query->update('tt_content')
					->set('imagecols', 1)
					->where(
						$query->expr->in('ctype', array('textpic', 'image')),
						$query->expr->equals('imagecols', $query->bindValue(0))
					)->execute();
			$dbQueries[] = str_replace(chr(10), ' ', $GLOBALS['TYPO3_DB']->debug_lastBuiltQuery);
			if ($GLOBALS['TYPO3_DB']->sqlErrorMessage()) {
				$customMessages = 'SQL-ERROR: ' . htmlspecialchars($GLOBALS['TYPO3_DB']->sqlErrorMessage());
			} else {
				$result = TRUE;
			}
		}
		return $result;
	}

}
