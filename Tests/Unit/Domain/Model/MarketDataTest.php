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

use Gerh\Evecorp\Domain\Model\MarketData;
use Gerh\Evecorp\Domain\Repository\EveitemRepository;
use TYPO3\CMS\Core\Tests\UnitTestCase;
use TYPO3\CMS\Extbase\Object\ObjectManagerInterface;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;

/**
 * Testcase for MarketData
 */
class MarketDataTest extends UnitTestCase {

    /**
     * @var ObjectManagerInterface
     */
    protected $mockObjectManager;

    /**
     * Sets up this test case.
     */
    public function setUp() {
        $this->mockObjectManager = $this->createMock(ObjectManagerInterface::class);
    }

    /**
     * @test
     */
    public function corpTaxCouldBeSet() {
        $corpTax = 10;
        $marketData = new MarketData();
        $marketData->setCorpTax($corpTax);
        $this->assertEquals($corpTax, $marketData->getCorpTax());
    }

    /**
     * @test
     */
    public function corpTaxCouldNotBeSetLowerThanZero() {
        $corpTax = -0.1;
        $marketData = new MarketData();
        $marketData->setCorpTax($corpTax);
        $this->assertEquals(0, $marketData->getCorpTax());
    }

    /**
     * @test
     */
    public function corpTaxCouldNotBeSetHigherThanOneHundred() {
        $corpTax = 100.1;
        $marketData = new MarketData();
        $marketData->setCorpTax($corpTax);
        $this->assertEquals(0, $marketData->getCorpTax());
    }

    /**
     * @test
     */
    public function getMarketDataReturnsEmptyArrayOnEmptyRepository() {
        $marketData = $this->getMockBuilder(MarketData::class)
            ->setMethods(['updateEveItems'])
            ->getMock();

        $mockedQueryInterface = $this->createMock(QueryInterface::class);

        $mockedRepository = $this->getMockBuilder(EveitemRepository::class)
            ->setConstructorArgs([$this->mockObjectManager])
            ->setMethods(['findAll'])
            ->getMock();

        $mockedRepository
            ->expects($this->once())
            ->method('findAll')
            ->will($this->returnValue($mockedQueryInterface));

        $this->inject($marketData, 'eveitemRepository', $mockedRepository);

        $expected = [];
        $actual = $marketData->getMarketData();
        $this->assertEquals($expected, $actual);
    }

}
