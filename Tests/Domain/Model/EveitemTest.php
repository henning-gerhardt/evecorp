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
 * Testcase for Eveitem
 */
class EveitemTest extends \TYPO3\CMS\Core\Tests\UnitTestCase {

	/**
	 * @test
	 */
	public function nameOfEveitemCouldBeSet() {
		$eveName = 'Tritanium';
		$item = new \gerh\Evecorp\Domain\Model\Eveitem();
		$item->setEveName($eveName);
		$this->assertEquals($eveName, $item->getEveName());
	}

	/**
	 * @test
	 */
	public function idOfEveitemCouldBeSet() {
		$eveId = 34;
		$item = new \gerh\Evecorp\Domain\Model\Eveitem();
		$item->setEveId($eveId);
		$this->assertEquals($eveId, $item->getEveId());
	}

	/**
	 * @test
	 */
	public function buyPriceOfEveitemCouldBeSet() {
		$price = 4.45;
		$item = new \gerh\Evecorp\Domain\Model\Eveitem();
		$item->setBuyPrice($price);
		$this->assertEquals($price, $item->getBuyPrice());
	}

	/**
	 * @test
	 */
	public function sellPriceOfEveitemCouldBeSet() {
		$price = 4.05;
		$item = new \gerh\Evecorp\Domain\Model\Eveitem();
		$item->setSellPrice($price);
		$this->assertEquals($price, $item->getSellPrice());
	}

	/**
	 * @test
	 */
	public function cacheTimeOfEveitemCouldBeSet() {
		$cacheTime = \time();
		$item = new \gerh\Evecorp\Domain\Model\Eveitem();
		$item->setCacheTime($cacheTime);
		$this->assertEquals($cacheTime, $item->getCacheTime());
	}
	
	/**
	 * @test
	 */
	public function systemIdOfEveitemCouldBeSet() {
		$systemId = 30000142;
		$item = new \gerh\Evecorp\Domain\Model\Eveitem();
		$item->setSystemId($systemId);
		$this->assertEquals($systemId, $item->getSystemId());
	}

	/**
	 * @test
	 */
	public function systemIdCouldNotSetBelowZero() {
		$systemId = -1;
		$expected = 0;
		$item = new \gerh\Evecorp\Domain\Model\Eveitem();
		$item->setSystemId($systemId);
		$this->assertEquals($expected, $item->getSystemId());
	}

	/**
	 * @test
	 */
	public function timeToCacheOfEveitemCouldBeSet() {
		$timeToCache = 5;
		$item = new \gerh\Evecorp\Domain\Model\Eveitem();
		$item->setTimeToCache($timeToCache);
		$this->assertEquals($timeToCache, $item->getTimeToCache());
	}
	
	/**
	 * @test
	 */
	public function timeToCacheCouldNotBeSetBelowOne() {
		$timeToCache = 0;
		$expected = 1;
		$item = new \gerh\Evecorp\Domain\Model\Eveitem();
		$item->setTimeToCache($timeToCache);
		$this->assertEquals($expected, $item->getTimeToCache());
	}
	
}
