<?php
namespace gerh\Evecorp\Domain\Model;

/***************************************************************
 *	Copyright notice
 *
 *	(c) 2013 Henning Gerhardt 
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

	private $baseUri = null;

	private $corpTax = 1.0;

	private $systemId = 0;

	private $typeIds = array();

	public function getBaseUri() {
		return $this->baseUri;
	}

	public function setBaseUri($baseUri) {
		$this->baseUri = $baseUri;
	}

	public function getCorpTax() {
		return $this->corpTax;
	}

	public function setCorpTax($corpTax) {
		$this->corpTax = $corpTax;
	}

	public function getSystemId() {
		return $this->systemId;
	}

	public function setSystemId($systemId) {
		$this->systemId = $systemId;
	}

	public function addTypeId($typeId) {
		array_push($this->typeIds, $typeId);
	}

	public function getTypeIds() {
		return $this->getTypeIds;
	}

	public function setTypeIds(array $typeIds) {
		$this->typeIds = $typeIds;
	}

	public function query() {
		$query = $this->buildQuery();
		$content = file_get_contents($query);
		return $this->parse($content);
	}

	private function buildQuery() {
		$result = $this->baseUri . '?usesystem=' . $this->systemId;
		foreach(array_keys($this->typeIds) as $typeId) {
			$result .= '&typeid=' . $typeId;
		}
		return $result;
	}

	private function parse($content) {
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
			$interim = array(
				'buy' => $resourceBuyMax,
				'buyCorp' => round($resourceBuyMax * $this->corpTax, 2),
				'sell' => $resourceSellMin,
			);
			$result[$this->typeIds[$resourceId]] = $interim;
		}

		return $result;
	}
}
?>
