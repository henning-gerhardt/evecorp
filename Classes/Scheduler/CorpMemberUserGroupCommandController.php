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

namespace Gerh\Evecorp\Scheduler;

/**
 *
 *
 * @package evecorp
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class CorpMemberUserGroupCommandController extends \TYPO3\CMS\Extbase\Mvc\Controller\CommandController {

    /**
     * @var \Gerh\Evecorp\Domain\Repository\CorpMemberRepository
     * @inject
     */
    protected $corpMemberRepository;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager
     * @inject
     */
    protected $persistenceManager;

    /**
     * Update usergroup membership of corp member
     *
     * @param \integer $storagePid PID of stored corp member (mostly fe user pid)
     * @return bool
     */
    public function corpMemberUserGroupCommand($storagePid = 0) {

        $querySettings = $this->corpMemberRepository->createQuery()->getQuerySettings();
        $querySettings->setStoragePageIds([$storagePid]);
        $this->corpMemberRepository->setDefaultQuerySettings($querySettings);
        $corpMemberUtility = new \Gerh\Evecorp\Domain\Utility\CorpMemberUtility();
        foreach ($this->corpMemberRepository->findAll() as $corpMember) {
            $corpMemberUtility->adjustFrontendUserGroups($corpMember);
        }
        $this->persistenceManager->persistAll();
        return TRUE;
    }

}
