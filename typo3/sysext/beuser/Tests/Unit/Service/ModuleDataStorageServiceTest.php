<?php
namespace TYPO3\CMS\Beuser\Tests\Unit\Service;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2012 Felix Kopp <felix-source@phorax.com>
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
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * Test case
 *
 * @author Felix Kopp <felix-source@phorax.com>
 * @author Nikolas Hagelstein <nikolas.hagelstein@gmail.com>
 */
class ModuleDataStorageServiceTest extends \TYPO3\CMS\Extbase\Tests\Unit\BaseTestCase {

	/**
	 * @test
	 */
	public function loadModuleDataReturnsModuleDataObjectForEmptyModuleData() {
		// Simulate empty module data
		$GLOBALS['BE_USER'] = $this->getMock('TYPO3\\CMS\\Core\\Authentication\\BackendUserAuthentication', array(), array(), '', FALSE);
		$GLOBALS['BE_USER']->uc = array();
		$GLOBALS['BE_USER']->uc['moduleData'] = array();

		/** @var \TYPO3\CMS\Beuser\Service\ModuleDataStorageService $subject */
		$subject = $this->objectManager->get('TYPO3\\CMS\\Beuser\\Service\\ModuleDataStorageService');
		$this->assertInstanceOf('TYPO3\\CMS\\Beuser\\Domain\\Model\\ModuleData', $subject->loadModuleData());
	}
}
