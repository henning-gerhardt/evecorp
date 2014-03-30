<?php
namespace gerh\Evecorp\Domain\Repository;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 - 2014 Henning Gerhardt
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 *
 *
 * @package evecorp
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class EveitemRepository extends \TYPO3\CMS\Extbase\Persistence\Repository {

	/**
	 * Check is given column name 'region_id' or 'system_id'
	 *
	 * @param \string $columnName
	 * @return boolean
	 */
	protected function isCorrectColumn($columnName) {

		if (($columnName === 'region_id') || ($columnName === 'system_id')) {
			$result = true;
		} else {
			$result = false;
		}

		return $result;
	}

	/**
	 * Return a list of unique ids for a specific column
	 *
	 * @param \string $searchColumn Must be 'region_id' or 'system_id'
	 * @return array
	 */
	protected function getListOfUniqueColumn($searchColumn) {
		$result = array();

		if (! $this->isCorrectColumn($searchColumn)) {
			return $result;
		}

		/** @var $query \TYPO3\CMS\Extbase\Persistence\QueryInterface */
		$query = $this->createQuery();
		$query->getQuerySettings()->setReturnRawQueryResult(true);

		/** todo replace if possible with matching query */
		$statement = 'SELECT DISTINCT `' . $searchColumn . '` FROM `tx_evecorp_domain_model_eveitem` ';
		$statement .= ' WHERE (`' . $searchColumn . '` > 0) AND (`deleted` = 0) AND (`hidden` = 0) ';
		$rowData = $query->statement($statement)->execute();

		// own data mapping
		foreach($rowData as $rows) {
			foreach($rows as $columnValue) {
				$result[] = $columnValue;
			}
		}

		return $result;
	}

	/**
	 * Search for all out of date EVE items for a given region or system
	 *
	 * @param \integer $searchId
	 * @param \string  $searchColumn Must be 'region_id' or 'system_id'
	 * @return \TYPO3\CMS\Extbase\Persistence\QueryResultInterface|array
	 */
	protected function findAllUpdateableItemsForColumn($searchId, $searchColumn) {

		if ($searchId == null || $searchId == 0) {
			return new \TYPO3\CMS\Extbase\Persistence\Generic\QueryResult();
		}

		if (! $this->isCorrectColumn($searchColumn)) {
			return new \TYPO3\CMS\Extbase\Persistence\Generic\QueryResult();
		}

		/** @var $query \TYPO3\CMS\Extbase\Persistence\QueryInterface */
		$query = $this->createQuery();

		/** @todo replace if possible with matching query */
		$statement = 'SELECT * FROM `tx_evecorp_domain_model_eveitem` ';
		$statement .= ' WHERE `cache_time` < (UNIX_TIMESTAMP() - (`time_to_cache` * 60)) ';
		$statement .= ' AND (`' . $searchColumn . '` = ?) ';
		$statement .= ' AND (`deleted` = 0) AND (`hidden` = 0) ';

		$query->statement($statement, array((int)$searchId));

		/** @var $result \TYPO3\CMS\Extbase\Persistence\Generic\QueryResult */
		$result = $query->execute();

		return $result;
	}

	/**
	 * Search for a specific EVE item
	 *
	 * @param \integer $eveId
	 * @param \integer $searchId
	 * @param \string  $searchColumn Must be 'region_id' or 'system_id'
	 * @param \boolean $respectStoragePage
	 * @return \TYPO3\CMS\Extbase\Persistence\QueryResultInterface|array
	 */
	public function findByEveIdAndColumn($eveId, $searchId, $searchColumn, $respectStoragePage = false) {

		if (! $this->isCorrectColumn($searchColumn)) {
			return new \TYPO3\CMS\Extbase\Persistence\Generic\QueryResult();
		}

		/** @var $query \TYPO3\CMS\Extbase\Persistence\QueryInterface */
		$query = $this->createQuery();

		$contraints = array();
		$contraints[] = $query->equals('EveId', $eveId);

		if ($searchColumn == 'region_id') {
			$contrains[] = $query->equals('RegionId', $searchId);
		} else {
			$contrains[] = $query->equals('SystemId', $searchId);
		}

		$query->matching($query->logicalAnd($contraints));

		// using or ignoring of storage page must be set after matching query
		$query->getQuerySettings()->setRespectStoragePage($respectStoragePage);

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

		$result = $this->getListOfUniqueColumn('region_id');

		return $result;
	}

	/**
	 * Get array of unique used system ids
	 *
	 * @return array
	 */
	public function getListOfUniqueSystemId() {

		$result = $this->getListOfUniqueColumn('system_id');

		return $result;
	}

	/**
	 * Search for all out of date EVE items for a given region
	 *
	 * @param \integer $regionId
	 * @return \TYPO3\CMS\Extbase\Persistence\QueryResultInterface|array
	 */
	public function findAllUpdateableItemsForRegion($regionId) {

		$result = $this->findAllUpdateableItemsForColumn($regionId, 'region_id');

		return $result;
	}

	/**
	 * Search for all out of date EVE items for a given system
	 *
	 * @param \integer $systemId
	 * @return \TYPO3\CMS\Extbase\Persistence\QueryResultInterface|array
	 */
	public function findAllUpdateableItemsForSystem($systemId) {

		$result = $this->findAllUpdateableItemsForColumn($systemId, 'system_id');

		return $result;
	}

	/**
	 * Search for a specific EVE item and region
	 *
	 * @param \integer $eveId
	 * @param \integer $regionId
	 * @param \boolean $respectStoragePage
	 * @return \TYPO3\CMS\Extbase\Persistence\QueryResultInterface|array
	 */
	public function findByEveIdAndRegionId($eveId, $regionId, $respectStoragePage = false) {

		$result = $this->findByEveIdAndColumn($eveId, $regionId, 'region_id', $respectStoragePage);

		return $result;
	}

	/**
	 * Search for a specific EVE item and system
	 *
	 * @param \integer $eveId
	 * @param \integer $systemId
	 * @param \boolean $respectStoragePage
	 * @return \TYPO3\CMS\Extbase\Persistence\QueryResultInterface|array
	 */
	public function findByEveIdAndSystemId($eveId, $systemId, $respectStoragePage = false) {

		$result = $this->findByEveIdAndColumn($eveId, $systemId, 'system_id', $respectStoragePage);

		return $result;
	}

}
