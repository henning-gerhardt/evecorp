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
class Corporation extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Gerh\Evecorp\Domain\Model\ApiKeyCorporation>
     * @lazy
     * @cascade remove
     */
    protected $apikeys;

    /**
     * @var \integer
     * @validate NotEmpty
     * @validate Integer
     */
    protected $corporationId;

    /**
     * @var \string
     * @validate NotEmpty
     */
    protected $corporationName;

    /**
     * @var \Gerh\Evecorp\Domain\Model\Alliance
     * @lazy
     */
    protected $currentAlliance;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Gerh\Evecorp\Domain\Model\CorporationTitle>
     * @lazy
     * @cascade remove
     */
    protected $titles;

    /**
     * @var \TYPO3\CMS\Extbase\Domain\Model\FrontendUserGroup
     * @lazy
     */
    protected $usergroup;

    /**
     * class constructor
     *
     * @param type $corporationId   (Optional) Corporation id
     * @param type $corporationName (Optional) Corporation name
     */
    public function __construct($corporationId = NULL, $corporationName = NULL) {
        $this->setCorporationId($corporationId);
        $this->setCorporationName($corporationName);
        $this->apikeys = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->titles = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }

    /**
     * Returns corporation id
     *
     * @return \integer
     */
    public function getCorporationId() {
        return $this->corporationId;
    }

    /**
     * Set corporation id
     *
     * @param type $corporationId
     */
    public function setCorporationId($corporationId) {
        $this->corporationId = $corporationId;
    }

    /**
     * Returns corporation name
     *
     * @return string
     */
    public function getCorporationName() {
        return $this->corporationName;
    }

    /**
     * Set corporation name
     *
     * @param \string $corporationName
     */
    public function setCorporationName($corporationName) {
        $this->corporationName = $corporationName;
    }

    /**
     * Get current alliance as object
     *
     * @return \Gerh\Evecorp\Domain\Model\Alliance | NULL
     */
    public function getCurrentAlliance() {
        if ($this->currentAlliance instanceof \TYPO3\CMS\Extbase\Persistence\Generic\LazyLoadingProxy) {
            $this->currentAlliance->_loadRealInstance();
        }

        return $this->currentAlliance;
    }

    /**
     * Set current alliance
     *
     * @param \Gerh\Evecorp\Domain\Model\Alliance $alliance
     */
    public function setCurrentAlliance(\Gerh\Evecorp\Domain\Model\Alliance $alliance = \NULL) {
        $this->currentAlliance = $alliance;
    }

    /**
     * Returns current name of alliance if corporation is in alliance
     *
     * @return string
     */
    public function getAllianceName() {
        $result = '';
        $alliance = $this->getCurrentAlliance();
        if ($alliance instanceof \Gerh\Evecorp\Domain\Model\Alliance) {
            $result = $alliance->getAllianceName();
        }

        return $result;
    }

    /**
     * Get default frontend user group
     *
     * @return \TYPO3\CMS\Extbase\Domain\Model\FrontendUserGroup
     */
    public function getUsergroup() {
        if ($this->usergroup instanceof \TYPO3\CMS\Extbase\Persistence\Generic\LazyLoadingProxy) {
            $this->usergroup->_loadRealInstance();
        }

        return $this->usergroup;
    }

    /**
     * Set default frontend user group
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FrontendUserGroup $usergroup
     * @return void
     */
    public function setUsergroup(\TYPO3\CMS\Extbase\Domain\Model\FrontendUserGroup $usergroup = NULL) {
        $this->usergroup = $usergroup;
    }

    /**
     * Add a api key to corporation
     *
     * @param \Gerh\Evecorp\Domain\Model\ApiKeyCorporation $apikey
     */
    public function addApiKey(\Gerh\Evecorp\Domain\Model\ApiKeyCorporation $apikey) {
        $this->apikeys->attach($apikey);
    }

    /**
     * Returns api keys of corporation
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Gerh\Evecorp\Domain\Model\ApiKeyCorporation>
     */
    public function getApiKeys() {
        if ($this->apikeys instanceof \TYPO3\CMS\Extbase\Persistence\Generic\LazyLoadingProxy) {
            $this->apikeys->_loadRealInstance();
        }
        return $this->apikeys;
    }

    /**
     * Remove all api keys from corporation
     */
    public function removeAllApiKeys() {
        $this->apikeys = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }

    /**
     * Remove a api key from corporation
     *
     * @param \Gerh\Evecorp\Domain\Model\ApiKeyCorporation $apikey
     */
    public function removeApiKey(\Gerh\Evecorp\Domain\Model\ApiKeyCorporation $apikey) {
        $this->apikeys->detach($apikey);
    }

    /**
     * Set api keys of corporation
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $apikeys
     */
    public function setApiKeys(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $apikeys) {
        $this->apikeys = $apikeys;
    }

    /**
     * Add a title to corporation
     *
     * @param \Gerh\Evecorp\Domain\Model\CorporationTitle $title
     */
    public function addCorporationTitle(\Gerh\Evecorp\Domain\Model\CorporationTitle $title) {
        $this->titles->attach($title);
    }

    /**
     * Returns titles of corporation
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Gerh\Evecorp\Domain\Model\CorporationTitle>
     */
    public function getCorporationTitles() {
        return $this->titles;
    }

    /**
     * Remove all titles from corporation
     */
    public function removeAllCorporationTitles() {
        $this->titles = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }

    /**
     * Remove a title from corporation
     *
     * @param \Gerh\Evecorp\Domain\Model\CorporationTitle $title
     */
    public function removeCorporationTitle(\Gerh\Evecorp\Domain\Model\CorporationTitle $title) {
        $this->titles->detach($title);
    }

    /**
     * Set titles of corporation
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $titles
     */
    public function setCorporationTitles(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $titles) {
        $this->titles = $titles;
    }

    /**
     * Prove if any corporation api key with requested access mask
     *
     * @param \integer $accessMaskToProve
     * @return \boolean
     */
    public function hasAccessTo($accessMaskToProve) {
        $result = \FALSE;
        foreach ($this->getApiKeys() as $apiKey) {
            if ($apiKey->hasAccessTo($accessMaskToProve)) {
                $result = \TRUE;
                break;
            }
        }
        return $result;
    }

    /**
     * Find / Search for first corporaton api key which match access mask
     * requirements. If none is found NULL is returned.
     *
     * @param \integer $accessMaskToSearchFor
     * @return \NULL|\Gerh\Evecorp\Domain\Model\ApiKeyCorporation
     */
    public function findFirstApiKeyByAccessMask($accessMaskToSearchFor) {
        $result = \NULL;
        foreach ($this->getApiKeys() as $apiKey) {
            if ($apiKey->hasAccessTo($accessMaskToSearchFor)) {
                $result = $apiKey;
                break;
            }
        }

        return $result;
    }

}
