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
        $expected = new \Gerh\Evecorp\Domain\Model\ApiKeyAccount();

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
        $expected = new \Gerh\Evecorp\Domain\Model\CorpMember();

        $character = new \Gerh\Evecorp\Domain\Model\Character();
        $character->setCorpMember($expected);

        $this->assertEquals($expected, $character->getCorpMember());
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

}
