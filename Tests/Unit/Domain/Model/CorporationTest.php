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
class CorporationTest extends \TYPO3\CMS\Core\Tests\UnitTestCase {

    /**
     * @test
     */
    public function classCouldBeInitiated() {
        $corporation = new \Gerh\Evecorp\Domain\Model\Corporation();

        $this->assertInstanceOf('Gerh\Evecorp\Domain\Model\Corporation', $corporation);
    }

    /**
     * @test
     */
    public function corporationIdCouldBeSet() {
        $expected = 123456;

        $corporation = new \Gerh\Evecorp\Domain\Model\Corporation();
        $corporation->setCorporationId($expected);

        $this->assertEquals($expected, $corporation->getCorporationId());
    }

    /**
     * @test
     */
    public function corporationNameCouldBeSet() {
        $expected = 'FooBar';

        $corporation = new \Gerh\Evecorp\Domain\Model\Corporation();
        $corporation->setCorporationName($expected);

        $this->assertEquals($expected, $corporation->getCorporationName());
    }

    /**
     * @test
     */
    public function corporationCouldBeInitializedThroughConstructor() {
        $corporationId = 567890;
        $corporationName = 'BarFoo';

        $corporation = new \Gerh\Evecorp\Domain\Model\Corporation($corporationId, $corporationName);

        $this->assertEquals($corporationId, $corporation->getCorporationId());
        $this->assertEquals($corporationName, $corporation->getCorporationName());
    }

    /**
     * @test
     */
    public function currentAllianceCouldBeSetToCorporation() {
        $expected = new \Gerh\Evecorp\Domain\Model\Alliance(12, 'FooBar');

        $corporation = new \Gerh\Evecorp\Domain\Model\Corporation();
        $corporation->setCurrentAlliance($expected);

        $this->assertEquals($expected, $corporation->getCurrentAlliance());
    }

    /**
     * @test
     */
    public function currentAllianceNameCouldBeGet() {
        $expected = 'BarFoo';
        $alliance = new \Gerh\Evecorp\Domain\Model\Alliance(12, $expected);

        $corporation = new \Gerh\Evecorp\Domain\Model\Corporation();
        $corporation->setCurrentAlliance($alliance);

        $this->assertEquals($expected, $corporation->getAllianceName());
    }

    /**
     * @test
     */
    public function corporationApiKeyCouldBeSet() {
        $apiKey = new \Gerh\Evecorp\Domain\Model\ApiKeyCorporation();
        $apiKey->setAccessMask(
                \Gerh\Evecorp\Domain\Constants\AccessMask\Corporation::ASSETLIST +
                \Gerh\Evecorp\Domain\Constants\AccessMask\Corporation::CORPORATIONSHEET
        );
        $apiKey->setKeyId(12345678);
        $apiKey->setVCode('1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ');
        $corporation = new \Gerh\Evecorp\Domain\Model\Corporation();
        $corporation->addApiKey($apiKey);
        $this->assertTrue($corporation->getApiKeys()->contains($apiKey));
    }

    /**
     * @test
     */
    public function hasApiKeyWithProperAccessMask() {
        $apiKeyOne = new \Gerh\Evecorp\Domain\Model\ApiKeyCorporation();
        $apiKeyOne->setAccessMask(
                \Gerh\Evecorp\Domain\Constants\AccessMask\Corporation::ASSETLIST +
                \Gerh\Evecorp\Domain\Constants\AccessMask\Corporation::CORPORATIONSHEET
        );
        $apiKeyOne->setKeyId(12345678);
        $apiKeyOne->setVCode('1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ');

        $apiKeyTwo = new \Gerh\Evecorp\Domain\Model\ApiKeyCorporation();
        $apiKeyTwo->setAccessMask(
                \Gerh\Evecorp\Domain\Constants\AccessMask\Corporation::TITLES +
                \Gerh\Evecorp\Domain\Constants\AccessMask\Corporation::MEMBERSECURITY
        );
        $apiKeyTwo->setKeyId(123456789);
        $apiKeyTwo->setVCode('ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890');

        $corporation = new \Gerh\Evecorp\Domain\Model\Corporation();
        $corporation->addApiKey($apiKeyOne);
        $corporation->addApiKey($apiKeyTwo);

        $this->assertTrue($corporation->hasAccessTo(\Gerh\Evecorp\Domain\Constants\AccessMask\Corporation::MEMBERSECURITY));
    }

