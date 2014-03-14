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
	 * Returns all objects of this repository with given storage pid.
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\QueryResultInterface|array
	 */
	public function findAllForStoragePids(array $storagePids) {
		$query = $this->createQuery();
		$query->getQuerySettings()->setStoragePageIds($storagePids);
		return $query->execute();
	}

	/**
	 * Find all updateable eve items
	 * 
	 * @param array $storagePids
	 * @param int $timeToCache
	 * @return \TYPO3\CMS\Extbase\Persistence\QueryResultInterface|array
	 */
	public function findAllUpdateableItems(array $storagePids, $timeToCache) {
		if (($timeToCache == null) || ($timeToCache < 1)) {
			$timeToCache = 1;
		}
		$cacheTime = time() - (60 * $timeToCache);
		$query = $this->createQuery();
		$query->getQuerySettings()->setStoragePageIds($storagePids);
		$query->matching($query->lessThan('cache_time', $cacheTime));
		return $query->execute();
	}

	/**
	 * Find Eve items by Eve name
	 * 
	 * @param array $storagePids
	 * @param string $eveName
	 * @return \TYPO3\CMS\Extbase\Persistence\QueryResultInterface|array
	 */
	public function findByEveName(array $storagePids, $eveName) {
		$query = $this->createQuery();
		$query->getQuerySettings()->setStoragePageIds($storagePids);
		$query->matching($query->equals('eve_name', $eveName));
		return $query->execute();
	}
}
?>