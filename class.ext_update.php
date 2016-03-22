<?php

/* * *************************************************************
 *  Copyright notice
 *
 *  (c) 2016 Henning Gerhardt
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
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
 * ************************************************************* */

/**
 * Class for updating Evecorp data
 *
 */
class ext_update {

	/**
	 *
	 * @var \array
	 */
	protected $messageArray = array();

	/**
	 * Execute a query inside database
	 *
	 * @param \string $query
	 * @return mixed
	 */
	private function executeDatabaseQuery($query) {
		return $GLOBALS['TYPO3_DB']->sql_query($query);
	}

	/**
	 * Insert a line from static file into database
	 *
	 * @param \string $line
	 * @return \array containing message and status of insert
	 */
	private function insertStaticDataLine($line) {
		$message = 'OK!';
		$status = \TYPO3\CMS\Core\Messaging\FlashMessage::OK;

		if ($this->executeDatabaseQuery($line) === \FALSE) {
			$message = 'SQL ERROR:' . $GLOBALS['TYPO3_DB']->sql_error();
			$status = \TYPO3\CMS\Core\Messaging\FlashMessage::ERROR;
		}

		return array('message' => $message, 'status' => $status);
	}

	/**
	 * Check if table tx_evecorp_domain_model_eveitem needs
	 * a structure update.
	 *
	 * @return \boolean
	 */
	protected function eveItemTableNeedsUpdate() {
		$fields = $GLOBALS['TYPO3_DB']->admin_get_fields('tx_evecorp_domain_model_eveitem');
		return isset($fields['region_id']) && isset($fields['system_id']);
	}

	/**
	 * Generates output by using flash messages
	 *
	 * @return string
	 */
	protected function generateOutput() {
		$output = '';
		foreach ($this->messageArray as $messageItem) {
			$flashMessage = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
							'TYPO3\CMS\Core\Messaging\FlashMessage', $messageItem[2], $messageItem[1], $messageItem[0]
			);
			$output .= $flashMessage->render();
		}
		return $output;
	}

	/**
	 * Import static data from ext_tables_static+adt.sql file
	 *
	 * @return \int
	 */
	protected function importStaticData() {
		$title = 'Import static data';
		$message = 'Import needs to be executed!';
		$status = \TYPO3\CMS\Core\Messaging\FlashMessage::WARNING;
		$extPath = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('evecorp');
		$fileContent = explode(LF, \TYPO3\CMS\Core\Utility\GeneralUtility::getUrl($extPath . 'ext_tables_static+adt.sql'));

		// clean up / truncate database tables
		$this->executeDatabaseQuery('TRUNCATE `tx_evecorp_domain_model_evemapregion`');
		$this->executeDatabaseQuery('TRUNCATE `tx_evecorp_domain_model_evemapsolarsystem`');

		// insert new static data
		foreach ($fileContent as $line) {
			$line = trim($line);
			if ($line && preg_match('#^INSERT#i', $line)) {
				$result = $this->insertStaticDataLine($line);
				$message = $result['message'];
				$status = $result['status'];
			}
		}
		$this->messageArray[] = array($status, $title, $message);
		return $status;
	}

	/**
	 * Stub function for the extension manager
	 *
	 * @return \boolean true to allow access
	 */
	public function access() {
		return \TRUE;
	}

	/**
	 * Update structure of table tx_evecorp_domain_model_eveitem if needed.
	 *
	 * @return \string
	 */
	public function main() {
		if ($this->eveItemTableNeedsUpdate()) {
			$this->updateOverridePaths();
		}
		$this->importStaticData();
		return $this->generateOutput();
	}

	/**
	 * Update structure of table tx_evecorp_domain_model_eveitem
	 *
	 * @return \int
	 */
	protected function updateEveItemStructure() {
		$title = 'Update structure of table "tx_evecorp_domain_model_eveitem"';
		$message = 'Structure of table "tx_evecorp_domain_model_eveitem" successful updated.';
		$status = \TYPO3\CMS\Core\Messaging\FlashMessage::OK;

		if ($this->executeDatabaseQuery('UPDATE `tx_evecorp_domain_model_eveitem` SET `region` = `region_id` WHERE `region_id` <> 0;') === \FALSE) {
			$message = 'SQL ERROR:' . $GLOBALS['TYPO3_DB']->sql_error();
			$status = \TYPO3\CMS\Core\Messaging\FlashMessage::ERROR;
		}

		if ($this->executeDatabaseQuery('UPDATE `tx_evecorp_domain_model_eveitem` SET `solar_system` = `system_id` WHERE `system_id` <> 0;') === \FALSE) {
			$message = 'SQL ERROR:' . $GLOBALS['TYPO3_DB']->sql_error();
			$status = \TYPO3\CMS\Core\Messaging\FlashMessage::ERROR;
		}

		if ($this->executeDatabaseQuery('UPDATE `tx_evecorp_domain_model_eveitem` SET `region_id` = 0, `system_id` = 0;') === \FALSE) {
			$message = 'SQL ERROR:' . $GLOBALS['TYPO3_DB']->sql_error();
			$status = \TYPO3\CMS\Core\Messaging\FlashMessage::ERROR;
		}

		if ($this->executeDatabaseQuery('ALTER TABLE `tx_evecorp_domain_model_eveitem` DROP `region_id`,  DROP `system_id`;') === \FALSE) {
			$message = 'SQL ERROR:' . $GLOBALS['TYPO3_DB']->sql_error();
			$status = \TYPO3\CMS\Core\Messaging\FlashMessage::ERROR;
		}

		$this->messageArray[] = array($status, $title, $message);
		return $status;
	}

}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/evecorp/class.ext_update.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/evecorp/class.ext_update.php']);
}
