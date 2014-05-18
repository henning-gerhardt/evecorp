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
class EmploymentHistory extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * @var \Gerh\Evecorp\Domain\Model\Character
	 * @lazy
	 */
	protected $characterUid;

	/**
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
	 * @var \Gerh\Evecorp\Domain\Model\DateTime
	 * @validate NotEmpty
	 */
	protected $startDate;

	/**
	 * Returns character
	 *
	 * @return \Gerh\Evecorp\Domain\Model\Character
	 */
	public function getCharacter() {
		if ($this->characterUid instanceof \TYPO3\CMS\Extbase\Persistence\Generic\LazyLoadingProxy) {
			$this->characterUid->_loadRealInstance();
		}

		return $this->characterUid;
	}

	/**
	 * Set character
	 *
	 * @param \Gerh\Evecorp\Domain\Model\Character $character
	 */
	public function setCharacter(\Gerh\Evecorp\Domain\Model\Character $character) {
		$this->characterUid = $character;
	}

	/**
	 * Returns corporation
	 *
	 * @return \Gerh\Evecorp\Domain\Model\Corporation
	 */
	public function getCorporation() {
		if ($this->corporationUid instanceof \TYPO3\CMS\Extbase\Persistence\Generic\LazyLoadingProxy) {
			$this->corporationUid->_loadRealInstance();
		}

		return $this->corporationUid;
	}

	/**
	 * Set corporation
	 *
	 * @param \Gerh\Evecorp\Domain\Model\Corporation $corporation
	 */
	public function setCorporation(\Gerh\Evecorp\Domain\Model\Corporation $corporation) {
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
	 * @return \Gerh\Evecorp\Domain\Model\DateTime
	 */
	public function getStartDate() {
		return $this->startDate;
	}

	/**
	 * Set date when character joined corporation
	 *
	 * @param \Gerh\Evecorp\Domain\Model\DateTime $startDate
	 */
	public function setStartDate(\Gerh\Evecorp\Domain\Model\DateTime $startDate) {
		$this->startDate = $startDate;
	}

}
