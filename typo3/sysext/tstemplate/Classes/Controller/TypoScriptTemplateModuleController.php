<?php
namespace TYPO3\CMS\Tstemplate\Controller;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 1999-2013 Kasper Skårhøj (kasperYYYY@typo3.com)
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

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Backend\Utility\IconUtility;

/**
 * Module: TypoScript Tools
 *
 * $TYPO3_CONF_VARS["MODS"]["web_ts"]["onlineResourceDir"]  = Directory of default resources. Eg. "fileadmin/res/" or so.
 *
 * @author Kasper Skårhøj <kasperYYYY@typo3.com>
 */
class TypoScriptTemplateModuleController extends \TYPO3\CMS\Backend\Module\BaseScriptClass {

	/**
	 * @todo Define visibility
	 */
	public $perms_clause;

	/**
	 * @todo Define visibility
	 */
	public $e;

	/**
	 * @todo Define visibility
	 */
	public $sObj;

	/**
	 * @todo Define visibility
	 */
	public $edit;

	/**
	 * @todo Define visibility
	 */
	public $textExtensions = 'html,htm,txt,css,tmpl,inc,js';

	/**
	 * @todo Define visibility
	 */
	public $modMenu_type = '';

	/**
	 * @todo Define visibility
	 */
	public $modMenu_dontValidateList = '';

	/**
	 * @todo Define visibility
	 */
	public $modMenu_setDefaultList = '';

	/**
	 * Constructor
	 */
	public function __construct() {
		$GLOBALS['LANG']->includeLLFile('EXT:tstemplate/ts/locallang.xlf');
		$GLOBALS['BE_USER']->modAccess($GLOBALS['MCONF'], TRUE);
	}

	/**
	 * Init
	 *
	 * @return void
	 * @todo Define visibility
	 */
	public function init() {
		parent::init();
		$this->id = (int)GeneralUtility::_GP('id');
		$this->e = GeneralUtility::_GP('e');
		$this->sObj = GeneralUtility::_GP('sObj');
		$this->edit = GeneralUtility::_GP('edit');
		$this->perms_clause = $GLOBALS['BE_USER']->getPagePermsClause(1);
	}

	/**
	 * Clear cache
	 *
	 * @return void
	 * @todo Define visibility
	 */
	public function clearCache() {
		if (GeneralUtility::_GP('clear_all_cache')) {
			$tce = GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\DataHandling\\DataHandler');
			/** @var $tce \TYPO3\CMS\Core\DataHandling\DataHandler */
			$tce->stripslashes_values = 0;
			$tce->start(array(), array());
			$tce->clear_cacheCmd('all');
		}
	}

