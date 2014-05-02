<?php
namespace Gerh\Evecorp\Domain\Model;
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014 Henning Gerhardt
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
 ***************************************************************/

/**
 *
 *
 * @package evecorp
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Alliance extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

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
	 * class constructor
	 *
	 * @param \integer $allianceID  (Optional) Alliance id
	 * @param \string $allianceName (Optional) Alliance name
	 */
	public function __construct($allianceId = NULL, $allianceName = NULL) {
		$this->setAllianceId($allianceId);
		$this->setAllianceName($allianceName);
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

}
