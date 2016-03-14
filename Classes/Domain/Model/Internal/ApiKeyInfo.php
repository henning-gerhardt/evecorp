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

namespace Gerh\Evecorp\Domain\Model\Internal;

/**
 *
 *
 * @package evecorp
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class ApiKeyInfo {

	/**
	 * @var string
	 */
	protected $accessMask;

	/**
	 *
	 * @var array
	 */
	protected $characters = array();

	/**
	 * @var string
	 */
	protected $expires;

	/**
	 * @var string
	 */
	protected $type;

	/**
	 *
	 * @return string
	 */
	public function getAccessMask() {
		return $this->accessMask;
	}

	/**
	 * Add a character
	 *
	 * @param \Gerh\Evecorp\Domain\Model\Internal\Character $character
	 */
	public function addCharacter(\Gerh\Evecorp\Domain\Model\Internal\Character $character) {
		$this->characters[] = $character;
	}

	/**
	 *
	 * @return array
	 */
	public function getCharacters() {
		return $this->characters;
	}

	/**
	 *
	 * @return string
	 */
	public function getExpires() {
		return $this->expires;
	}

	/**
	 *
	 * @return string
	 */
	public function getType() {
		return $this->type;
	}

	/**
	 *
	 * @param string $accessMask
	 */
	public function setAccessMask($accessMask) {
		$this->accessMask = $accessMask;
	}

	/**
	 *
	 * @param array $characters
	 */
	public function setCharacters(array $characters) {
		$this->characters = $characters;
	}

	/**
	 *
	 * @param string $expires
	 */
	public function setExpires($expires) {
		$this->expires = $expires;
	}

	/**
	 *
	 * @param string $type
	 */
	public function setType($type) {
		$this->type = $type;
	}

}
