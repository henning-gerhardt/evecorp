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
class CharacterTest extends \TYPO3\CMS\Core\Tests\UnitTestCase {
	
	/**
	 * @test
	 */
	public function classCouldBeInitiated() {
		$character = new \Gerh\Evecorp\Domain\Model\Character();

		$this->assertInstanceOf('Gerh\Evecorp\Domain\Model\Character', $character);
	}

	/**
	 * @test
	 */
	public function apiKeyCouldBeSet() {
		$expected = new \Gerh\Evecorp\Domain\Model\ApiKey();

		$character = new \Gerh\Evecorp\Domain\Model\Character();
		$character->setApiKey($expected);

		$this->assertEquals($expected, $character->getApiKey());
	}

	/**
	 * @test
	 */
	public function characterIdCouldBeSet() {
		$expected = 13579;

		$character = new \Gerh\Evecorp\Domain\Model\Character();
		$character->setCharacterId($expected);

		$this->assertEquals($expected, $character->getCharacterId());
	}

	/**
	 * @test
	 */
	public function characterNameCouldBeSet() {
		$expected = 'FooBar';

		$character = new \Gerh\Evecorp\Domain\Model\Character();
		$character->setCharacterName($expected);

		$this->assertEquals($expected, $character->getCharacterName());
	}

	/**
	 * @test
	 */
	public function corpMemberCouldBeSet() {
		$expected = new \TYPO3\CMS\Extbase\Domain\Model\FrontendUser();

		$character = new \Gerh\Evecorp\Domain\Model\Character();
		$character->setCorpMember($expected);

		$this->assertEquals($expected, $character->getCorpMember());
	}

	/**
	 * @test
	 */
	public function currentAllianceCouldBeSet() {
		$expected = new \Gerh\Evecorp\Domain\Model\Alliance();

		$character = new \Gerh\Evecorp\Domain\Model\Character();
		$character->setCurrentAlliance($expected);

		$this->assertEquals($expected, $character->getCurrentAlliance());
	}

	/**
	 * @test
	 */
	public function currentCorporationCouldBeSet() {
		$expected = new \Gerh\Evecorp\Domain\Model\Corporation();

		$character = new \Gerh\Evecorp\Domain\Model\Character();
		$character->setCurrentCorporation($expected);

		$this->assertEquals($expected, $character->getCurrentCorporation());
	}

	/**
	 * @test
	 */
	public function raceCouldBeSet() {
		$expected = 'Baar';

		$character = new \Gerh\Evecorp\Domain\Model\Character();
		$character->setRace($expected);

		$this->assertEquals($expected, $character->getRace());
	}
	
	/**
	 * @test
	 */
	public function securityStatusCouldBeSet() {
		$expected = 4.3;

		$character = new \Gerh\Evecorp\Domain\Model\Character();
		$character->setSecurityStatus($expected);

		$this->assertEquals($expected, $character->getSecurityStatus());
	}

	/**
	 * @test
	 */
	public function allianceCouldBeNull() {
		$character = new \Gerh\Evecorp\Domain\Model\Character();
		$character->setCurrentAlliance(NULL);

		$this->assertNull($character->getCurrentAlliance());
	}
}
