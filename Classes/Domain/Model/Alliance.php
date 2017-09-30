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
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 *
 *
 * @package evecorp
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Alliance extends AbstractEntity {

    /**
     * @var \integer
     * @validate NotEmpty
     * @validate Number
     */
    protected $allianceId;

    /**
     *
     * @var \string
     * @validate NotEmpty
     */
    protected $allianceName;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Gerh\Evecorp\Domain\Model\Corporation>
     * @lazy
     */
    protected $corporations;

    /**
     * class constructor
     *
     * @param \integer $allianceId   (Optional) Alliance id
     * @param \string  $allianceName (Optional) Alliance name
     */
    public function __construct($allianceId = \NULL, $allianceName = \NULL) {
        $this->setAllianceId($allianceId);
        $this->setAllianceName($allianceName);

        $this->corporations = new ObjectStorage();
    }

    /**
     * Returns alliance id
     *
     * @return \integer
     */
    public function getAllianceId() {
        return $this->allianceId;
    }

    /**
     * Set alliance id
     *
     * @param \integer $allianceId
     */
    public function setAllianceId($allianceId) {
        $this->allianceId = $allianceId;
    }

    /**
     * Returns alliance name
     *
     * @return \string
     */
    public function getAllianceName() {
        return $this->allianceName;
    }

    /**
     * Set alliance name
     *
     * @param \string $allianceName
     */
    public function setAllianceName($allianceName) {
        $this->allianceName = $allianceName;
    }

    /**
     * Add a corporation to alliance
     *
     * @param Corporation $corporation
     */
    public function addCorporation(Corporation $corporation) {
        $this->corporations->attach($corporation);
    }

    /**
     * Returns corporations of alliance
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Gerh\Evecorp\Domain\Model\Corporation>
     */
    public function getCorporations() {
        return $this->corporations;
    }

    /**
     * Remove all corporations from alliance
     */
    public function removeAllCorporations() {
        $this->corporations = new ObjectStorage();
    }

    /**
     * Remove a corporation from alliance
     *
     * @param Corporation $corporation
     */
    public function removeCorporation(Corporation $corporation) {
        $this->corporations->detach($corporation);
    }

    /**
     * Set alliance corporations,
     *
     * @param ObjectStorage $corporations
     */
    public function setCorporations(ObjectStorage $corporations) {
        $this->corporations = $corporations;
    }

}
