<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014 Henning Gerhardt 
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
 ***************************************************************/

/**
 * Class for updating Evecorp data
 *
 */
class ext_update {

	/**
	 * Stub function for the extension manager
	 *
	 * @param	string	$what	What should be updated
	 * @return	boolean	true to allow access
	 */
	public function access($what = 'all') {
		$fields = $GLOBALS['TYPO3_DB']->admin_get_fields('tx_evecorp_domain_model_eveitem');
		return isset($fields['region_id']) && isset($fields['system_id']);
	}

	/**
	 * Updates nested sets
	 *
	 * @return	string		HTML output
	 */
	public function main() {
		if (t3lib_div::_POST('nssubmit') != '') {
			$this->updateOverridePaths();
			$content = 'Update finished successfully.';
		}
		else {
			$content = $this->prompt();
		}
		return $content;
	}

	/**
	 * Shows a form to created nested sets data.
	 *
	 * @return	string
	 */
	protected function prompt() {
		return
			'<form action="' . t3lib_div::getIndpEnv('REQUEST_URI') . '" method="POST">' .
			'<p>This update will do the following:</p>' .
			'<ul>' .
			'<li>Transfering data of column region_id to column region</li>' .
			'<li>Transfering data of column system_id to column solar_system</li>' .
			'<li>Removing column region_id and system_id</li>' .
			'</ul>' .
			'<br />' .
			'<input type="submit" name="nssubmit" value="Update" /></form>';
	}

	/**
	 * Creates nested sets data for pages
	 *
	 * @return	string	Result
	 */
	protected function updateOverridePaths() {
		$GLOBALS['TYPO3_DB']->sql_query('UPDATE `tx_evecorp_domain_model_eveitem` SET `region` = `region_id` WHERE `region_id` <> 0;');
		$GLOBALS['TYPO3_DB']->sql_query('UPDATE `tx_evecorp_domain_model_eveitem` SET `solar_system` = `system_id` WHERE `system_id` <> 0;');
		$GLOBALS['TYPO3_DB']->sql_query('UPDATE `tx_evecorp_domain_model_eveitem` SET `region_id` = 0, `system_id` = 0;');
		$GLOBALS['TYPO3_DB']->sql_query('ALTER TABLE `tx_evecorp_domain_model_eveitem` DROP `region_id`,  DROP `system_id`;');
	}
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/evecorp/class.ext_update.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/evecorp/class.ext_update.php']);
}
