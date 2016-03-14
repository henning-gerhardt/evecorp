<?php

/* * *************************************************************
 *  Copyright notice
 *
 *  (c) 2016 Henning Gerhardt
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
 * ************************************************************* */

namespace Gerh\Evecorp\Domain\Model;

/**
 *
 *
 * @package evecorp
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Character extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * @var \Gerh\Evecorp\Domain\Model\ApiKeyAccount
	 * @lazy
	 */
	protected $apiKeyAccount;

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
	 * @var \Gerh\Evecorp\Domain\Model\CorpMember
	 * @lazy
	 */
	protected $corpMember;

	/**
	 * @var \Gerh\Evecorp\Domain\Model\DateTime
	 * @validate NotEmpty
	 */
	protected $corporationDate;

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
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Gerh\Evecorp\Domain\Model\EmploymentHistory>
	 * @lazy
	 * @cascade remove
	 */
	protected $employments;

	/**
	 * @var \string
	 */
	protected $race;

	/**
	 * @var \float
	 */
	protected $securityStatus;

	/**
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Gerh\Evecorp\Domain\Model\CorporationTitle>
	 * @lazy
	 */
	protected $titles;

	/**
	 * class constructor
	 */
	public function __construct() {
		$this->employments = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->titles = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
	}

	/**
	 * Returns characters dependend API key
	 *
	 * @return \Gerh\Evecorp\Domain\Model\ApiKey
	 */
	public function getApiKeyAccount() {
		if ($this->apiKeyAccount instanceof \TYPO3\CMS\Extbase\Persistence\Generic\LazyLoadingProxy) {
			$this->apiKeyAccount->_loadRealInstance();
		}

		return $this->apiKeyAccount;
	}

	/**
	 * Set characters dependend API key
	 *
	 * @param \Gerh\Evecorp\Domain\Model\ApiKeyAccount $apiKeyAccount
	 */
	public function setApiKeyAccount(\Gerh\Evecorp\Domain\Model\ApiKeyAccount $apiKeyAccount) {
		$this->apiKeyAccount = $apiKeyAccount;
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
	 * @return \Gerh\Evecorp\Domain\Model\CorpMember
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
	 * @param \Gerh\Evecorp\Domain\Model\CorpMember
	 */
	public function setCorpMember(\Gerh\Evecorp\Domain\Model\CorpMember $corpMember = NULL) {
		$this->corpMember = $corpMember;
	}

	/**
	 * Get date when character joined his current corporation.
	 * This information could be retrieved from employment history too.
	 *
	 * @return \Gerh\Evecorp\Domain\Model\DateTime
	 */
	public function getCorporationDate() {
		return $this->corporationDate;
	}

	/**
	 * Set date when character joins his current corporation.
	 *
	 * @param \Gerh\Evecorp\Domain\Model\DateTime $corporationDate
	 */
	public function setCorporationDate(\Gerh\Evecorp\Domain\Model\DateTime $corporationDate) {
		$this->corporationDate = $corporationDate;
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
	 * Add a employment
	 *
	 * @param \Gerh\Evecorp\Domain\Model\EmploymentHistory $employment
	 */
	public function addEmployment(\Gerh\Evecorp\Domain\Model\EmploymentHistory $employment) {
		$this->employments->attach($employment);
	}

	/**
	 * Return characters employments
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Gerh\Evecorp\Domain\Model\EmploymentHistory>
	 */
	public function getEmployments() {
		if ($this->employments instanceof \TYPO3\CMS\Extbase\Persistence\Generic\LazyLoadingProxy) {
			$this->employments->_loadRealInstance();
		}

		return $this->employments;
	}

	/**
	 * Remove a single employment
	 *
	 * @param \Gerh\Evecorp\Domain\Model\EmploymentHistory $employment
	 */
	public function removeEmployment(\Gerh\Evecorp\Domain\Model\EmploymentHistory $employment) {
		$this->employments->detach($employment);
	}

	/**
	 * Remove all employments of character
	 */
	public function removeAllEmployments() {
		$this->employments = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
	}

	/**
	 * Set employments of character
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $employments
	 */
	public function setEmployments(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $employments) {
		$this->employments = $employments;
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

	/**
	 * Add corporation title
	 *
	 * @param \Gerh\Evecorp\Domain\Model\CorporationTitle $title
	 */
	public function addTitle(\Gerh\Evecorp\Domain\Model\CorporationTitle $title) {
		$this->titles->attach($title);
	}

	/**
	 * Return characters corporation titles
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Gerh\Evecorp\Domain\Model\CorporationTitle>
	 */
	public function getTitles() {
		if ($this->titles instanceof \TYPO3\CMS\Extbase\Persistence\Generic\LazyLoadingProxy) {
			$this->titles->_loadRealInstance();
		}

		return $this->titles;
	}

	/**
	 * Remove a single corporation title
	 *
	 * @param \Gerh\Evecorp\Domain\Model\CorporationTitle $title
	 */
	public function removeTitle(\Gerh\Evecorp\Domain\Model\CorporationTitle $title) {
		$this->titles->detach($title);
	}

	/**
	 * Remove all corporation titles from character
	 */
	public function removeAllTitles() {
		$this->titles = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
	}

	/**
	 * Set corporation titles of character
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $titles
	 */
	public function setTitles(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $titles) {
		$this->titles = $titles;
	}

}
