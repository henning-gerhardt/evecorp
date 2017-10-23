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

use Gerh\Evecorp\Domain\Model\ApiKeyAccount;
use Gerh\Evecorp\Domain\Model\CorpMember;
use TYPO3\CMS\Core\Tests\UnitTestCase;

/**
 *
 *
 * @package evecorp
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class ApiKeyAccountTest extends UnitTestCase
{

    /**
     * @test
     */
    public function classCouldBeInitiated()
    {
        $apiKeyAccount = new ApiKeyAccount();

        $this->assertInstanceOf(ApiKeyAccount::class, $apiKeyAccount);
    }

    /**
     * @test
     */
    public function corpMemberCouldBeSet()
    {
        $expected = new CorpMember();

        $apiKeyAccount = new ApiKeyAccount();
        $apiKeyAccount->setCorpMember($expected);

        $this->assertEquals($expected, $apiKeyAccount->getCorpMember());
    }
}
