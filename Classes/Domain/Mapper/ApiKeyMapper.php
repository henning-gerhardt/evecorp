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
use Gerh\Evecorp\Domain\Model\ApiKeyAccount;
use Gerh\Evecorp\Domain\Model\DateTime;
use Gerh\Evecorp\Domain\Repository\CharacterRepository;
use Gerh\Evecorp\Service\PhealService;
use Pheal\Exceptions\PhealException;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use TYPO3\CMS\Install\ViewHelpers\Exception as ExceptionViewHelper;

/**
 *
 *
 * @package evecorp
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class ApiKeyMapper
{

    /**
     * @var \Gerh\Evecorp\Domain\Repository\CharacterRepository
     */
    protected $characterRepository;

    /**
     * @var \string
     */
    protected $errorMessage;

    /**
     * @var \TYPO3\CMS\Extbase\Object\ObjectManager
     */
    protected $objectManager;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager
     */
    protected $persistenceManager;

    /**
     * @var \int
     */
    protected $storagePid;

    /**
     * Create new character and add him to current api key
     *
     * @param \integer $characterId
     * @param ApiKeyAccount $apiKeyAccount
     * @throws Exception
     * @return void
     */
    protected function createAndAddNewCharacter($characterId, ApiKeyAccount $apiKeyAccount)
    {
        $characterMapper = $this->getNewCharacterMapper($apiKeyAccount);
        $characterModel = $characterMapper->createModel($characterId);

        if ($characterModel === \NULL) {
            throw new Exception($characterMapper->getErrorMessage());
        }

        $characterModel->setApiKey($apiKeyAccount);
        $characterModel->setCorpMember($apiKeyAccount->getCorpMember());
        $apiKeyAccount->addCharacter($characterModel);
    }

    /**
     * Return new character mapper model with initialized depend repositories.
     *
     * @param ApiKeyAccount $apiKeyAccount
     * @return CharacterMapper
     */
    protected function getNewCharacterMapper(ApiKeyAccount $apiKeyAccount)
    {
        /* @var $characterMapper CharacterMapper */
        $characterMapper = $this->objectManager->get(CharacterMapper::class);
        $characterMapper->setApiKey($apiKeyAccount);
        $characterMapper->setStoragePid($this->storagePid);

        return $characterMapper;
    }

    /**
     * Remove removed characters from api key
     *
     * @param array $removedCharacterIds
     * @param ApiKeyAccount $apiKeyAccount
     */
    protected function removeCharacters(array $removedCharacterIds, ApiKeyAccount $apiKeyAccount)
    {
        foreach ($removedCharacterIds as $characterId) {
            $characterModel = $this->characterRepository->findOneByCharacterId($characterId);
            $characterModel->setCorpMember(\NULL);
            $this->characterRepository->update($characterModel);
            $apiKeyAccount->removeCharacter($characterModel);
        }
    }

    /**
     * Update character information
     *
     * @param \integer $characterId
     * @param ApiKeyAccount $apiKeyAccount
     * @throws Exception
     */
    protected function updateCharacter($characterId, $apiKeyAccount)
    {
        $characterModel = $this->characterRepository->findOneByCharacterId($characterId);
        $characterMapper = $this->getNewCharacterMapper($apiKeyAccount);
        $result = $characterMapper->updateModel($characterModel);
        if ($result === \FALSE) {
            throw new Exception($characterMapper->getErrorMessage());
        }
        $this->characterRepository->update($characterModel);
    }

    /**
     * Class constructor.
     *
     * @param CharacterRepository $characterRepository
     * @param ObjectManager $objectManager
     * @param PersistenceManager $persistenceManager
     * @return void
     */
    public function __construct(CharacterRepository $characterRepository, ObjectManager $objectManager, PersistenceManager $persistenceManager)
    {
        $this->characterRepository = $characterRepository;
        $this->objectManager = $objectManager;
        $this->persistenceManager = $persistenceManager;
    }

    /**
     * Returns error message
     *
     * @return \string
     */
    public function getErrorMessage()
    {
        return $this->errorMessage;
    }

    /**
     *
     * @param ApiKeyAccount $apiKeyAccountModel
     * @return boolean
     */
    public function fillUpModel(ApiKeyAccount $apiKeyAccountModel)
    {
        $keyId = $apiKeyAccountModel->getKeyId();
        $vCode = $apiKeyAccountModel->getVCode();
        $scope = 'Account';

        $phealService = new PhealService($keyId, $vCode, $scope);
        $pheal = $phealService->getPhealInstance();

        try {
            $response = $pheal->accountScope->APIKeyInfo();
            $apiKeyAccountModel->setAccessMask($response->key->accessMask);

            $keyExpires = $response->key->expires;
            if ($keyExpires != '') {
                $expires = new DateTime($keyExpires, new DateTimeZone('UTC'));
                $apiKeyAccountModel->setExpires($expires);
            }

            foreach ($response->key->characters as $character) {
                $characterId = \intval($character->characterID);
                $this->createAndAddNewCharacter($characterId, $apiKeyAccountModel);
            }
        } catch (PhealException $ex) {
            $this->errorMessage = 'Fetched PhealException with message: "' . $ex->getMessage() . '" Model was not be updated!';
            return \FALSE;
        } catch (Exception $e) {
            $this->errorMessage = 'Fetched general exception with message: "' . $e->getMessage() . '" Model was not be updated!';
            return \FALSE;
        }

        $this->persistenceManager->persistAll();

        return \TRUE;
    }

    /**
     * Store storage pid and initialise used repositories to use this storage pid.
     *
     * @param \int $storagePid
     */
    public function setStoragePid($storagePid = 0)
    {
        if ($storagePid !== \NULL) {
            $this->storagePid = $storagePid;
            $this->characterRepository->setRepositoryStoragePid($storagePid);
        }
    }

    /**
     * Update account based API key
     *
     * @param ApiKeyAccount $apiKeyAccount
     * @return boolean
     */
    public function updateApiKeyAccount(ApiKeyAccount $apiKeyAccount)
    {
        $keyId = $apiKeyAccount->getKeyId();
        $vCode = $apiKeyAccount->getVCode();
        $scope = 'Account';

        $currentCharacters = $apiKeyAccount->getCharacters();
        $currentCharacterIds = [];
        $wellKnownCharacterIds = [];

        foreach ($currentCharacters as $character) {
            $currentCharacterIds[] = \intval($character->getCharacterId());
        }

        $phealService = new PhealService($keyId, $vCode, $scope);
        $pheal = $phealService->getPhealInstance();

        try {
            $response = $pheal->accountScope->APIKeyInfo();

            $apiKeyAccount->setAccessMask($response->key->accessMask);

            $keyExpires = $response->key->expires;
            $expireDate = \NULL;
            if (!empty($keyExpires)) {
                $expireDate = new DateTime($keyExpires, new DateTimeZone('UTC'));
            }
            $apiKeyAccount->setExpires($expireDate);

            foreach ($response->key->characters as $character) {
                $characterId = \intval($character->characterID);

                if (in_array($characterId, $currentCharacterIds)) {
                    $this->updateCharacter($characterId, $apiKeyAccount);
                    $wellKnownCharacterIds[] = $characterId;
                } else {
                    $this->createAndAddNewCharacter($characterId, $apiKeyAccount);
                }
            }

            $removedCharacterIds = \array_diff($currentCharacterIds, $wellKnownCharacterIds);
            $this->removeCharacters($removedCharacterIds, $apiKeyAccount);
        } catch (ExceptionViewHelper $ex) {
            $this->errorMessage = 'Fetched general exception with message: "' . $ex->getMessage() . '" Model was not be updated!';
            return \FALSE;
        }

        $this->persistenceManager->persistAll();

        return \TRUE;
    }
}
