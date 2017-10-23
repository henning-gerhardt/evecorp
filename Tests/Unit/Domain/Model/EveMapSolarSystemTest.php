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

use Gerh\Evecorp\Domain\Model\EveMapSolarSystem;
use TYPO3\CMS\Core\Tests\UnitTestCase;

/**
 * Testcase for EveMapRegion
 */
class EveMapSolarSystemTest extends UnitTestCase
{

    /**
     * @test
     */
    public function solarSystemIdCouldBeSet()
    {
        $systemId = 30000142;
        $solarSystem = new EveMapSolarSystem();
        $solarSystem->setSolarSystemId($systemId);

        $this->assertEquals($systemId, $solarSystem->getSolarSystemId());
    }

    /**
     * @test
     */
    public function solarSystemNameCouldBeSet()
    {
        $systemName = 'Jita';
        $solarSystem = new EveMapSolarSystem();
        $solarSystem->setSolarSystemName($systemName);

        $this->assertEquals($systemName, $solarSystem->getSolarSystemName());
    }
}
