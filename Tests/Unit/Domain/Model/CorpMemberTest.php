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
 * Testcase for CorpMember class
 */
class CorpMemberTest extends \TYPO3\CMS\Core\Tests\UnitTestCase {

    /**
     * @test
     */
    public function classCouldBeInitiatedWithoutUsernameAndPassword() {
        $corpMember = new \Gerh\Evecorp\Domain\Model\CorpMember();

        $this->assertInstanceOf('Gerh\Evecorp\Domain\Model\CorpMember', $corpMember);
    }

}
