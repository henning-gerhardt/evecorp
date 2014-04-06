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
	 * @var integer Holds current used tax rate
	 */
	private $corpTax;

	/**
	 * eveitemRepository
	 *
	 * @var \gerh\Evecorp\Domain\Repository\EveitemRepository
	 * @inject
	 */
	protected $eveitemRepository;

	/**
	 * fetch all current items
	 * 
	 * @return array
	 */
	protected function getAllItems() {
		$result = array();
		foreach ($this->eveitemRepository->findAll() as $dbEntry) {
			$result[] = array(
				'displayName' => $dbEntry->getEveName(),
				'buy' => $dbEntry->getBuyPrice(),
				'buyCorp' => round($dbEntry->getBuyPrice() * $this->getCorpTaxModifier(), 2),
				'sell' => $dbEntry->getSellPrice()
				);
		}
		return $result;
	}

	/**
	 * Calculate corporation tax modifier
	 * 
	 * @return real
	 */
	protected function getCorpTaxModifier() {
		$result = \round(1 - ($this->getCorpTax() / 100), 2);
		return $result;
	}

	/**
	 * Return all market data (up to date).
	 * 
	 * @return array
	 */
	public function getMarketData() {
		return $this->getAllItems();
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
		if (($corpTax < 0) || ($corpTax > 100)) {
			$corpTax = 0;
		}
		$this->corpTax = $corpTax;
	}
	
}
