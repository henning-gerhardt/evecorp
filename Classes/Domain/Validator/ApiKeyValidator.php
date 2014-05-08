<?php
namespace Gerh\Evecorp\Domain\Validator;

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
class ApiKeyValidator extends \TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator {

	/**
	 * @var \Gerh\Evecorp\Domain\Repository\ApiKeyRepository
	 * @inject
	 */
	protected $apiKeyRepository;

	/**
	 * @var \Gerh\Evecorp\Domain\Repository\CharacterRepository
	 * @inject
	 */
	protected $characterRepository;

	/**
	 * Is given type equal expected type. Expected type default is 'Account'.
	 *
	 * @param \string $actualType   Current API key type
	 * @param \string $expectedType To check against. Default: 'Account'
	 * @return \boolean
	 */
	protected function isApiType($actualType, $expectedType = 'Account') {
		return ($actualType === $expectedType);
	}

	/**
	 * Check if given character id is already stored in database
	 *
	 * @param \integer $characterId
	 * @return \boolean
	 */
	protected function isCharacterIdAlreadyInDatabase($characterId) {
		$result = $this->characterRepository->countByCharacterId($characterId);
		if ($result > 0) {
			return TRUE;
		}

		return FALSE;
	}

	/**
	 * Returns configured API key access mask
	 *
	 * @return \integer
	 */
	protected function getAccessMask() {
		return \Gerh\Evecorp\Domain\Utility\AccessMaskUtility::getAccessMask();
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
	 * Check for :
	 *  - Given API key against CCP API server for correct API key type
	 *  - API key based characters are not already stored in database
	 *
	 * @param \integer $keyId
	 * @param \string $vCode
	 * @return \boolean
	 */
	protected function checkApiKey($keyId, $vCode) {
		$scope = 'account';

		try {
			$phealService = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('Gerh\\Evecorp\\Service\\PhealService', $keyId, $vCode, $scope);
			$pheal = $phealService->getPhealInstance();
			$response = $pheal->accountScope->APIKeyInfo();

			if (! $this->isApiType($response->key->type, 'Account')) {
				$this->addError('Given API key is not an Account API key.', 123456890);
				return FALSE;
			}

			if (! $this->hasCorrectAccessMask(\intval($response->key->accessMask))) {
				$this->addError('Given API key has not correct access mask: ' . $this->getAccessMask(), 1234567890);
				return FALSE;
			}

			foreach($response->key->characters as $characterInfo) {
				if ($this->isCharacterIdAlreadyInDatabase($characterInfo->characterID)) {
					$this->addError('Character "' . $characterInfo->characterName . '" is already in database.', 1234567890);
					return FALSE;
				}
			}
		} catch (\Pheal\Exceptions\PhealException $ex) {
			$this->addError($ex->getMessage(), 123456890);
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

		$result = $this->apiKeyRepository->countByKeyId($keyId);
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

		return  $this->checkApiKey($keyId, $vCode);
	}

}
