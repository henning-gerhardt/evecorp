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

use Gerh\Evecorp\Domain\Constants\AccessMask\Corporation;
use Gerh\Evecorp\Domain\Mapper\CorporationMemberList;
use Gerh\Evecorp\Domain\Repository\ApiKeyCorporationRepository;
use TYPO3\CMS\Extbase\Mvc\Controller\CommandController;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;

/**
 * Description of CorpMemberListCommandController
 *
 * @author Henning Gerhardt
 */
class UpdateCorporationMemberListCommandController extends CommandController
{

    /**
     * @var \Gerh\Evecorp\Domain\Repository\ApiKeyCorporationRepository
     */
    protected $apiKeyCorporationRepository;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager
     */
    protected $persistenceManager;

    /**
     * Set storage pid of api key repository
     *
     * @param \integer $storagePid
     */
    protected function setApiKeyCorporationRepositoryStoragePid($storagePid = 0)
    {
        $querySettings = $this->apiKeyCorporationRepository->createQuery()->getQuerySettings();
        $querySettings->setStoragePageIds([$storagePid]);
        $querySettings->setRespectStoragePage(\TRUE);
        $this->apiKeyCorporationRepository->setDefaultQuerySettings($querySettings);
    }

    /**
     * Initialize all used repositories with correct storage pid
     *
     * @param \integer $storagePid
     */
    protected function initializeRepositories($storagePid = 0)
    {
        $this->setApiKeyCorporationRepositoryStoragePid($storagePid);
    }

    /**
     * Class constructor.
     *
     * @param ApiKeyCorporationRepository $apiKeyCorporationRepository
     * @param PersistenceManager $persistenceManager
     * @return void
     */
    public function __construct(ApiKeyCorporationRepository $apiKeyCorporationRepository, PersistenceManager $persistenceManager)
    {
        $this->apiKeyCorporationRepository = $apiKeyCorporationRepository;
        $this->persistenceManager = $persistenceManager;
    }

    /**
     * Update corporations member lists
     *
     * @param \int $storagePid
     * @return boolean
     */
    public function updateCorporationMemberListCommand($storagePid = 0)
    {

        $this->initializeRepositories($storagePid);

        foreach ($this->apiKeyCorporationRepository->findAll() as $corporationApiKey) {
            if ($corporationApiKey->hasAccessTo(Corporation::MEMBERTRACKINGLIMITED)) {
                $corporation = $corporationApiKey->getCorporation();

                // use object manager to get proper initialised object
                $corpMemberListUpdater = $this->objectManager->get(CorporationMemberList::class);
                $corpMemberListUpdater->setStoragePid($storagePid);
                $corpMemberListUpdater->setCorporationApiKey($corporationApiKey);
                $corpMemberListUpdater->setCorporation($corporation);
                $corpMemberListUpdater->updateCorpMemberList();
            }
        }

        $this->persistenceManager->persistAll();

        return \TRUE;
    }
}
