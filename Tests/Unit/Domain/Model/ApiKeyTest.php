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

namespace Gerh\Evecorp\Test\Domain\Model;

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
    public function classCouldBeInitiated() {
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
    public function vCodeCouldBeSet() {
        $expected = 'FooBar';

        $apiKey = new \Gerh\Evecorp\Domain\Model\ApiKey();
        $apiKey->setVCode($expected);

        $this->assertEquals($expected, $apiKey->getVCode());
    }

    /**
     *
     * @return array
     */
    public function accessProvider() {
        $characterMask = \Gerh\Evecorp\Domain\Constants\AccessMask\Character::BOOKMARKS +
            \Gerh\Evecorp\Domain\Constants\AccessMask\Character::KILLLOG +
            \Gerh\Evecorp\Domain\Constants\AccessMask\Character::CONTACTLIST;

        $corporationMask = \Gerh\Evecorp\Domain\Constants\AccessMask\Corporation::TITLES +
            \Gerh\Evecorp\Domain\Constants\AccessMask\Corporation::FACWARSTATS;

        return [
            [\TRUE, $characterMask, \Gerh\Evecorp\Domain\Constants\AccessMask\Character::BOOKMARKS],
            [\TRUE, $characterMask, \Gerh\Evecorp\Domain\Constants\AccessMask\Character::KILLLOG],
            [\TRUE, $characterMask, \Gerh\Evecorp\Domain\Constants\AccessMask\Character::CONTACTLIST],
            [\FALSE, $characterMask, \Gerh\Evecorp\Domain\Constants\AccessMask\Character::CALENDAREVENTATTENDEES],
            [\TRUE, $corporationMask, \Gerh\Evecorp\Domain\Constants\AccessMask\Corporation::TITLES],
            [\FALSE, $corporationMask, \Gerh\Evecorp\Domain\Constants\AccessMask\Corporation::INDUSTRYJOBS],
            [\FALSE, $corporationMask, \Gerh\Evecorp\Domain\Constants\AccessMask\Corporation::ACCOUNTBALANCE],
        ];
    }

    /**
     * @test
     * @param \boolean $expected
     * @param \integer $accessMask
     * @param \integer $toProveAgainst
     * @dataProvider accessProvider
     */
    public function hasAccessToChecks($expected, $accessMask, $toProveAgainst) {
        $apiKey = new \Gerh\Evecorp\Domain\Model\ApiKey();
        $apiKey->setAccessMask($accessMask);
        $result = $apiKey->hasAccessTo($toProveAgainst);

        $this->assertEquals($expected, $result);
    }

}
