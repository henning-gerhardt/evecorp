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
 * Testcase for MarketData
 */
class MarketDataTest extends \TYPO3\CMS\Core\Tests\UnitTestCase {

    /**
     * @var \TYPO3\CMS\Extbase\Object\ObjectManagerInterface
     */
    protected $mockObjectManager;

    /**
     * Sets up this test case.
     */
    public function setUp() {
        $this->mockObjectManager = $this->getMock('TYPO3\CMS\Extbase\Object\ObjectManagerInterface');
    }

    /**
     * @test
     */
    public function corpTaxCouldBeSet() {
        $corpTax = 10;
        $marketData = new \Gerh\Evecorp\Domain\Model\MarketData();
        $marketData->setCorpTax($corpTax);
        $this->assertEquals($corpTax, $marketData->getCorpTax());
    }

    /**
     * @test
     */
    public function corpTaxCouldNotBeSetLowerThanZero() {
        $corpTax = -0.1;
        $marketData = new \Gerh\Evecorp\Domain\Model\MarketData();
        $marketData->setCorpTax($corpTax);
        $this->assertEquals(0, $marketData->getCorpTax());
    }

    /**
     * @test
     */
    public function corpTaxCouldNotBeSetHigherThanOneHundred() {
        $corpTax = 100.1;
        $marketData = new \Gerh\Evecorp\Domain\Model\MarketData();
        $marketData->setCorpTax($corpTax);
        $this->assertEquals(0, $marketData->getCorpTax());
    }

    /**
     * @test
     */
    public function getMarketDataReturnsEmptyArrayOnEmptyRepository() {
        $marketData = $this->getMock('\Gerh\Evecorp\Domain\Model\MarketData', array('updateEveItems'));

        $mockedQueryInterface = $this->getMock('TYPO3\CMS\Extbase\Persistence\QueryInterface');
        $mockedRepository = $this->getMock('Gerh\Evecorp\Domain\Repository\EveitemRepository', array('findAll'), array($this->mockObjectManager));
        $mockedRepository
                ->expects($this->once())
                ->method('findAll')
                ->will($this->returnValue($mockedQueryInterface));

        $this->inject($marketData, 'eveitemRepository', $mockedRepository);

        $expected = array();
        $actual = $marketData->getMarketData();
        $this->assertEquals($expected, $actual);
    }

}
