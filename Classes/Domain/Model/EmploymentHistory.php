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

/**
 *
 *
 * @package evecorp
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class EmploymentHistory extends AbstractEntity {

    /**
     * @var Character
     * @lazy
     */
    protected $characterUid;

    /**
     * TODO: why a full defined qualifier name is needed here
     *
     * @var \Gerh\Evecorp\Domain\Model\Corporation
     * @lazy
     */
    protected $corporationUid;

    /**
     * @var \integer
     * @validate NotEmpty
     * @validate Integer
     */
    protected $recordId;

    /**
     * @var DateTime
     * @validate NotEmpty
     */
    protected $startDate;

    /**
     * Returns character
     *
     * @return Character
     */
    public function getCharacter() {
        if ($this->characterUid instanceof LazyLoadingProxy) {
            $this->characterUid->_loadRealInstance();
        }

        return $this->characterUid;
    }

    /**
     * Set character
     *
     * @param Character $character
     */
    public function setCharacter(Character $character) {
        $this->characterUid = $character;
    }

    /**
     * Returns corporation
     *
     * @return Corporation
     */
    public function getCorporation() {
        if ($this->corporationUid instanceof LazyLoadingProxy) {
            $this->corporationUid->_loadRealInstance();
        }

        return $this->corporationUid;
    }

    /**
     * Set corporation
     *
     * @param Corporation $corporation
     */
    public function setCorporation(Corporation $corporation) {
        $this->corporationUid = $corporation;
    }

    /**
     * Returns record id of character employment history
     *
     * @return \integer
     */
    public function getRecordId() {
        return $this->recordId;
    }

    /**
     * Set record id of character employment history
     *
     * @param \integer $recordId
     */
    public function setRecordId($recordId) {
        $this->recordId = intval($recordId);
    }

    /**
     * Returns date when character joined corporation
     *
     * @return DateTime
     */
    public function getStartDate() {
        return $this->startDate;
    }

    /**
     * Set date when character joined corporation
     *
     * @param DateTime $startDate
     */
    public function setStartDate(DateTime $startDate) {
        $this->startDate = $startDate;
    }

}
