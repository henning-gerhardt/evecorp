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
class CorpMember extends \TYPO3\CMS\Extbase\Domain\Model\FrontendUser {

	/**
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Gerh\Evecorp\Domain\Model\ApiKeyAccount>
	 * @lazy
	 * @cascade remove
	 */
	protected $apiKeys;

	/**
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Gerh\Evecorp\Domain\Model\Character>
	 * @lazy
	 * @cascade remove
	 */
	protected $characters;

	/**
	 * default class constructor
	 *
	 * @param \string $username
	 * @param \string $password
	 */
	public function __construct($username = '', $password = '') {
		parent::__construct($username, $password);
		$this->apiKeys = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->characters = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
	}

	/**
	 * Return all corp members api keys
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Gerh\Evecorp\Domain\Model\ApiKeyAccount>
	 */
	public function getApiKeys() {
		return $this->apiKeys;
	}

	/**
	 * Return all corp member characters
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Gerh\Evecorp\Domain\Model\Character>
	 */
	public function getCharacters() {
		return $this->characters;
	}

}
