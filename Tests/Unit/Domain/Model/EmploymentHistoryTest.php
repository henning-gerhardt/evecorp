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
class EmploymentHistoryTest extends \TYPO3\CMS\Core\Tests\UnitTestCase {

    /**
     * @test
     */
    public function classCouldBeInitiated() {
        $history = new \Gerh\Evecorp\Domain\Model\EmploymentHistory();

        $this->assertInstanceOf('Gerh\Evecorp\Domain\Model\EmploymentHistory', $history);
    }

    /**
     * @test
     */
    public function characterCouldBeSet() {
        $expected = new \Gerh\Evecorp\Domain\Model\Character();
        $expected->setCharacterId(815);
        $expected->setCharacterName('Foo Bar');

        $history = new \Gerh\Evecorp\Domain\Model\EmploymentHistory();
        $history->setCharacter($expected);

        $this->assertEquals($expected, $history->getCharacter());
    }

    /**
     * @test
     */
    public function corporationCouldBeSet() {
        $expected = new \Gerh\Evecorp\Domain\Model\Corporation;
        $expected->setCorporationId(1234);
        $expected->setCorporationName('Bar Corporation');

        $history = new \Gerh\Evecorp\Domain\Model\EmploymentHistory();
        $history->setCorporation($expected);

        $this->assertEquals($expected, $history->getCorporation());
    }

    /**
     * @test
     */
    public function recordIdCouldBeSet() {
        $expected = 987654;

        $history = new \Gerh\Evecorp\Domain\Model\EmploymentHistory();
        $history->setRecordId($expected);

        $this->assertEquals($expected, $history->getRecordId());
    }

    /**
     * @test
     */
    public function startDateCouldBeSet() {
        $expected = new \Gerh\Evecorp\Domain\Model\DateTime();

        $history = new \Gerh\Evecorp\Domain\Model\EmploymentHistory();
        $history->setStartDate($expected);

        $this->assertEquals($expected, $history->getStartDate());
    }

}
