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
namespace Gerh\Evecorp\Domain\Mapper;

use Gerh\Evecorp\Domain\Model\Internal\ApiKeyInfo;
use Gerh\Evecorp\Domain\Model\Internal\Character;
use Gerh\Evecorp\Service\PhealService;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Description of ApiKeyInfoMapper
 *
 * @author Henning Gerhardt
 */
class ApiKeyInfoMapper
{

    /**
     * @var int
     */
    protected $keyId;

    /**
     * @var string
     */
    protected $vCode;

    /**
     *
     * @param \Pheal\Core\Element $resultElement
     * @return ApiKeyInfo
     */
    protected function mapRetrievedInformation(\Pheal\Core\Element $resultElement)
    {
        $result = new ApiKeyInfo();
        $result->setAccessMask($resultElement->accessMask);
        $result->setExpires($resultElement->expires);
        $result->setType($resultElement->type);

        foreach ($resultElement->characters as $char) {
            $character = new Character();
            $character->setCharacterId($char->characterID);
            $character->setCharacterName($char->characterName);
            $character->setCorporationId($char->corporationID);
            $character->setCorporationName($char->corporationName);
            $character->setAllianceId($char->allianceId);
            $character->setAllianceName($char->allianceName);
            $character->setFactionId($char->factionID);
            $character->setFactionName($char->factionName);

            $result->addCharacter($character);
        }

        return $result;
    }

    /**
     *
     * @param int $keyId
     */
    public function setKeyId($keyId)
    {
        $this->keyId = $keyId;
    }

    /**
     *
     * @param string $vCode
     */
    public function setVcode($vCode)
    {
        $this->vCode = $vCode;
    }

    /**
     *
     * @return ApiKeyInfo
     */
    public function retrieveApiKeyInfo()
    {

        try {
            $phealService = GeneralUtility::makeInstance(PhealService::class, $this->keyId, $this->vCode);
            $pheal = $phealService->getPhealInstance();
            // using account scope as no coporation api key info is available
            $response = $pheal->accountScope->APIKeyInfo();
            return $this->mapRetrievedInformation($response->key);
        } catch (\Pheal\Exceptions\PhealException $ex) {
            return new ApiKeyInfo();
        }
    }
}
