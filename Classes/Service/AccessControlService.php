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

namespace Gerh\Evecorp\Service;

/**
 *
 *
 * @package evecorp
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class AccessControlService implements \TYPO3\CMS\Core\SingletonInterface {

	/**
	 * @var \Gerh\Evecorp\Domain\Repository\CorpMemberRepository
	 * @inject
	 */
	protected $corpMemberRepository;

	/**
	 * @var \TYPO3\CMS\Extbase\Domain\Repository\FrontendUserRepository
	 * @inject
	 */
	protected $frontendUserRepository;

	/**
	 * Returns if a user is logged in or not
	 *
	 * @return \boolean
	 */
	public function isLoggedIn() {
		return $GLOBALS['TSFE']->loginUser == TRUE ? TRUE : FALSE;
	}

	/**
	 * Returns frontend user id if logged in
	 *
	 * @return \integer | NULL if not logged in
	 */
	public function getFrontendUserId() {
		if ($this->isLoggedIn()) {
			return intval($GLOBALS['TSFE']->fe_user->user['uid']);
		}

		return NULL;
	}

	/**
	 * Returns frontend user object if logged in
	 *
	 * @return \TYPO3\CMS\Extbase\Domain\Model\FrontendUser | NULL if not logged in
	 */
	public function getFrontendUser() {
		if ($this->isLoggedIn()) {
			return $this->frontendUserRepository->findByUid($this->getFrontendUserId());
		}

		return NULL;
	}

	/**
	 * Return corp member object for logged in frontend user
	 *
	 * @return \Gerh\Evecorp\Domain\Model\CorpMember | NULL
	 */
	public function getCorpMember() {
		if ($this->isLoggedIn()) {
			return $this->corpMemberRepository->findByUid($this->getFrontendUserId());
		}

		return NULL;
	}

}
