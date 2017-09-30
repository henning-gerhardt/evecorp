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

use Gerh\Evecorp\Domain\Constants\AccessMask\Character;
use Gerh\Evecorp\Domain\Constants\AccessMask\Corporation;
use Gerh\Evecorp\Domain\Model\ApiKey;
use Gerh\Evecorp\Domain\Model\DateTime;
use TYPO3\CMS\Core\Tests\UnitTestCase;

/**
 *
 *
 * @package evecorp
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class ApiKeyTest extends UnitTestCase {

    /**
     * @test
     */
    public function classCouldBeInitiated() {
        $apiKey = new ApiKey();

        $this->assertInstanceOf('Gerh\Evecorp\Domain\Model\ApiKey', $apiKey);
    }

    /**
     * @test
     */
    public function accessMaskCouldBeSet() {
        $expected = 1234567890;

        $apiKey = new ApiKey();
        $apiKey->setAccessMask($expected);

        $this->assertEquals($expected, $apiKey->getAccessMask());
    }

    /**
     * @test
     */
    public function expiresCouldBeSet() {
        $expected = new DateTime();

        $apiKey = new ApiKey();
        $apiKey->setExpires($expected);

        $this->assertEquals($expected, $apiKey->getExpires());
    }

    /**
     * @test
     */
    public function keyIdCouldBeSet() {
        $expected = 1234567890;

        $apiKey = new ApiKey();
        $apiKey->setKeyId($expected);

        $this->assertEquals($expected, $apiKey->getKeyId());
    }

    /**
     * @test
     */
    public function vCodeCouldBeSet() {
        $expected = 'FooBar';

        $apiKey = new ApiKey();
        $apiKey->setVCode($expected);

        $this->assertEquals($expected, $apiKey->getVCode());
    }

    /**
     *
     * @return array
     */
    public function accessProvider() {
        $characterMask = Character::BOOKMARKS +
            Character::KILLLOG +
            Character::CONTACTLIST;

        $corporationMask = Corporation::TITLES +
            Corporation::FACWARSTATS;

        return [
            [\TRUE, $characterMask, Character::BOOKMARKS],
            [\TRUE, $characterMask, Character::KILLLOG],
            [\TRUE, $characterMask, Character::CONTACTLIST],
            [\FALSE, $characterMask, Character::CALENDAREVENTATTENDEES],
            [\TRUE, $corporationMask, Corporation::TITLES],
            [\FALSE, $corporationMask, Corporation::INDUSTRYJOBS],
            [\FALSE, $corporationMask, Corporation::ACCOUNTBALANCE],
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
        $apiKey = new ApiKey();
        $apiKey->setAccessMask($accessMask);
        $result = $apiKey->hasAccessTo($toProveAgainst);

        $this->assertEquals($expected, $result);
    }

}
