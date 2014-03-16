<?php
namespace gerh\Evecorp\Domain\Model;

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
 *
 *
 * @package evecorp
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class MarketData {
	
	/**
	 * @var integer Holds time in minutes for caching a value
	 */
	private $cachingTime;
	
	/**
	 * @var integer Holds current used tax rate
	 */
	private $corpTax;

	/**
	 * @var string Holds uri to eve-central.com
	 */
	private $eveCentralUri;
	
	/**
	 * @var integer Holds system id of EvE station (f.e. Jita 4-4)
	 */
	private $systemId;
	
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
	 * Check and update out of date Eve items.
	 */
	protected function updateEveItems() {
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
	protected function getUpdateableEveItems() {
		$result = array();
		$timeToCache = (int)$this->getCachingTime();
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
	protected function fetchItems(array $fetchItems) {
		$this->fetcher->setBaseUri($this->getEveCentralUri());
		$this->fetcher->setSystemId($this->getSystemId());
		$this->fetcher->setTypeIds($fetchItems);
		$result = $this->fetcher->query();
		return $result;
	}

	/**
	 * update items in database
	 * 
	 * @param array $itemsToUpdate
	 */
	protected function updateItems(array $itemsToUpdate) {
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
	protected function getAllItems() {
		$result = array();
		foreach ($this->eveitemRepository->findAll() as $dbEntry) {
			$result[$dbEntry->getEveName()] = array(
				'buy' => $dbEntry->getBuyPrice(),
				'buyCorp' => round($dbEntry->getBuyPrice() * $this->getCorpTax(), 2),
				'sell' => $dbEntry->getSellPrice()
				);
		}
		return $result;
	}

	/**
	 * Return all market data (up to date).
	 * 
	 * @return array
	 */
	public function getMarketData() {
		$this->updateEveItems();		
		return $this->getAllItems();
	}
	
	/**
	 * Return current caching time in minutes
	 * 
	 * @return integer
	 */
	public function getCachingTime() {
		return $this->cachingTime;
	}
	
	/**
	 * Set caching time in minutes
	 * 
	 * @param integer $cachingTime
	 */
	public function setCachingTime($cachingTime) {
		$this->cachingTime = $cachingTime;
	}
	
	/**
	 * Return current corporation tax rate
	 * 
	 * @return integer
	 */
	public function getCorpTax() {
		return $this->corpTax;
	}
	
	/**
	 * Set corporation tax rate
	 * 
	 * @param integer $corpTax
	 */
	public function setCorpTax($corpTax) {
		$this->corpTax = $corpTax;
	}
	
	/**
	 * Return used eve-central.com uri
	 * 
	 * @return string
	 */
	public function getEveCentralUri() {
		return $this->eveCentralUri;
	}
	
	/**
	 * Set eve-central.com api uri
	 * 
	 * @param string $eveCentralUri
	 */
	public function setEveCentralUri($eveCentralUri) {
		$this->eveCentralUri = $eveCentralUri;
	}
	
	/**
	 * Return used system id
	 * 
	 * @return integer
	 */
	public function getSystemId() {
		return $this->systemId;
	}
	
	/**
	 * Set system id
	 * 
	 * @param integer $systemId
	 */
	public function setSystemId($systemId) {
		$this->systemId = $systemId;
	}
}
