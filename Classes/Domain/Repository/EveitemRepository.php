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

namespace Gerh\Evecorp\Domain\Repository;

/**
 *
 *
 * @package evecorp
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class EveitemRepository extends \Gerh\Evecorp\Domain\Repository\BaseRepository {

    /**
     * Check is given column name 'region' or 'solar_system'
     *
     * @param \string $columnName
     * @return boolean
     */
    protected function isCorrectColumn($columnName) {

        $result = false;
        if (($columnName === 'region') || ($columnName === 'solar_system')) {
            $result = true;
        }

        return $result;
    }

    /**
     * Return a list of unique ids for a specific column
     *
     * @param \string $searchColumn Must be 'region' or 'solar_system'
     * @return array
     */
    protected function getListOfUniqueColumn($searchColumn) {
        $result = [];
        $returnRawQueryResult = true;

        if (!$this->isCorrectColumn($searchColumn)) {
            return $result;
        }

        /** @var $query \TYPO3\CMS\Extbase\Persistence\QueryInterface */
        $query = $this->createQuery();

        /** todo replace if possible with matching query */
        $statement = 'SELECT DISTINCT `' . $searchColumn . '` FROM `tx_evecorp_domain_model_eveitem` ';
        $statement .= ' WHERE (`' . $searchColumn . '` > 0) AND (`deleted` = 0) AND (`hidden` = 0) ';

        $rowData = $query->statement($statement)->execute($returnRawQueryResult);

        // own data mapping
        foreach ($rowData as $rows) {
            foreach ($rows as $columnValue) {
                $result[] = $columnValue;
            }
        }

        return $result;
    }

    /**
     * Search for all out of date EVE items for a given region or system
     *
     * @param \integer $searchId
     * @param \string  $searchColumn Must be 'region' or 'solar_system'
     * @return \TYPO3\CMS\Extbase\Persistence\QueryResultInterface|array
     */
    protected function findAllUpdateableItemsForColumn($searchId, $searchColumn) {

        if ($searchId == null || $searchId == 0) {
            return new \TYPO3\CMS\Extbase\Persistence\Generic\QueryResult();
        }

        if (!$this->isCorrectColumn($searchColumn)) {
            return new \TYPO3\CMS\Extbase\Persistence\Generic\QueryResult();
        }

        /** @var $query \TYPO3\CMS\Extbase\Persistence\QueryInterface */
        $query = $this->createQuery();

        /** @todo replace if possible with matching query */
        $queryStatement = 'SELECT * FROM `tx_evecorp_domain_model_eveitem` ';
        $queryStatement .= ' WHERE `cache_time` < (UNIX_TIMESTAMP() - (`time_to_cache` * 60)) ';
        $queryStatement .= ' AND (`' . $searchColumn . '` = :searchId) ';
        $queryStatement .= ' AND (`deleted` = 0) AND (`hidden` = 0) ';

        $statement = new \TYPO3\CMS\Core\Database\PreparedStatement($queryStatement, 'tx_evecorp_domain_model_eveitem');
        $statement->bindValues([':searchId' => (int) $searchId]);
        $query->statement($statement);

        /** @var $result \TYPO3\CMS\Extbase\Persistence\Generic\QueryResult */
        $result = $query->execute();

        return $result;
    }

    /**
     * Search for a specific EVE item
     *
     * @param \integer $eveId
     * @param \integer $searchId
     * @param \string  $searchColumn Must be 'region' or 'system'
     * @return \TYPO3\CMS\Extbase\Persistence\QueryResultInterface|array
     */
    public function findByEveIdAndColumn($eveId, $searchId, $searchColumn) {

        if (!$this->isCorrectColumn($searchColumn)) {
            return new \TYPO3\CMS\Extbase\Persistence\Generic\QueryResult();
        }

        /** @var $query \TYPO3\CMS\Extbase\Persistence\QueryInterface */
        $query = $this->createQuery();

        /** @todo replace if possible with matching query */
        $queryStatement = 'SELECT * FROM `tx_evecorp_domain_model_eveitem` ';
        $queryStatement .= ' WHERE (`eve_id` = :eveId) ';
        $queryStatement .= ' AND (`' . $searchColumn . '` = :searchId) ';
        $queryStatement .= ' AND (`deleted` = 0) AND (`hidden` = 0) ';

        $statement = new \TYPO3\CMS\Core\Database\PreparedStatement($queryStatement, 'tx_evecorp_domain_model_eveitem');
        $statement->bindValues([':eveId' => (int) $eveId, ':searchId' => (int) $searchId]);
        $query->statement($statement);

        /** @var $result \TYPO3\CMS\Extbase\Persistence\Generic\QueryResult */
        $result = $query->execute();
        return $result;
    }

    /**
     * Get array of unique used region ids
     *
     * @return array
     */
    public function getListOfUniqueRegionId() {

        $result = $this->getListOfUniqueColumn('region');

        return $result;
    }

    /**
     * Get array of unique used system ids
     *
     * @return array
     */
    public function getListOfUniqueSystemId() {

        $result = $this->getListOfUniqueColumn('solar_system');

        return $result;
    }

    /**
     * Search for all out of date EVE items for a given region
     *
     * @param \integer $regionId
     * @return \TYPO3\CMS\Extbase\Persistence\QueryResultInterface|array
     */
    public function findAllUpdateableItemsForRegion($regionId) {

        $result = $this->findAllUpdateableItemsForColumn($regionId, 'region');

        return $result;
    }

    /**
     * Search for all out of date EVE items for a given system
     *
     * @param \integer $systemId
     * @return \TYPO3\CMS\Extbase\Persistence\QueryResultInterface|array
     */
    public function findAllUpdateableItemsForSystem($systemId) {

        $result = $this->findAllUpdateableItemsForColumn($systemId, 'solar_system');

        return $result;
    }

    /**
     * Search for a specific EVE item and region
     *
     * @param \integer $eveId
     * @param \integer $regionId
     * @return \TYPO3\CMS\Extbase\Persistence\QueryResultInterface|array
     */
    public function findByEveIdAndRegionId($eveId, $regionId) {

        $result = $this->findByEveIdAndColumn($eveId, $regionId, 'region');

        return $result;
    }

    /**
     * Search for a specific EVE item and system
     *
     * @param \integer $eveId
     * @param \integer $systemId
     * @return \TYPO3\CMS\Extbase\Persistence\QueryResultInterface|array
     */
    public function findByEveIdAndSystemId($eveId, $systemId) {

        $result = $this->findByEveIdAndColumn($eveId, $systemId, 'solar_system');

        return $result;
    }

}
