<?php
namespace Gerh\Evecorp\Test\Domain\Model;

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
class CorporationTest extends \TYPO3\CMS\Core\Tests\UnitTestCase {

	/**
	 * @test
	 */
	public function classCouldBeInitiated() {
		$corporation = new \Gerh\Evecorp\Domain\Model\Corporation();

		$this->assertInstanceOf('Gerh\Evecorp\Domain\Model\Corporation', $corporation);
	}

	/**
	 * @test
	 */
	public function corporationIdCouldBeSet() {
		$expected = 123456;

		$corporation = new \Gerh\Evecorp\Domain\Model\Corporation();
		$corporation->setCorporationId($expected);

		$this->assertEquals($expected, $corporation->getCorporationId());
	}

	/**
	 * @test
	 */
	public function corporationNameCouldBeSet() {
		$expected = 'FooBar';

		$corporation = new \Gerh\Evecorp\Domain\Model\Corporation();
		$corporation->setCorporationName($expected);

		$this->assertEquals($expected, $corporation->getCorporationName());
	}

	/**
	 * @test
	 */
	public function corporationCouldBeInitializedThroughConstructor() {
		$corporationId = 567890;
		$corporationName = 'BarFoo';

		$corporation = new \Gerh\Evecorp\Domain\Model\Corporation($corporationId, $corporationName);

		$this->assertEquals($corporationId, $corporation->getCorporationId());
		$this->assertEquals($corporationName, $corporation->getCorporationName());
	}

	/**
	 * @test
	 */
	public function currentAllianceCouldBeSetToCorporation() {
		$expected = new \Gerh\Evecorp\Domain\Model\Alliance(12, 'FooBar');

		$corporation = new \Gerh\Evecorp\Domain\Model\Corporation();
		$corporation->setCurrentAlliance($expected);

		$this->assertEquals($expected, $corporation->getCurrentAlliance());
	}

	/**
	 * @test
	 */
	public function currentAllianceNameCouldBeGet() {
		$expected = 'BarFoo';
		$alliance = new \Gerh\Evecorp\Domain\Model\Alliance(12, $expected);

		$corporation = new \Gerh\Evecorp\Domain\Model\Corporation();
		$corporation->setCurrentAlliance($alliance);

		$this->assertEquals($expected, $corporation->getAllianceName());
	}

}
