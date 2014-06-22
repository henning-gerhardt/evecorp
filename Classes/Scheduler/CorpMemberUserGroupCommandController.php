<?php
namespace Gerh\Evecorp\Scheduler;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014 Henning Gerhardt
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
class CorpMemberUserGroupCommandController extends \TYPO3\CMS\Extbase\Mvc\Controller\CommandController {

	/**
	 * @var \Gerh\Evecorp\Domain\Repository\CorpMemberRepository
	 * @inject
	 */
	protected $corpMemberRepository;

	/**
	 * @var \TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager
	 * @inject
	 */
	protected $persistenceManager;

	/**
	 * Update usergroup membership of corp member
	 *
	 * @param \integer $storagePid PID of stored corp member (mostly fe user pid)
	 * @return bool
	 */
	public function corpMemberUserGroupCommand($storagePid = 0) {

		$querySettings = $this->corpMemberRepository->createQuery()->getQuerySettings();
		$querySettings->setStoragePageIds(array($storagePid));
		$this->corpMemberRepository->setDefaultQuerySettings($querySettings);
		$corpMemberUtility = new \Gerh\Evecorp\Domain\Utility\CorpMemberUtility();
		foreach($this->corpMemberRepository->findAll() as $corpMember) {
			$corpMemberUtility->adjustFrontendUserGroups($corpMember);
		}
		$this->persistenceManager->persistAll();
		return TRUE;
	}

}
