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

namespace Gerh\Evecorp\Domain\Validator;

use Gerh\Evecorp\Domain\Mapper\ApiKeyInfoMapper;
use Gerh\Evecorp\Domain\Model\ApiKey;
use Gerh\Evecorp\Domain\Model\Character as CharacterModel;
use Gerh\Evecorp\Domain\Model\CorpMember;
use Gerh\Evecorp\Domain\Model\Internal\Character;
use Gerh\Evecorp\Domain\Repository\ApiKeyAccountRepository;
use Gerh\Evecorp\Domain\Repository\CharacterRepository;
use Gerh\Evecorp\Domain\Utility\AccessMaskUtility;
use TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator;

/**
 *
 *
 * @package evecorp
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class AccountApiKeyValidator extends AbstractValidator {

    /**
     * @var ApiKeyAccountRepository
     */
    protected $apiKeyAccountRepository;

    /**
     * @var CharacterRepository
     */
    protected $characterRepository;

    /**
     * Returns configured API key access mask
     *
     * @return \integer
     */
    protected function getAccessMask() {
        return AccessMaskUtility::getAccessMask();
    }

    /**
     *
     * @param \int $characterId
     * @return mixed
     */
    protected function getCharacterFromDatabase($characterId) {
        return $this->characterRepository->findOneByCharacterId($characterId);
    }

    /**
     * Check if given API key access mask fits configured access mask
     *
     * @param \integer $accessMask
     * @return boolean
     */
    protected function hasCorrectAccessMask($accessMask) {
        return (($this->getAccessMask() & $accessMask) > 0);
    }

    /**
     * Check if a given character is not in database nor has a login assigned
     *
     * @param Character $internalCharacterInfo
     * @return boolean
     */
    protected function isCharacterIsNotInDatabaseNorHasALoginAssigned(Character $internalCharacterInfo) {
        $character = $this->getCharacterFromDatabase($internalCharacterInfo->getCharacterId());
        if ($character instanceof CharacterModel) {
            if ($character->getCorpMember() instanceof CorpMember) {
                $this->addError('Character "' . $character->getCharacterName() . '" is already assigned to a login.', 1234567890);
                return \FALSE;
            }
        }

        return \TRUE;
    }

    /**
     * Check for :
     *  - Given API key against CCP API server for correct API key type
     *  - API key based characters are not already stored in database
     *
     * @param \integer $keyId
     * @param \string $vCode
     * @return \boolean
     */
    protected function checkApiKey($keyId, $vCode) {

        $mapper = new ApiKeyInfoMapper();
        $mapper->setKeyId($keyId);
        $mapper->setVcode($vCode);
        $apiKeyInfo = $mapper->retrieveApiKeyInfo();

        if ($apiKeyInfo->getType() !== 'Account') {
            $this->addError('Given API key is not an Account API key.', 123456890);
            return \FALSE;
        }

        if (!$this->hasCorrectAccessMask(\intval($apiKeyInfo->getAccessMask()))) {
            $this->addError('Given API key has not correct access mask: ' . $this->getAccessMask(), 1234567890);
            return \FALSE;
        }

        /* @var $characterInfo Character */
        foreach ($apiKeyInfo->getCharacters() as $characterInfo) {
            if (!$this->isCharacterIsNotInDatabaseNorHasALoginAssigned($characterInfo)) {
                return \FALSE;
            }
        }

        return \TRUE;
    }

    /**
     * Check if given key already be used by somebody else
     *
     * @param \integer $keyId
     * @return \boolean
     */
    protected function isKeyIdAlreadyInDatabase($keyId) {

        $result = $this->apiKeyAccountRepository->countByKeyId($keyId);
        if ($result > 0) {
            return \TRUE;
        }

        return \FALSE;
    }

    /**
     * Made some checks for given model to be valid
     *
     * @param ApiKey $value
     * @return \boolean
     */
    protected function isValid($value) {

        if (($value instanceof ApiKey) === \FALSE) {
            $this->addError('Given object has wrong type!', 1234567890);
            return \FALSE;
        }

        $keyId = $value->getKeyId();
        $vCode = $value->getVCode();

        if (empty($keyId) === \TRUE) {
            $this->addError('Key ID is empty!', 1234567890);
            return \FALSE;
        }

        if (\is_int($keyId) === \FALSE) {
            $this->addError('Key ID is not a integer value!', 1234567890);
            return \FALSE;
        }

        if (empty($vCode) === \TRUE) {
            $this->addError('Verification code is empty!', 1234567890);
            return \FALSE;
        }

        if ($this->isKeyIdAlreadyInDatabase($keyId)) {
            $this->addError('Key already stored in database', 1234567890);
            return \FALSE;
        }

        return $this->checkApiKey($keyId, $vCode);
    }

    /**
     * Class constructor.
     *
     * @param ApiKeyAccountRepository $apiKeyAccountRepository
     * @param CharacterRepository $characterRepository
     * @param array $options
     * @return void
     */
    public function __construct(ApiKeyAccountRepository $apiKeyAccountRepository, CharacterRepository $characterRepository, array $options = array()) {
        // call default validator constructor
        parent::__construct($options);

        $this->apiKeyAccountRepository = $apiKeyAccountRepository;
        $this->characterRepository = $characterRepository;
    }

}
