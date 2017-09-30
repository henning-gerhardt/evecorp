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

namespace Gerh\Evecorp\Domain\Model;

/**
 *
 *
 * @package evecorp
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class EveCentralFetcher {

    /**
     * @var string Holds static part of Eve-Central uri
     */
    private $baseUri = null;

    /**
     * @var \integer Holds used region id
     */
    private $regionId = 0;

    /**
     * @var \integer Holds used system id
     */
    private $systemId = 0;

    /**
     *
     * @var array Holds a list of EVE item type ids.
     */
    private $typeIds = [];

    /**
     * Returns current used EvE-Central uri.
     *
     * @return string
     */
    public function getBaseUri() {
        return $this->baseUri;
    }

    /**
     * Set static part of EVE-Central uri
     *
     * @param string $baseUri
     */
    public function setBaseUri($baseUri) {
        $this->baseUri = $baseUri;
    }

    /**
     * Get current used region id
     *
     * @return \integer
     */
    public function getRegionId() {
        return $this->regionId;
    }

    /**
     * Set region id
     *
     * @param \integer $regionId
     */
    public function setRegionId($regionId) {
        $this->regionId = 0;
        if ($regionId > 0) {
            $this->regionId = $regionId;
            // region and solar system id could not be set at the same time
            $this->systemId = 0;
        }
    }

    /**
     * Returns current used system id
     *
     * @return \integer
     */
    public function getSystemId() {
        return $this->systemId;
    }

    /**
     * Set to used system id
     *
     * @param \integer $systemId
     */
    public function setSystemId($systemId) {
        if ($systemId > 0) {
            $this->systemId = $systemId;
            // region and solar system id could not be set at the same time
            $this->regionId = 0;
        } else {
            $this->systemId = 0;
        }
    }

    /**
     * Returns current used EVE type ids
     *
     * @return array
     */
    public function getTypeIds() {
        return $this->typeIds;
    }

    /**
     * Set a list of EVE type ids
     *
     * @param array $typeIds
     */
    public function setTypeIds(array $typeIds) {
        $this->typeIds = $typeIds;
    }

    /**
     * Fetch data based on system id and type ids and returns buy and sell values of types.
     *
     * @return array
     */
    public function query() {
        $result = [];
        $query = $this->buildQuery();
        if (!empty($query)) {
            $content = file_get_contents($query);
            if (!empty($content)) {
                $result = $this->parse($content);
            }
        }

        return $result;
    }

    /**
     * Concat static part of uri with system or region id and type ids to a HTTP query
     *
     * @return string
     */
    protected function buildQuery() {
        $result = $this->baseUri;

        if ($this->getSystemId() > 0) {
            $result .= '?usesystem=' . $this->getSystemId();
        } else if ($this->getRegionId() > 0) {
            $result .= '?regionlimit=' . $this->getRegionId();
        } else {
            return '';
        }

        foreach ($this->typeIds as $typeId) {
            $result .= '&typeid=' . $typeId;
        }

        return $result;
    }

    /**
     * Parse returned HTTP query value
     *
     * @param string $content
     * @return array
     */
    protected function parse($content) {
        $result = [];

        if (empty($content)) {
            return $result;
        }

        $doc = new \DOMDocument();
        $doc->loadXML($content);
        $xpath = new \DOMXPath($doc);

        $resourceTypes = $xpath->evaluate('.//type');
        for ($i = 0; $i < $resourceTypes->length; $i++) {
            $resource = $resourceTypes->item($i);
            $resourceId = $resource->getAttribute('id');
            $resourceBuyMax = $xpath->evaluate('.//buy/max', $resource)->item(0)->textContent;
            $resourceSellMin = $xpath->evaluate('.//sell/min', $resource)->item(0)->textContent;
            $result[$resourceId] = [
                'buy' => $resourceBuyMax,
                'sell' => $resourceSellMin,
            ];
        }

        return $result;
    }

}
