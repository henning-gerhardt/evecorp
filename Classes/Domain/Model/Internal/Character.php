<?php

/* * *************************************************************
 * Copyright notice
 *
 * (c) 2016 Henning Gerhardt
 *
 * All rights reserved
 *
 * This script is part of the TYPO3 project. The TYPO3 project is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 *
 * This script is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * This copyright notice MUST APPEAR in all copies of the script!
 * ************************************************************* */

namespace Gerh\Evecorp\Domain\Model\Internal;

/**
 * Description of Character
 *
 * @author Henning Gerhardt
 */
class Character {

	protected $characterId;
	protected $characterName;
	protected $corporationId;
	protected $corporationName;
	protected $allianceId;
	protected $allianceName;
	protected $factionId;
	protected $factionName;

	public function getCharacterId() {
		return $this->characterId;
	}

	public function getCharacterName() {
		return $this->characterName;
	}

	public function getCorporationId() {
		return $this->corporationId;
	}

	public function getCorporationName() {
		return $this->corporationName;
	}

	public function getAllianceId() {
		return $this->allianceId;
	}

	public function getAllianceName() {
		return $this->allianceName;
	}

	public function getFactionId() {
		return $this->factionId;
	}

	public function getFactionName() {
		return $this->factionName;
	}

	public function setCharacterId($characterId) {
		$this->characterId = $characterId;
	}

	public function setCharacterName($characterName) {
		$this->characterName = $characterName;
	}

	public function setCorporationId($corporationId) {
		$this->corporationId = $corporationId;
	}

	public function setCorporationName($corporationName) {
		$this->corporationName = $corporationName;
	}

	public function setAllianceId($allianceId) {
		$this->allianceId = $allianceId;
	}

	public function setAllianceName($allianceName) {
		$this->allianceName = $allianceName;
	}

	public function setFactionId($factionId) {
		$this->factionId = $factionId;
	}

	public function setFactionName($factionName) {
		$this->factionName = $factionName;
	}

}
