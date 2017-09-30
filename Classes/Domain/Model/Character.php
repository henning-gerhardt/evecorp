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

namespace Gerh\Evecorp\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\Generic\LazyLoadingProxy;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 *
 *
 * @package evecorp
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Character extends AbstractEntity {

    /**
     * @var ApiKeyAccount
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
     * @var CorpMember
     * @lazy
     */
    protected $corpMember;

    /**
     * @var DateTime
     * @validate NotEmpty
     */
    protected $corporationDate;

    /**
     * @var Alliance
     * @lazy
     */
    protected $currentAlliance;

    /**
     * @var Corporation
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
        $this->employments = new ObjectStorage();
        $this->titles = new ObjectStorage();
    }

    /**
     * Returns characters dependend API key
     *
     * @return ApiKey
     */
    public function getApiKey() {
        if ($this->apiKey instanceof LazyLoadingProxy) {
            $this->apiKey->_loadRealInstance();
        }

        return $this->apiKey;
    }

    /**
     * Set characters dependend API key
     *
     * @param ApiKeyAccount $apiKeyAccount
     */
    public function setApiKey(ApiKeyAccount $apiKeyAccount) {
        $this->apiKey = $apiKeyAccount;
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
     * @return CorpMember
     */
    public function getCorpMember() {
        if ($this->corpMember instanceof LazyLoadingProxy) {
            $this->corpMember->_loadRealInstance();
        }

        return $this->corpMember;
    }

    /**
     * Set frontend user for this API key
     *
     * @param CorpMember
     */
    public function setCorpMember(CorpMember $corpMember = \NULL) {
        $this->corpMember = $corpMember;
    }

    /**
     * Get date when character joined his current corporation.
     * This information could be retrieved from employment history too.
     *
     * @return DateTime
     */
    public function getCorporationDate() {
        return $this->corporationDate;
    }

    /**
     * Set date when character joins his current corporation.
     *
     * @param DateTime $corporationDate
     */
    public function setCorporationDate(DateTime $corporationDate) {
        $this->corporationDate = $corporationDate;
    }

    /**
     * Returns characters current corporation
     *
     * @return Corporation
     */
    public function getCurrentCorporation() {
        if ($this->currentCorporation instanceof LazyLoadingProxy) {
            $this->currentCorporation->_loadRealInstance();
        }

        return $this->currentCorporation;
    }

    /**
     * Set characters current corporation
     *
     * @param Corporation $corporation
     */
    public function setCurrentCorporation(Corporation $corporation) {
        $this->currentCorporation = $corporation;
    }

    /**
     * Add a employment
     *
     * @param EmploymentHistory $employment
     */
    public function addEmployment(EmploymentHistory $employment) {
        $this->employments->attach($employment);
    }

    /**
     * Return characters employments
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Gerh\Evecorp\Domain\Model\EmploymentHistory>
     */
    public function getEmployments() {
        if ($this->employments instanceof LazyLoadingProxy) {
            $this->employments->_loadRealInstance();
        }

        return $this->employments;
    }

    /**
     * Remove a single employment
     *
     * @param EmploymentHistory $employment
     */
    public function removeEmployment(EmploymentHistory $employment) {
        $this->employments->detach($employment);
    }

    /**
     * Remove all employments of character
     */
    public function removeAllEmployments() {
        $this->employments = new ObjectStorage();
    }

    /**
     * Set employments of character
     *
     * @param ObjectStorage $employments
     */
    public function setEmployments(ObjectStorage $employments) {
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
     * @param CorporationTitle $title
     */
    public function addTitle(CorporationTitle $title) {
        $this->titles->attach($title);
    }

    /**
     * Return characters corporation titles
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Gerh\Evecorp\Domain\Model\CorporationTitle>
     */
    public function getTitles() {
        if ($this->titles instanceof LazyLoadingProxy) {
            $this->titles->_loadRealInstance();
        }

        return $this->titles;
    }

    /**
     * Remove a single corporation title
     *
     * @param CorporationTitle $title
     */
    public function removeTitle(CorporationTitle $title) {
        $this->titles->detach($title);
    }

    /**
     * Remove all corporation titles from character
     */
    public function removeAllTitles() {
        $this->titles = new ObjectStorage();
    }

    /**
     * Set corporation titles of character
     *
     * @param ObjectStorage $titles
     */
    public function setTitles(ObjectStorage $titles) {
        $this->titles = $titles;
    }

}
