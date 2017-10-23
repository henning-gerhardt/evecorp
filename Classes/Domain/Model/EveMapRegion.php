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
class EveMapRegion extends AbstractEntity
{

    /**
     * @var \integer
     */
    protected $regionId;

    /**
     * @var \string
     */
    protected $regionName;

    /**
     * Get region id
     *
     * @return \integer
     */
    public function getRegionId()
    {
        return $this->regionId;
    }

    /**
     * Set region id
     *
     * @param \integer $regionId
     * @return void
     */
    public function setRegionId($regionId)
    {
        $this->regionId = $regionId;
    }

    /**
     * Get region name
     *
     * @return \string
     */
    public function getRegionName()
    {
        return $this->regionName;
    }

    /**
     * Set region name
     *
     * @param \string $regionName
     * @return void
     */
    public function setRegionName($regionName)
    {
        $this->regionName = $regionName;
    }
}
