<?php
namespace Gerh\Evecorp\Domain\Model;

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
class EveItemDisplay {

	/**
	 * display name of EVE item
	 *
	 * @var \string
	 */
	protected $displayName;

	/**
	 * buy price of EVE item
	 *
	 * @var \float
	 */
	protected $buyPrice;

	/**
	 * sell price of EVE item
	 *
	 * @var \float
	 */
	protected $sellPrice;

	/**
	 * region name where EVE item is bought / sold
	 *
	 * @var \string
	 */
	protected $regionName;

	/**
	 * solar system name where EVE item is bought / sold
	 *
	 * @var \string
	 */
	protected $solarSystemName;

	/**
	 * corporation tax
	 *
	 * @var \float
	 */
	protected $corpTax = 0.0;

	/**
	 * Calculate corporation tax modifier
	 *
	 * @return \real
	 */
	protected function getCorpTaxModifier() {
		$result = \round(1 - ($this->getCorpTax() / 100), 3);
		return $result;
	}

	/**
	 * Calculate corporation price of EVE item
	 *
	 * @param \float $price
	 * @return \float
	 */
	protected function getCorpPrice($price) {
		$result = \round($price * $this->getCorpTaxModifier(), 3);
		return $result;
	}

	/**
	 * Get display name of EVE item
	 *
	 * @return \string
	 */
	public function getDisplayName() {
		return $this->displayName;
	}

	/**
	 * Set display name of EVE item
	 *
	 * @param \string $displayName
	 * @return void
	 */
	public function setDisplayName($displayName) {
		$this->displayName = $displayName;
	}

	/**
	 * Get buy price of EVE item
	 *
	 * @return \float $buyPrice
	 */
	public function getBuyPrice() {
		return $this->buyPrice;
	}

	/**
	 * Get corporation buy price of EVE item
	 *
	 * @return \float $buyPrice
	 */
	public function getCorpBuyPrice() {
		return $this->getCorpPrice($this->getBuyPrice());
	}

	/**
	 * Sets the buy price of item
	 *
	 * @param \float $buyPrice
	 * @return void
	 */
	public function setBuyPrice($buyPrice) {
		$this->buyPrice = $buyPrice;
	}

	/**
	 * Get sell price of EVE item
	 *
	 * @return \float $sellPrice
	 */
	public function getSellPrice() {
		return $this->sellPrice;
	}

	/**
	 * Get corporation sell price of EVE item
	 *
	 * @return \float $sellPrice
	 */
	public function getCorpSellPrice() {
		return $this->getCorpPrice($this->getSellPrice());
	}

	/**
	 * Sets the sell price of item
	 *
	 * @param \float $sellPrice
	 * @return void
	 */
	public function setSellPrice($sellPrice) {
		$this->sellPrice = $sellPrice;
	}

	/**
	 * Get current region name
	 *
	 * @return \Gerh\Evecorp\Domain\Model\EveMapRegion
	 */
	public function getRegionName() {
		return $this->regionName;
	}

	/**
	 * Set region name
	 *
	 * @param \string $regionName
	 */
	public function setRegionName($regionName) {
		$this->regionName = $regionName;
	}

	/**
	 * Set region name by a given region object
	 *
	 * @param \Gerh\Evecorp\Domain\Model\EveMapRegion $region
	 */
	public function setRegionNameByRegion(\Gerh\Evecorp\Domain\Model\EveMapRegion $region = null) {
		if (($region instanceof \Gerh\Evecorp\Domain\Model\EveMapRegion) && ($region != null)) {
			$this->setRegionName($region->getRegionName());
		}
	}

	/**
	 * Return used solar system name
	 *
	 * @return \Gerh\Evecorp\Domain\Model\EveMapSolarSystem
	 */
	public function getSolarSystemName() {
		return $this->solarSystemName;
	}

	/**
	 * Set solar system name
	 *
	 * @param \string $solarSystemName
	 * @return void
	 */
	public function setSolarSystemName($solarSystemName) {
		$this->solarSystemName = $solarSystemName;
	}

	/**
	 * Set solar system name by solar system object
	 *
	 * @param \Gerh\Evecorp\Domain\Model\EveMapSolarSystem $solarSystem
	 * @return void
	 */
	public function setSolarSystemNameBySolarSystem(\Gerh\Evecorp\Domain\Model\EveMapSolarSystem $solarSystem = null) {
		if (($solarSystem instanceof \Gerh\Evecorp\Domain\Model\EveMapSolarSystem) && ($solarSystem != null)) {
			$this->setSolarSystemName($solarSystem->getSolarSystemName());
		}
	}

	/**
	 * Get current used corporation tax
	 *
	 * @return \float
	 */
	public function getCorpTax() {
		return $this->corpTax;
	}

	/**
	 * Set current used corporation tax
	 *
	 * @param type $corpTax
	 */
	public function setCorpTax($corpTax) {
		if (($corpTax >= 0.0) && ($corpTax <= 100.0)) {
			$this->corpTax = $corpTax;
		} else {
			$this->corpTax = 0.0;
		}
	}

}
