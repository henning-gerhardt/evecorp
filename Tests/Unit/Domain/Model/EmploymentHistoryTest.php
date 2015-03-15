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
class EmploymentHistoryTest  extends \TYPO3\CMS\Core\Tests\UnitTestCase {

	/**
	 * @test
	 */
	public function classCouldBeInitiated() {
		$history = new \Gerh\Evecorp\Domain\Model\EmploymentHistory();

		$this->assertInstanceOf('Gerh\Evecorp\Domain\Model\EmploymentHistory', $history);
	}

	/**
	 * @test
	 */
	public function characterCouldBeSet() {
		$expected = new \Gerh\Evecorp\Domain\Model\Character();
		$expected->setCharacterId(815);
		$expected->setCharacterName('Foo Bar');

		$history = new \Gerh\Evecorp\Domain\Model\EmploymentHistory();
		$history->setCharacter($expected);

		$this->assertEquals($expected, $history->getCharacter());
	}

	/**
	 * @test
	 */
	public function corporationCouldBeSet() {
		$expected = new \Gerh\Evecorp\Domain\Model\Corporation;
		$expected->setCorporationId(1234);
		$expected->setCorporationName('Bar Corporation');

		$history = new \Gerh\Evecorp\Domain\Model\EmploymentHistory();
		$history->setCorporation($expected);

		$this->assertEquals($expected, $history->getCorporation());
	}

	/**
	 * @test
	 */
	public function recordIdCouldBeSet() {
		$expected = 987654;

		$history = new \Gerh\Evecorp\Domain\Model\EmploymentHistory();
		$history->setRecordId($expected);

		$this->assertEquals($expected, $history->getRecordId());
	}

	/**
	 * @test
	 */
	public function startDateCouldBeSet() {
		$expected = new \Gerh\Evecorp\Domain\Model\DateTime();

		$history = new \Gerh\Evecorp\Domain\Model\EmploymentHistory();
		$history->setStartDate($expected);

		$this->assertEquals($expected, $history->getStartDate());
	}
}
