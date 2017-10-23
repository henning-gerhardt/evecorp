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
namespace Gerh\Evecorp\Test\Domain\Model;

use Gerh\Evecorp\Domain\Model\EveCentralFetcher;
use TYPO3\CMS\Core\Tests\UnitTestCase;

/**
 * Testcase for EveCentralFetcher
 */
class EveCentralFetcherTest extends UnitTestCase
{

    /**
     * @test
     */
    public function baseUriCouldBeSet()
    {
        $baseUri = 'http://api.eve-central.com/api/marketstat';
        $fetcher = new EveCentralFetcher();
        $fetcher->setBaseUri($baseUri);
        $this->assertEquals($baseUri, $fetcher->getBaseUri());
    }

    /**
     * @test
     */
    public function regionIdCouldBeSet()
    {
        $regionId = 10000002;
        $fetcher = new EveCentralFetcher();
        $fetcher->setRegionId($regionId);
        $this->assertEquals($regionId, $fetcher->getRegionId());
    }

    /**
     * @test
     */
    public function regionIdCouldNotBeSetBelowZero()
    {
        $regionId = -1;
        $expected = 0;
        $fetcher = new EveCentralFetcher();
        $fetcher->setRegionId($regionId);
        $this->assertEquals($expected, $fetcher->getRegionId());
    }

    /**
     * @test
     */
    public function systemIdCouldBeSet()
    {
        $systemId = 30000142;
        $fetcher = new EveCentralFetcher();
        $fetcher->setSystemId($systemId);
        $this->assertEquals($systemId, $fetcher->getSystemId());
    }

    /**
     * @test
     */
    public function systemIdCouldNotBeSetBelowZero()
    {
        $systemId = -1;
        $expected = 0;
        $fetcher = new EveCentralFetcher();
        $fetcher->setSystemId($systemId);
        $this->assertEquals($expected, $fetcher->getSystemId());
    }

    /**
     * @test
     */
    public function typeIdsCouldBeSet()
    {
        $typeIds = [34, 35];
        $fetcher = new EveCentralFetcher();
        $fetcher->setTypeIds($typeIds);
        $this->assertEquals($typeIds, $fetcher->getTypeIds());
    }

    /**
     * @test
     */
    public function queryReturnsEmptyArrayOnNonConfiguredFetcher()
    {
        $expected = [];
        $fetcher = new EveCentralFetcher();
        $this->assertEquals($expected, $fetcher->query());
    }

    /**
     * @test
     */
    public function regionAndSystemIdCouldNotBeSetAtSameTime()
    {
        $fetcher = new EveCentralFetcher();
        $fetcher->setRegionId(1);
        $fetcher->setSystemId(2);

        $this->assertEquals(0, $fetcher->getRegionId());
        $this->assertEquals(2, $fetcher->getSystemId());
    }

    /**
     * @test
     */
    public function systemAndRegionIdCouldNotBeSetAtSameTime()
    {
        $fetcher = new EveCentralFetcher();
        $fetcher->setSystemId(1);
        $fetcher->setRegionId(2);

        $this->assertEquals(2, $fetcher->getRegionId());
        $this->assertEquals(0, $fetcher->getSystemId());
    }
}
