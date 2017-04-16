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
 * ************************************************************* */

namespace Gerh\Evecorp\Test\Domain\Model;

/**
 *
 *
 * @package evecorp
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class ApiKeyAccountTest extends \TYPO3\CMS\Core\Tests\UnitTestCase {

    /**
     * @test
     */
    public function classCouldBeInitiated() {
        $apiKeyAccount = new \Gerh\Evecorp\Domain\Model\ApiKeyAccount();

        $this->assertInstanceOf('Gerh\Evecorp\Domain\Model\ApiKeyAccount', $apiKeyAccount);
    }

    /**
     * @test
     */
    public function corpMemberCouldBeSet() {
        $expected = new \Gerh\Evecorp\Domain\Model\CorpMember();

        $apiKeyAccount = new \Gerh\Evecorp\Domain\Model\ApiKeyAccount();
        $apiKeyAccount->setCorpMember($expected);

        $this->assertEquals($expected, $apiKeyAccount->getCorpMember());
    }

}
