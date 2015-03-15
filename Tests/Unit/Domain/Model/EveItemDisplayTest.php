<?php
namespace Gerh\Evecorp\Test\Domain\Model;

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
 * Testcase for EveItemDisplay
 */
class EveItemDisplayTest extends \TYPO3\CMS\Core\Tests\UnitTestCase {

	/**
	 * @test
	 */
	public function displayNameCouldBeSet() {
		$eveName = 'Tritanium';

		$item = new \Gerh\Evecorp\Domain\Model\EveItemDisplay();
		$item->setDisplayName($eveName);

		$this->assertEquals($eveName, $item->getDisplayName());
	}

	/**
	 * @test
	 */
	public function buyPriceCouldBeSet() {
		$price = 4.45;

		$item = new \Gerh\Evecorp\Domain\Model\EveItemDisplay();
		$item->setBuyPrice($price);

		$this->assertEquals($price, $item->getBuyPrice());
	}

	/**
	 * @test
	 */
	public function sellPriceCouldBeSet() {
		$price = 4.05;

		$item = new \Gerh\Evecorp\Domain\Model\EveItemDisplay();
		$item->setSellPrice($price);

		$this->assertEquals($price, $item->getSellPrice());
	}

	/**
	 * @test
	 */
	public function corpTaxCouldBeSet() {
		$corpTax = 15.0;

		$eveItemDisplay = new \Gerh\Evecorp\Domain\Model\EveItemDisplay();
		$eveItemDisplay->setCorpTax($corpTax);

		$this->assertEquals($corpTax, $eveItemDisplay->getCorpTax());
	}

	/**
	 * @test
	 */
	public function corpTaxCouldNotBeSetLowerThanZero() {
		$corpTax = -0.1;

		$eveItemDisplay = new \Gerh\Evecorp\Domain\Model\EveItemDisplay();
		$eveItemDisplay->setCorpTax($corpTax);

		$this->assertEquals(0, $eveItemDisplay->getCorpTax());
	}

	/**
	 * @test
	 */
	public function corpTaxCouldNotBeSetHigherThanOneHundred() {
		$corpTax = 100.1;

		$eveItemDisplay = new \Gerh\Evecorp\Domain\Model\EveItemDisplay();
		$eveItemDisplay->setCorpTax($corpTax);

		$this->assertEquals(0.0, $eveItemDisplay->getCorpTax());
	}

	/**
	 * @test
	 */
	public function getCorpTaxModifierWorksAsExpected() {
		$corpTax = 15.5;

		$eveItemDisplay = new \Gerh\Evecorp\Domain\Model\EveItemDisplay();
		$eveItemDisplay->setCorpTax($corpTax);

		$expected = 0.845;
		$actual = $this->callInaccessibleMethod($eveItemDisplay, 'getCorpTaxModifier');

		$this->assertEquals($expected, $actual);
	}

	/**
	 * @test
	 */
	public function regionNameCouldBeSet() {
		$regionName = 'The Forge';

		$eveItemDisplay = new \Gerh\Evecorp\Domain\Model\EveItemDisplay();
		$eveItemDisplay->setRegionName($regionName);

		$this->assertEquals($regionName, $eveItemDisplay->getRegionName());
	}

	/**
	 * @test
	 */
	public function regionNameCouldBeSetByRegionObject() {
		$regionName = 'The Forge';

		$region = new \Gerh\Evecorp\Domain\Model\EveMapRegion();
		$region->setRegionName($regionName);

		$eveItemDisplay = new \Gerh\Evecorp\Domain\Model\EveItemDisplay();
		$eveItemDisplay->setRegionNameByRegion($region);

		$this->assertEquals($regionName, $eveItemDisplay->getRegionName());
	}

	/**
	 * @test
	 */
	public function regionNameIsNullOnNullRegionObject() {
		$eveItemDisplay = new \Gerh\Evecorp\Domain\Model\EveItemDisplay();
		$eveItemDisplay->setRegionNameByRegion(null);

		$this->assertEquals(null, $eveItemDisplay->getRegionName());
	}

		/**
	 * @test
	 */
	public function solarSystemNameCouldBeSet() {
		$solarSystemName = 'Jita';

		$eveItemDisplay = new \Gerh\Evecorp\Domain\Model\EveItemDisplay();
		$eveItemDisplay->setSolarSystemName($solarSystemName);

		$this->assertEquals($solarSystemName, $eveItemDisplay->getSolarSystemName());
	}

	/**
	 * @test
	 */
	public function solarSystemNameCouldBeSetBySolarSystemObject() {
		$solarSystemName = 'Jita';

		$solarSystem = new \Gerh\Evecorp\Domain\Model\EveMapSolarSystem();
		$solarSystem->setSolarSystemName($solarSystemName);

		$eveItemDisplay = new \Gerh\Evecorp\Domain\Model\EveItemDisplay();
		$eveItemDisplay->setSolarSystemNameBySolarSystem($solarSystem);

		$this->assertEquals($solarSystemName, $eveItemDisplay->getSolarSystemName());
	}

	/**
	 * @test
	 */
	public function solarSystemNameIsNullOnNullSolarSystemObject() {
		$eveItemDisplay = new \Gerh\Evecorp\Domain\Model\EveItemDisplay();
		$eveItemDisplay->setSolarSystemName(null);

		$this->assertEquals(null, $eveItemDisplay->getSolarSystemName());
	}

}
