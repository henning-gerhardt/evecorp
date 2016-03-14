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
class ApiKeyCorporation extends \Gerh\Evecorp\Domain\Model\ApiKey {

	/**
	 * @var \Gerh\Evecorp\Domain\Model\Corporation
	 * @lazy
	 */
	protected $corporation;

	/**
	 * Returns corporation
	 *
	 * @return \Gerh\Evecorp\Domain\Model\Corporation
	 */
	public function getCorporation() {
		if ($this->corporation instanceof \TYPO3\CMS\Extbase\Persistence\Generic\LazyLoadingProxy) {
			$this->corporation->_loadRealInstance();
		}

		return $this->corporation;
	}

	/**
	 * Set corporation
	 *
	 * @param \Gerh\Evecorp\Domain\Model\Corporation $corporation
	 */
	public function setCorporation(\Gerh\Evecorp\Domain\Model\Corporation $corporation) {
		$this->corporation = $corporation;
	}

}