	/**
	 * Main
	 *
	 * @return void
	 * @todo Define visibility
	 */
	public function main() {
		// Template markers
		$markers = array(
			'CSH' => '',
			'FUNC_MENU' => '',
			'CONTENT' => ''
		);

		// Access check...
		// The page will show only if there is a valid page and if this page may be viewed by the user
		$this->pageinfo = BackendUtility::readPageAccess($this->id, $this->perms_clause);
		$this->access = is_array($this->pageinfo) ? 1 : 0;
		$this->doc = GeneralUtility::makeInstance('TYPO3\\CMS\\Backend\\Template\\DocumentTemplate');
		$this->doc->backPath = $GLOBALS['BACK_PATH'];
		$this->doc->setModuleTemplate('EXT:tstemplate/Resources/Private/Templates/tstemplate.html');

		if ($this->id && $this->access) {
			$urlParameters = array(
				'id' => $this->id,
				'template' => 'all'
			);
			$aHref = BackendUtility::getModuleUrl('web_ts', $urlParameters);
			$this->doc->form = '<form action="' . htmlspecialchars($aHref) . '" method="post" enctype="' . $GLOBALS['TYPO3_CONF_VARS']['SYS']['form_enctype'] . '" name="editForm">';

			// JavaScript
			$this->doc->JScode = '
		<script language="javascript" type="text/javascript">
			function uFormUrl(aname) {
				document.forms[0].action = ' . GeneralUtility::quoteJSvalue(($aHref . '#'), TRUE) . '+aname;
			}
			function brPoint(lnumber,t) {
				window.location.href = ' . GeneralUtility::quoteJSvalue(($aHref . '&SET[function]=TYPO3\\CMS\\Tstemplate\\Controller\\TypoScriptTemplateObjectBrowserModuleFunctionController&SET[ts_browser_type]='), TRUE) . '+(t?"setup":"const")+"&breakPointLN="+lnumber;
				return false;
			}
		</script>
		';
			$this->doc->postCode = '
		<script language="javascript" type="text/javascript">
			if (top.fsMod) top.fsMod.recentIds["web"] = ' . $this->id . ';
		</script>
		';
			$this->doc->inDocStylesArray[] = '
				TABLE#typo3-objectBrowser { width: 100%; margin-bottom: 24px; }
				TABLE#typo3-objectBrowser A { text-decoration: none; }
				TABLE#typo3-objectBrowser .comment { color: maroon; font-weight: bold; }
				.ts-typoscript { width: 100%; }
				.tsob-menu label, .tsob-menu-row2 label, .tsob-conditions label { padding: 0 5px 0 0; vertical-align: text-top;}
				.tsob-menu-row2 {margin-top: 10px;}
				.tsob-conditions {padding: 1px 2px;}
				.tsob-search-submit {margin-left: 3px; margin-right: 3px;}
				.tst-analyzer-options { margin:5px 0; }
				.tst-analyzer-options label {padding-left:5px; vertical-align:text-top; }
			';
			// Setting up the context sensitive menu:
			$this->doc->getContextMenuCode();
			// Build the modulle content
			$this->content = $this->doc->header($GLOBALS['LANG']->getLL('moduleTitle'));
			$this->extObjContent();
			// Setting up the buttons and markers for docheader
			$docHeaderButtons = $this->getButtons();
			$markers['FUNC_MENU'] = BackendUtility::getFuncMenu($this->id, 'SET[function]', $this->MOD_SETTINGS['function'], $this->MOD_MENU['function']);
			$markers['CONTENT'] = $this->content;
		} else {
			// Template pages:
			$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery('pages.uid, count(*) AS count, max(sys_template.root) AS root_max_val, min(sys_template.root) AS root_min_val', 'pages,sys_template', 'pages.uid=sys_template.pid' . BackendUtility::deleteClause('pages') . BackendUtility::versioningPlaceholderClause('pages') . BackendUtility::deleteClause('sys_template') . BackendUtility::versioningPlaceholderClause('sys_template'), 'pages.uid');
			$templateArray = array();
			$pArray = array();
			while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {
				$this->setInPageArray($pArray, BackendUtility::BEgetRootLine($row['uid'], 'AND 1=1'), $row);
			}
			$GLOBALS['TYPO3_DB']->freeResult($res);

			$table = '<table class="t3-table" id="ts-overview">' .
					'<thead>' .
					'<tr>' .
					'<th>' . $GLOBALS['LANG']->getLL('pageName') . '</th>' .
					'<th>' . $GLOBALS['LANG']->getLL('templates') . '</th>' .
					'<th>' . $GLOBALS['LANG']->getLL('isRoot') . '</th>' .
					'<th>' . $GLOBALS['LANG']->getLL('isExt') . '</th>' .
					'</tr>' .
					'</thead>' .
					'<tbody>' . implode('', $this->renderList($pArray)) . '</tbody>' .
					'</table>';

			$this->content = $this->doc->header($GLOBALS['LANG']->getLL('moduleTitle'));
			$this->content .= $this->doc->section('', '<p class="lead">' . $GLOBALS['LANG']->getLL('overview') . '</p>' . $table);

			// RENDER LIST of pages with templates, END
			// Setting up the buttons and markers for docheader
			$docHeaderButtons = $this->getButtons();
			$markers['CONTENT'] = $this->content;
		}

		// Build the <body> for the module
		$this->content = $this->doc->moduleBody($this->pageinfo, $docHeaderButtons, $markers);
		// Renders the module page
		$this->content = $this->doc->render('Template Tools', $this->content);
	}

