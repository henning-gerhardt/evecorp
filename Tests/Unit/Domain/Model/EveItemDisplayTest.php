<?php

/*
 * Copyright notice
 *
 * (c) 2017 Henning Gerhardt
 *
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 3
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

namespace Gerh\Evecorp\Test\Domain\Model;

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
