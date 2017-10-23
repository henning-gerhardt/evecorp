<?php
/*
 * Copyright notice
 *
 * (c) 2017 Henning Gerhardt
 *
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 3
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */
namespace Gerh\Evecorp\Domain\Model\Internal;

/**
 * Description of Character
 *
 * @author Henning Gerhardt
 */
class Character
{

    protected $characterId;
    protected $characterName;
    protected $corporationId;
    protected $corporationName;
    protected $allianceId;
    protected $allianceName;
    protected $factionId;
    protected $factionName;

    public function getCharacterId()
    {
        return $this->characterId;
    }

    public function getCharacterName()
    {
        return $this->characterName;
    }

    public function getCorporationId()
    {
        return $this->corporationId;
    }

    public function getCorporationName()
    {
        return $this->corporationName;
    }

    public function getAllianceId()
    {
        return $this->allianceId;
    }

    public function getAllianceName()
    {
        return $this->allianceName;
    }

    public function getFactionId()
    {
        return $this->factionId;
    }

    public function getFactionName()
    {
        return $this->factionName;
    }

    public function setCharacterId($characterId)
    {
        $this->characterId = $characterId;
    }

    public function setCharacterName($characterName)
    {
        $this->characterName = $characterName;
    }

    public function setCorporationId($corporationId)
    {
        $this->corporationId = $corporationId;
    }

    public function setCorporationName($corporationName)
    {
        $this->corporationName = $corporationName;
    }

    public function setAllianceId($allianceId)
    {
        $this->allianceId = $allianceId;
    }

    public function setAllianceName($allianceName)
    {
        $this->allianceName = $allianceName;
    }

    public function setFactionId($factionId)
    {
        $this->factionId = $factionId;
    }

    public function setFactionName($factionName)
    {
        $this->factionName = $factionName;
    }
}