	/**
	 * Print content
	 *
	 * @return void
	 * @todo Define visibility
	 */
	public function printContent() {
		echo $this->content;
	}

	/**
	 * Create the panel of buttons for submitting the form or otherwise perform operations.
	 *
	 * @return array All available buttons as an assoc. array
	 */
	protected function getButtons() {
		$buttons = array(
			'back' => '',
			'close' => '',
			'new' => '',
			'save' => '',
			'save_close' => '',
			'view' => '',
			'shortcut' => ''
		);

		if ($this->id && $this->access) {
			// View page
			$buttons['view'] = '<a href="#" onclick="' . htmlspecialchars(BackendUtility::viewOnClick($this->pageinfo['uid'], $GLOBALS['BACK_PATH'], BackendUtility::BEgetRootLine($this->pageinfo['uid']))) . '" title="' . $GLOBALS['LANG']->sL('LLL:EXT:lang/locallang_core.xlf:labels.showPage', TRUE) . '">' . IconUtility::getSpriteIcon('actions-document-view') . '</a>';
			if ($this->extClassConf['name'] == 'TYPO3\CMS\Tstemplate\Controller\TypoScriptTemplateInformationModuleFunctionController') {
				// NEW button
				$buttons['new'] = '<input type="image" class="c-inputButton" name="createExtension" value="New"' . IconUtility::skinImg($GLOBALS['BACK_PATH'], 'gfx/new_el.gif', '') . ' title="' . $GLOBALS['LANG']->sL('LLL:EXT:lang/locallang_core.xlf:db_new.php.pagetitle', TRUE) . '" />';
				if (!empty($this->e) && !GeneralUtility::_POST('abort') && !GeneralUtility::_POST('saveclose')) {
					// no NEW-button while edit
					$buttons['new'] = '';
					// SAVE button
					$buttons['save'] = IconUtility::getSpriteIcon('actions-document-save', array(
						'html' => '<input type="image" class="c-inputButton" name="submit" src="clear.gif" ' . 'title="' . $GLOBALS['LANG']->sL('LLL:EXT:lang/locallang_core.xlf:rm.saveDoc', TRUE) . '" ' . 'value="' . $GLOBALS['LANG']->sL('LLL:EXT:lang/locallang_core.xlf:rm.saveDoc', TRUE) . '" ' . '/>'
					));
					// SAVE AND CLOSE button
					$buttons['save_close'] = IconUtility::getSpriteIcon('actions-document-save-close', array(
						'html' => '<input type="image" class="c-inputButton" name="saveclose" src="clear.gif" ' . 'title="' . $GLOBALS['LANG']->sL('LLL:EXT:lang/locallang_core.xlf:rm.saveCloseDoc', TRUE) . '" ' . 'value="' . $GLOBALS['LANG']->sL('LLL:EXT:lang/locallang_core.xlf:rm.saveCloseDoc', TRUE) . '" ' . '/>'
					));
					// CLOSE button
					$buttons['close'] = IconUtility::getSpriteIcon('actions-document-close', array(
						'html' => '<input type="image" class="c-inputButton" name="abort" src="clear.gif" ' . 'title="' . $GLOBALS['LANG']->sL('LLL:EXT:lang/locallang_core.xlf:rm.closeDoc', TRUE) . '" ' . 'value="' . $GLOBALS['LANG']->sL('LLL:EXT:lang/locallang_core.xlf:rm.closeDoc', TRUE) . '" ' . '/>'
					));
				}
			} elseif ($this->extClassConf['name'] == 'TYPO3\CMS\Tstemplate\Controller\TypoScriptTemplateConstantEditorModuleFunctionController' && count($this->MOD_MENU['constant_editor_cat'])) {
				// SAVE button
				$buttons['save'] = IconUtility::getSpriteIcon('actions-document-save', array('html' => '<input type="image" class="c-inputButton" name="submit" src="clear.gif" ' . 'title="' . $GLOBALS['LANG']->sL('LLL:EXT:lang/locallang_core.xlf:rm.saveDoc', TRUE) . '" ' . 'value="' . $GLOBALS['LANG']->sL('LLL:EXT:lang/locallang_core.xlf:rm.saveDoc', TRUE) . '" ' . '/>'));
			} elseif ($this->extClassConf['name'] == 'TYPO3\CMS\Tstemplate\Controller\TypoScriptTemplateObjectBrowserModuleFunctionController') {
				if (!empty($this->sObj)) {
					// BACK
					$urlParameters = array(
						'id' => $this->id
					);
					$aHref = BackendUtility::getModuleUrl('web_ts', $urlParameters);
					$buttons['back'] = '<a href="' . htmlspecialchars($aHref) . '" class="typo3-goBack" title="' . $GLOBALS['LANG']->sL('LLL:EXT:lang/locallang_core.xlf:labels.goBack', TRUE) . '">' . IconUtility::getSpriteIcon('actions-view-go-back') . '</a>';
				}
			}
			// Shortcut
			if ($GLOBALS['BE_USER']->mayMakeShortcut()) {
				$buttons['shortcut'] = $this->doc->makeShortcutIcon('id, edit_record, pointer, new_unique_uid, search_field, search_levels, showLimit', implode(',', array_keys($this->MOD_MENU)), $this->MCONF['name']);
			}
		} else {
			// Shortcut
			if ($GLOBALS['BE_USER']->mayMakeShortcut()) {
				$buttons['shortcut'] = $this->doc->makeShortcutIcon('id', '', $this->MCONF['name']);
			}
		}
		return $buttons;
	}

