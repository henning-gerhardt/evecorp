<?php
namespace gerh\Evecorp\Domain\Model;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Henning Gerhardt 
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
 * @package testing
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

}
?>