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

namespace Gerh\Evecorp\Domain\Mapper;

/**
 * Description of CorporationMemberList
 *
 * @author Henning Gerhardt
 */
class CorporationMemberList {

	/**
	 * @var \Gerh\Evecorp\Domain\Repository\CharacterRepository
	 * @inject
	 */
	protected $characterRepository;

	/**
	 * @var \Gerh\Evecorp\Domain\Model\Corporation
	 */
	protected $corporation;

	/**
	 * @var \Gerh\Evecorp\Domain\Model\ApiKeyCorporation
	 */
	protected $corporationApiKey;

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
	 * @var \int
	 */
	protected $storagePid;

	/**
	 * Create and store character by giben character id
	 * @param \int $characterId
	 * @return \boolean
	 */
	protected function createAndStoreNewCharacterByCharacterId($characterId) {
		/* @var $characterMapper \Gerh\Evecorp\Domain\Mapper\CharacterMapper */
		$characterMapper = $this->objectManager->get('Gerh\\Evecorp\\Domain\\Mapper\\CharacterMapper');
		$characterMapper->setStoragePid($this->storagePid);

		$character = $characterMapper->createModel($characterId);
		if ($character instanceof \Gerh\Evecorp\Domain\Model\Character) {
			$this->characterRepository->add($character);
			return \TRUE;
		}

		return \FALSE;
	}

	/**
	 * Fetch current corporation members
	 *
	 * @return \Pheal\Core\RowSet | ArrayObject
	 */
	protected function fetchCurrentCorporationMembers() {
		try {
			$phealService = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
							'Gerh\\Evecorp\\Service\\PhealService', $this->corporationApiKey->getKeyId(), $this->corporationApiKey->getVCode()
			);
			$pheal = $phealService->getPhealInstance();

			$response = $pheal->corpScope->MemberTracking();
			return $response->members;
		} catch (Exception $ex) {
			$this->errorMessage = 'Fetched PhealException with message: "' . $ex->getMessage();
		}
		return new \ArrayObject();
	}

	/**
	 * Update character data
	 *
	 * @param \Gerh\Evecorp\Domain\Model\Character $formerCorporationMember
	 */
	protected function updateFormerCorporationMember(\Gerh\Evecorp\Domain\Model\Character $formerCorporationMember) {
		/* @var $characterMapper \Gerh\Evecorp\Domain\Mapper\CharacterMapper */
		$characterMapper = $this->objectManager->get('Gerh\Evecorp\Domain\Mapper\CharacterMapper', $formerCorporationMember->getApiKeyAccount());
		$characterMapper->setStoragePid($this->storagePid);

		$characterMapper->updateModel($formerCorporationMember);
		$this->characterRepository->update($formerCorporationMember);
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
	 * Set corporation be used for updating usage
	 *
	 * @param \Gerh\Evecorp\Domain\Model\Corporation $corporation
	 */
	public function setCorporation(\Gerh\Evecorp\Domain\Model\Corporation $corporation) {
		$this->corporation = $corporation;
	}

	/**
	 * Set corporation api key
	 *
	 * @param \Gerh\Evecorp\Domain\Model\ApiKeyCorporation $corporationApiKey
	 */
	public function setCorporationApiKey(\Gerh\Evecorp\Domain\Model\ApiKeyCorporation $corporationApiKey) {
		$this->corporationApiKey = $corporationApiKey;
	}

	/**
	 * Store storage pid and initialise used repositories to use this storage pid.
	 *
	 * @param \int $storagePid
	 */
	public function setStoragePid($storagePid = 0) {
		if ($storagePid !== \NULL) {
			$this->storagePid = $storagePid;
			$this->characterRepository->setRepositoryStoragePid($storagePid);
		}
	}

	/**
	 * Update corporation member list
	 *
	 * @return boolean
	 */
	public function updateCorpMemberList() {
		$newCorpMemberIdList = array();

		// hold current member list
		$currentCorpMembers = $this->characterRepository->findByCurrentCorporation($this->corporation);

		// fetch current corporation members and store new members into database
		$fetchedCorporationMembers = $this->fetchCurrentCorporationMembers();

		if (empty($fetchedCorporationMembers)) {
			return \FALSE;
		}

		/* @var $member \Pheal\Core\RowSetRow */
		foreach ($fetchedCorporationMembers as $member) {
			$characterId = $member->characterID;
			$corpMember = $this->characterRepository->findOneByCharacterId($characterId);
			if ($corpMember instanceof \Gerh\Evecorp\Domain\Model\Character) {
				$newCorpMemberIdList[] = $characterId;
			} else {
				if ($this->createAndStoreNewCharacterByCharacterId($characterId)) {
					$newCorpMemberIdList[] = $characterId;
				}
			}
		}

		// search for characters which left corporation and update their data
		/* @var $formerCorpMember \Gerh\Evecorp\Domain\Model\Character */
		foreach ($currentCorpMembers as $formerCorpMember) {
			if (!in_array($formerCorpMember->getCharacterId(), $newCorpMemberIdList)) {
				// found former corporation character, update his data
				$this->updateFormerCorporationMember($formerCorpMember);
			}
		}

		$this->persistenceManager->persistAll();

		return \TRUE;
	}

}
