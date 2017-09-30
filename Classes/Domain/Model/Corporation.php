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

use TYPO3\CMS\Extbase\Domain\Model\FrontendUserGroup;
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
class Corporation extends AbstractEntity {

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
     * @var Alliance
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
     * @var FrontendUserGroup
     * @lazy
     */
    protected $usergroup;

    /**
     * class constructor
     *
     * @param type $corporationId   (Optional) Corporation id
     * @param type $corporationName (Optional) Corporation name
     */
    public function __construct($corporationId = \NULL, $corporationName = \NULL) {
        $this->setCorporationId($corporationId);
        $this->setCorporationName($corporationName);
        $this->apikeys = new ObjectStorage();
        $this->titles = new ObjectStorage();
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
     * @return Alliance | NULL
     */
    public function getCurrentAlliance() {
        if ($this->currentAlliance instanceof LazyLoadingProxy) {
            $this->currentAlliance->_loadRealInstance();
        }

        return $this->currentAlliance;
    }

    /**
     * Set current alliance
     *
     * @param Alliance $alliance
     */
    public function setCurrentAlliance(Alliance $alliance = \NULL) {
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
        if ($alliance instanceof Alliance) {
            $result = $alliance->getAllianceName();
        }

        return $result;
    }

    /**
     * Get default frontend user group
     *
     * @return FrontendUserGroup
     */
    public function getUsergroup() {
        if ($this->usergroup instanceof LazyLoadingProxy) {
            $this->usergroup->_loadRealInstance();
        }

        return $this->usergroup;
    }

    /**
     * Set default frontend user group
     *
     * @param FrontendUserGroup $usergroup
     * @return void
     */
    public function setUsergroup(FrontendUserGroup $usergroup = \NULL) {
        $this->usergroup = $usergroup;
    }

    /**
     * Add a api key to corporation
     *
     * @param ApiKeyCorporation $apikey
     */
    public function addApiKey(ApiKeyCorporation $apikey) {
        $this->apikeys->attach($apikey);
    }

    /**
     * Returns api keys of corporation
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Gerh\Evecorp\Domain\Model\ApiKeyCorporation>
     */
    public function getApiKeys() {
        if ($this->apikeys instanceof LazyLoadingProxy) {
            $this->apikeys->_loadRealInstance();
        }
        return $this->apikeys;
    }

    /**
     * Remove all api keys from corporation
     */
    public function removeAllApiKeys() {
        $this->apikeys = new ObjectStorage();
    }

    /**
     * Remove a api key from corporation
     *
     * @param ApiKeyCorporation $apikey
     */
    public function removeApiKey(ApiKeyCorporation $apikey) {
        $this->apikeys->detach($apikey);
    }

    /**
     * Set api keys of corporation
     *
     * @param ObjectStorage $apikeys
     */
    public function setApiKeys(ObjectStorage $apikeys) {
        $this->apikeys = $apikeys;
    }

    /**
     * Add a title to corporation
     *
     * @param CorporationTitle $title
     */
    public function addCorporationTitle(CorporationTitle $title) {
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
        $this->titles = new ObjectStorage();
    }

    /**
     * Remove a title from corporation
     *
     * @param CorporationTitle $title
     */
    public function removeCorporationTitle(CorporationTitle $title) {
        $this->titles->detach($title);
    }

    /**
     * Set titles of corporation
     *
     * @param ObjectStorage $titles
     */
    public function setCorporationTitles(ObjectStorage $titles) {
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
     * @return \NULL|ApiKeyCorporation
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
