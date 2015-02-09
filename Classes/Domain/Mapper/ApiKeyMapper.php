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
class ApiKeyMapper {

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
	 * Create new character and add him to current api key
	 *
	 * @param \integer $characterId
	 * @param \Gerh\Evecorp\Domain\Model\ApiKeyAccount $apiKeyAccount
	 * @throws \Exception
	 * @return void
	 */
	protected function createAndAddNewCharacter($characterId, \Gerh\Evecorp\Domain\Model\ApiKeyAccount $apiKeyAccount) {
		$characterMapper = $this->getNewCharacterMapper($apiKeyAccount);
		$characterModel = $characterMapper->createModel($characterId);

		if ($characterModel === NULL) {
			throw new \Exception($characterMapper->getErrorMessage());
		}

		$characterModel->setApiKeyAccount($apiKeyAccount);
		$characterModel->setCorpMember($apiKeyAccount->getCorpMember());
		$apiKeyAccount->addCharacter($characterModel);
	}

	/**
	 * Return new character mapper model with initialized depend repositories.
	 *
	 * @param \Gerh\Evecorp\Domain\Model\ApiKeyAccount $apiKeyAccount
	 * @return \Gerh\Evecorp\Domain\Mapper\CharacterMapper
	 */
	protected function getNewCharacterMapper(\Gerh\Evecorp\Domain\Model\ApiKeyAccount $apiKeyAccount) {
		$characterMapper = new \Gerh\Evecorp\Domain\Mapper\CharacterMapper($apiKeyAccount);

		$characterMapper->setAllianceRepository($this->allianceRepository);
		$characterMapper->setCorporationRepository($this->corporationRepository);
		$characterMapper->setCharacterRepository($this->characterRepository);
		$characterMapper->setEmploymentHistoryRepository($this->employmentHistoryRepository);

		return $characterMapper;
	}

	/**
	 * Remove removed characters from api key
	 *
	 * @param array $removedCharacterIds
	 * @param \Gerh\Evecorp\Domain\Model\ApiKeyAccount $apiKeyAccount
	 */
	protected function removeCharacters(array $removedCharacterIds, \Gerh\Evecorp\Domain\Model\ApiKeyAccount $apiKeyAccount) {
		foreach($removedCharacterIds as $characterId) {
			$characterModel = $this->characterRepository->findOneByCharacterId($characterId);
			$characterModel->setCorpMember(NULL);
			$this->characterRepository->update($characterModel);
			$apiKeyAccount->removeCharacter($characterModel);
		}
	}

	/**
	 * Update character information
	 *
	 * @param \integer $characterId
	 * @param \Gerh\Evecorp\Domain\Model\ApiKeyAccount $apiKeyAccount
	 * @throws \Exception
	 */
	protected function updateCharacter($characterId, $apiKeyAccount) {
		$characterModel = $this->characterRepository->findOneByCharacterId($characterId);
		$characterMapper = $this->getNewCharacterMapper($apiKeyAccount);
		$result = $characterMapper->updateModel($characterModel);
		if ($result === FALSE) {
			throw new \Exception($characterMapper->getErrorMessage());
		}
		$this->characterRepository->update($characterModel);
	}

	/**
	 * class constructor
	 */
	public function __construct() {
		$objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');

		$this->allianceRepository = $objectManager->get('Gerh\\Evecorp\\Domain\\Repository\\AllianceRepository');
		$this->corporationRepository = $objectManager->get('Gerh\\Evecorp\\Domain\\Repository\\CorporationRepository');
		$this->characterRepository = $objectManager->get('Gerh\\Evecorp\\Domain\\Repository\\CharacterRepository');
		$this->employmentHistoryRepository = $objectManager->get('Gerh\\Evecorp\\Domain\\Repository\\EmploymentHistoryRepository');
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
	 *
	 * @param \Gerh\Evecorp\Domain\Model\ApiKeyAccount $apiKeyAccountModel
	 * @return boolean
	 */
	public function fillUpModel(\Gerh\Evecorp\Domain\Model\ApiKeyAccount $apiKeyAccountModel) {
		$keyId = $apiKeyAccountModel->getKeyId();
		$vCode = $apiKeyAccountModel->getVCode();
		$scope = 'Account';

		$phealService = new \Gerh\Evecorp\Service\PhealService($keyId, $vCode, $scope);
		$pheal = $phealService->getPhealInstance();

		try {
			$response = $pheal->accountScope->APIKeyInfo();
			$apiKeyAccountModel->setAccessMask($response->key->accessMask);

			$keyExpires = $response->key->expires;
			if ($keyExpires != '') {
				$expires = new \Gerh\Evecorp\Domain\Model\DateTime($keyExpires, new \DateTimeZone('UTC'));
				$apiKeyAccountModel->setExpires($expires);
			}

			foreach($response->key->characters as $character) {
				$characterId = intval($character->characterID);
				$this->createAndAddNewCharacter($characterId, $apiKeyAccountModel);
			}

			return TRUE;
		} catch (\Pheal\Exceptions\PhealException $ex) {
			$this->errorMessage = 'Fetched PhealException with message: "' . $ex->getMessage() . '" Model was not be updated!';
			return FALSE;
		} catch(\Exception $e) {
			$this->errorMessage = 'Fetched general exception with message: "' . $e->getMessage() . '" Model was not be updated!';
			return FALSE;
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
	 * Update account based API key
	 *
	 * @param \Gerh\Evecorp\Domain\Model\ApiKeyAccount $apiKeyAccount
	 * @return boolean
	 */
	public function updateApiKeyAccount(\Gerh\Evecorp\Domain\Model\ApiKeyAccount $apiKeyAccount) {
		$keyId = $apiKeyAccount->getKeyId();
		$vCode = $apiKeyAccount->getVCode();
		$scope = 'Account';

		$currentCharacters = $apiKeyAccount->getCharacters();
		$currentCharacterIds = array();
		$wellKnownCharacterIds = array();

		foreach($currentCharacters as $character) {
			$currentCharacterIds[] = intval($character->getCharacterId());
		}

		$phealService = new \Gerh\Evecorp\Service\PhealService($keyId, $vCode, $scope);
		$pheal = $phealService->getPhealInstance();

		try {
			$response = $pheal->accountScope->APIKeyInfo();

			$apiKeyAccount->setAccessMask($response->key->accessMask);

			$keyExpires = $response->key->expires;
			if ($keyExpires != '') {
				$expires = new \Gerh\Evecorp\Domain\Model\DateTime($keyExpires, new \DateTimeZone('UTC'));
				$apiKeyAccount->setExpires($expires);
			} else {
				$apiKeyAccount->setExpires(NULL);
			}

			foreach($response->key->characters as $character) {
				$characterId = intval($character->characterID);

				if (in_array($characterId, $currentCharacterIds)) {
					$this->updateCharacter($characterId, $apiKeyAccount);
					$wellKnownCharacterIds[] = $characterId;
				} else {
					$this->createAndAddNewCharacter($characterId, $apiKeyAccount);
				}
			}

			$removedCharacterIds = array_diff($currentCharacterIds, $wellKnownCharacterIds);
			$this->removeCharacters($removedCharacterIds, $apiKeyAccount);

		} catch (Exception $ex) {
			$this->errorMessage = 'Fetched general exception with message: "' . $ex->getMessage() . '" Model was not be updated!';
			return FALSE;
		}

		return TRUE;
	}

}
