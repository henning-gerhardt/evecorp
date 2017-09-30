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

use DateTimeZone;
use Exception;
use Gerh\Evecorp\Domain\Constants\AccessMask\Character as CharacterModel;
use Gerh\Evecorp\Domain\Model\Alliance;
use Gerh\Evecorp\Domain\Model\ApiKey;
use Gerh\Evecorp\Domain\Model\Character;
use Gerh\Evecorp\Domain\Model\Corporation;
use Gerh\Evecorp\Domain\Model\CorporationTitle;
use Gerh\Evecorp\Domain\Model\DateTime;
use Gerh\Evecorp\Domain\Model\EmploymentHistory;
use Gerh\Evecorp\Domain\Repository\AllianceRepository;
use Gerh\Evecorp\Domain\Repository\CharacterRepository;
use Gerh\Evecorp\Domain\Repository\CorporationRepository;
use Gerh\Evecorp\Domain\Repository\EmploymentHistoryRepository;
use Gerh\Evecorp\Service\PhealService;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Object\ObjectManagerInterface;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;

/**
 *
 *
 * @package evecorp
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class CharacterMapper {

    /**
     * @var AllianceRepository
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
     * @var ApiKey
     */
    protected $apiKey;

    /**
     * @var CharacterRepository
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
     * @var CorporationRepository
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
     * @var EmploymentHistoryRepository
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
     * @var PhealService
     */
    protected $phealService;

    /**
     * Add employment history of character
     *
     * @param Character $character
     * @param \Pheal\Core\RowSet $employmentHistory
     */
    protected function addEmploymentHistoryOfCharacter(Character $character, \Pheal\Core\RowSet $employmentHistory) {
        foreach ($employmentHistory as $record) {
            $corporation = $this->getOrCreateCorporationModel(\intval($record->corporationID), $record->corporationName);
            $startDate = new DateTime($record->startDate, new DateTimeZone('UTC'));

            $employment = $this->createEmploymentHistoryModel($character, $corporation, intval($record->recordID), $startDate);
            $this->employmentHistoryRepository->add($employment);
        }
        $this->persistenceManager->persistAll();
    }

    /**
     * Create an employment history model
     *
     * @param Character $character
     * @param Corporation $corporation
     * @param \integer $recordId
     * @param DateTime $startDate
     * @return EmploymentHistory
     */
    protected function createEmploymentHistoryModel($character, $corporation, $recordId, $startDate) {
        $employment = new EmploymentHistory();
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
     * @return Alliance
     * @throws Exception Throws exception if allianceId is less then one.
     */
    protected function getOrCreateAllianceModel($allianceId, $allianceName) {
        if ($allianceId > 0) {
            $searchResult = $this->allianceRepository->findOneByAllianceId($allianceId);
            if ($searchResult) {
                $alliance = $searchResult;
            } else {
                $alliance = new Alliance($allianceId, $allianceName);
                // TODO check if setting pid is really necessary
                $alliance->setPid($this->allianceRepositoryStoragePids[0]);
                $this->allianceRepository->add($alliance);
                $this->persistenceManager->persistAll();
            }

            return $alliance;
        }

        throw new Exception('Could not determinate characters alliance.');
    }

    /**
     * Returns a corporation model: Create a new or use stored one.
     *
     * @param \integer $corporationId
     * @param \string $corporationName
     * @return Corporation
     * @throws Exception Throws exception if corporationId is less then one.
     */
    protected function getOrCreateCorporationModel($corporationId, $corporationName) {
        if ($corporationId > 0) {
            $searchResult = $this->corporationRepository->findOneByCorporationId($corporationId);
            if ($searchResult) {
                $corporation = $searchResult;
            } else {
                $corporation = new Corporation($corporationId, $corporationName);
                // TODO check if setting pid is really necessary
                $corporation->setPid($this->corporationRepositoryStoragePids[0]);
                $this->corporationRepository->add($corporation);
                $this->persistenceManager->persistAll();
            }

            return $corporation;
        }

        throw new Exception('Could not determinate characters corporation.');
    }

    /**
     * Set chracter information from character info response
     *
     * @param Character $character
     * @param \Pheal\Core\Result $response
     */
    protected function setCharacterInformationFromCharacterInfoResponse($character, $response) {
        $character->setCharacterName($response->characterName);
        $character->setRace($response->race);
        $character->setSecurityStatus($response->securityStatus);

        $corporationDate = new DateTime($response->corporationDate, new DateTimeZone('UTC'));
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
     * @param Character $character
     * @param \Pheal\Core\RowSet $employmentHistory
     * @return void
     */
    protected function updateEmploymentHistoryOfCharacter(Character $character, \Pheal\Core\RowSet $employmentHistory) {

        $currentEmployments = $this->employmentHistoryRepository->findByCharacterUid($character);
        $wellknownEmployments = [];

        foreach ($employmentHistory as $record) {
            $corporation = $this->getOrCreateCorporationModel(\intval($record->corporationID), $record->corporationName);
            $startDate = new DateTime($record->startDate, new DateTimeZone('UTC'));

            $result = $this->employmentHistoryRepository->searchForEmployment($character, $corporation, $startDate);

            if ($result === NULL) {
                $employment = $this->createEmploymentHistoryModel($character, $corporation, intval($record->recordID), $startDate);
                $this->employmentHistoryRepository->add($employment);
            } else {
                $wellknownEmployments[$result->getUid()] = $result;
            }
        }

        foreach ($currentEmployments as $employment) {
            if (\array_key_exists($employment->getUid(), $wellknownEmployments) === \FALSE) {
                $character->removeEmployment($employment);
            }
        }
        $this->persistenceManager->persistAll();
    }

    /**
     * Set characters corporation titles
     *
     * @param Character $characterModel
     * @param \Pheal\Core\RowSet $fetchedTitles
     */
    protected function setCharacterCorporationTitles(Character $characterModel, \Pheal\Core\RowSet $fetchedTitles) {
        $existingCorpTitles = $characterModel->getCurrentCorporation()->getCorporationTitles();
        $characterModel->removeAllTitles();
        foreach ($fetchedTitles as $fetchedTitle) {
            /* @var $existingCorpTitle CorporationTitle */
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
    public function __construct(ApiKey $apiKeyModel = \NULL) {

        if ($apiKeyModel === \NULL) {
            $apiKeyModel = new ApiKey();
        }

        $this->apiKey = $apiKeyModel;
        $scope = 'eve';
        $this->phealService = new PhealService($this->apiKey->getKeyId(), $this->apiKey->getVCode(), $scope);
        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);

        $this->setAllianceRepository($objectManager->get(AllianceRepository::class));
        $this->setCharacterRepository($objectManager->get(CharacterRepository::class));
        $this->setCorporationRepository($objectManager->get(CorporationRepository::class));
        $this->setEmploymentHistoryRepository($objectManager->get(EmploymentHistoryRepository::class));
        $this->persistenceManager = $objectManager->get(PersistenceManager::class);
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
     * @return Character | NULL
     */
    public function createModel($characterId) {

        $pheal = $this->phealService->getPhealInstance();

        try {
            $response = $pheal->eveScope->CharacterInfo(['CharacterID' => $characterId]);
        } catch (\Pheal\Exceptions\PhealException $ex) {
            $this->errorMessage = 'Fetched PhealException with message: "' . $ex->getMessage();
            return \NULL;
        }

        $characterDb = $this->characterRepository->findOneByCharacterId(\intval($response->characterID));
        if ($characterDb instanceof Character) {
            return $characterDb;
        }

        try {
            $character = new Character();
            $character->setCharacterId(\intval($response->characterID));

            $this->setCharacterInformationFromCharacterInfoResponse($character, $response);

            $this->addEmploymentHistoryOfCharacter($character, $response->employmentHistory);
        } catch (Exception $ex) {
            $this->errorMessage = 'Fetched general Exception with message: "' . $ex->getMessage() . '" Model was not be updated!';
            return \NULL;
        }

        if ($this->apiKey->hasAccessTo(CharacterModel::CHARACTERSHEET)) {
            try {
                $response = $pheal->charScope->CharacterSheet(['CharacterID' => $characterId]);
            } catch (\Pheal\Exceptions\PhealException $ex) {
                $this->errorMessage = 'Fetched PhealException with message: "' . $ex->getMessage();
                return \NULL;
            }

            try {
                $this->setCharacterCorporationTitles($character, $response->corporationTitles);
            } catch (Exception $ex) {
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
     * @param AllianceRepository $repository
     */
    public function setAllianceRepository(AllianceRepository $repository) {
        $this->allianceRepository = $repository;
        $this->allianceRepositoryStoragePids = $repository->getRepositoryStoragePid();
    }

    /**
     * Set character repository from outside
     *
     * @param CharacterRepository $repository
     */
    public function setCharacterRepository(CharacterRepository $repository) {
        $this->characterRepository = $repository;
        $this->characterRepositoryStoragePids = $repository->getRepositoryStoragePid();
    }

    /**
     * Set corporation repository from outside
     *
     * @param CorporationRepository $repository
     */
    public function setCorporationRepository(CorporationRepository $repository) {
        $this->corporationRepository = $repository;
        $this->corporationRepositoryStoragePids = $repository->getRepositoryStoragePid();
    }

    /**
     * Set employment history repository from outside
     *
     * @param EmploymentHistoryRepository $repository
     */
    public function setEmploymentHistoryRepository(EmploymentHistoryRepository $repository) {
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
            $this->allianceRepositoryStoragePids = [$storagePid];
            $this->characterRepository->setRepositoryStoragePid($storagePid);
            $this->characterRepositoryStoragePids = [$storagePid];
            $this->corporationRepository->setRepositoryStoragePid($storagePid);
            $this->corporationRepositoryStoragePids = [$storagePid];
            $this->employmentHistoryRepository->setRepositoryStoragePid($storagePid);
            $this->employmentHistoryRepositoryStoragePids = [$storagePid];
        }
    }

    /**
     * Update character model with API data
     *
     * @param Character $characterModel
     * @return boolean
     */
    public function updateModel(Character $characterModel) {

        $pheal = $this->phealService->getPhealInstance();
        $characterId = $characterModel->getCharacterId();

        try {
            $response = $pheal->eveScope->CharacterInfo(['CharacterID' => $characterId]);
        } catch (\Pheal\Exceptions\PhealException $ex) {
            $this->errorMessage = 'Fetched PhealException with message: "' . $ex->getMessage();
            return \FALSE;
        }

        try {
            $this->setCharacterInformationFromCharacterInfoResponse($characterModel, $response);

            $this->updateEmploymentHistoryOfCharacter($characterModel, $response->employmentHistory);
        } catch (Exception $ex) {
            $this->errorMessage = 'Fetched general Exception with message: "' . $ex->getMessage() . '" Model was not be updated!';
            return \FALSE;
        }

        if ($this->apiKey->hasAccessTo(CharacterModel::CHARACTERSHEET)) {
            try {
                $response = $pheal->charScope->CharacterSheet(['CharacterID' => $characterId]);
            } catch (\Pheal\Exceptions\PhealException $ex) {
                $this->errorMessage = 'Fetched PhealException with message: "' . $ex->getMessage();
                return \FALSE;
            }

            try {
                $this->setCharacterCorporationTitles($characterModel, $response->corporationTitles);
            } catch (Exception $ex) {
                $this->errorMessage = 'Fetched general Exception with message: "' . $ex->getMessage() . '" Model was not be updated!';
                return \FALSE;
            }
        }

        $this->persistenceManager->persistAll();

        return \TRUE;
    }

}
