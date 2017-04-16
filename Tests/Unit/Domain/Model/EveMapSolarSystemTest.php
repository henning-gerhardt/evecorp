<?php

/* * *************************************************************
 *  Copyright notice
 *
 *  (c) 2016 Henning Gerhardt
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 *
 */

namespace Gerh\Evecorp\Test\Domain\Model;

/**
 * Testcase for EveMapRegion
 */
class EveMapSolarSystemTest extends \TYPO3\CMS\Core\Tests\UnitTestCase {

    /**
     * @test
     */
    public function solarSystemIdCouldBeSet() {
        $systemId = 30000142;
        $solarSystem = new \Gerh\Evecorp\Domain\Model\EveMapSolarSystem();
        $solarSystem->setSolarSystemId($systemId);

        $this->assertEquals($systemId, $solarSystem->getSolarSystemId());
    }

    /**
     * @test
     */
    public function solarSystemNameCouldBeSet() {
        $systemName = 'Jita';
        $solarSystem = new \Gerh\Evecorp\Domain\Model\EveMapSolarSystem();
        $solarSystem->setSolarSystemName($systemName);

        $this->assertEquals($systemName, $solarSystem->getSolarSystemName());
    }

}
