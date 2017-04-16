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
class ApiKeyAccountCommandController extends \TYPO3\CMS\Extbase\Mvc\Controller\CommandController {

    /**
     * @var \Gerh\Evecorp\Domain\Repository\ApiKeyAccountRepository
     * @inject
     */
    protected $apiKeyAccountRepository;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager
     * @inject
     */
    protected $persistenceManager;

    /**
     * Set storage pid of api key repository
     *
     * @param \integer $storagePid
     */
    protected function setApiKeyRepositoryStoragePid($storagePid = 0) {
        $querySettings = $this->apiKeyAccountRepository->createQuery()->getQuerySettings();
        $querySettings->setStoragePageIds(array($storagePid));
        $querySettings->setRespectStoragePage(\TRUE);
        $this->apiKeyAccountRepository->setDefaultQuerySettings($querySettings);
    }

    /**
     * Initialize all used repositories with correct storage pid
     *
     * @param \integer $storagePid
     */
    protected function initializeRepositories($storagePid = 0) {
        $this->setApiKeyRepositoryStoragePid($storagePid);
    }

    /**
     * Update stored account api keys
     *
     * @param \integer $storagePid PID where API data could be found
     * @return boolean
     */
    public function apiKeyAccountCommand($storagePid = 0) {

        $this->initializeRepositories($storagePid);

        $mapper = $this->objectManager->get('Gerh\\Evecorp\\Domain\\Mapper\\ApiKeyMapper');
        $mapper->setStoragePid($storagePid);

        foreach ($this->apiKeyAccountRepository->findAll() as $apiKeyAccount) {
            $result = $mapper->updateApiKeyAccount($apiKeyAccount);
            if ($result === \TRUE) {
                $this->apiKeyAccountRepository->update($apiKeyAccount);
            }
        }
        $this->persistenceManager->persistAll();

        return \TRUE;
    }

}
