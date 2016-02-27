<?php
namespace Gerh\Evecorp\Controller;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2015 Henning Gerhardt
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
class CorpMemberListController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	/**
	 * @var \Gerh\Evecorp\Domain\Repository\CharacterRepository
	 * @inject
	 */
	protected $characterRepository;

	/**
	 * Show corporation member list
	 *
	 * @return void
	 */
	public function indexAction() {
		$choosedCorporation = (\strlen($this->settings['corporation']) > 0) ?
				\TYPO3\CMS\Core\Utility\GeneralUtility::intExplode(',', $this->settings['corporation']) : array();
		if (\count($choosedCorporation) == 1) {
			$corpMembers = $this->characterRepository->findAllCharactersSortedByCharacterName($choosedCorporation);
		} else {
			$corpMembers = array();
		}
		$this->view->assign('corpMembers', $corpMembers);
	}

	/**
	 * Show corporation member list (light)
	 *
	 * @return void
	 */
	public function showLightAction() {
		$choosedCorporations = (\strlen($this->settings['corporation']) > 0) ?
				\TYPO3\CMS\Core\Utility\GeneralUtility::intExplode(',', $this->settings['corporation']) : array();
		$corpMembers = $this->characterRepository->findAllCharactersSortedByCharacterName($choosedCorporations);
		$this->view->assign('corpMembers', $corpMembers);
	}

}
