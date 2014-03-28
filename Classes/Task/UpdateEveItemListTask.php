<?php
namespace gerh\Evecorp\Task;

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
class UpdateEveItemListTask extends \TYPO3\CMS\Scheduler\Task\AbstractTask {

	/**
	 * Update outdated stored EVE item
	 *
	 * @return void
	 */
	protected function updateEveItemList() {
		/** @todo replace with configurable value */
		$eveCentralUri = 'http://api.eve-central.com/api/marketstat';
		/** @todo replace with configurable value */
		$systemId = 30000142;
		/** @todo replace with configurable value */
		$timeToCache = 5;

		/** @var $objectManager \TYPO3\CMS\Extbase\Object\ObjectManager */
		$objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');

		/** @var $eveItemRepository \gerh\Evecorp\Domain\Repository\EveitemRepository */
		$eveItemRepository = $objectManager->get('gerh\\Evecorp\\Domain\\Repository\\EveitemRepository');

		// get out dated items
		$fetchList = array();
		$dbEntryList = $eveItemRepository->findAllUpdateableItems($timeToCache);
		foreach($dbEntryList as $entry) {
			$fetchList[$entry->getEveId()] = $entry->getEveName();
		}

		// fetch current values for this items
		/** @var $fetcher \gerh\Evecorp\Domain\Model\EveCentralFetcher */
		$fetcher = $objectManager->get('gerh\\Evecorp\\Domain\\Model\\EveCentralFetcher');
		$fetcher->setBaseUri($eveCentralUri);
		$fetcher->setSystemId($systemId);
		$fetcher->setTypeIds($fetchList);
		$newValuesForDb = $fetcher->query();

		// update database
		foreach($newValuesForDb as $eveId => $values) {
			foreach($eveItemRepository->findByEveId($eveId) as $dbEntry) {
				$dbEntry->setBuyPrice($values['buy']);
				$dbEntry->setSellPrice($values['sell']);
				$dbEntry->setCacheTime(time());
				$eveItemRepository->update($dbEntry);
			}
		}

		/** @var $persistenceManager \TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager */
		$persistenceManager = $objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager');
		$persistenceManager->persistAll();
	}

	/**
	 * Public method, called by scheduler.
	 *
	 * @return boolean TRUE on success
	 */
	public function execute() {
		$this->updateEveItemList();

		return true;
	}

}