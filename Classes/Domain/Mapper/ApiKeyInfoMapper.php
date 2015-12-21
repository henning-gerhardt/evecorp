<?php

/* * *************************************************************
 * Copyright notice
 *
 * (c) 2015 Henning Gerhardt
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
 * Description of ApiKeyInfoMapper
 *
 * @author Henning Gerhardt
 */
class ApiKeyInfoMapper {

	/**
	 * @var int
	 */
	protected $keyId;

	/**
	 * @var string
	 */
	protected $vCode;

	/**
	 *
	 * @param \Pheal\Core\Element $resultElement
	 * @return \Gerh\Evecorp\Domain\Model\Internal\ApiKeyInfo
	 */
	protected function mapRetrievedInformation(\Pheal\Core\Element $resultElement) {
		$result = new \Gerh\Evecorp\Domain\Model\Internal\ApiKeyInfo();
		$result->setAccessMask($resultElement->accessMask);
		$result->setExpires($resultElement->expires);
		$result->setType($resultElement->type);

		foreach($resultElement->characters as $char) {
			$character = new \Gerh\Evecorp\Domain\Model\Internal\Character();
			$character->setCharacterId($char->characterID);
			$character->setCharacterName($char->characterName);
			$character->setCorporationId($char->corporationID);
			$character->setCorporationName($char->corporationName);
			$character->setAllianceId($char->allianceId);
			$character->setAllianceName($char->allianceName);
			$character->setFactionId($char->factionID);
			$character->setFactionName($char->factionName);

			$result->addCharacter($character);
		}

		return $result;
	}

	/**
	 *
	 * @param int $keyId
	 */
	public function setKeyId($keyId) {
		$this->keyId = $keyId;
	}

	/**
	 *
	 * @param string $vCode
	 */
	public function setVcode($vCode) {
		$this->vCode = $vCode;
	}

	/**
	 *
	 * @return \Gerh\Evecorp\Domain\Model\Internal\ApiKeyInfo
	 */
	public function retrieveApiKeyInfo() {

		try {
			$phealService = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('Gerh\\Evecorp\\Service\\PhealService', $this->keyId, $this->vCode);
			$pheal = $phealService->getPhealInstance();
			// using account scope as no coporation api key info is available
			$response = $pheal->accountScope->APIKeyInfo();
			return $this->mapRetrievedInformation($response->key);
		} catch (\Pheal\Exceptions\PhealException $ex) {
			return new \Gerh\Evecorp\Domain\Model\Internal\ApiKeyInfo();
		}

	}

}
