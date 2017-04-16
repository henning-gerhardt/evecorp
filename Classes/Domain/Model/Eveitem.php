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

/**
 *
 *
 * @package evecorp
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Eveitem extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

    /**
     * eveName
     *
     * @var \string
     * @validate NotEmpty
     */
    protected $eveName;

    /**
     * eveId
     *
     * @var \integer
     * @validate NotEmpty
     */
    protected $eveId;

    /**
     * buyPrice of item
     *
     * @var \float
     * @validate NotEmpty
     */
    protected $buyPrice;

    /**
     * sellPrice of item
     *
     * @var \float
     * @validate NotEmpty
     */
    protected $sellPrice;

    /**
     * cache time of object
     *
     * @var \integer
     * @validate NotEmpty
     */
    protected $cacheTime;

    /**
     * time to cache (in minutes)
     *
     * @var \integer
     * @validate NotEmpty
     */
    protected $timeToCache;

    /**
     * region
     *
     * @var \Gerh\Evecorp\Domain\Model\EveMapRegion
     */
    protected $region;

    /**
     * solar system
     *
     * @var \Gerh\Evecorp\Domain\Model\EveMapSolarSystem
     */
    protected $solarSystem;

    /**
     * Returns the eveName
     *
     * @return \string $eveName
     */
    public function getEveName() {
        return $this->eveName;
    }

    /**
     * Sets the eveName
     *
     * @param \string $eveName
     * @return void
     */
    public function setEveName($eveName) {
        $this->eveName = $eveName;
    }

    /**
     * Returns the eveCentralId
     *
     * @return \integer $eveId
     */
    public function getEveId() {
        return $this->eveId;
    }

    /**
     * Sets the eveId
     *
     * @param \integer $eveId
     * @return void
     */
    public function setEveId($eveId) {
        $this->eveId = $eveId;
    }

    /**
     * Returns the stored buyPrice
     *
     * @return \float $buyPrice
     */
    public function getBuyPrice() {
        return $this->buyPrice;
    }

    /**
     * Sets the buyPrice of item
     *
     * @param \float $buyPrice
     * @return void
     */
    public function setBuyPrice($buyPrice) {
        $this->buyPrice = $buyPrice;
    }

    /**
     * Returns the stored sellPrice
     *
     * @return \float $sellPrice
     */
    public function getSellPrice() {
        return $this->sellPrice;
    }

    /**
     * Sets the sellPrice of item
     *
     * @param \float $sellPrice
     * @return void
     */
    public function setSellPrice($sellPrice) {
        $this->sellPrice = $sellPrice;
    }

    /**
     * Returns cached until time
     *
     * @return \integer $cacheTime
     */
    public function getCacheTime() {
        return $this->cacheTime;
    }

    /**
     * Sets cache until time
     *
     * @param \integer $cacheTime
     * @return void
     */
    public function setCacheTime($cacheTime) {
        $this->cacheTime = $cacheTime;
    }

    /**
     * Return used time to cache (in minutes)
     *
     * @return \integer $cacheTime
     */
    public function getTimeToCache() {
        return $this->timeToCache;
    }

    /**
     * Set time to cache (in minutes)
     *
     * @param \integer $timeToCache
     * @return void
     */
    public function setTimeToCache($timeToCache) {
        $this->timeToCache = 1;
        if (is_int($timeToCache) && ($timeToCache > 0)) {
            $this->timeToCache = \intval($timeToCache);
        }
    }

    /**
     * Get current region
     *
     * @return \Gerh\Evecorp\Domain\Model\EveMapRegion
     */
    public function getRegion() {
        return $this->region;
    }

    /**
     * Set region
     *
     * @param \Gerh\Evecorp\Domain\Model\EveMapRegion $region
     */
    public function setRegion(\Gerh\Evecorp\Domain\Model\EveMapRegion $region) {
        $this->region = $region;
    }

    /**
     * Return used solar system
     *
     * @return \Gerh\Evecorp\Domain\Model\EveMapSolarSystem
     */
    public function getSolarSystem() {
        return $this->solarSystem;
    }

    /**
     * Set solar system
     *
     * @param \Gerh\Evecorp\Domain\Model\EveMapSolarSystem $solarSystem
     * @return void
     */
    public function setSolarSystem(\Gerh\Evecorp\Domain\Model\EveMapSolarSystem $solarSystem) {
        $this->solarSystem = $solarSystem;
    }

}
