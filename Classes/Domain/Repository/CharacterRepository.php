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

use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;

/**
 *
 *
 * @package evecorp
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class CharacterRepository extends BaseRepository
{

    /**
     * Find all characters sorted by character name.
     * Could be restricted to choosed corporations.
     *
     * @param array $corporations (Optional) corporations
     * @return QueryResultInterface|array
     */
    public function findAllCharactersSortedByCharacterName(array $corporations)
    {
        $orderings = [
            'characterName' => QueryInterface::ORDER_ASCENDING
        ];

        $query = $this->createQuery();
        $query->setOrderings($orderings);

        if (!empty($corporations)) {
            $query->matching($query->in('currentCorporation', $corporations));
        }

        return $query->execute();
    }
}
