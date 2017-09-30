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

use Gerh\Evecorp\Domain\Constants\AccessMask\Corporation as Corporation2;
use Gerh\Evecorp\Domain\Model\Alliance;
use Gerh\Evecorp\Domain\Model\ApiKeyCorporation;
use Gerh\Evecorp\Domain\Model\Corporation;
use TYPO3\CMS\Core\Tests\UnitTestCase;

/**
 *
 *
 * @package evecorp
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class CorporationTest extends UnitTestCase {

    /**
     * @test
     */
    public function classCouldBeInitiated() {
        $corporation = new Corporation();

        $this->assertInstanceOf('Gerh\Evecorp\Domain\Model\Corporation', $corporation);
    }

    /**
     * @test
     */
    public function corporationIdCouldBeSet() {
        $expected = 123456;

        $corporation = new Corporation();
        $corporation->setCorporationId($expected);

        $this->assertEquals($expected, $corporation->getCorporationId());
    }

    /**
     * @test
     */
    public function corporationNameCouldBeSet() {
        $expected = 'FooBar';

        $corporation = new Corporation();
        $corporation->setCorporationName($expected);

        $this->assertEquals($expected, $corporation->getCorporationName());
    }

    /**
     * @test
     */
    public function corporationCouldBeInitializedThroughConstructor() {
        $corporationId = 567890;
        $corporationName = 'BarFoo';

        $corporation = new Corporation($corporationId, $corporationName);

        $this->assertEquals($corporationId, $corporation->getCorporationId());
        $this->assertEquals($corporationName, $corporation->getCorporationName());
    }

    /**
     * @test
     */
    public function currentAllianceCouldBeSetToCorporation() {
        $expected = new Alliance(12, 'FooBar');

        $corporation = new Corporation();
        $corporation->setCurrentAlliance($expected);

        $this->assertEquals($expected, $corporation->getCurrentAlliance());
    }

    /**
     * @test
     */
    public function currentAllianceNameCouldBeGet() {
        $expected = 'BarFoo';
        $alliance = new Alliance(12, $expected);

        $corporation = new Corporation();
        $corporation->setCurrentAlliance($alliance);

        $this->assertEquals($expected, $corporation->getAllianceName());
    }

    /**
     * @test
     */
    public function corporationApiKeyCouldBeSet() {
        $apiKey = new ApiKeyCorporation();
        $apiKey->setAccessMask(
                Corporation2::ASSETLIST +
            Corporation2::CORPORATIONSHEET
        );
        $apiKey->setKeyId(12345678);
        $apiKey->setVCode('1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ');
        $corporation = new Corporation();
        $corporation->addApiKey($apiKey);
        $this->assertTrue($corporation->getApiKeys()->contains($apiKey));
    }

    /**
     * @test
     */
    public function hasApiKeyWithProperAccessMask() {
        $apiKeyOne = new ApiKeyCorporation();
        $apiKeyOne->setAccessMask(
                Corporation2::ASSETLIST +
            Corporation2::CORPORATIONSHEET
        );
        $apiKeyOne->setKeyId(12345678);
        $apiKeyOne->setVCode('1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ');

        $apiKeyTwo = new ApiKeyCorporation();
        $apiKeyTwo->setAccessMask(
                Corporation2::TITLES +
            Corporation2::MEMBERSECURITY
        );
        $apiKeyTwo->setKeyId(123456789);
        $apiKeyTwo->setVCode('ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890');

        $corporation = new Corporation();
        $corporation->addApiKey($apiKeyOne);
        $corporation->addApiKey($apiKeyTwo);

        $this->assertTrue($corporation->hasAccessTo(Corporation2::MEMBERSECURITY));
    }

    /**
     * @test
     */
    public function hasNoneApiKeyWithProperAccessMask() {
        $apiKeyOne = new ApiKeyCorporation();
        $apiKeyOne->setAccessMask(
                Corporation2::ASSETLIST +
            Corporation2::CORPORATIONSHEET
        );
        $apiKeyOne->setKeyId(12345678);
        $apiKeyOne->setVCode('1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ');

        $apiKeyTwo = new ApiKeyCorporation();
        $apiKeyTwo->setAccessMask(
                Corporation2::TITLES +
            Corporation2::MEMBERSECURITY
        );
        $apiKeyTwo->setKeyId(123456789);
        $apiKeyTwo->setVCode('ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890');

        $corporation = new Corporation();
        $corporation->addApiKey($apiKeyOne);
        $corporation->addApiKey($apiKeyTwo);

        $this->assertFalse($corporation->hasAccessTo(Corporation2::KILLLOG));
    }

    /**
     * @test
     */
    public function findApiKeyByAccessMask() {
        $apiKeyOne = new ApiKeyCorporation();
        $apiKeyOne->setAccessMask(
                Corporation2::ASSETLIST +
            Corporation2::CORPORATIONSHEET
        );
        $apiKeyOne->setKeyId(12345678);
        $apiKeyOne->setVCode('1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ');

        $apiKeyTwo = new ApiKeyCorporation();
        $apiKeyTwo->setAccessMask(
                Corporation2::TITLES +
            Corporation2::MEMBERSECURITY
        );
        $apiKeyTwo->setKeyId(123456789);
        $apiKeyTwo->setVCode('ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890');

        $corporation = new Corporation();
        $corporation->addApiKey($apiKeyOne);
        $corporation->addApiKey($apiKeyTwo);

        $result = $corporation->findFirstApiKeyByAccessMask(Corporation2::TITLES);
        $this->assertEquals($apiKeyTwo, $result);
    }

    /**
     * @test
     */
    public function findNoneApiKeyByAccessMask() {
        $apiKeyOne = new ApiKeyCorporation();
        $apiKeyOne->setAccessMask(
                Corporation2::ASSETLIST +
            Corporation2::CORPORATIONSHEET
        );
        $apiKeyOne->setKeyId(12345678);
        $apiKeyOne->setVCode('1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ');

        $apiKeyTwo = new ApiKeyCorporation();
        $apiKeyTwo->setAccessMask(
                Corporation2::TITLES +
            Corporation2::MEMBERSECURITY
        );
        $apiKeyTwo->setKeyId(123456789);
        $apiKeyTwo->setVCode('ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890');

        $corporation = new Corporation();
        $corporation->addApiKey($apiKeyOne);
        $corporation->addApiKey($apiKeyTwo);

        $result = $corporation->findFirstApiKeyByAccessMask(Corporation2::MEDALS);
        $this->assertNull($result);
    }

}
