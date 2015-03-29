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
	public function getMarketDataReturnsEmptyArrayOnEmptyRepository(){
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