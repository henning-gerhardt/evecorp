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

namespace Gerh\Evecorp\Domain\Mapper;

use ArrayObject;
use Gerh\Evecorp\Domain\Model\ApiKeyCorporation;
use Gerh\Evecorp\Domain\Model\Character;
use Gerh\Evecorp\Domain\Model\Corporation;
use Gerh\Evecorp\Domain\Repository\CharacterRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManagerInterface;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use TYPO3\CMS\Install\ViewHelpers\Exception;

/**
 * Description of CorporationMemberList
 *
 * @author Henning Gerhardt
 */
class CorporationMemberList {

    /**
     * @var CharacterRepository
     * @inject
     */
    protected $characterRepository;

    /**
     * @var Corporation
     */
    protected $corporation;

    /**
     * @var ApiKeyCorporation
     */
    protected $corporationApiKey;

    /**
     * @var \string
     */
    protected $errorMessage;

    /**
     * @var ObjectManagerInterface
     * @inject
     */
    protected $objectManager;

    /**
     * @var PersistenceManager
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
        /* @var $characterMapper CharacterMapper */
        $characterMapper = $this->objectManager->get('Gerh\\Evecorp\\Domain\\Mapper\\CharacterMapper');
        $characterMapper->setStoragePid($this->storagePid);

        $character = $characterMapper->createModel($characterId);
        if ($character instanceof Character) {
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
            $phealService = GeneralUtility::makeInstance(
                    'Gerh\\Evecorp\\Service\\PhealService', $this->corporationApiKey->getKeyId(), $this->corporationApiKey->getVCode()
            );
            $pheal = $phealService->getPhealInstance();

            $response = $pheal->corpScope->MemberTracking();
            return $response->members;
        } catch (Exception $ex) {
            $this->errorMessage = 'Fetched PhealException with message: "' . $ex->getMessage();
        }
        return new ArrayObject();
    }

    /**
     * Update character data
     *
     * @param Character $formerCorporationMember
     */
    protected function updateFormerCorporationMember(Character $formerCorporationMember) {
        /* @var $characterMapper CharacterMapper */
        $characterMapper = $this->objectManager->get('Gerh\Evecorp\Domain\Mapper\CharacterMapper', $formerCorporationMember->getApiKey());
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
     * @param Corporation $corporation
     */
    public function setCorporation(Corporation $corporation) {
        $this->corporation = $corporation;
    }

    /**
     * Set corporation api key
     *
     * @param ApiKeyCorporation $corporationApiKey
     */
    public function setCorporationApiKey(ApiKeyCorporation $corporationApiKey) {
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
        $newCorpMemberIdList = [];

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
            if ($corpMember instanceof Character) {
                $newCorpMemberIdList[] = $characterId;
            } else {
                if ($this->createAndStoreNewCharacterByCharacterId($characterId)) {
                    $newCorpMemberIdList[] = $characterId;
                }
            }
        }

        // search for characters which left corporation and update their data
        /* @var $formerCorpMember Character */
        foreach ($currentCorpMembers as $formerCorpMember) {
            if (!\in_array($formerCorpMember->getCharacterId(), $newCorpMemberIdList)) {
                // found former corporation character, update his data
                $this->updateFormerCorporationMember($formerCorpMember);
            }
        }

        $this->persistenceManager->persistAll();

        return \TRUE;
    }

}
