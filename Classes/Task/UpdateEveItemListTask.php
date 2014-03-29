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
	 * @var $eveItemRepository \gerh\Evecorp\Domain\Repository\EveitemRepository
	 */
	protected $eveItemRepository;

	/**
	 * @var $eveCentralFetcher \gerh\Evecorp\Domain\Model\EveCentralFetcher
	 */
	protected $eveCentralFetcher;

	/**
	 * Update outdated stored EVE item
	 *
	 * @return void
	 */
	protected function updateEveItemList() {

		/** @var $objectManager \TYPO3\CMS\Extbase\Object\ObjectManager */
		$objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
		$this->eveItemRepository = $objectManager->get('gerh\\Evecorp\\Domain\\Repository\\EveitemRepository');
		$this->eveCentralFetcher = $objectManager->get('gerh\\Evecorp\\Domain\\Model\\EveCentralFetcher');

		$extconf = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['evecorp']);
		$this->eveCentralFetcher->setBaseUri($extconf['evecentralUri']);

		foreach($this->eveItemRepository->getListOfUniqueSystemId() as $systemId) {

			// get out dated items
			$listOfOutdatedItems = $this->getListOfOutdatedItemsForSystem($systemId);

			// fetch current values for this items
			$newValuesForDb = $this->fetchUpdateableItems($listOfOutdatedItems, $systemId);

			// update database
			$this->updateEveItemsForSystem($newValuesForDb, $systemId);
		}

		/** @var $persistenceManager \TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager */
		$persistenceManager = $objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager');
		$persistenceManager->persistAll();
	}

	/**
	 * Get list of out dated EVE items for a specific system
	 *
	 * @param \integer $systemId
	 * @return array
	 */
	protected function getListOfOutdatedItemsForSystem($systemId) {
		$fetchList = array();
		
		if (($systemId == null) || ($systemId == 0)) {
			return $fetchList;
		}

		foreach($this->eveItemRepository->findAllUpdateableItemsForSystem($systemId) as $entry) {
			$fetchList[$entry->getEveId()] = $entry->getEveName();
		}
		return $fetchList;
	}

	/**
	 * Fetch current EVE item values for a specific system
	 *
	 * @param array $fetchList
	 * @param \integer $systemId
	 * @return array
	 */
	protected function fetchUpdateableItems($fetchList, $systemId) {
		
		if ((count($fetchList) == 0) || ($systemId == null) || ($systemId == 0)) {
			return array();
		}
		
		$this->eveCentralFetcher->setSystemId($systemId);
		$this->eveCentralFetcher->setTypeIds($fetchList);
		$result = $this->eveCentralFetcher->query();
		
		return $result;
	}

	/**
	 * Update changed EVE items with new values
	 * 
	 * @param array $eveItemUpdateList
	 * @param \integer $systemId
	 */
	protected function updateEveItemsForSystem($eveItemUpdateList, $systemId) {
		
		if ((count($eveItemUpdateList) == 0) || ($systemId == null) || $systemId == 0) {
			return;
		}

		foreach($eveItemUpdateList as $eveId => $values) {
			foreach($this->eveItemRepository->findByEveIdAndSystemId($eveId, $systemId) as $dbEntry) {
				$dbEntry->setBuyPrice($values['buy']);
				$dbEntry->setSellPrice($values['sell']);
				$dbEntry->setCacheTime(time());
				$this->eveItemRepository->update($dbEntry);
			}
		}
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