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

namespace Gerh\Evecorp\Domain\Model;

/**
 *
 *
 * @package evecorp
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class MarketData {

	/**
	 * @var \float Holds current used tax rate
	 */
	private $corpTax;

	/**
	 * eveitemRepository
	 *
	 * @var \Gerh\Evecorp\Domain\Repository\EveitemRepository
	 * @inject
	 */
	protected $eveitemRepository;

	/**
	 * Extract database data to an array structure
	 *
	 * @param \Gerh\Evecorp\Domain\Model\EveItem $entry
	 * @return \array
	 */
	protected function extractDisplayData(\Gerh\Evecorp\Domain\Model\EveItem $entry) {

		$result = new \Gerh\Evecorp\Domain\Model\EveItemDisplay();
		$result->setDisplayName($entry->getEveName());
		$result->setBuyPrice($entry->getBuyPrice());
		$result->setSellPrice($entry->getSellPrice());
		$result->setCorpTax($this->getCorpTax());
		$result->setRegionNameByRegion($entry->getRegion());
		$result->setSolarSystemNameBySolarSystem($entry->getSolarSystem());

		return $result;
	}

	/**
	 * Return all market data (up to date).
	 *
	 * @return array
	 */
	public function getMarketData() {
		$result = array();
		foreach ($this->eveitemRepository->findAll() as $dbEntry) {
			if ($dbEntry != null) {
				$result[] = $this->extractDisplayData($dbEntry);
			}
		}

		return $result;
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
	 * @param \float $corpTax
	 */
	public function setCorpTax($corpTax) {
		if (($corpTax < 0.0) || ($corpTax > 100.0)) {
			$corpTax = 0;
		}
		$this->corpTax = $corpTax;
	}

}
