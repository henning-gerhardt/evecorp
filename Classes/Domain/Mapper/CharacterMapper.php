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
	 * @var \string
	 */
	protected $errorMessage;

	/**
	 * @var \TYPO3\CMS\Extbase\Object\ObjectManager
	 */
	protected $objectManager;

	/**
	 *
	 * @var type
	 */
	protected $phealService;

	/**
	 * class constructor
	 */
	public function __construct(\Gerh\Evecorp\Domain\Model\ApiKey $apiKeyModel) {

		$keyId = $apiKeyModel->getKeyId();
		$vCode = $apiKeyModel->getVCode();
		$scope = 'eve';
		$this->phealService = new \Gerh\Evecorp\Service\PhealService($keyId, $vCode, $scope);
		$this->objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
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
	 * Get alliance model by alliance id
	 *
	 * @param \integer $allianceId
	 * @param \string $allianceName
	 * @return \Gerh\Evecorp\Domain\Model\Alliance | NULL
	 */
	protected function getAllianceModel($allianceId, $allianceName) {
		if ($allianceId > 0) {
			$allianceRepository = $this->objectManager->get('Gerh\\Evecorp\\Domain\\Repository\\AllianceRepository');
			$searchResult = $allianceRepository->findOneByAllianceId($allianceId);
			if ($searchResult) {
				$alliance = $searchResult;
			} else {
				$alliance = new \Gerh\Evecorp\Domain\Model\Alliance($allianceId, $allianceName);
			}
		} else {
			$alliance = NULL;
		}

		return $alliance;
	}

	/**
	 * Get corporation model by corporation id
	 *
	 * @param \integer $corporationId
	 * @return \Gerh\Evecorp\Domain\Model\Corporation
	 */
	protected function getCorporationModel($corporationId) {

		if ($corporationId > 0) {
			$corporationRepository = $this->objectManager->get('Gerh\\Evecorp\\Domain\\Repository\\CorporationRepository');
			$searchResult = $corporationRepository->findOneByCorporationId($corporationId);
			if ($searchResult) {
				$corporation = $searchResult;
			} else {
				$corporationMapper = new \Gerh\Evecorp\Domain\Mapper\CorporationMapper();
				$corporation = $corporationMapper->getCorporationModelFromCorporationId($corporationId);
				$corporationRepository->add($corporation);
				$persistenceManager = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager');
				$persistenceManager->persistAll();
			}

			return $corporation;
		}

		throw new \Exception('Could not determinate characters´corporation.');
	}

	/**
	 * Add employment history of character
	 *
	 * @param \Gerh\Evecorp\Domain\Model\Character $character
	 * @param \Pheal\Core\RowSet $employmentHistory
	 */
	protected function addEmploymentHistoryOfCharachter(\Gerh\Evecorp\Domain\Model\Character $character, \Pheal\Core\RowSet $employmentHistory) {
		$employmentHistoryRepository = $this->objectManager->get('Gerh\\Evecorp\\Domain\\Repository\\EmploymentHistoryRepository');

		foreach($employmentHistory as $record) {
			$corporation = $this->getCorporationModel(\intval($record->corporationID), '');
			$startDate = new \Gerh\Evecorp\Domain\Model\DateTime($record->startDate, new \DateTimeZone('UTC'));

			$employment = new \Gerh\Evecorp\Domain\Model\EmploymentHistory();
			$employment->setCharacterUid($character);
			$employment->setCorporationUid($corporation);
			$employment->setRecordId($record->recordID);
			$employment->setStartDate($startDate);

			$employmentHistoryRepository->add($employment);
		}
	}

	/**
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
			$character->setCharacterName($response->characterName);
			$character->setRace($response->race);
			$character->setSecurityStatus($response->securityStatus);
			$character->setCurrentCorporation($this->getCorporationModel(\intval($response->corporationID), $response->corporationUid));
			$character->setCurrentAlliance($this->getAllianceModel(\intval($response->allianceID), $response->alliance));

			$this->addEmploymentHistoryOfCharachter($character, $response->employmentHistory);

			return $character;

		} catch (\Exception $ex) {
			$this->errorMessage = 'Fetched general Exception with message: "' . $ex->getMessage() . '" Model was not be updated!';
			return NULL;
		}

	}
}
