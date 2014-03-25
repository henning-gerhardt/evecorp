<?php
namespace gerh\Evecorp\Test\Domain\Model;

/***************************************************************
 *	Copyright notice
 *
 *	(c) 2014 Henning Gerhardt
 *
 *	All rights reserved
 *
 *	This script is part of the TYPO3 project. The TYPO3 project is
 *	free software; you can redistribute it and/or modify
 *	it under the terms of the GNU General Public License as published by
 *	the Free Software Foundation; either version 3 of the License, or
 *	(at your option) any later version.
 *
 *	The GNU General Public License can be found at
 *	http://www.gnu.org/copyleft/gpl.html.
 *
 *	This script is distributed in the hope that it will be useful,
 *	but WITHOUT ANY WARRANTY; without even the implied warranty of
 *	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *	GNU General Public License for more details.
 *
 *	This copyright notice MUST APPEAR in all copies of the script!
 *
 */

/**
 * Testcase for MarketData
 */
class MarketDataTest extends \TYPO3\CMS\Extbase\Tests\Unit\BaseTestCase {

	/**
	 * @test
	 */
	public function cachingTimeCouldBeSet() {
		$cacheTime = 5;
		$marketData = new \gerh\Evecorp\Domain\Model\MarketData();
		$marketData->setCachingTime($cacheTime);
		$this->assertEquals($cacheTime, $marketData->getCachingTime());
	}

	/**
	 * @test
	 */
	public function corpTaxCouldBeSet() {
		$corpTax = 10;
		$marketData = new \gerh\Evecorp\Domain\Model\MarketData();
		$marketData->setCorpTax($corpTax);
		$this->assertEquals($corpTax, $marketData->getCorpTax());
	}

	/**
	 * @test
	 */
	public function corpTaxCouldNotBeSetLowerThanZero() {
		$corpTax = -1;
		$marketData = new \gerh\Evecorp\Domain\Model\MarketData();
		$marketData->setCorpTax($corpTax);
		$this->assertEquals(0, $marketData->getCorpTax());
	}

	/**
	 * @test
	 */
	public function corpTaxCouldNotBeSetHigherThanOneHundred() {
		$corpTax = 101;
		$marketData = new \gerh\Evecorp\Domain\Model\MarketData();
		$marketData->setCorpTax($corpTax);
		$this->assertEquals(0, $marketData->getCorpTax());
	}

	/**
	 * @test
	 */
	public function eveCentralUriCouldBeSet() {
		$eveCentralUri = 'http://api.eve-central.com/api/marketstat';
		$marketData = new \gerh\Evecorp\Domain\Model\MarketData();
		$marketData->setEveCentralUri($eveCentralUri);
		$this->assertEquals($eveCentralUri, $marketData->getEveCentralUri());
	}

	/**
	 * @test
	 */
	public function systemIdCouldBeSet() {
		$systemId = 30000142;
		$marketData = new \gerh\Evecorp\Domain\Model\MarketData();
		$marketData->setSystemId($systemId);
		$this->assertEquals($systemId, $marketData->getSystemId());
	}

}
