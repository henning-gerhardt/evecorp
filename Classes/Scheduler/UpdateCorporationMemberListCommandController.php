<?php

/* * *************************************************************
 * Copyright notice
 *
 * (c) 2016 Henning Gerhardt
 *
 * All rights reserved
 *
 * This script is part of the TYPO3 project. The TYPO3 project is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 *
 * This script is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * This copyright notice MUST APPEAR in all copies of the script!
 * ************************************************************* */

namespace Gerh\Evecorp\Scheduler;

/**
 * Description of CorpMemberListCommandController
 *
 * @author Henning Gerhardt
 */
class UpdateCorporationMemberListCommandController extends \TYPO3\CMS\Extbase\Mvc\Controller\CommandController {

	/**
	 * @var \Gerh\Evecorp\Domain\Repository\ApiKeyCorporationRepository
	 * @inject
	 */
	protected $apiKeyCorporationRepository;

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
	protected function setApiKeyCorporationRepositoryStoragePid($storagePid = 0) {
		$querySettings = $this->apiKeyCorporationRepository->createQuery()->getQuerySettings();
		$querySettings->setStoragePageIds(array($storagePid));
		$querySettings->setRespectStoragePage(TRUE);
		$this->apiKeyCorporationRepository->setDefaultQuerySettings($querySettings);
	}

	/**
	 * Initialize all used repositories with correct storage pid
	 *
	 * @param \integer $storagePid
	 */
	protected function initializeRepositories($storagePid = 0) {
		$this->setApiKeyCorporationRepositoryStoragePid($storagePid);
	}

	/**
	 * Update corporations member lists
	 *
	 * @param \int $storagePid
	 * @return boolean
	 */
	public function updateCorporationMemberListCommand($storagePid = 0) {

		$this->initializeRepositories($storagePid);

		foreach ($this->apiKeyCorporationRepository->findAll() as $corporationApiKey) {
			if ($corporationApiKey->hasAccessTo(\Gerh\Evecorp\Domain\Constants\AccessMask\Corporation::MEMBERTRACKINGLIMITED)) {
				$corporation = $corporationApiKey->getCorporation();

				// use object manager to get proper initialised object
				$corpMemberListUpdater = $this->objectManager->get('Gerh\\Evecorp\\Domain\\Mapper\\CorporationMemberList');
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
