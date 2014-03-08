<?php
namespace gerh\Evecorp\Domain\Model;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Henning Gerhardt 
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
class Eveitem extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * eveName
	 *
	 * @var \string
	 * @validate NotEmpty
	 */
	protected $eveName;

	/**
	 * eveId
	 *
	 * @var \integer
	 * @validate NotEmpty
	 */
	protected $eveId;

	/**
	 * buyPrice of item
	 *
	 * @var \float
	 * @validate NotEmpty
	 */
	protected $buyPrice;

	/**
	 * sellPrice of item
	 *
	 * @var \float
	 * @validate NotEmpty
	 */
	protected $sellPrice;

	/**
	 * cache time of object
	 *
	 * @var \integer
	 * @validate NotEmpty
	 */
	protected $cacheTime;

	/**
	 * Returns the eveName
	 *
	 * @return \string $eveName
	 */
	public function getEveName() {
		return $this->eveName;
	}

	/**
	 * Sets the eveName
	 *
	 * @param \string $eveName
	 * @return void
	 */
	public function setEveName($eveName) {
		$this->eveName = $eveName;
	}

	/**
	 * Returns the eveCentralId
	 *
	 * @return \integer $eveId
	 */
	public function getEveId() {
		return $this->eveId;
	}

	/**
	 * Sets the eveId
	 *
	 * @param \integer $eveId
	 * @return void
	 */
	public function setEveId($eveId) {
		$this->eveId = $eveId;
	}

	/**
	 * Returns the stored buyPrice
	 *
	 * @return \float $buyPrice
	 */
	public function getBuyPrice() {
		return $this->buyPrice;
	}

	/**
	 * Sets the buyPrice of item
	 *
	 * @param \float $buyPrice
	 * @return void
	 */
	public function setBuyPrice($buyPrice) {
		$this->buyPrice = $buyPrice;
	}

	/**
	 * Returns the stored sellPrice
	 *
	 * @return \float $sellPrice
	 */
	public function getSellPrice() {
		return $this->sellPrice;
	}

	/**
	 * Sets the sellPrice of item
	 *
	 * @param \float $sellPrice
	 * @return void
	 */
	public function setSellPrice($sellPrice) {
		$this->sellPrice = $sellPrice;
	}

	/**
	 * Returns cached until time
	 *
	 * @return \integer $cacheTime
	 */
	public function getCacheTime() {
		return $this->cacheTime;
	}

	/**
	 * Sets cache until time
	 *
	 * @param \integer $cachetime
	 * @return void
	 */
	public function setCacheTime($cacheTime) {
		$this->cacheTime = $cacheTime;
	}

	/**
	 * Checks if item is up to date with cached time
	 *
	 * @param \integer $timeToCache
	 * @return boolean
	 */
	public function isUpToDate($timeToCache) {
		$result = true;

		if (($timeToCache == null) or ($timeToCache < 0)) {
			$timeToCache = 0;
		}

		$timeToCacheInSeconds = $timeToCache * 60;
		$currentTime = time();

		if (($this->cacheTime + $timeToCacheInSeconds) < $currentTime ) {
			$result = false;
		}
		return $result;
	}
}
?>