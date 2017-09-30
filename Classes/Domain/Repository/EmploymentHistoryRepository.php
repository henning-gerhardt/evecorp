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

        $constraints = [];
        $constraints[] = $query->equals('characterUid', $character);
        $constraints[] = $query->equals('corporationUid', $corporation);
        $constraints[] = $query->equals('startDate', $startDate);
        $query->matching($query->logicalAnd($constraints))->setLimit(1);
        $searchResult = $query->execute();

        if ($searchResult->count() == 1) {
            return $searchResult->getFirst();
        }
        return \NULL;
    }

}
