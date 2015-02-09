<?php
namespace Gerh\Evecorp\Scheduler;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014 Henning Gerhardt
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
 ***************************************************************/

/**
 *
 *
 * @package evecorp
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class ApiKeyAccountCommandController extends \TYPO3\CMS\Extbase\Mvc\Controller\CommandController {

	/**
	 * @var \Gerh\Evecorp\Domain\Repository\AllianceRepository
	 * @inject
	 */
	protected $allianceRepository;

	/**
	 * @var \Gerh\Evecorp\Domain\Repository\ApiKeyAccountRepository
	 * @inject
	 */
	protected $apiKeyAccountRepository;

	/**
	 * @var \Gerh\Evecorp\Domain\Repository\CorporationRepository
	 * @inject
	 */
	protected $corporationRepository;

	/**
	 * @var \Gerh\Evecorp\Domain\Repository\CharacterRepository
	 * @inject
	 */
	protected $characterRepository;

	/**
	 * @var \Gerh\Evecorp\Domain\Repository\EmploymentHistoryRepository
	 * @inject
	 */
	protected $employmentHistoryRepository;

	/**
	 * @var \TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager
	 * @inject
	 */
	protected $persistenceManager;

	/**
	 * Set storage pid of alliance repository
	 *
	 * @param \integer $storagePid
	 */
	protected function setAllianceRepositoryStoragePid($storagePid = 0) {
		$querySettings = $this->allianceRepository->createQuery()->getQuerySettings();
		$querySettings->setStoragePageIds(array($storagePid));
		$querySettings->setRespectStoragePage(TRUE);
		$this->allianceRepository->setDefaultQuerySettings($querySettings);
	}

	/**
	 * Set storage pid of api key repository
	 *
	 * @param \integer $storagePid
	 */
	protected function setApiKeyRepositoryStoragePid($storagePid = 0) {
		$querySettings = $this->apiKeyAccountRepository->createQuery()->getQuerySettings();
		$querySettings->setStoragePageIds(array($storagePid));
		$querySettings->setRespectStoragePage(TRUE);
		$this->apiKeyAccountRepository->setDefaultQuerySettings($querySettings);
	}

	/**
	 * Set storage pid of corporation repository
	 *
	 * @param \integer $storagePid
	 */
	protected function setCorporationRepositoryStoragePid($storagePid = 0) {
		$querySettings = $this->corporationRepository->createQuery()->getQuerySettings();
		$querySettings->setStoragePageIds(array($storagePid));
		$querySettings->setRespectStoragePage(TRUE);
		$this->corporationRepository->setDefaultQuerySettings($querySettings);
	}

	/**
	 * Set storage pid of character repository
	 *
	 * @param \integer $storagePid
	 */
	protected function setCharacterRepositoryStoragePid($storagePid = 0) {
		$querySettings = $this->characterRepository->createQuery()->getQuerySettings();
		$querySettings->setStoragePageIds(array($storagePid));
		$querySettings->setRespectStoragePage(TRUE);
		$this->characterRepository->setDefaultQuerySettings($querySettings);
	}

	/**
	 * Set storage pid of employment history repository
	 *
	 * @param \integer $storagePid
	 */
	protected function setEmploymentHistoryRepositoryStoragePid($storagePid = 0) {
		$querySettings = $this->employmentHistoryRepository->createQuery()->getQuerySettings();
		$querySettings->setStoragePageIds(array($storagePid));
		$querySettings->setRespectStoragePage(TRUE);
		$this->employmentHistoryRepository->setDefaultQuerySettings($querySettings);
	}

	/**
	 * Initialize all used repositories with correct storage pid
	 *
	 * @param \integer $storagePid
	 */
	protected function initializeRepositories($storagePid = 0) {
		$this->setAllianceRepositoryStoragePid($storagePid);
		$this->setApiKeyRepositoryStoragePid($storagePid);
		$this->setCorporationRepositoryStoragePid($storagePid);
		$this->setCharacterRepositoryStoragePid($storagePid);
		$this->setEmploymentHistoryRepositoryStoragePid($storagePid);
	}

	/**
	 * Update stored account api keys
	 *
	 * @param \integer $storagePid PID where API data could be found
	 * @return boolean
	 */
	public function apiKeyAccountCommand($storagePid = 0) {

		$this->initializeRepositories($storagePid);

		$mapper = new \Gerh\Evecorp\Domain\Mapper\ApiKeyMapper();
		$mapper->setAllianceRepository($this->allianceRepository);
		$mapper->setCorporationRepository($this->corporationRepository);
		$mapper->setCharacterRepository($this->characterRepository);
		$mapper->setEmploymentHistoryRepository($this->employmentHistoryRepository);

		foreach ($this->apiKeyAccountRepository->findAll() as $apiKeyAccount) {
			$result = $mapper->updateApiKeyAccount($apiKeyAccount);
			if ($result === TRUE) {
				$this->apiKeyAccountRepository->update($apiKeyAccount);
			}
		}
		$this->persistenceManager->persistAll();

		return TRUE;
	}

}
