<?php
namespace gerh\Evecorp\Test\Service;

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
 * Testcase for PhealService
 */
class PhealServiceTest extends \TYPO3\CMS\Core\Tests\UnitTestCase {

	/**
	 * @test
	 */
	public function classCouldBeInstantiated() {
		$service = new \gerh\Evecorp\Service\PhealService();
		$this->assertEquals('gerh\Evecorp\Service\PhealService', \get_class($service));
	}

	/**
	 * @test
	 */
	public function serviceReturnsInstanceOfPhealClass() {
		$service = new \gerh\Evecorp\Service\PhealService();
		$this->assertEquals('Pheal\Pheal', \get_class($service->getPhealInstance()));
	}

	/**
	 * @test
	 */
	public function defaultConnectionTimeoutIsUsedIfNonConfigurated() {
		$service = new \gerh\Evecorp\Service\PhealService();
		$this->assertEquals(120, $service->getConnectionTimeout());
	}

	/**
	 * @backupGlobals enabled
	 * @test
	 */
	public function connectionTimoutIsSetCorrect() {
		$expected = 5;
		$modifier = array('phealConnectionTimeout' => $expected);
		$GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['evecorp'] = \serialize($modifier);

		$service = new \gerh\Evecorp\Service\PhealService();
		$this->assertEquals($expected, $service->getConnectionTimeout());
	}

	/**
	 * @backupGlobals enabled
	 * @test
	 */
	public function connectionTimoutCouldBeSetToOneSecond() {
		$expected = 1;
		$modifier = array('phealConnectionTimeout' => $expected);
		$GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['evecorp'] = \serialize($modifier);

		$service = new \gerh\Evecorp\Service\PhealService();
		$this->assertEquals($expected, $service->getConnectionTimeout());
	}

	/**
	 * @backupGlobals enabled
	 * @test
	 */
	public function connectionTimoutCouldNotBeSetBelowOneSecond() {
		$expected = 0;
		$modifier = array('phealConnectionTimeout' => $expected);
		$GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['evecorp'] = \serialize($modifier);

		$service = new \gerh\Evecorp\Service\PhealService();
		$this->assertEquals(120, $service->getConnectionTimeout());
	}

	/**
	 * @test
	 */
	public function defaultCachePathIsUsedIfNonConfigurated() {
		$service = new \gerh\Evecorp\Service\PhealService();
		$expected = \realpath(PATH_site . 'typo3temp');
		$this->assertEquals($expected, $service->getPhealCacheDirectory());
	}

	/**
	 * @backupGlobals enabled
	 * @test
	 */
	public function defaultCachePathIsUsedIfCacheDirectoryDoesNotExists() {
		$modifier = array('phealCacheDirectory' => '\a\b\a');
		$GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['evecorp'] = \serialize($modifier);

		$service = new \gerh\Evecorp\Service\PhealService();
		$expected = \realpath(PATH_site . 'typo3temp');
		$this->assertEquals($expected, $service->getPhealCacheDirectory());
	}

	/**
	 * @backupGlobals enabled
	 * @test
	 */
	public function defaultCachePathIsUsedIfCacheDirectoryIsNotADirectory() {
		$modifier = array('phealCacheDirectory' => \tempnam(\sys_get_temp_dir(), 'FOO'));
		$GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['evecorp'] = \serialize($modifier);

		$service = new \gerh\Evecorp\Service\PhealService();
		$expected = \realpath(PATH_site . 'typo3temp');
		$this->assertEquals($expected, $service->getPhealCacheDirectory());
	}

	/**
	 * @backupGlobals enabled
	 * @test
	 */
	public function cacheDirectoryCouldBeSet() {
		$expected = sys_get_temp_dir();
		$modifier = array('phealCacheDirectory' => $expected);
		$GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['evecorp'] = \serialize($modifier);

		$service = new \gerh\Evecorp\Service\PhealService();
		$this->assertEquals($expected, $service->getPhealCacheDirectory());
	}

	/**
	 * @test
	 */
	public function verifyingHttpsConnectionIsFalseOnDefault() {
		$service = new \gerh\Evecorp\Service\PhealService();
		$this->assertFalse($service->isHttpsConnectionVerified());
	}

	/**
	 * @backupGlobals enabled
	 * @test
	 */
	public function verifyHttpsConnectoinsCouldBeTrue() {
		$modifier = array('phealVerifyingHttpsConnection' => true);
		$GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['evecorp'] = \serialize($modifier);
		$service = new \gerh\Evecorp\Service\PhealService();
		$this->assertTrue($service->isHttpsConnectionVerified());
	}

	/**
	 * @backupGlobals enabled
	 * @test
	 */
	public function verifyHttpsConnectoinsIsFalseOnWrongValues() {
		$modifier = array('phealVerifyingHttpsConnection' => 'bla');
		$GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['evecorp'] = \serialize($modifier);
		$service = new \gerh\Evecorp\Service\PhealService();
		$this->assertFalse($service->isHttpsConnectionVerified());
	}

}