	// OTHER FUNCTIONS:
	/**
	 * Wrap title for link in template
	 *
	 * @param string $title
	 * @param string $onlyKey
	 * @return string
	 * @todo Define visibility
	 */
	public function linkWrapTemplateTitle($title, $onlyKey = '') {
		$urlParameters = array(
			'id' => $this->id
		);
		$aHref = BackendUtility::getModuleUrl('web_ts', $urlParameters);
		if ($onlyKey) {
			$title = '<a href="' . htmlspecialchars(($aHref . '&e[' . $onlyKey . ']=1&SET[function]=TYPO3\\CMS\\Tstemplate\\Controller\\TypoScriptTemplateInformationModuleFunctionController')) . '">' . htmlspecialchars($title) . '</a>';
		} else {
			$title = '<a href="' . htmlspecialchars(($aHref . '&e[constants]=1&e[config]=1&SET[function]=TYPO3\\CMS\\Tstemplate\\Controller\\TypoScriptTemplateInformationModuleFunctionController')) . '">' . htmlspecialchars($title) . '</a>';
		}
		return $title;
	}

	/**
	 * No template
	 *
	 * @param integer $newStandardTemplate
	 * @return string
	 * @todo Define visibility
	 */
	public function noTemplate($newStandardTemplate = 0) {
		// Defined global here!
		$tmpl = GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\TypoScript\\ExtendedTemplateService');
		/** @var $tmpl \TYPO3\CMS\Core\TypoScript\ExtendedTemplateService */
		// Do not log time-performance information
		$tmpl->tt_track = FALSE;
		$tmpl->init();
		$theOutput = '';
		$flashMessage = GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Messaging\\FlashMessage', $GLOBALS['LANG']->getLL('noTemplateDescription') . '<br />' . $GLOBALS['LANG']->getLL('createTemplateToEditConfiguration'), $GLOBALS['LANG']->getLL('noTemplate'), \TYPO3\CMS\Core\Messaging\FlashMessage::INFO);
		$theOutput .= $flashMessage->render();
		// New standard?
		if ($newStandardTemplate) {
			// Hook to change output, implemented for statictemplates
			if (isset(
				$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['TYPO3\\CMS\\Tstemplate\\Controller\\TypoScriptTemplateModuleController']['newStandardTemplateView']
			)) {
				$selector = '';
				$staticsText = '';
				$reference = array(
					'selectorHtml' => &$selector,
					'staticsText' => &$staticsText
				);
				GeneralUtility::callUserFunction(
					$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['TYPO3\\CMS\\Tstemplate\\Controller\\TypoScriptTemplateModuleController']['newStandardTemplateView'],
					$reference,
					$this
				);
				$selector = $reference['selectorHtml'];
				$staticsText = $reference['staticsText'];
			} else {
				$selector = '<input type="hidden" name="createStandard" value="" />';
				$staticsText = '';
			}
			// Extension?
			$theOutput .= $this->doc->section($GLOBALS['LANG']->getLL('newWebsite') . $staticsText, $GLOBALS['LANG']->getLL('newWebsiteDescription') . '<br /><br />' . $selector . '<input type="Submit" name="newWebsite" value="' . $GLOBALS['LANG']->getLL('newWebsiteAction') . '" />', 0, 1);
		}
		// Extension?
		$theOutput .= $this->doc->spacer(10);
		$theOutput .= $this->doc->section($GLOBALS['LANG']->getLL('extTemplate'), $GLOBALS['LANG']->getLL('extTemplateDescription') . '<br /><br />' . '<input type="submit" name="createExtension" value="' . $GLOBALS['LANG']->getLL('extTemplateAction') . '" />', 0, 1);
		// Go to first appearing...
		$first = $tmpl->ext_prevPageWithTemplate($this->id, $this->perms_clause);
		if ($first) {
			$theOutput .= $this->doc->spacer(10);
			$urlParameters = array(
				'id' => $first['uid']
			);
			$aHref = BackendUtility::getModuleUrl('web_ts', $urlParameters);
			$theOutput .= $this->doc->section($GLOBALS['LANG']->getLL('goToClosest'), sprintf($GLOBALS['LANG']->getLL('goToClosestDescription') . '<br /><br />%s<strong>' . $GLOBALS['LANG']->getLL('goToClosestAction') . '</strong>%s', htmlspecialchars($first['title']), $first['uid'], '<a href="' . htmlspecialchars($aHref) . '">', '</a>'), 0, 1);
		}
		return $theOutput;
	}

