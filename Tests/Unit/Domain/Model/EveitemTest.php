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
 * Testcase for Eveitem
 */
class EveitemTest extends \TYPO3\CMS\Core\Tests\UnitTestCase {

    /**
     * @test
     */
    public function nameOfEveitemCouldBeSet() {
        $eveName = 'Tritanium';
        $item = new \Gerh\Evecorp\Domain\Model\Eveitem();
        $item->setEveName($eveName);
        $this->assertEquals($eveName, $item->getEveName());
    }

    /**
     * @test
     */
    public function idOfEveitemCouldBeSet() {
        $eveId = 34;
        $item = new \Gerh\Evecorp\Domain\Model\Eveitem();
        $item->setEveId($eveId);
        $this->assertEquals($eveId, $item->getEveId());
    }

    /**
     * @test
     */
    public function buyPriceOfEveitemCouldBeSet() {
        $price = 4.45;
        $item = new \Gerh\Evecorp\Domain\Model\Eveitem();
        $item->setBuyPrice($price);
        $this->assertEquals($price, $item->getBuyPrice());
    }

    /**
     * @test
     */
    public function sellPriceOfEveitemCouldBeSet() {
        $price = 4.05;
        $item = new \Gerh\Evecorp\Domain\Model\Eveitem();
        $item->setSellPrice($price);
        $this->assertEquals($price, $item->getSellPrice());
    }

    /**
     * @test
     */
    public function cacheTimeOfEveitemCouldBeSet() {
        $cacheTime = \time();
        $item = new \Gerh\Evecorp\Domain\Model\Eveitem();
        $item->setCacheTime($cacheTime);
        $this->assertEquals($cacheTime, $item->getCacheTime());
    }

    /**
     * @test
     */
    public function solarSystemOfEveitemCouldBeSet() {
        $solarSystem = new \Gerh\Evecorp\Domain\Model\EveMapSolarSystem();
        $solarSystem->setSolarSystemId(30000142);
        $solarSystem->setSolarSystemName('Jita');

        $item = new \Gerh\Evecorp\Domain\Model\Eveitem();
        $item->setSolarSystem($solarSystem);

        $this->assertEquals($solarSystem, $item->getSolarSystem());
    }

    /**
     * @test
     */
    public function timeToCacheOfEveitemCouldBeSet() {
        $timeToCache = 5;
        $item = new \Gerh\Evecorp\Domain\Model\Eveitem();
        $item->setTimeToCache($timeToCache);
        $this->assertEquals($timeToCache, $item->getTimeToCache());
    }

    /**
     * @test
     */
    public function timeToCacheCouldNotBeSetBelowOne() {
        $timeToCache = 0;
        $expected = 1;
        $item = new \Gerh\Evecorp\Domain\Model\Eveitem();
        $item->setTimeToCache($timeToCache);
        $this->assertEquals($expected, $item->getTimeToCache());
    }

    /**
     * @test
     */
    public function regionCouldBeSet() {
        $region = new \Gerh\Evecorp\Domain\Model\EveMapRegion();
        $region->setRegionId(10000002);
        $region->setRegionName('The Forge');

        $item = new \Gerh\Evecorp\Domain\Model\Eveitem();
        $item->setRegion($region);

        $this->assertEquals($region, $item->getRegion());
    }

}
