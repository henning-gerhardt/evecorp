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
class CorporationTitle extends AbstractEntity
{

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
    public function __construct()
    {
        $this->characters = new ObjectStorage();
    }

    /**
     * Returns corporation
     *
     * @return Corporation
     */
    public function getCorporation()
    {
        if ($this->corporation instanceof LazyLoadingProxy) {
            $this->corporation->_loadRealInstance();
        }

        return $this->corporation;
    }

    /**
     * Return title id
     *
     * @return \integer
     */
    public function getTitleId()
    {
        return $this->titleId;
    }

    /**
     * Return title name
     *
     * @return \string
     */
    public function getTitleName()
    {
        return $this->titleName;
    }

    /**
     * Get default frontend user group
     *
     * @return FrontendUserGroup
     */
    public function getUsergroup()
    {
        if ($this->usergroup instanceof LazyLoadingProxy) {
            $this->usergroup->_loadRealInstance();
        }

        return $this->usergroup;
    }

    /**
     * Set corporation
     *
     * @param Corporation $corporation
     */
    public function setCorporation(Corporation $corporation)
    {
        $this->corporation = $corporation;
    }

    /**
     * Set title id
     *
     * @param \integer $titleId
     */
    public function setTitleId($titleId)
    {
        $this->titleId = $titleId;
    }

    /**
     * Set title name
     *
     * @param \string $titleName
     */
    public function setTitleName($titleName)
    {
        $this->titleName = $titleName;
    }

    /**
     * Set frontend user group
     *
     * @param FrontendUserGroup $usergroup
     * @return void
     */
    public function setUsergroup(FrontendUserGroup $usergroup = \NULL)
    {
        $this->usergroup = $usergroup;
    }

    /**
     * Add character to this title
     *
     * @param Character $character
     */
    public function addCharacter(Character $character)
    {
        $this->characters->attach($character);
    }

    /**
     * Return characters of this title
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Gerh\Evecorp\Domain\Model\Character>
     */
    public function getCharacters()
    {
        if ($this->characters instanceof LazyLoadingProxy) {
            $this->characters->_loadRealInstance();
        }

        return $this->characters;
    }

    /**
     * Remove a single character
     *
     * @param Character $character
     */
    public function removeCharacter(Character $character)
    {
        $this->characters->detach($character);
    }

    /**
     * Remove all characters from this title
     */
    public function removeAllCharacters()
    {
        $this->characters = new ObjectStorage();
    }

    /**
     * Set characters of this title
     *
     * @param ObjectStorage $characters
     */
    public function setCharacters(ObjectStorage $characters)
    {
        $this->characters = $characters;
    }
}