	/**
	 * @todo Define visibility
	 */
	public function templateMenu() {
		// Defined global here!
		$tmpl = GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\TypoScript\\ExtendedTemplateService');
		/** @var $tmpl \TYPO3\CMS\Core\TypoScript\ExtendedTemplateService */
		// Do not log time-performance information
		$tmpl->tt_track = FALSE;
		$tmpl->init();
		$all = $tmpl->ext_getAllTemplates($this->id, $this->perms_clause);
		$menu = '';
		if (count($all) > 1) {
			$this->MOD_MENU['templatesOnPage'] = array();
			foreach ($all as $d) {
				$this->MOD_MENU['templatesOnPage'][$d['uid']] = $d['title'];
			}
		}
		$this->MOD_SETTINGS = BackendUtility::getModuleData($this->MOD_MENU, GeneralUtility::_GP('SET'), $this->MCONF['name'], $this->modMenu_type, $this->modMenu_dontValidateList, $this->modMenu_setDefaultList);
		$menu = BackendUtility::getFuncMenu($this->id, 'SET[templatesOnPage]', $this->MOD_SETTINGS['templatesOnPage'], $this->MOD_MENU['templatesOnPage']);
		return $menu;
	}

	/**
	 * Create template
	 *
	 * @param integer $id
	 * @param integer $actTemplateId
	 * @return string
	 * @todo Define visibility
	 */
	public function createTemplate($id, $actTemplateId = 0) {
		if (GeneralUtility::_GP('createExtension') || GeneralUtility::_GP('createExtension_x')) {
			$tce = GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\DataHandling\\DataHandler');
			/** @var $tce \TYPO3\CMS\Core\DataHandling\DataHandler */
			$tce->stripslashes_values = 0;
			$recData = array();
			$recData['sys_template']['NEW'] = array(
				'pid' => $actTemplateId ? -1 * $actTemplateId : $id,
				'title' => '+ext'
			);
			$tce->start($recData, array());
			$tce->process_datamap();
			return $tce->substNEWwithIDs['NEW'];
		} elseif (GeneralUtility::_GP('newWebsite')) {
			$tce = GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\DataHandling\\DataHandler');
			/** @var $tce \TYPO3\CMS\Core\DataHandling\DataHandler */
			$tce->stripslashes_values = 0;
			$recData = array();
			// Hook to handle row data, implemented for statictemplates
			if (isset(
				$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['TYPO3\\CMS\\Tstemplate\\Controller\\TypoScriptTemplateModuleController']['newStandardTemplateHandler']
			)) {
				$reference = array(
					'recData' => &$recData,
					'id' => $id,
				);
				GeneralUtility::callUserFunction(
					$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['TYPO3\\CMS\\Tstemplate\\Controller\\TypoScriptTemplateModuleController']['newStandardTemplateHandler'],
					$reference,
					$this
				);
				$recData = $reference['recData'];
			} else {
				$recData['sys_template']['NEW'] = array(
					'pid' => $id,
					'title' => $GLOBALS['LANG']->getLL('titleNewSite'),
					'sorting' => 0,
					'root' => 1,
					'clear' => 3,
					'config' => '
# Default PAGE object:
page = PAGE
page.10 = TEXT
page.10.value = HELLO WORLD!
'
				);
			}
			$tce->start($recData, array());
			$tce->process_datamap();
			$tce->clear_cacheCmd('all');
		}
	}

