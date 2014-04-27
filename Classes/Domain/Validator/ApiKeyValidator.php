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
	 *
	 * @param type $keyId
	 * @param type $vCode
	 * @return boolean
	 */
	protected function checkApiKeys($keyId, $vCode) {
		$scope = 'account';

		try {
			$phealService = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('Gerh\Evecorp\Service\PhealService', $keyId, $vCode, $scope);
			$pheal = $phealService->getPhealInstance();
			$response = $pheal->accountScope->APIKeyInfo();
			return ($response->key->type === 'Account');
		} catch (\Pheal\Exceptions\PhealException $ex) {
			$this->addError($ex->getMessage(), 123456890);
			return FALSE;
		}

		return FALSE;
	}

	/**
	 *
	 * @param \integer $keyId
	 * @return boolean
	 */
	protected function checkForAlreadyExistingKeyIdInDatabase($keyId) {
		$apiKeyRepository = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('Gerh\Evecorp\Domain\Repository\ApiKeyRepository');

		$result = $apiKeyRepository->countByKeyId($keyId);
		if ($result > 0) {
			$this->addError('Key already stored in database', 1234567890);
			return FALSE;
		} else {
			return TRUE;
		}
	}

	/**
	 *
	 * @param \Gerh\Evecorp\Domain\Model\ApiKey $value
	 * @return boolean
	 */
	protected function isValid($value) {

		if (!$value instanceof \Gerh\Evecorp\Domain\Model\ApiKey) {
			$this->addError('Given object has wrong type!', 1234567890);
			return FALSE;
		}

		if (empty($value->getKeyId()) || empty($value->getVCode())) {
			$this->addError('Key ID or Verification Code are empty!', 1234567890);
			return FALSE;
		}

		return $this->checkForAlreadyExistingKeyIdInDatabase($value->getKeyId()) && $this->checkApiKeys($value->getKeyId(), $value->getVCode());
	}

}
