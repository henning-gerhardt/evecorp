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

use TYPO3\CMS\Extbase\Persistence\Repository;

/**
 * Description of BaseRepository
 *
 * @author Henning Gerhardt
 */
class BaseRepository extends Repository
{

    /**
     * Returns used storage pids for this repository.
     *
     * @return array
     */
    public function getRepositoryStoragePid()
    {
        return $this->createQuery()->getQuerySettings()->getStoragePageIds();
    }

    /**
     * Set storage pid of this repository
     *
     * @param \int $storagePid
     */
    public function setRepositoryStoragePid($storagePid = 0)
    {
        $querySettings = $this->createQuery()->getQuerySettings();
        $querySettings->setStoragePageIds([$storagePid]);
        $querySettings->setRespectStoragePage(\TRUE);
        $this->setDefaultQuerySettings($querySettings);
    }
}
