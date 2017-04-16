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
class CorporationTitle extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Gerh\Evecorp\Domain\Model\Character>
     * @lazy
     */
    protected $characters;

    /**
     * @var \integer
     * @validate NotEmpty
     * @validate Integer
     */
    protected $titleId;

    /**
     * @var \string
     * @validate NotEmpty
     */
    protected $titleName;

    /**
     * @var \Gerh\Evecorp\Domain\Model\Corporation
     * @lazy
     */
    protected $corporation;

    /**
     * @var \TYPO3\CMS\Extbase\Domain\Model\FrontendUserGroup
     * @lazy
     */
    protected $usergroup;

    /**
     * class constructor
     */
    public function __construct() {
        $this->characters = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }

    /**
     * Returns corporation
     *
     * @return \Gerh\Evecorp\Domain\Model\Corporation
     */
    public function getCorporation() {
        if ($this->corporation instanceof \TYPO3\CMS\Extbase\Persistence\Generic\LazyLoadingProxy) {
            $this->corporation->_loadRealInstance();
        }

        return $this->corporation;
    }

    /**
     * Return title id
     *
     * @return \integer
     */
    public function getTitleId() {
        return $this->titleId;
    }

    /**
     * Return title name
     *
     * @return \string
     */
    public function getTitleName() {
        return $this->titleName;
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
     * Set corporation
     *
     * @param \Gerh\Evecorp\Domain\Model\Corporation $corporation
     */
    public function setCorporation(\Gerh\Evecorp\Domain\Model\Corporation $corporation) {
        $this->corporation = $corporation;
    }

    /**
     * Set title id
     *
     * @param \integer $titleId
     */
    public function setTitleId($titleId) {
        $this->titleId = $titleId;
    }

    /**
     * Set title name
     *
     * @param \string $titleName
     */
    public function setTitleName($titleName) {
        $this->titleName = $titleName;
    }

    /**
     * Set frontend user group
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FrontendUserGroup $usergroup
     * @return void
     */
    public function setUsergroup(\TYPO3\CMS\Extbase\Domain\Model\FrontendUserGroup $usergroup = \NULL) {
        $this->usergroup = $usergroup;
    }

    /**
     * Add character to this title
     *
     * @param \Gerh\Evecorp\Domain\Model\Character $character
     */
    public function addCharacter(\Gerh\Evecorp\Domain\Model\Character $character) {
        $this->characters->attach($character);
    }

    /**
     * Return characters of this title
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Gerh\Evecorp\Domain\Model\Character>
     */
    public function getCharacters() {
        if ($this->characters instanceof \TYPO3\CMS\Extbase\Persistence\Generic\LazyLoadingProxy) {
            $this->characters->_loadRealInstance();
        }

        return $this->characters;
    }

    /**
     * Remove a single character
     *
     * @param \Gerh\Evecorp\Domain\Model\Character $character
     */
    public function removeCharacter(\Gerh\Evecorp\Domain\Model\Character $character) {
        $this->characters->detach($character);
    }

    /**
     * Remove all characters from this title
     */
    public function removeAllCharacters() {
        $this->characters = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }

    /**
     * Set characters of this title
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $characters
     */
    public function setCharacters(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $characters) {
        $this->characters = $characters;
    }

}
