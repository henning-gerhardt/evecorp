<?php
namespace Gerh\Evecorp\Domain\Mapper;

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
class CharacterMapper {

	/**
	 * @var \Gerh\Evecorp\Domain\Repository\AllianceRepository
	 */
	protected $allianceRepository;

	/**
	 * @var \Gerh\Evecorp\Domain\Repository\CorporationRepository
	 */
	protected $corporationRepository;

	/**
	 * @var \Gerh\Evecorp\Domain\Repository\CharacterRepository
	 */
	protected $characterRepository;

	/**
	 * @var \Gerh\Evecorp\Domain\Repository\EmploymentHistoryRepository
	 */
	protected $employmentHistoryRepository;

	/**
	 * @var \string
	 */
	protected $errorMessage;

	/**
	 * @var \TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager
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
		foreach($employmentHistory as $record) {
			$corporation = $this->getOrCreateCorporationModel(\intval($record->corporationID), $record->corporationName);
			$startDate = new \Gerh\Evecorp\Domain\Model\DateTime($record->startDate, new \DateTimeZone('UTC'));

			$employment = $this->createEmploymentHistoryModel($character, $corporation, intval($record->recordID), $startDate);
			$this->employmentHistoryRepository->add($employment);
		}
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
		$storagePids = $this->employmentHistoryRepository->createQuery()->getQuerySettings()->getStoragePageIds();
		$employment->setPid($storagePids[0]);
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
				$storagePids = $this->allianceRepository->createQuery()->getQuerySettings()->getStoragePageIds();
				$alliance->setPid($storagePids[0]);
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
			}  else {
				$corporation = new \Gerh\Evecorp\Domain\Model\Corporation($corporationId, $corporationName);
				$storagePids = $this->corporationRepository->createQuery()->getQuerySettings()->getStoragePageIds();
				$corporation->setPid($storagePids[0]);
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

		$storagePids = $this->characterRepository->createQuery()->getQuerySettings()->getStoragePageIds();
		$character->setPid($storagePids[0]);

		$corporationModel = $this->getOrCreateCorporationModel(\intval($response->corporationID), $response->corporation);
		$allianceId = \intval($response->allianceID);
		$allianceName = $response->alliance;
		if ((! empty($allianceId)) && (! empty($allianceName))) {
			$allianceModel = $this->getOrCreateAllianceModel($allianceId, $allianceName);
			$corporationModel->setCurrentAlliance($allianceModel);
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

		foreach($employmentHistory as $record) {
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

		foreach($currentEmployments as $employment) {
			if (array_key_exists($employment->getUid(), $wellknownEmployments) === false) {
				$character->removeEmployment($employment);
			}
		}
	}

	/**
	 * class constructor
	 */
	public function __construct(\Gerh\Evecorp\Domain\Model\ApiKey $apiKeyModel) {

		$keyId = $apiKeyModel->getKeyId();
		$vCode = $apiKeyModel->getVCode();
		$scope = 'eve';
		$this->phealService = new \Gerh\Evecorp\Service\PhealService($keyId, $vCode, $scope);
		$objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');

		$this->allianceRepository = $objectManager->get('Gerh\\Evecorp\\Domain\\Repository\\AllianceRepository');
		$this->corporationRepository = $objectManager->get('Gerh\\Evecorp\\Domain\\Repository\\CorporationRepository');
		$this->characterRepository = $objectManager->get('Gerh\\Evecorp\\Domain\\Repository\\CharacterRepository');
		$this->employmentHistoryRepository = $objectManager->get('Gerh\\Evecorp\\Domain\\Repository\\EmploymentHistoryRepository');
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
			return NULL;
		}

		try {
			$character = new \Gerh\Evecorp\Domain\Model\Character();
			$character->setCharacterId(\intval($response->characterID));

			$this->setCharacterInformationFromCharacterInfoResponse($character, $response);

			$this->addEmploymentHistoryOfCharacter($character, $response->employmentHistory);

			return $character;

		} catch (\Exception $ex) {
			$this->errorMessage = 'Fetched general Exception with message: "' . $ex->getMessage() . '" Model was not be updated!';
			return NULL;
		}

	}

	/**
	 * Set alliance repository from outside
	 *
	 * @param \Gerh\Evecorp\Domain\Repository\AllianceRepository $repository
	 */
	public function setAllianceRepository(\Gerh\Evecorp\Domain\Repository\AllianceRepository $repository) {
		$this->allianceRepository = $repository;
	}

	/**
	 * Set corporation repository from outside
	 *
	 * @param \Gerh\Evecorp\Domain\Repository\CorporationRepository $repository
	 */
	public function setCorporationRepository(\Gerh\Evecorp\Domain\Repository\CorporationRepository $repository) {
		$this->corporationRepository = $repository;
	}

	/**
	 * Set character repository from outside
	 *
	 * @param \Gerh\Evecorp\Domain\Repository\CharacterRepository $repository
	 */
	public function setCharacterRepository(\Gerh\Evecorp\Domain\Repository\CharacterRepository $repository) {
		$this->characterRepository = $repository;
	}

	/**
	 * Set employment history repository from outside
	 *
	 * @param \Gerh\Evecorp\Domain\Repository\EmploymentHistoryRepository $repository
	 */
	public function setEmploymentHistoryRepository(\Gerh\Evecorp\Domain\Repository\EmploymentHistoryRepository $repository) {
		$this->employmentHistoryRepository = $repository;
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
			return FALSE;
		}

		try {

			$this->setCharacterInformationFromCharacterInfoResponse($characterModel, $response);

			$this->updateEmploymentHistoryOfCharacter($characterModel, $response->employmentHistory);

		} catch (\Exception $ex) {
			$this->errorMessage = 'Fetched general Exception with message: "' . $ex->getMessage() . '" Model was not be updated!';
			return FALSE;
		}

		return TRUE;
	}
}
