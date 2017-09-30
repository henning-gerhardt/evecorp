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

namespace Gerh\Evecorp\Test\Service;

use Gerh\Evecorp\Service\PhealService;
use TYPO3\CMS\Core\Tests\UnitTestCase;
use const PATH_site;

/**
 * Testcase for PhealService
 */
class PhealServiceTest extends UnitTestCase {

    /**
     * @test
     */
    public function classCouldBeInstantiated() {
        $service = new PhealService();
        $this->assertInstanceOf(PhealService::class, $service);
    }

    /**
     * @test
     */
    public function serviceReturnsInstanceOfPhealClass() {
        $service = new PhealService();
        $this->assertInstanceOf(\Pheal\Pheal::class, $service->getPhealInstance());
    }

    /**
     * @test
     */
    public function defaultConnectionTimeoutIsUsedIfNonConfigurated() {
        $service = new PhealService();
        $this->assertEquals(120, $service->getConnectionTimeout());
    }

    /**
     * @backupGlobals enabled
     * @test
     */
    public function connectionTimoutIsSetCorrect() {
        $expected = 5;
        $modifier = ['phealConnectionTimeout' => $expected];
        $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['evecorp'] = \serialize($modifier);

        $service = new PhealService();
        $this->assertEquals($expected, $service->getConnectionTimeout());
    }

    /**
     * @backupGlobals enabled
     * @test
     */
    public function connectionTimoutCouldBeSetToOneSecond() {
        $expected = 1;
        $modifier = ['phealConnectionTimeout' => $expected];
        $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['evecorp'] = \serialize($modifier);

        $service = new PhealService();
        $this->assertEquals($expected, $service->getConnectionTimeout());
    }

    /**
     * @backupGlobals enabled
     * @test
     */
    public function connectionTimoutCouldNotBeSetBelowOneSecond() {
        $expected = 0;
        $modifier = ['phealConnectionTimeout' => $expected];
        $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['evecorp'] = \serialize($modifier);

        $service = new PhealService();
        $this->assertEquals(120, $service->getConnectionTimeout());
    }

    /**
     * @backupGlobals enabled
     * @test
     */
    public function defaultCachePathIsUsedIfNonConfigurated() {
        $modifier = ['phealCacheDirectory' => \NULL];
        $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['evecorp'] = \serialize($modifier);

        $service = new PhealService();
        $expected = \realpath(PATH_site . 'typo3temp');
        $this->assertEquals($expected, $service->getPhealCacheDirectory());
    }

    /**
     * @backupGlobals enabled
     * @test
     */
    public function defaultCachePathIsUsedIfCacheDirectoryDoesNotExists() {
        $modifier = ['phealCacheDirectory' => '\a\b\a'];
        $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['evecorp'] = \serialize($modifier);

        $service = new PhealService();
        $expected = \realpath(PATH_site . 'typo3temp');
        $this->assertEquals($expected, $service->getPhealCacheDirectory());
    }

    /**
     * @backupGlobals enabled
     * @test
     */
    public function defaultCachePathIsUsedIfCacheDirectoryIsNotADirectory() {
        $modifier = ['phealCacheDirectory' => \tempnam(\sys_get_temp_dir(), 'FOO')];
        $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['evecorp'] = \serialize($modifier);

        $service = new PhealService();
        $expected = \realpath(PATH_site . 'typo3temp');
        $this->assertEquals($expected, $service->getPhealCacheDirectory());
    }

    /**
     * @backupGlobals enabled
     * @test
     */
    public function cacheDirectoryCouldBeSet() {
        $expected = \sys_get_temp_dir();
        $modifier = ['phealCacheDirectory' => $expected];
        $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['evecorp'] = \serialize($modifier);

        $service = new PhealService();
        $this->assertEquals($expected, $service->getPhealCacheDirectory());
    }

    /**
     * @test
     */
    public function verifyingHttpsConnectionIsFalseOnDefault() {
        $service = new PhealService();
        $this->assertFalse($service->isHttpsConnectionVerified());
    }

    /**
     * @backupGlobals enabled
     * @test
     */
    public function verifyHttpsConnectoinsCouldBeTrue() {
        $modifier = ['phealVerifyingHttpsConnection' => \TRUE];
        $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['evecorp'] = \serialize($modifier);
        $service = new PhealService();
        $this->assertTrue($service->isHttpsConnectionVerified());
    }

    /**
     * @backupGlobals enabled
     * @test
     */
    public function verifyHttpsConnectoinsIsFalseOnWrongValues() {
        $modifier = ['phealVerifyingHttpsConnection' => 'bla'];
        $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['evecorp'] = \serialize($modifier);
        $service = new PhealService();
        $this->assertFalse($service->isHttpsConnectionVerified());
    }

    /**
     * @backupGlobals enabled
     * @test
     */
    public function fileCreateMaskCouldBeSet() {
        $octValue = '0777';
        $expected = 511;
        $modifier = ['phealFileCreateMask' => $octValue];
        $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['evecorp'] = \serialize($modifier);

        $service = new PhealService();

        $this->assertEquals($expected, $service->getFileMask());
    }

    /**
     * @backupGlobals enabled
     * @test
     */
    public function fileCreateHasDefaultValueIfNotDefined() {
        $expected = 0666; // value is octal!
        // reset productive values
        $modifier = ['phealFileCreateMask' => ''];
        $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['evecorp'] = \serialize($modifier);

        $service = new PhealService();

        $this->assertEquals($expected, $service->getFileMask());
    }

    /**
     * @backupGlobals enabled
     * @test
     */
    public function folderCreateMaskCouldBeSet() {
        $octValue = '2777';
        $expected = 1535;
        $modifier = ['phealFolderCreateMask' => $octValue];
        $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['evecorp'] = \serialize($modifier);

        $service = new PhealService();

        $this->assertEquals($expected, $service->getFolderMask());
    }

    /**
     * @backupGlobals enabled
     * @test
     */
    public function folderCreateHasDefaultValueIfNotDefined() {
        $expected = 0777; // value is octal!
        // reset productive values
        $modifier = ['phealFolderCreateMask' => ''];
        $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['evecorp'] = \serialize($modifier);

        $service = new PhealService();

        $this->assertEquals($expected, $service->getFolderMask());
    }

    /**
     * @backupGlobals enabled
     * @test
     */
    public function getUmaskOptionsReturnsCorrectArrayConstructOnNotDefined() {
        $expected = ['umask' => 0666, 'umask_directory' => 0777]; // values are octal!
        // reset productive values
        $modifier = ['phealFileCreateMask' => '', 'phealFolderCreateMask' => ''];
        $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['evecorp'] = \serialize($modifier);

        $service = new PhealService();

        $this->assertEquals($expected, $service->getUmaskOptions());
    }

    /**
     * @backupGlobals enabled
     * @test
     */
    public function getUmaskOptionsReturnsCorrectArrayConstructOnDefinedValues() {
        $expected = ['umask' => 416, 'umask_directory' => 488];
        $modifier = ['phealFileCreateMask' => '0640', 'phealFolderCreateMask' => '0750'];
        $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['evecorp'] = \serialize($modifier);

        $service = new PhealService();

        $this->assertEquals($expected, $service->getUmaskOptions());
    }

}
