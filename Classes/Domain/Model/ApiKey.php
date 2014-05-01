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
	 * @var \integer
	 * @validate Number
	 */
	protected $accessMask;

	/**
	 * @var \TYPO3\CMS\Extbase\Domain\Model\FrontendUser
	 * @lazy
	 */
	protected $corpMember;

	/**
	 * @var \Gerh\Evecorp\Domain\Model\DateTime
	 */
	protected $expires;

	/**
	 * @var \integer
	 * @validate NotEmpty
	 * @validate Number
	 * @validate NumberRange(minimum=1, maximum=2147483647)
	 */
	protected $keyId;

	/**
	 * @var \string
	 */
	protected $type = 'Account';

	/**
	 * @var \string
	 * @validate NotEmpty
	 * @validate StringLength(minimum=64, maximum=64)
	 */
	protected $vCode;

	/**
	 * Returns access mask of API key
	 *
	 * @return \integer
	 */
	public function getAccessMask() {
		return $this->accessMask;
	}

	/**
	 * Set acces mask for API key
	 *
	 * @param \integer $accessMask
	 */
	public function setAccessMask($accessMask) {
		$this->accessMask = \intval($accessMask);
	}

	/**
	 * Returns frontend user for API key
	 *
	 * @return \TYPO3\CMS\Extbase\Domain\Model\FrontendUser
	 */
	public function getCorpMember() {
		if ($this->corpMember instanceof \TYPO3\CMS\Extbase\Persistence\Generic\LazyLoadingProxy) {
			$this->corpMember->_loadRealInstance();
		}

		return $this->corpMember;
	}

	/**
	 * Set frontend user for this API key
	 *
	 * @param \TYPO3\CMS\Extbase\Domain\Model\FrontendUser
	 */
	public function setCorpMember(\TYPO3\CMS\Extbase\Domain\Model\FrontendUser $corpMember) {
		$this->corpMember = $corpMember;
	}

	/**
	 * Returns date of API key expire
	 *
	 * @return \Gerh\Evecorp\Domain\Model\DateTime | NULL if no expire date
	 */
	public function getExpires() {
		return $this->expires;
	}

	/**
	 * Set date when an API key get expired
	 *
	 * @param \Gerh\Evecorp\Domain\Model\DateTime $expires
	 */
	public function setExpires(\Gerh\Evecorp\Domain\Model\DateTime $expires = NULL) {
		$this->expires = $expires;
	}

	/**
	 * Returns key id of this API key
	 *
	 * @return \integer
	 */
	public function getKeyId() {
		return $this->keyId;
	}

	/**
	 * Set key id for this API key
	 *
	 * @param \integer $keyId
	 */
	public function setKeyId($keyId) {
		$this->keyId = \intval($keyId);
	}

	/**
	 * Returns type of API key
	 *
	 * @return \string
	 */
	public function getType() {
		return $this->type;
	}

	/**
	 * Set type for this API key. Could be f.e. Account, Character or Corporation.
	 * Default value is Account
	 *
	 * @param \string $type
	 */
	public function setType($type = 'Account') {
		$this->type = $type;
	}

	/**
	 * Returns verification code (vCode) of API key
	 *
	 * @return \string
	 */
	public function getVCode() {
		return $this->vCode;
	}

	/**
	 * Set verification code (vCode) for this API key
	 *
	 * @param \string $vCode
	 */
	public function setVCode($vCode) {
		$this->vCode = $vCode;
	}

}
