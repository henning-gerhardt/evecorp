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

namespace Gerh\Evecorp\Domain\Mapper;

/**
 *
 *
 * @package evecorp
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class CharacterMapper {

	/**
	 * @var \Gerh\Evecorp\Domain\Repository\AllianceRepository
	 * @inject
	 */
	protected $allianceRepository;

	/**
	 * Holds storage pid information for alliance repository.
	 *
	 * @var array
	 */
	protected $allianceRepositoryStoragePids;

	/**
	 * Holds api  key
	 *
	 * @var \Gerh\Evecorp\Domain\Model\ApiKey
	 */
	protected $apiKey;

	/**
	 * @var \Gerh\Evecorp\Domain\Repository\CharacterRepository
	 * @inject
	 */
	protected $characterRepository;

	/**
	 * Holds storage pid information for character repository.
	 *
	 * @var array
	 */
	protected $characterRepositoryStoragePids;

	/**
	 * @var \Gerh\Evecorp\Domain\Repository\CorporationRepository
	 * @inject
	 */
	protected $corporationRepository;

	/**
	 * Holds storage pid information for corporation repository.
	 *
	 * @var array
	 */
	protected $corporationRepositoryStoragePids;

	/**
	 * @var \Gerh\Evecorp\Domain\Repository\EmploymentHistoryRepository
	 * @inject
	 */
	protected $employmentHistoryRepository;

	/**
	 * Holds storage pid information for employment history repository.
	 *
	 * @var array
	 */
	protected $employmentHistoryRepositoryStoragePids;

	/**
	 * @var \string
	 */
	protected $errorMessage;

	/**
	 * @var \TYPO3\CMS\Extbase\Object\ObjectManagerInterface
	 * @inject
	 */
	protected $objectManager;

	/**
	 * @var \TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager
	 * @inject
	 */
	protected $persistenceManager;

	/**
	 * @var \Gerh\Evecorp\Service\PhealService
	 */
	protected $phealService;

	/**
	 * Add employment history of character
	 *
	 * @param \Gerh\Evecorp\Domain\Model\Character $character
	 * @param \Pheal\Core\RowSet $employmentHistory
	 */
	protected function addEmploymentHistoryOfCharacter(\Gerh\Evecorp\Domain\Model\Character $character, \Pheal\Core\RowSet $employmentHistory) {
		foreach ($employmentHistory as $record) {
			$corporation = $this->getOrCreateCorporationModel(\intval($record->corporationID), $record->corporationName);
			$startDate = new \Gerh\Evecorp\Domain\Model\DateTime($record->startDate, new \DateTimeZone('UTC'));

			$employment = $this->createEmploymentHistoryModel($character, $corporation, intval($record->recordID), $startDate);
			$this->employmentHistoryRepository->add($employment);
		}
		$this->persistenceManager->persistAll();
	}

	/**
	 * Create an employment history model
	 *
	 * @param \Gerh\Evecorp\Domain\Model\Character $character
	 * @param \Gerh\Evecorp\Domain\Model\Corporation $corporation
	 * @param \integer $recordId
	 * @param \Gerh\Evecorp\Domain\Model\DateTime $startDate
	 * @return \Gerh\Evecorp\Domain\Model\EmploymentHistory
	 */
	protected function createEmploymentHistoryModel($character, $corporation, $recordId, $startDate) {
		$employment = new \Gerh\Evecorp\Domain\Model\EmploymentHistory();
		$employment->setCharacter($character);
		$employment->setCorporation($corporation);
		$employment->setRecordId($recordId);
		$employment->setStartDate($startDate);
		// TODO check if setting pid is really necessary
		$employment->setPid($this->employmentHistoryRepositoryStoragePids[0]);
		return $employment;
	}

	/**
	 * Returns an alliance model: Create a new or use a stored one.
	 *
	 * @param \integer $allianceId
	 * @param \string $allianceName
	 * @return \Gerh\Evecorp\Domain\Model\Alliance
	 * @throws \Exception Throws exception if allianceId is less then one.
	 */
	protected function getOrCreateAllianceModel($allianceId, $allianceName) {
		if ($allianceId > 0) {
			$searchResult = $this->allianceRepository->findOneByAllianceId($allianceId);
			if ($searchResult) {
				$alliance = $searchResult;
			} else {
				$alliance = new \Gerh\Evecorp\Domain\Model\Alliance($allianceId, $allianceName);
				// TODO check if setting pid is really necessary
				$alliance->setPid($this->allianceRepositoryStoragePids[0]);
				$this->allianceRepository->add($alliance);
				$this->persistenceManager->persistAll();
			}

			return $alliance;
		}

		throw new \Exception('Could not determinate characters alliance.');
	}

	/**
	 * Returns a corporation model: Create a new or use stored one.
	 *
	 * @param \integer $corporationId
	 * @param \string $corporationName
	 * @return \Gerh\Evecorp\Domain\Model\Corporation
	 * @throws \Exception Throws exception if corporationId is less then one.
	 */
	protected function getOrCreateCorporationModel($corporationId, $corporationName) {
		if ($corporationId > 0) {
			$searchResult = $this->corporationRepository->findOneByCorporationId($corporationId);
			if ($searchResult) {
				$corporation = $searchResult;
			} else {
				$corporation = new \Gerh\Evecorp\Domain\Model\Corporation($corporationId, $corporationName);
				// TODO check if setting pid is really necessary
				$corporation->setPid($this->corporationRepositoryStoragePids[0]);
				$this->corporationRepository->add($corporation);
				$this->persistenceManager->persistAll();
			}

			return $corporation;
		}

		throw new \Exception('Could not determinate characters corporation.');
	}

	/**
	 * Set chracter information from character info response
	 *
	 * @param \Gerh\Evecorp\Domain\Model\Character $character
	 * @param \Pheal\Core\Result $response
	 */
	protected function setCharacterInformationFromCharacterInfoResponse($character, $response) {
		$character->setCharacterName($response->characterName);
		$character->setRace($response->race);
		$character->setSecurityStatus($response->securityStatus);

		$corporationDate = new \Gerh\Evecorp\Domain\Model\DateTime($response->corporationDate, new \DateTimeZone('UTC'));
		$character->setCorporationDate($corporationDate);

		// TODO check if setting pid is really necessary
		$character->setPid($this->characterRepositoryStoragePids[0]);

		$corporationModel = $this->getOrCreateCorporationModel(\intval($response->corporationID), $response->corporation);
		$allianceId = \intval($response->allianceID);
		$allianceName = $response->alliance;
		if ((!empty($allianceId)) && (!empty($allianceName))) {
			$allianceModel = $this->getOrCreateAllianceModel($allianceId, $allianceName);
			$corporationModel->setCurrentAlliance($allianceModel);
		} else {
			$corporationModel->setCurrentAlliance(\NULL);
		}
		$character->setCurrentCorporation($corporationModel);
	}

	/**
	 * Updating employment history of character
	 *
	 * @param \Gerh\Evecorp\Domain\Model\Character $character
	 * @param \Pheal\Core\RowSet $employmentHistory
	 * @return void
	 */
	protected function updateEmploymentHistoryOfCharacter(\Gerh\Evecorp\Domain\Model\Character $character, \Pheal\Core\RowSet $employmentHistory) {

		$currentEmployments = $this->employmentHistoryRepository->findByCharacterUid($character);
		$wellknownEmployments = array();

		foreach ($employmentHistory as $record) {
			$corporation = $this->getOrCreateCorporationModel(\intval($record->corporationID), $record->corporationName);
			$startDate = new \Gerh\Evecorp\Domain\Model\DateTime($record->startDate, new \DateTimeZone('UTC'));

			$result = $this->employmentHistoryRepository->searchForEmployment($character, $corporation, $startDate);

			if ($result === NULL) {
				$employment = $this->createEmploymentHistoryModel($character, $corporation, intval($record->recordID), $startDate);
				$this->employmentHistoryRepository->add($employment);
			} else {
				$wellknownEmployments[$result->getUid()] = $result;
			}
		}

		foreach ($currentEmployments as $employment) {
			if (array_key_exists($employment->getUid(), $wellknownEmployments) === false) {
				$character->removeEmployment($employment);
			}
		}
		$this->persistenceManager->persistAll();
	}

	/**
	 * Set characters corporation titles
	 *
	 * @param \Gerh\Evecorp\Domain\Model\Character $characterModel
	 * @param \Pheal\Core\RowSet $fetchedTitles
	 */
	protected function setCharacterCorporationTitles(\Gerh\Evecorp\Domain\Model\Character $characterModel, \Pheal\Core\RowSet $fetchedTitles) {
		$existingCorpTitles = $characterModel->getCurrentCorporation()->getCorporationTitles();
		$characterModel->removeAllTitles();
		foreach ($fetchedTitles as $fetchedTitle) {
			/* @var $existingCorpTitle \Gerh\Evecorp\Domain\Model\CorporationTitle */
			foreach ($existingCorpTitles as $existingCorpTitle) {
				if ($existingCorpTitle->getTitleId() === intval($fetchedTitle->titleID)) {
					$characterModel->addTitle($existingCorpTitle);
				}
			}
		}
	}

	/**
	 * class constructor
	 */
	public function __construct(\Gerh\Evecorp\Domain\Model\ApiKey $apiKeyModel = \NULL) {

		if ($apiKeyModel === \NULL) {
			$apiKeyModel = new \Gerh\Evecorp\Domain\Model\ApiKey();
		}

		$this->apiKey = $apiKeyModel;
		$scope = 'eve';
		$this->phealService = new \Gerh\Evecorp\Service\PhealService($this->apiKey->getKeyId(), $this->apiKey->getVCode(), $scope);
		$objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');

		$this->setAllianceRepository($objectManager->get('Gerh\\Evecorp\\Domain\\Repository\\AllianceRepository'));
		$this->setCharacterRepository($objectManager->get('Gerh\\Evecorp\\Domain\\Repository\\CharacterRepository'));
		$this->setCorporationRepository($objectManager->get('Gerh\\Evecorp\\Domain\\Repository\\CorporationRepository'));
		$this->setEmploymentHistoryRepository($objectManager->get('Gerh\\Evecorp\\Domain\\Repository\\EmploymentHistoryRepository'));
		$this->persistenceManager = $objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager');
	}

	/**
	 * Returns error message
	 *
	 * @return \string
	 */
	public function getErrorMessage() {
		return $this->errorMessage;
	}

	/**
	 * Create character model for given character id from API data
	 *
	 * @param \integer $characterId
	 * @return \Gerh\Evecorp\Domain\Model\Character | NULL
	 */
	public function createModel($characterId) {

		$pheal = $this->phealService->getPhealInstance();

		try {
			$response = $pheal->eveScope->CharacterInfo(array('CharacterID' => $characterId));
		} catch (\Pheal\Exceptions\PhealException $ex) {
			$this->errorMessage = 'Fetched PhealException with message: "' . $ex->getMessage();
			return \NULL;
		}

		$characterDb = $this->characterRepository->findOneByCharacterId(\intval($response->characterID));
		if ($characterDb instanceOf \Gerh\Evecorp\Domain\Model\Character) {
			return $characterDb;
		}

		try {
			$character = new \Gerh\Evecorp\Domain\Model\Character();
			$character->setCharacterId(\intval($response->characterID));

			$this->setCharacterInformationFromCharacterInfoResponse($character, $response);

			$this->addEmploymentHistoryOfCharacter($character, $response->employmentHistory);
		} catch (\Exception $ex) {
			$this->errorMessage = 'Fetched general Exception with message: "' . $ex->getMessage() . '" Model was not be updated!';
			return \NULL;
		}

		if ($this->apiKey->hasAccessTo(\Gerh\Evecorp\Domain\Constants\AccessMask\Character::CHARACTERSHEET)) {
			try {
				$response = $pheal->charScope->CharacterSheet(array('CharacterID' => $characterId));
			} catch (\Pheal\Exceptions\PhealException $ex) {
				$this->errorMessage = 'Fetched PhealException with message: "' . $ex->getMessage();
				return \NULL;
			}

			try {
				$this->setCharacterCorporationTitles($character, $response->corporationTitles);
			} catch (\Exception $ex) {
				$this->errorMessage = 'Fetched general Exception with message: "' . $ex->getMessage() . '" Model was not be updated!';
				return \NULL;
			}
		}

		$this->persistenceManager->persistAll();

		return $character;
	}

	/**
	 * Set alliance repository from outside
	 *
	 * @param \Gerh\Evecorp\Domain\Repository\AllianceRepository $repository
	 */
	public function setAllianceRepository(\Gerh\Evecorp\Domain\Repository\AllianceRepository $repository) {
		$this->allianceRepository = $repository;
		$this->allianceRepositoryStoragePids = $repository->getRepositoryStoragePid();
	}

	/**
	 * Set character repository from outside
	 *
	 * @param \Gerh\Evecorp\Domain\Repository\CharacterRepository $repository
	 */
	public function setCharacterRepository(\Gerh\Evecorp\Domain\Repository\CharacterRepository $repository) {
		$this->characterRepository = $repository;
		$this->characterRepositoryStoragePids = $repository->getRepositoryStoragePid();
	}

	/**
	 * Set corporation repository from outside
	 *
	 * @param \Gerh\Evecorp\Domain\Repository\CorporationRepository $repository
	 */
	public function setCorporationRepository(\Gerh\Evecorp\Domain\Repository\CorporationRepository $repository) {
		$this->corporationRepository = $repository;
		$this->corporationRepositoryStoragePids = $repository->getRepositoryStoragePid();
	}

	/**
	 * Set employment history repository from outside
	 *
	 * @param \Gerh\Evecorp\Domain\Repository\EmploymentHistoryRepository $repository
	 */
	public function setEmploymentHistoryRepository(\Gerh\Evecorp\Domain\Repository\EmploymentHistoryRepository $repository) {
		$this->employmentHistoryRepository = $repository;
		$this->employmentHistoryRepositoryStoragePids = $repository->getRepositoryStoragePid();
	}

	/**
	 * Store storage pid and initialise used repositories to use this storage pid.
	 *
	 * @param \int $storagePid
	 */
	public function setStoragePid($storagePid = 0) {
		if ($storagePid !== \NULL) {
			$this->allianceRepository->setRepositoryStoragePid($storagePid);
			$this->allianceRepositoryStoragePids = array($storagePid);
			$this->characterRepository->setRepositoryStoragePid($storagePid);
			$this->characterRepositoryStoragePids = array($storagePid);
			$this->corporationRepository->setRepositoryStoragePid($storagePid);
			$this->corporationRepositoryStoragePids = array($storagePid);
			$this->employmentHistoryRepository->setRepositoryStoragePid($storagePid);
			$this->employmentHistoryRepositoryStoragePids = array($storagePid);
		}
	}

	/**
	 * Update character model with API data
	 *
	 * @param \Gerh\Evecorp\Domain\Model\Character $characterModel
	 * @return boolean
	 */
	public function updateModel(\Gerh\Evecorp\Domain\Model\Character $characterModel) {

		$pheal = $this->phealService->getPhealInstance();
		$characterId = $characterModel->getCharacterId();

		try {
			$response = $pheal->eveScope->CharacterInfo(array('CharacterID' => $characterId));
		} catch (\Pheal\Exceptions\PhealException $ex) {
			$this->errorMessage = 'Fetched PhealException with message: "' . $ex->getMessage();
			return \FALSE;
		}

		try {

			$this->setCharacterInformationFromCharacterInfoResponse($characterModel, $response);

			$this->updateEmploymentHistoryOfCharacter($characterModel, $response->employmentHistory);
		} catch (\Exception $ex) {
			$this->errorMessage = 'Fetched general Exception with message: "' . $ex->getMessage() . '" Model was not be updated!';
			return \FALSE;
		}

		if ($this->apiKey->hasAccessTo(\Gerh\Evecorp\Domain\Constants\AccessMask\Character::CHARACTERSHEET)) {
			try {
				$response = $pheal->charScope->CharacterSheet(array('CharacterID' => $characterId));
			} catch (\Pheal\Exceptions\PhealException $ex) {
				$this->errorMessage = 'Fetched PhealException with message: "' . $ex->getMessage();
				return \FALSE;
			}

			try {
				$this->setCharacterCorporationTitles($characterModel, $response->corporationTitles);
			} catch (\Exception $ex) {
				$this->errorMessage = 'Fetched general Exception with message: "' . $ex->getMessage() . '" Model was not be updated!';
				return \FALSE;
			}
		}

		$this->persistenceManager->persistAll();

		return \TRUE;
	}

}
