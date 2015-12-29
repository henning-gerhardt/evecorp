<?php
namespace Gerh\Evecorp\Test\Domain\Validator;

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
class ApiKeyAccountValidatorTest extends \TYPO3\CMS\Extbase\Tests\Unit\Validation\Validator\AbstractValidatorTestcase {

	/**
	 * @var \string
	 */
	protected $validatorClassName = 'Gerh\\Evecorp\\Domain\\Validator\\ApiKeyAccountValidator';

	/**
	 * Testsuite setup
	 */
	public function setup() {
		$this->validator = $this->getMock($this->validatorClassName, array('translateErrorMessage'));
	}

	/**
	 * Data provider with invalid validation types
	 * @return array
	 */
	public function invalidValidationTypes() {
		return array(
			array('string'),
			array(12345),
			array(new \stdClass()),
		);
	}

	/**
	 * @test
	 * @dataProvider invalidValidationTypes
	 * @param mixed $types
	 */
	public function wrongValidationTypeResultsInFailure($types) {
		$this->assertTrue($this->validator->validate($types)->hasErrors());
	}

	/**
	 * Data provider with invalid key
	 * @return array
	 */
	public function invalidKeyIdOrVCode() {
		return array(
			array('', ''),
			array(12, ''),
			array('12', ''),
			array(12.5, ''),
		);
	}

	/**
	 * @test
	 * @dataProvider invalidKeyIdOrVCode
	 * @param mixed $keyId
	 * @param mixed $vCode
	 */
	public function apiKeyAccountValidatorReturnFalseForInvalidKeyIdOrVCode($keyId, $vCode) {
		$apiKeyAccountModel = new \Gerh\Evecorp\Domain\Model\ApiKeyAccount();
		$apiKeyAccountModel->setKeyId($keyId);
		$apiKeyAccountModel->setVCode($vCode);

		$this->assertTrue($this->validator->validate($apiKeyAccountModel)->hasErrors());
	}

	/**
	 * Data provder for different count ofkey ids
	 *
	 * @return array
	 */
	public function countOfKeyIds () {
		return array(
			array(0, false),
			array(1, true)
		);
	}

	/**
	 * @test
	 * @dataProvider countOfKeyIds
	 * @param \integer $returnValue
	 * @param \boolean $expected
	 */
	public function checkIsKeyAlreadyInDatabase($returnValue, $expected) {
		$mockObjectManager = $this->getMock('TYPO3\\CMS\\Extbase\\Object\\ObjectManagerInterface');
		$mockedRepository = $this->getMock('Gerh\\Evecorp\\Domain\\Repository\\ApiKeyAccountRepository', array('countByKeyId'), array($mockObjectManager));
		$mockedRepository
			->expects($this->once())
			->method('countByKeyId')
			->will($this->returnValue($returnValue));

		$this->inject($this->validator, 'apiKeyAccountRepository', $mockedRepository);

		$actual = $this->callInaccessibleMethod($this->validator, 'isKeyIdAlreadyInDatabase', 1234567890);

		$this->assertEquals($expected, $actual);
	}

	/**
	 * Data provider for different count of character ids
	 *
	 * @return array
	 */
	public function countOfCharacterIds() {
		return array(
			array(0, false),
			array(1, true),
		);
	}

	/**
	 * @test
	 * @dataProvider countOfCharacterIds
	 * @param \integer $returnValue
	 * @param \boolean $expected
	 */
	public function checkIsCharacterAlreadyInDatabase($returnValue, $expected) {
		$mockObjectManager = $this->getMock('TYPO3\\CMS\\Extbase\\Object\\ObjectManagerInterface');
		$mockedRepository = $this->getMock('Gerh\\Evecorp\\Domain\\Repository\\CharacterRepository', array('countByCharacterId'), array($mockObjectManager));
		$mockedRepository
			->expects($this->once())
			->method('countByCharacterId')
			->will($this->returnValue($returnValue));

		$this->inject($this->validator, 'characterRepository', $mockedRepository);

		$actual = $this->callInaccessibleMethod($this->validator, 'isCharacterIdAlreadyInDatabase', 1234567890);

		$this->assertEquals($expected, $actual);
	}

	/**
	 * Data provider for different access mask
	 *
	 * @return \array
	 */
	public function accessMaskList() {
		return array(
			array(8388608,  8388608,  true),
			array(8388608,        2, false),
			array(8388608, 25165896,  true),
		);
	}

	/**
	 * @backupGlobals enabled
	 * @dataProvider accessMaskList
	 * @test
	 * @param \integer $configuredAccessMask
	 * @param \integer $actualAccessMask
	 * @param \boolean $expected
	 */
	public function checkAccessMask($configuredAccessMask, $actualAccessMask, $expected) {
		$modifier = array('accessMask' => $configuredAccessMask);
		$GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['evecorp'] = \serialize($modifier);

		$actual = $this->callInaccessibleMethod($this->validator, 'hasCorrectAccessMask', $actualAccessMask);

		$this->assertEquals($expected, $actual);
	}

}
