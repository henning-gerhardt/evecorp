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

use TYPO3\CMS\Extbase\Domain\Model\FrontendUser;
use TYPO3\CMS\Extbase\Domain\Model\FrontendUserGroup;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 *
 *
 * @package evecorp
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class CorpMember extends FrontendUser {

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Gerh\Evecorp\Domain\Model\ApiKeyAccount>
     * @lazy
     * @cascade remove
     */
    protected $apiKeys;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Gerh\Evecorp\Domain\Model\Character>
     * @lazy
     * @cascade remove
     */
    protected $characters;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FrontendUserGroup>
     * @lazy
     */
    protected $eveCorpGroups;

    /**
     * default class constructor
     *
     * @param \string $username
     * @param \string $password
     */
    public function __construct($username = '', $password = '') {
        parent::__construct($username, $password);
        $this->apiKeys = new ObjectStorage();
        $this->characters = new ObjectStorage();
        $this->eveCorpGroups = new ObjectStorage();
    }

    /**
     * Return all corp members api keys
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Gerh\Evecorp\Domain\Model\ApiKeyAccount>
     */
    public function getApiKeys() {
        return $this->apiKeys;
    }

    /**
     * Return all corp member characters
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Gerh\Evecorp\Domain\Model\Character>
     */
    public function getCharacters() {
        return $this->characters;
    }

    /**
     * Add a new frontend user group to eve corp and standard user group
     *
     * @param FrontendUserGroup $group
     */
    public function addEveCorpGroup(FrontendUserGroup $group) {
        $this->eveCorpGroups->attach($group);
        $this->usergroup->attach($group);
    }

    /**
     * Returns all used frontend user groups
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FrontendUserGroup>
     */
    public function getEveCorpGroups() {
        if ($this->eveCorpGroups === \NULL) {
            $this->eveCorpGroups = new ObjectStorage();
        }

        return $this->eveCorpGroups;
    }

    /**
     * Remove a frontend user group from eve corp and standard user group
     *
     * @param FrontendUserGroup $group
     */
    public function removeEveCorpGroup(FrontendUserGroup $group) {
        $this->eveCorpGroups->detach($group);
        $this->usergroup->detach($group);
    }

}
