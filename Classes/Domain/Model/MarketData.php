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

use Gerh\Evecorp\Domain\Repository\EveitemRepository;

/**
 *
 *
 * @package evecorp
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class MarketData {

    /**
     * @var \float Holds current used tax rate
     */
    private $corpTax;

    /**
     * eveitemRepository
     *
     * @var EveitemRepository
     * @inject
     */
    protected $eveitemRepository;

    /**
     * Extract database data to an array structure
     *
     * @param Eveitem $entry
     * @return \array
     */
    protected function extractDisplayData(Eveitem $entry) {

        $result = new EveItemDisplay();
        $result->setDisplayName($entry->getEveName());
        $result->setBuyPrice($entry->getBuyPrice());
        $result->setSellPrice($entry->getSellPrice());
        $result->setCorpTax($this->getCorpTax());
        $result->setRegionNameByRegion($entry->getRegion());
        $result->setSolarSystemNameBySolarSystem($entry->getSolarSystem());

        return $result;
    }

    /**
     * Return all market data (up to date).
     *
     * @return array
     */
    public function getMarketData() {
        $result = [];
        foreach ($this->eveitemRepository->findAll() as $dbEntry) {
            if ($dbEntry != \NULL) {
                $result[] = $this->extractDisplayData($dbEntry);
            }
        }

        return $result;
    }

    /**
     * Return current corporation tax rate
     *
     * @return integer
     */
    public function getCorpTax() {
        return $this->corpTax;
    }

    /**
     * Set corporation tax rate
     *
     * @param \float $corpTax
     */
    public function setCorpTax($corpTax) {
        if (($corpTax < 0.0) || ($corpTax > 100.0)) {
            $corpTax = 0;
        }
        $this->corpTax = $corpTax;
    }

}
