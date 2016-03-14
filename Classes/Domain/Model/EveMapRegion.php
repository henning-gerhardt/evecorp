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
class EveMapRegion extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

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
	public function getRegionId() {
		return $this->regionId;
	}

	/**
	 * Set region id
	 *
	 * @param \integer $regionId
	 * @return void
	 */
	public function setRegionId($regionId) {
		$this->regionId = $regionId;
	}

	/**
	 * Get region name
	 *
	 * @return \string
	 */
	public function getRegionName() {
		return $this->regionName;
	}

	/**
	 * Set region name
	 *
	 * @param \string $regionName
	 * @return void
	 */
	public function setRegionName($regionName) {
		$this->regionName = $regionName;
	}

}
