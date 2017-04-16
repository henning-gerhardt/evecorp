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
class ApiKeyAccount extends \Gerh\Evecorp\Domain\Model\ApiKey {

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Gerh\Evecorp\Domain\Model\Character>
     * @lazy
     * @cascade remove
     */
    protected $characters;

    /**
     * @var \Gerh\Evecorp\Domain\Model\CorpMember
     * @lazy
     */
    protected $corpMember;

    /**
     * class constructor
     */
    public function __construct() {
        $this->characters = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }

    /**
     * Add character to API key
     *
     * @param \Gerh\Evecorp\Domain\Model\Character $character
     */
    public function addCharacter(\Gerh\Evecorp\Domain\Model\Character $character) {
        $this->characters->attach($character);
    }

    /**
     * Returns all characters of API key
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Gerh\Evecorp\Domain\Model\Character>
     */
    public function getCharacters() {
        return $this->characters;
    }

    /**
     * Remove character from API key
     *
     * @param \Gerh\Evecorp\Domain\Model\Character $character
     */
    public function removeCharacter(\Gerh\Evecorp\Domain\Model\Character $character) {
        $this->characters->detach($character);
    }

    /**
     * Remove all characters from API key
     */
    public function removeAllCharacters() {
        $this->characters = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }

    /**
     * Set characters of API key
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $characters
     */
    public function setCharacters(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $characters) {
        $this->characters = $characters;
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
     * @param \Gerh\Evecorp\Domain\Model\CorpMember
     */
    public function setCorpMember(\Gerh\Evecorp\Domain\Model\CorpMember $corpMember) {
        $this->corpMember = $corpMember;
    }

}
