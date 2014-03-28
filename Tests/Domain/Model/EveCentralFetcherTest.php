<?php
namespace gerh\Evecorp\Test\Domain\Model;

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
 * Testcase for EveCentralFetcher
 */
class EveCentralFetcherTest extends \TYPO3\CMS\Core\Tests\UnitTestCase {

	/**
	 * @test
	 */
	public function baseUriCouldBeSet() {
		$baseUri = 'http://api.eve-central.com/api/marketstat';
		$fetcher = new \gerh\Evecorp\Domain\Model\EveCentralFetcher();
		$fetcher->setBaseUri($baseUri);
		$this->assertEquals($baseUri, $fetcher->getBaseUri());
	}

	/**
	 * @test
	 */
	public function systemIdCouldBeSet() {
		$systemId = 30000142;
		$fetcher = new \gerh\Evecorp\Domain\Model\EveCentralFetcher();
		$fetcher->setSystemId($systemId);
		$this->assertEquals($systemId, $fetcher->getSystemId());
	}

	/**
	 * @test
	 */
	public function typeIdsCouldBeSet() {
		$typeIds = array(34 => 'Tritanium', 35 => 'Pyrite');
		$fetcher = new \gerh\Evecorp\Domain\Model\EveCentralFetcher();
		$fetcher->setTypeIds($typeIds);
		$this->assertEquals($typeIds, $fetcher->getTypeIds());
	}

}
