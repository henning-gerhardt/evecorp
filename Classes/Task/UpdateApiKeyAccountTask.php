<?php
namespace Gerh\Evecorp\Task;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 - 2014 Henning Gerhardt
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
 *
 *
 * @package evecorp
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class UpdateApiKeyAccountTask extends \TYPO3\CMS\Scheduler\Task\AbstractTask {

	/**
	 * Updating all api keys of type account
	 */
	protected function updateAccountApiKeys() {
		$objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
		$apiKeyAccountRepository = $objectManager->get('Gerh\\Evecorp\\Domain\\Repository\\ApiKeyAccountRepository');

		$mapper = new \Gerh\Evecorp\Domain\Mapper\ApiKeyMapper();
		foreach($apiKeyAccountRepository->findAll() as $apiKeyAccount) {
			$result = $mapper->updateApiKeyAccount($apiKeyAccount);
			if ($result === TRUE) {
				$apiKeyAccountRepository->update($apiKeyAccount);
			}
		}

		$persistenceManager = $objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager');
		$persistenceManager->persistAll();
	}

	/**
	 * Public method, called by scheduler.
	 *
	 * @return boolean TRUE on success
	 */
	public function execute() {
		$this->updateAccountApiKeys();

		return true;
	}
}
