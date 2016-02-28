<?php

/* * *************************************************************
 *  Copyright notice
 *
 *  (c) 2016 Henning Gerhardt
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
 * ************************************************************* */

namespace Gerh\Evecorp\Domain\Repository;

/**
 *
 *
 * @package evecorp
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class EmploymentHistoryRepository extends \Gerh\Evecorp\Domain\Repository\BaseRepository {

	/**
	 *
	 * @param \Gerh\Evecorp\Domain\Model\Character $character
	 * @param \Gerh\Evecorp\Domain\Model\Corporation $corporation
	 * @param \Gerh\Evecorp\Domain\Model\DateTime $startDate
	 * @return null | \Gerh\Evecorp\Domain\Model\EmploymentHistory
	 */
	public function searchForEmployment(\Gerh\Evecorp\Domain\Model\Character $character, \Gerh\Evecorp\Domain\Model\Corporation $corporation, \Gerh\Evecorp\Domain\Model\DateTime $startDate) {
		$query = $this->createQuery();

		$constraints = array();
		$constraints[] = $query->equals('characterUid', $character);
		$constraints[] = $query->equals('corporationUid', $corporation);
		$constraints[] = $query->equals('startDate', $startDate);
		$query->matching($query->logicalAnd($constraints))->setLimit(1);
		$searchResult = $query->execute();

		if ($searchResult->count() <> 1) {
			return NULL;
		} else {
			return $searchResult->getFirst();
		}
	}

}
