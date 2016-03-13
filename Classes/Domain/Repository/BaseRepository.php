<?php

/* * *************************************************************
 * Copyright notice
 *
 * (c) 2016 Henning Gerhardt
 *
 * All rights reserved
 *
 * This script is part of the TYPO3 project. The TYPO3 project is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 *
 * This script is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * This copyright notice MUST APPEAR in all copies of the script!
 * ************************************************************* */

namespace Gerh\Evecorp\Domain\Repository;

/**
 * Description of BaseRepository
 *
 * @author Henning Gerhardt
 */
class BaseRepository extends \TYPO3\CMS\Extbase\Persistence\Repository {

	/**
	 * Returns used storage pids for this repository.
	 *
	 * @return array
	 */
	public function getRepositoryStoragePid() {
		return $this->createQuery()->getQuerySettings()->getStoragePageIds();
	}

	/**
	 * Set storage pid of this repository
	 *
	 * @param \int $storagePid
	 */
	public function setRepositoryStoragePid($storagePid = 0) {
		$querySettings = $this->createQuery()->getQuerySettings();
		$querySettings->setStoragePageIds(array($storagePid));
		$querySettings->setRespectStoragePage(TRUE);
		$this->setDefaultQuerySettings($querySettings);
	}

}