	// RENDER LIST of pages with templates, BEGIN
	/**
	 * Set page in array
	 *
	 * @param array $pArray
	 * @param array $rlArr
	 * @param array $row
	 * @return void
	 * @todo Define visibility
	 */
	public function setInPageArray(&$pArray, $rlArr, $row) {
		ksort($rlArr);
		reset($rlArr);
		if (!$rlArr[0]['uid']) {
			array_shift($rlArr);
		}
		$cEl = current($rlArr);
		$pArray[$cEl['uid']] = htmlspecialchars($cEl['title']);
		array_shift($rlArr);
		if (count($rlArr)) {
			if (!isset($pArray[($cEl['uid'] . '.')])) {
				$pArray[$cEl['uid'] . '.'] = array();
			}
			$this->setInPageArray($pArray[$cEl['uid'] . '.'], $rlArr, $row);
		} else {
			$pArray[$cEl['uid'] . '_'] = $row;
		}
	}

	/**
	 * Render the list
	 *
	 * @param array $pArray
	 * @param array $lines
	 * @param integer $c
	 * @return array
	 * @todo Define visibility
	 */
	public function renderList($pArray, $lines = array(), $c = 0) {
		if (is_array($pArray)) {
			reset($pArray);
			static $i;
			foreach ($pArray as $k => $v) {
				if (\TYPO3\CMS\Core\Utility\MathUtility::canBeInterpretedAsInteger($k)) {
					if (isset($pArray[$k . '_'])) {
						$lines[] = '<tr class="' . ($i++ % 2 == 0 ? 'bgColor4' : 'bgColor6') . '">
							<td nowrap><img src="clear.gif" width="1" height="1" hspace=' . $c * 10 . ' align="top">' . '<a href="' . GeneralUtility::linkThisScript(array('id' => $k)) . '">' . IconUtility::getSpriteIconForRecord('pages', BackendUtility::getRecordWSOL('pages', $k), array('title' => ('ID: ' . $k))) . GeneralUtility::fixed_lgd_cs($pArray[$k], 30) . '</a></td>
							<td>' . $pArray[($k . '_')]['count'] . '</td>
							<td>' . ($pArray[$k . '_']['root_max_val'] > 0 ? IconUtility::getSpriteIcon('status-status-checked') : '&nbsp;') . '</td>
							<td>' . ($pArray[$k . '_']['root_min_val'] == 0 ? IconUtility::getSpriteIcon('status-status-checked') : '&nbsp;') . '</td>
							</tr>';
					} else {
						$lines[] = '<tr class="' . ($i++ % 2 == 0 ? 'bgColor4' : 'bgColor6') . '">
							<td nowrap ><img src="clear.gif" width="1" height="1" hspace=' . $c * 10 . ' align=top>' . IconUtility::getSpriteIconForRecord('pages', BackendUtility::getRecordWSOL('pages', $k)) . GeneralUtility::fixed_lgd_cs($pArray[$k], 30) . '</td>
							<td></td>
							<td></td>
							<td></td>
							</tr>';
					}
					$lines = $this->renderList($pArray[$k . '.'], $lines, $c + 1);
				}
			}
		}
		return $lines;
	}

}
