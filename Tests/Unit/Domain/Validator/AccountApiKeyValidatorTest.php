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

namespace Gerh\Evecorp\Test\Domain\Validator;

/**
 *
 *
 * @package evecorp
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class AccountApiKeyValidatorTest extends \TYPO3\CMS\Extbase\Tests\Unit\Validation\Validator\AbstractValidatorTestcase {

    /**
     * @var \string
     */
    protected $validatorClassName = 'Gerh\\Evecorp\\Domain\\Validator\\AccountApiKeyValidator';

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
    public function countOfKeyIds() {
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
     * Data provider for testing character is in database
     *
     * @return array
     */
    public function characterInDatabase() {
        $internalCharacter = new \Gerh\Evecorp\Domain\Model\Internal\Character();
        $internalCharacter->setCharacterId(1);
        $simpleCharacter = new \Gerh\Evecorp\Domain\Model\Character();
        $complexCharacter = new \Gerh\Evecorp\Domain\Model\Character();
        $complexCharacter->setCorpMember(new \Gerh\Evecorp\Domain\Model\CorpMember());

        return array(
            array($internalCharacter, \NULL, \TRUE),
            array($internalCharacter, $simpleCharacter, \TRUE),
            array($internalCharacter, $complexCharacter, \FALSE)
        );
    }

    /**
     * @test
     * @dataProvider characterInDatabase
     * @param \Gerh\Evecorp\Domain\Model\Internal\Character $internalCharacter
     * @param mixed $databaseValue
     * @param \boolean $expected
     */
    public function checkIsCharacterIsNotInDatabaseNorHasALoginAssigned($internalCharacter, $databaseValue, $expected) {
        $mockObjectManager = $this->getMock('TYPO3\\CMS\\Extbase\\Object\\ObjectManagerInterface');
        $mockedRepository = $this->getMock('Gerh\\Evecorp\\Domain\\Repository\\CharacterRepository', array('findOneByCharacterId'), array($mockObjectManager));
        $mockedRepository
                ->expects($this->once())
                ->method('findOneByCharacterId')
                ->will($this->returnValue($databaseValue));

        $this->inject($this->validator, 'characterRepository', $mockedRepository);

        $actual = $this->callInaccessibleMethod($this->validator, 'isCharacterIsNotInDatabaseNorHasALoginAssigned', $internalCharacter);

        $this->assertEquals($expected, $actual);
    }

    /**
     * Data provider for different access mask
     *
     * @return \array
     */
    public function accessMaskList() {
        return array(
            array(8388608, 8388608, true),
            array(8388608, 2, false),
            array(8388608, 25165896, true),
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
