<?php
namespace gerh\Evecorp\Controller;

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
class AppController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	/**
	 * eveitemRepository
	 *
	 * @var \gerh\Evecorp\Domain\Repository\EveitemRepository
	 * @inject
	 */
	protected $eveitemRepository;

	/**
	 * Holds an instance of current support fetcher (EveCentral)
	 * 
	 * @var \gerh\Evecorp\Domain\Model\EveCentralFetcher
	 * @inject
	 */
	protected $fetcher;

	/**
	 * action index
	 *
	 * @return void
	 */
	public function indexAction() {
		$this->updateEveItems();
		$result = $this->getAllItems();
		ksort($result);

		$this->view->assign('result', $result);
		$this->view->assign('tableTypeContent', $this->settings['tabletypecontent']);
		$this->view->assign('preTableText', $this->settings['pretabletext']);
		$this->view->assign('postTableText', $this->settings['posttabletext']);
		$this->view->assign('showBuyCorpColumn', $this->settings['showbuycorpcolumn']);
	}

	/**
	 * Check and update out of date Eve items.
	 */
	private function updateEveItems() {
		$updateableItems = $this->getUpdateableEveItems();
		if (count($updateableItems) > 0) {
			$updatedItems = $this->fetchItems($updateableItems);
			$this->updateItems($updatedItems);
		}
	}
	/**
	 * get all updateable items
	 * 
	 * @return array
	 */
	private function getUpdateableEveItems() {
		$result = array();
		$timeToCache = (int)$this->settings['cachingtime'];
		foreach($this->eveitemRepository->findAllUpdateableItems($timeToCache) as $entry) {
			$result[$entry->getEveId()] = $entry->getEveName();
		}
		return $result;
	}

	/**
	 * fetch items from Eve Central
	 * 
	 * @param array $fetchItems
	 * @return array
	 */
	private function fetchItems(array $fetchItems) {
		$this->fetcher->setBaseUri($this->settings['evecentralurl']);
		$this->fetcher->setSystemId($this->settings['systemid']);
		$this->fetcher->setTypeIds($fetchItems);
		$result = $this->fetcher->query();
		return $result;
	}

	/**
	 * update items in database
	 * 
	 * @param array $itemsToUpdate
	 */
	private function updateItems(array $itemsToUpdate) {
		foreach($itemsToUpdate as $eveName => $values) {
			foreach($this->eveitemRepository->findByEveName($eveName) as $dbEntry) {
				$dbEntry->setBuyPrice($values['buy']);
				$dbEntry->setSellPrice($values['sell']);
				$dbEntry->setCacheTime(time());
				$this->eveitemRepository->update($dbEntry);
			}
		}
	}

	/**
	 * fetch all current items
	 * 
	 * @return array
	 */
	private function getAllItems() {
		$result = array();
		foreach ($this->eveitemRepository->findAll() as $dbEntry) {
			$result[$dbEntry->getEveName()] = array(
				'buy' => $dbEntry->getBuyPrice(),
				'buyCorp' => round($dbEntry->getBuyPrice() * $this->settings['corptax'], 2),
				'sell' => $dbEntry->getSellPrice()
				);
		}
		return $result;
	}
}