    /**
     * @test
     */
    public function hasNoneApiKeyWithProperAccessMask() {
        $apiKeyOne = new \Gerh\Evecorp\Domain\Model\ApiKeyCorporation();
        $apiKeyOne->setAccessMask(
                \Gerh\Evecorp\Domain\Constants\AccessMask\Corporation::ASSETLIST +
                \Gerh\Evecorp\Domain\Constants\AccessMask\Corporation::CORPORATIONSHEET
        );
        $apiKeyOne->setKeyId(12345678);
        $apiKeyOne->setVCode('1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ');

        $apiKeyTwo = new \Gerh\Evecorp\Domain\Model\ApiKeyCorporation();
        $apiKeyTwo->setAccessMask(
                \Gerh\Evecorp\Domain\Constants\AccessMask\Corporation::TITLES +
                \Gerh\Evecorp\Domain\Constants\AccessMask\Corporation::MEMBERSECURITY
        );
        $apiKeyTwo->setKeyId(123456789);
        $apiKeyTwo->setVCode('ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890');

        $corporation = new \Gerh\Evecorp\Domain\Model\Corporation();
        $corporation->addApiKey($apiKeyOne);
        $corporation->addApiKey($apiKeyTwo);

        $this->assertFalse($corporation->hasAccessTo(\Gerh\Evecorp\Domain\Constants\AccessMask\Corporation::KILLLOG));
    }

    /**
     * @test
     */
    public function findApiKeyByAccessMask() {
        $apiKeyOne = new \Gerh\Evecorp\Domain\Model\ApiKeyCorporation();
        $apiKeyOne->setAccessMask(
                \Gerh\Evecorp\Domain\Constants\AccessMask\Corporation::ASSETLIST +
                \Gerh\Evecorp\Domain\Constants\AccessMask\Corporation::CORPORATIONSHEET
        );
        $apiKeyOne->setKeyId(12345678);
        $apiKeyOne->setVCode('1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ');

        $apiKeyTwo = new \Gerh\Evecorp\Domain\Model\ApiKeyCorporation();
        $apiKeyTwo->setAccessMask(
                \Gerh\Evecorp\Domain\Constants\AccessMask\Corporation::TITLES +
                \Gerh\Evecorp\Domain\Constants\AccessMask\Corporation::MEMBERSECURITY
        );
        $apiKeyTwo->setKeyId(123456789);
        $apiKeyTwo->setVCode('ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890');

        $corporation = new \Gerh\Evecorp\Domain\Model\Corporation();
        $corporation->addApiKey($apiKeyOne);
        $corporation->addApiKey($apiKeyTwo);

        $result = $corporation->findFirstApiKeyByAccessMask(\Gerh\Evecorp\Domain\Constants\AccessMask\Corporation::TITLES);
        $this->assertEquals($apiKeyTwo, $result);
    }

    /**
     * @test
     */
    public function findNoneApiKeyByAccessMask() {
        $apiKeyOne = new \Gerh\Evecorp\Domain\Model\ApiKeyCorporation();
        $apiKeyOne->setAccessMask(
                \Gerh\Evecorp\Domain\Constants\AccessMask\Corporation::ASSETLIST +
                \Gerh\Evecorp\Domain\Constants\AccessMask\Corporation::CORPORATIONSHEET
        );
        $apiKeyOne->setKeyId(12345678);
        $apiKeyOne->setVCode('1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ');

        $apiKeyTwo = new \Gerh\Evecorp\Domain\Model\ApiKeyCorporation();
        $apiKeyTwo->setAccessMask(
                \Gerh\Evecorp\Domain\Constants\AccessMask\Corporation::TITLES +
                \Gerh\Evecorp\Domain\Constants\AccessMask\Corporation::MEMBERSECURITY
        );
        $apiKeyTwo->setKeyId(123456789);
        $apiKeyTwo->setVCode('ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890');

        $corporation = new \Gerh\Evecorp\Domain\Model\Corporation();
        $corporation->addApiKey($apiKeyOne);
        $corporation->addApiKey($apiKeyTwo);

        $result = $corporation->findFirstApiKeyByAccessMask(\Gerh\Evecorp\Domain\Constants\AccessMask\Corporation::MEDALS);
        $this->assertNull($result);
    }

}
