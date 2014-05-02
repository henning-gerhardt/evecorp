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
class ApiKeyTest extends \TYPO3\CMS\Core\Tests\UnitTestCase {

	/**
	 * @test
	 */
	public function classCouldBeInitiatedWithoutUsernameAndPassword() {
		$apiKey = new \Gerh\Evecorp\Domain\Model\ApiKey();

		$this->assertInstanceOf('Gerh\Evecorp\Domain\Model\ApiKey', $apiKey);
	}

	/**
	 * @test
	 */
	public function accessMaskCouldBeSet() {
		$expected = 1234567890;

		$apiKey = new \Gerh\Evecorp\Domain\Model\ApiKey();
		$apiKey->setAccessMask($expected);

		$this->assertEquals($expected, $apiKey->getAccessMask());
	}

	/**
	 * @test
	 */
	public function corpMemberCouldBeSet() {
		$expected = $this->getAccessibleMock('\TYPO3\CMS\Extbase\Domain\Model\FrontendUser');

		$apiKey = new \Gerh\Evecorp\Domain\Model\ApiKey();
		$apiKey->setCorpMember($expected);

		$this->assertEquals($expected, $apiKey->getCorpMember());
	}

	/**
	 * @test
	 */
	public function expiresCouldBeSet() {
		$expected = new \Gerh\Evecorp\Domain\Model\DateTime();

		$apiKey = new \Gerh\Evecorp\Domain\Model\ApiKey();
		$apiKey->setExpires($expected);

		$this->assertEquals($expected, $apiKey->getExpires());
	}

	/**
	 * @test
	 */
	public function keyIdCouldBeSet() {
		$expected = 1234567890;

		$apiKey = new \Gerh\Evecorp\Domain\Model\ApiKey();
		$apiKey->setKeyId($expected);

		$this->assertEquals($expected, $apiKey->getKeyId());
	}

	/**
	 * @test
	 */
	public function typeCouldBeSet() {
		$expected = 'Corporation';

		$apiKey = new \Gerh\Evecorp\Domain\Model\ApiKey();
		$apiKey->setType($expected);

		$this->assertEquals($expected,$apiKey->getType());
	}

	/**
	 * @test
	 */
	public function unintializedTypeIsAccount() {
		$expected = 'Account';

		$apiKey = new \Gerh\Evecorp\Domain\Model\ApiKey();

		$this->assertEquals($expected,$apiKey->getType());
	}

	/**
	 * @test
	 */
	public function callingSetTypeWithoutValueReturnsAccount() {
		$expected = 'Account';

		$apiKey = new \Gerh\Evecorp\Domain\Model\ApiKey();
		$apiKey->setType();

		$this->assertEquals($expected,$apiKey->getType());
	}

	/**
	 * @test
	 */
	public function callingSetTypeWithNullValueReturnsNull() {
		$expected = null;

		$apiKey = new \Gerh\Evecorp\Domain\Model\ApiKey();
		$apiKey->setType(NULL);

		$this->assertEquals($expected,$apiKey->getType());
	}

	/**
	 * @test
	 */
	public function vCodeCouldBeSet() {
		$expected = 'FooBar';

		$apiKey = new \Gerh\Evecorp\Domain\Model\ApiKey();
		$apiKey->setVCode($expected);

		$this->assertEquals($expected, $apiKey->getVCode());
	}
}
