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
class Corporation extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * @var \integer
	 * @validate NotEmpty
	 * @validate Integer
	 */
	protected $corporationId;

	/**
	 * @var \string
	 * @validate NotEmpty
	 */
	protected $corporationName;

	/**
	 * @var \Gerh\Evecorp\Domain\Model\Alliance
	 * @lazy
	 */
	protected $currentAlliance;

	/**
	 * @var \TYPO3\CMS\Extbase\Domain\Model\FrontendUserGroup
	 * @lazy
	 */
	protected $usergroup;

	/**
	 * class constructor
	 *
	 * @param type $corporationId   (Optional) Corporation id
	 * @param type $corporationName (Optional) Corporation name
	 */
	public function __construct($corporationId = NULL, $corporationName = NULL) {
		$this->setCorporationId($corporationId);
		$this->setCorporationName($corporationName);
	}

	/**
	 * Returns corporation id
	 *
	 * @return \integer
	 */
	public function getCorporationId() {
		return $this->corporationId;
	}

	/**
	 * Set corporation id
	 *
	 * @param type $corporationId
	 */
	public function setCorporationId($corporationId) {
		$this->corporationId = $corporationId;
	}

	/**
	 * Returns corporation name
	 *
	 * @return string
	 */
	public function getCorporationName() {
		return $this->corporationName;
	}

	/**
	 * Set corporation name
	 *
	 * @param \string $corporationName
	 */
	public function setCorporationName($corporationName) {
		$this->corporationName = $corporationName;
	}

	/**
	 * Get current alliance as object
	 *
	 * @return \Gerh\Evecorp\Domain\Model\Alliance | NULL
	 */
	public function getCurrentAlliance() {
		if ($this->currentAlliance instanceof \TYPO3\CMS\Extbase\Persistence\Generic\LazyLoadingProxy) {
			$this->currentAlliance->_loadRealInstance();
		}
		
		return $this->currentAlliance;
	}

	/**
	 * Set current alliance
	 *
	 * @param \Gerh\Evecorp\Domain\Model\Alliance $alliance
	 */
	public function setCurrentAlliance(\Gerh\Evecorp\Domain\Model\Alliance $alliance) {
		$this->currentAlliance = $alliance;
	}

	/**
	 * Returns current name of alliance if corporation is in alliance
	 *
	 * @return string
	 */
	public function getAllianceName() {
		$alliance = $this->getCurrentAlliance();
		if ($alliance != null) {
			$result = $alliance->getAllianceName();
		} else {
			$result = '';
		}

		return $result;
	}

	/**
	 * Get default frontend user group
	 *
	 * @return \TYPO3\CMS\Extbase\Domain\Model\FrontendUserGroup
	 */
	public function getUsergroup() {
		return $this->usergroup;
	}

	/**
	 * Set default frontend user group
	 *
	 * @param \TYPO3\CMS\Extbase\Domain\Model\FrontendUserGroup $usergroup
	 * @return void
	 */
	public function setUsergroup(\TYPO3\CMS\Extbase\Domain\Model\FrontendUserGroup $usergroup = NULL) {
		$this->usergroup = $usergroup;
	}
}
