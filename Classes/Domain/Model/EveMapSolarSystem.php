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

/**
 *
 *
 * @package evecorp
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class EveMapSolarSystem extends AbstractEntity {

    /**
     * @var \integer
     */
    protected $solarSystemId;

    /**
     * @var \string
     */
    protected $solarSystemName;

    /**
     * Get solar system id
     *
     * @return \integer
     */
    public function getSolarSystemId() {
        return $this->solarSystemId;
    }

    /**
     * Set solar system id
     *
     * @param \integer $solarSystemId
     * @return void
     */
    public function setSolarSystemId($solarSystemId) {
        $this->solarSystemId = $solarSystemId;
    }

    /**
     * Get solar system name
     *
     * @return \string
     */
    public function getSolarSystemName() {
        return $this->solarSystemName;
    }

    /**
     * Set solar system name
     *
     * @param \string $solarSystemName
     * @return void
     */
    public function setSolarSystemName($solarSystemName) {
        $this->solarSystemName = $solarSystemName;
    }

}
