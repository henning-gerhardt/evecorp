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
	 * Find all updateable eve items
	 *
	 * @param int $timeToCache
	 * @return \TYPO3\CMS\Extbase\Persistence\QueryResultInterface|array
	 */
	public function findAllUpdateableItems($timeToCache) {
		/** @var $defaultQuerySettings \TYPO3\CMS\Extbase\Persistence\Generic\QuerySettingsInterface */
		$defaultQuerySettings = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\QuerySettingsInterface');
		$defaultQuerySettings->setRespectStoragePage(FALSE);
		$this->setDefaultQuerySettings($defaultQuerySettings);

		if (($timeToCache == null) || ($timeToCache < 1)) {
			$timeToCache = 1;
		}
		$cacheTime = time() - (60 * $timeToCache);

		/** @var $query \TYPO3\CMS\Extbase\Persistence\QueryInterface */
		$query = $this->createQuery();
		$query->matching($query->lessThan('cache_time', $cacheTime));
		return $query->execute();
	}

	/**
	 * Get array of unique used system ids
	 * 
	 * @return array
	 */
	public function getListOfUniqueSystemId() {

		/** @var $query \TYPO3\CMS\Extbase\Persistence\QueryInterface */
		$query = $this->createQuery();
		$query->getQuerySettings()->setReturnRawQueryResult(true);

		/** todo replace if possible with matching query */
		$statement = 'SELECT DISTINCT `system_id` FROM `tx_evecorp_domain_model_eveitem` ';
		$statement .= ' WHERE (`deleted` = 0) AND (`hidden` = 0) ';
		$rowData = $query->statement($statement)->execute();

		// own data mapping
		$result = array();
		foreach($rowData as $rows) {
			foreach($rows as $columnValue) {
				$result[] = $columnValue;
			}
		}

		return $result;
	}

	/**
	 * Search for all out of date EVE items for a given system
	 * 
	 * @param \integer $systemId
	 * @return \TYPO3\CMS\Extbase\Persistence\QueryResultInterface|array
	 */
	public function findAllUpdateableItemsForSystem($systemId) {

		if ($systemId == null || $systemId == 0) {
			return new \TYPO3\CMS\Extbase\Persistence\Generic\QueryResult();
		}

		/** @var $query \TYPO3\CMS\Extbase\Persistence\QueryInterface */
		$query = $this->createQuery();

		/** @todo replace if possible with matching query */
		$statement = 'SELECT * FROM `tx_evecorp_domain_model_eveitem` ';
		$statement .= ' WHERE `cache_time` < (UNIX_TIMESTAMP() - (`time_to_cache` * 60)) ';
		$statement .= ' AND (`system_id` = ?) ';
		$statement .= ' AND (`deleted` = 0) AND (`hidden` = 0) ';

		$query->statement($statement, array((int)$systemId));

		/** @var $result \TYPO3\CMS\Extbase\Persistence\Generic\QueryResult */
		$result = $query->execute();

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
		/** @var $query \TYPO3\CMS\Extbase\Persistence\QueryInterface */
		$query = $this->createQuery();

		$query->matching($query->logicalAnd(
			$query->equals('EveId', $eveId),
			$query->equals('SystemId', $systemId)
		));

		// using or ignoring of storage page must be set after matching query
		$query->getQuerySettings()->setRespectStoragePage($respectStoragePage);

		/** @var $result \TYPO3\CMS\Extbase\Persistence\Generic\QueryResult */
		$result = $query->execute();
		return $result;
	}
	
}
