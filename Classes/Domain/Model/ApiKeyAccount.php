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
use TYPO3\CMS\Extbase\Persistence\Generic\LazyLoadingProxy;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 *
 *
 * @package evecorp
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class ApiKeyAccount extends ApiKey {

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Gerh\Evecorp\Domain\Model\Character>
     * @lazy
     * @cascade remove
     */
    protected $characters;

    /**
     * @var CorpMember
     * @lazy
     */
    protected $corpMember;

    /**
     * class constructor
     */
    public function __construct() {
        $this->characters = new ObjectStorage();
    }

    /**
     * Add character to API key
     *
     * @param Character $character
     */
    public function addCharacter(Character $character) {
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
     * @param Character $character
     */
    public function removeCharacter(Character $character) {
        $this->characters->detach($character);
    }

    /**
     * Remove all characters from API key
     */
    public function removeAllCharacters() {
        $this->characters = new ObjectStorage();
    }

    /**
     * Set characters of API key
     *
     * @param ObjectStorage $characters
     */
    public function setCharacters(ObjectStorage $characters) {
        $this->characters = $characters;
    }

    /**
     * Returns frontend user for API key
     *
     * @return FrontendUser
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
    public function setCorpMember(CorpMember $corpMember) {
        $this->corpMember = $corpMember;
    }

}
