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
class EveMapSolarSystem extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

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
