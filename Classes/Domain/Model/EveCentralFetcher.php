<?php
namespace gerh\Evecorp\Domain\Model;

/***************************************************************
 *	Copyright notice
 *
 *	(c) 2014 Henning Gerhardt 
 *	
 *	All rights reserved
 *
 *	This script is part of the TYPO3 project. The TYPO3 project is
 *	free software; you can redistribute it and/or modify
 *	it under the terms of the GNU General Public License as published by
 *	the Free Software Foundation; either version 3 of the License, or
 *	(at your option) any later version.
 *
 *	The GNU General Public License can be found at
 *	http://www.gnu.org/copyleft/gpl.html.
 *
 *	This script is distributed in the hope that it will be useful,
 *	but WITHOUT ANY WARRANTY; without even the implied warranty of
 *	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *	GNU General Public License for more details.
 *
 *	This copyright notice MUST APPEAR in all copies of the script!
 *
 */

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
	 * @var integer Holds used system / station id on queries 
	 */
	private $systemId = 0;

	/**
	 *
	 * @var array Holds a list of EvE item type ids. 
	 */
	private $typeIds = array();

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
	 * Returns current used system / station id
	 * 
	 * @return integer
	 */
	public function getSystemId() {
		return $this->systemId;
	}

	/**
	 * Set to used system / station id
	 * 
	 * @param integer $systemId
	 */
	public function setSystemId($systemId) {
		$this->systemId = $systemId;
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
		$query = $this->buildQuery();
		$content = file_get_contents($query);
		return $this->parse($content);
	}

	/**
	 * Concat static part of uri with system / station id and type ids to a HTTP query
	 * @return string
	 */
	protected function buildQuery() {
		$result = $this->baseUri . '?usesystem=' . $this->systemId;
		foreach(array_keys($this->typeIds) as $typeId) {
			$result .= '&amp;typeid=' . $typeId;
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
		$result = array();

		$doc = new \DOMDocument();
		$doc->loadXML($content);
		$xpath = new \DOMXPath($doc);

		$resourceTypes = $xpath->evaluate('.//type');
		for ($i = 0 ; $i < $resourceTypes->length; $i++) {
			$resource = $resourceTypes->item($i);
			$resourceId = $resource->getAttribute('id');
			$resourceBuyMax = $xpath->evaluate('.//buy/max', $resource)->item(0)->textContent;
			$resourceSellMin = $xpath->evaluate('.//sell/min', $resource)->item(0)->textContent;
			$result[$this->typeIds[$resourceId]] = array(
				'buy' => $resourceBuyMax,
				'sell' => $resourceSellMin,
			);
		}

		return $result;
	}
}
