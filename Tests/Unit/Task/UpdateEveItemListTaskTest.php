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

namespace Gerh\Evecorp\Test\Task;

use Gerh\Evecorp\Scheduler\UpdateEveItemListTask;
use TYPO3\CMS\Core\Tests\UnitTestCase;
use TYPO3\CMS\Scheduler\Task\AbstractTask;

/**
 *
 *
 * @package evecorp
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class UpdateEveItemListTaskTest extends UnitTestCase {

    /**
     * @test
     */
    public function updateEveItemListTaskIsInstanceOfAbstractTask() {
        $taskMock = $this->createMock(UpdateEveItemListTask::class);
        $this->assertInstanceOf(AbstractTask::class, $taskMock);
    }

}
