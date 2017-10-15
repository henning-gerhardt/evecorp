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

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\QueryBuilder;

/**
 *
 *
 * @package evecorp
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class EveitemRepository extends BaseRepository {

    /**
     * @var string
     */
    private $tableName = 'tx_evecorp_domain_model_eveitem';

    /**
     * Check is given column name 'region' or 'solar_system'
     *
     * @param \string $columnName
     * @return boolean
     */
    protected function isCorrectColumn($columnName) {

        $result = \FALSE;
        if (($columnName === 'region') || ($columnName === 'solar_system')) {
            $result = \TRUE;
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

        if (!$this->isCorrectColumn($searchColumn)) {
            return [];
        }

        /* @var $queryBuilder QueryBuilder */
        $queryBuilder = $this->objectManager->get(ConnectionPool::class)->getQueryBuilderForTable($this->tableName);
        $queryBuilder
            ->select($searchColumn)
            ->from($this->tableName)
            ->where($queryBuilder->expr()->gt($searchColumn, 0))
            ->groupBy($searchColumn);

        // own data mapping
        $result = [];
        foreach ($queryBuilder->execute()->fetchAll() as $rows) {
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
     * @return array
     */
    protected function findAllUpdateableItemsForColumn($searchId, $searchColumn) {

        if ($searchId == \NULL || $searchId == 0) {
            return [];
        }

        if (!$this->isCorrectColumn($searchColumn)) {
            return [];
        }

        /* @var $queryBuilder QueryBuilder */
        $queryBuilder = $this->objectManager->get(ConnectionPool::class)->getQueryBuilderForTable($this->tableName);
        $queryBuilder
            ->select('eve_id')
            ->from($this->tableName)
            ->where($queryBuilder->expr()->lt('cache_time', '(UNIX_TIMESTAMP() - (`time_to_cache` * 60))'))
            ->andWhere($queryBuilder->expr()->eq($searchColumn, $searchId))
            ->groupBy('eve_id');

        $result = $queryBuilder->execute()->fetchAll(\PDO::FETCH_COLUMN);
        return $result;
    }

    /**
     * Search for a specific EVE item
     *
     * @param \integer $eveId
     * @param \integer $searchId
     * @param \string  $searchColumn Must be 'region' or 'system'
     * @return array
     */
    public function findByEveIdAndColumn($eveId, $searchId, $searchColumn) {

        if (!$this->isCorrectColumn($searchColumn)) {
            return [];
        }

        /* @var $queryBuilder QueryBuilder */
        $queryBuilder = $this->objectManager->get(ConnectionPool::class)->getQueryBuilderForTable($this->tableName);
        $queryBuilder
            ->select('uid')
            ->from($this->tableName)
            ->where($queryBuilder->expr()->eq('eve_id', $eveId))
            ->andWhere($queryBuilder->expr()->eq($searchColumn, $searchId));

        $result = [];
        foreach ($queryBuilder->execute()->fetchAll(\PDO::FETCH_COLUMN) as $rowUid) {
            // load hit as model object
            $result[] = $this->findByUid($rowUid);
        }

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
     * @return array
     */
    public function findAllUpdateableItemsForRegion($regionId) {

        $result = $this->findAllUpdateableItemsForColumn($regionId, 'region');

        return $result;
    }

    /**
     * Search for all out of date EVE items for a given system
     *
     * @param \integer $systemId
     * @return array
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
     * @return array
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
     * @return array
     */
    public function findByEveIdAndSystemId($eveId, $systemId) {

        $result = $this->findByEveIdAndColumn($eveId, $systemId, 'solar_system');

        return $result;
    }

}
