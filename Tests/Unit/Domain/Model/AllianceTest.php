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

use Gerh\Evecorp\Domain\Model\Alliance;
use TYPO3\CMS\Core\Tests\UnitTestCase;

/**
 *
 *
 * @package evecorp
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class AllianceTest extends UnitTestCase
{

    /**
     * @test
     */
    public function classCouldBeInitiated()
    {
        $alliance = new Alliance();

        $this->assertInstanceOf(Alliance::class, $alliance);
    }

    /**
     * @test
     */
    public function allianceIdCouldBeSet()
    {
        $expected = 123456;

        $alliance = new Alliance();
        $alliance->setAllianceId($expected);

        $this->assertEquals($expected, $alliance->getAllianceId());
    }

    /**
     * @test
     */
    public function allianceNameCouldBeSet()
    {
        $expected = 'FooBar';

        $alliance = new Alliance();
        $alliance->setAllianceName($expected);

        $this->assertEquals($expected, $alliance->getAllianceName());
    }

    /**
     * @test
     */
    public function allianceCouldBeInitializedThroughConstructor()
    {
        $allianceId = 567890;
        $allianceName = 'BarFoo';

        $alliance = new Alliance($allianceId, $allianceName);

        $this->assertEquals($allianceId, $alliance->getAllianceId());
        $this->assertEquals($allianceName, $alliance->getAllianceName());
    }
}
