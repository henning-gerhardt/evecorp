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

/**
 *
 *
 * @package evecorp
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class CorporationApiKeyValidator extends \TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator {

    /**
     * @var \Gerh\Evecorp\Domain\Repository\ApiKeyAccountRepository
     * @inject
     */
    protected $apiKeyAccountRepository;

    /**
     * Check for :
     *  - Given API key against CCP API server for correct API key type
     *
     * @param \integer $keyId
     * @param \string $vCode
     * @return \boolean
     */
    protected function checkApiKey($keyId, $vCode) {

        $mapper = new \Gerh\Evecorp\Domain\Mapper\ApiKeyInfoMapper();
        $mapper->setKeyId($keyId);
        $mapper->setVcode($vCode);
        $apiKeyInfo = $mapper->retrieveApiKeyInfo();

        if ($apiKeyInfo->getType() !== 'Corporation') {
            $this->addError('Given API key is not an corporation API key.', 123456890);
            return FALSE;
        }

        return TRUE;
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
            return TRUE;
        }

        return FALSE;
    }

    /**
     * Made some checks for given model to be valid
     *
     * @param \Gerh\Evecorp\Domain\Model\ApiKey $value
     * @return \boolean
     */
    protected function isValid($value) {

        if (($value instanceof \Gerh\Evecorp\Domain\Model\ApiKey) === FALSE) {
            $this->addError('Given object has wrong type!', 1234567890);
            return FALSE;
        }

        $keyId = $value->getKeyId();
        $vCode = $value->getVCode();

        if (empty($keyId) === TRUE) {
            $this->addError('Key ID is empty!', 1234567890);
            return FALSE;
        }

        if (\is_int($keyId) === FALSE) {
            $this->addError('Key ID is not a integer value!', 1234567890);
            return FALSE;
        }

        if (empty($vCode) === TRUE) {
            $this->addError('Verification code is empty!', 1234567890);
            return FALSE;
        }

        if ($this->isKeyIdAlreadyInDatabase($keyId)) {
            $this->addError('Key already stored in database', 1234567890);
            return FALSE;
        }

        return $this->checkApiKey($keyId, $vCode);
    }

}
