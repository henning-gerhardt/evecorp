<?php
namespace Gerh\Evecorp\Domain\Model;
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
class Character extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * @var \Gerh\Evecorp\Domain\Model\ApiKey
	 * @lazy
	 */
	protected $apiKey;

	/**
	 * @var \integer
	 * @validate NotEmpty
	 * @validate Integer
	 */
	protected $characterId;

	/**
	 * @var \string
	 * @validate NotEmpty
	 */
	protected $characterName;

	/**
	 * @var \TYPO3\CMS\Extbase\Domain\Model\FrontendUser
	 * @lazy
	 */
	protected $corpMember;

	/**
	 * @var \Gerh\Evecorp\Domain\Model\Alliance
	 * @lazy
	 */
	protected $currentAlliance;

	/**
	 * @var \Gerh\Evecorp\Domain\Model\Corporation
	 * @lazy
	 * @validate NotEmpty
	 */
	protected $currentCorporation;

	/**
	 * @var \string
	 */
	protected $race;

	/**
	 * @var \float
	 */
	protected $securityStatus;

	/**
	 * Returns characters dependend API key
	 *
	 * @return \Gerh\Evecorp\Domain\Model\ApiKey
	 */
	public function getApiKey() {
		if ($this->apiKey instanceof \TYPO3\CMS\Extbase\Persistence\Generic\LazyLoadingProxy) {
			$this->apiKey->_loadRealInstance();
		}

		return $this->apiKey;
	}

	/**
	 * Set characters dependend API key
	 *
	 * @param \Gerh\Evecorp\Domain\Model\ApiKey $apiKey
	 */
	public function setApiKey(\Gerh\Evecorp\Domain\Model\ApiKey $apiKey) {
		$this->apiKey = $apiKey;
	}

	/**
	 * Returns character id
	 *
	 * @return \integer
	 */
	public function getCharacterId() {
		return $this->characterId;
	}

	/**
	 * Set character id
	 *
	 * @param \integer $characterId
	 */
	public function setCharacterId($characterId) {
		$this->characterId = $characterId;
	}

	/**
	 * Returns name of character
	 *
	 * @return \string
	 */
	public function getCharacterName() {
		return $this->characterName;
	}

	/**
	 * Set name of character
	 *
	 * @param \string $characterName
	 */
	public function setCharacterName($characterName) {
		$this->characterName = $characterName;
	}

	/**
	 * Returns frontend user for API key
	 *
	 * @return \TYPO3\CMS\Extbase\Domain\Model\FrontendUser
	 */
	public function getCorpMember() {
		if ($this->corpMember instanceof \TYPO3\CMS\Extbase\Persistence\Generic\LazyLoadingProxy) {
			$this->corpMember->_loadRealInstance();
		}

		return $this->corpMember;
	}

	/**
	 * Set frontend user for this API key
	 *
	 * @param \TYPO3\CMS\Extbase\Domain\Model\FrontendUser
	 */
	public function setCorpMember(\TYPO3\CMS\Extbase\Domain\Model\FrontendUser $corpMember) {
		$this->corpMember = $corpMember;
	}

	/**
	 * Returns characters current alliance
	 *
	 * @return \Gerh\Evecorp\Domain\Model\Alliance
	 */
	public function getCurrentAlliance() {
		if ($this->currentAlliance instanceof \TYPO3\CMS\Extbase\Persistence\Generic\LazyLoadingProxy) {
			$this->currentAlliance->_loadRealInstance();
		}

		return $this->currentAlliance;
	}

	/**
	 * Set characters current alliance
	 *
	 * @param \Gerh\Evecorp\Domain\Model\Alliance $alliance
	 */
	public function setCurrentAlliance(\Gerh\Evecorp\Domain\Model\Alliance $alliance = NULL) {
		$this->currentAlliance = $alliance;
	}

	/**
	 * Returns characters current corporation
	 *
	 * @return \Gerh\Evecorp\Domain\Model\Corporation
	 */
	public function getCurrentCorporation() {
		if ($this->currentCorporation instanceof \TYPO3\CMS\Extbase\Persistence\Generic\LazyLoadingProxy) {
			$this->currentCorporation->_loadRealInstance();
		}

		return $this->currentCorporation;
	}

	/**
	 * Set characters current corporation
	 *
	 * @param \Gerh\Evecorp\Domain\Model\Corporation $corporation
	 */
	public function setCurrentCorporation(\Gerh\Evecorp\Domain\Model\Corporation $corporation) {
		$this->currentCorporation = $corporation;
	}

	/**
	 * Returns characters race
	 *
	 * @return \string
	 */
	public function getRace() {
		return $this->race;
	}

	/**
	 * Set characters race
	 *
	 * @param \string $race
	 */
	public function setRace($race) {
		$this->race = $race;
	}

	/**
	 * Returns characters security status
	 *
	 * @return \float
	 */
	public function getSecurityStatus() {
		return $this->securityStatus;
	}

	/**
	 * Set characters security status
	 *
	 * @param \float $securityStatus
	 */
	public function setSecurityStatus($securityStatus) {
		$this->securityStatus = $securityStatus;
	}

}
