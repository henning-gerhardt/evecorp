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
	 * @var \string
	 */
	protected $errorMessage;

	/**
	 * @var $logger \TYPO3\CMS\Core\Log\Logger
	 */
	protected $logger;

	/**
	 * class constructor
	 */
	public function __construct() {
		$this->errorMessage = '';
		$this->logger = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Core\Log\LogManager')->getLogger(__CLASS__);
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
	 * @param \Gerh\Evecorp\Domain\Model\ApiKey $apiKeyModel
	 * @return $boolean
	 */
	public function fillUpModel(\Gerh\Evecorp\Domain\Model\ApiKey $apiKeyModel) {
		$keyId = $apiKeyModel->getKeyId();
		$vCode = $apiKeyModel->getVCode();
		$scope = 'Account';

		/** @var \Gerh\Evecorp\Service\PhealSerice */
		$phealService = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('Gerh\Evecorp\Service\PhealService', $keyId, $vCode, $scope);
		/** @var \Pheal\Pheal */
		$pheal = $phealService->getPhealInstance();

		try {
			$response = $pheal->accountScope->APIKeyInfo();
			$apiKeyModel->setAccessMask($response->key->accessMask);

			$keyExpires = $response->key->expires;
			if ($keyExpires != '') {
				$expires = new \Gerh\Evecorp\Domain\Model\DateTime($keyExpires, new \DateTimeZone('UTC'));
				$apiKeyModel->setExpires($expires);
			}

			$apiKeyModel->setType($response->key->type);

			return true;
		} catch (\Pheal\Exceptions\PhealException $ex) {
			$this->errorMessage = 'Fetched PhealException with message: \"' . $ex->getMessage() . '\" Model was not be updated!';
			$this->logger->error($this->errorMessage);
			return false;
		}
	}
}
