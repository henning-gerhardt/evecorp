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
class AllianceTest extends \TYPO3\CMS\Core\Tests\UnitTestCase {

	/**
	 * @test
	 */
	public function classCouldBeInitiatedWithoutUsernameAndPassword() {
		$alliance = new \Gerh\Evecorp\Domain\Model\Alliance();

		$this->assertInstanceOf('Gerh\Evecorp\Domain\Model\Alliance', $alliance);
	}

	/**
	 * @test
	 */
	public function allianceIdCouldBeSet() {
		$expected = 123456;

		$alliance = new \Gerh\Evecorp\Domain\Model\Alliance();
		$alliance->setAllianceId($expected);

		$this->assertEquals($expected, $alliance->getAllianceId());
	}

	/**
	 * @test
	 */
	public function allianceNameCouldBeSet() {
		$expected = 'FooBar';

		$alliance = new \Gerh\Evecorp\Domain\Model\Alliance();
		$alliance->setAllianceName($expected);

		$this->assertEquals($expected, $alliance->getAllianceName());
	}

	/**
	 * @test
	 */
	public function allianceCouldBeInitializedThroughConstructor() {
		$allianceId = 567890;
		$allianceName = 'BarFoo';

		$alliance = new \Gerh\Evecorp\Domain\Model\Alliance($allianceId, $allianceName);

		$this->assertEquals($allianceId, $alliance->getAllianceId());
		$this->assertEquals($allianceName, $alliance->getAllianceName());
	}

}
