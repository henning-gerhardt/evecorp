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
class ApiKey extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * @todo using of \Gerh\Evecorp\Domain\Model\CorpMember
	 * @lazy
	 * @var \TYPO3\CMS\Extbase\Domain\Model\FrontendUser
	 */
	protected $corpMember;

	/**
	 * @var \integer
	 * @NotNull
	 */
	protected $keyId;

	/**
	 * @var \string
	 * @NotNull
	 */
	protected $vCode;

	/**
	 *
	 * @return \Gerh\Evecorp\Domain\Model\CorpMember
	 */
	public function getCorpMember() {
		if ($this->corpMember instanceof \TYPO3\CMS\Extbase\Persistence\Generic\LazyLoadingProxy) {
			$this->corpMember->_loadRealInstance();
		}
		
		return $this->corpMember;
	}

	/**
	 *
	 * @param \Gerh\Evecorp\Domain\Model\CorpMember $corpMember
	 */
	public function setCorpMember(\Gerh\Evecorp\Domain\Model\CorpMember $corpMember) {
		$this->corpMember = $corpMember;
	}

	/**
	 *
	 * @return \integer
	 */
	public function getKeyId() {
		return $this->keyId;
	}

	/**
	 *
	 * @param \integer $keyId
	 */
	public function setKeyId($keyId) {
		$this->keyId = $keyId;
	}

	/**
	 *
	 * @return \string
	 */
	public function getVCode() {
		return $this->vCode;
	}

	/**
	 *
	 * @param \string $vCode
	 */
	public function setVCode($vCode) {
		$this->vCode = $vCode;
	}
}
