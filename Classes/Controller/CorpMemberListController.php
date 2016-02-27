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
	 * @var \Gerh\Evecorp\Domain\Repository\CorporationRepository
	 * @inject
	 */
	protected $corporationRepository;

	/**
	 * Show corporation member list
	 *
	 * @return void
	 */
	public function indexAction() {
		$hasCorpMemberListAccess = \FALSE;

		$choosedCorporation = (\strlen($this->settings['corporation']) > 0) ?
				\TYPO3\CMS\Core\Utility\GeneralUtility::intExplode(',', $this->settings['corporation']) : array();
		if (\count($choosedCorporation) == 1) {
			$corpMembers = $this->characterRepository->findAllCharactersSortedByCharacterName($choosedCorporation);
			$corporation = $this->corporationRepository->findByUid($choosedCorporation);
			if ($corporation instanceof \Gerh\Evecorp\Domain\Model\Corporation) {
				$hasCorpMemberListAccess = $corporation->hasAccessTo(\Gerh\Evecorp\Domain\Constants\AccessMask\Corporation::MEMBERTRACKINGLIMITED);
			}
		} else {
			$corpMembers = array();
		}

		$this->view->assign('corpMembers', $corpMembers);
		$this->view->assign('hasCorpMemberListAccess', $hasCorpMemberListAccess);
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

	/**
	 * Update corporation member list
	 */
	public function updateAction() {
		$choosedCorporation = (\strlen($this->settings['corporation']) > 0) ?
				\TYPO3\CMS\Core\Utility\GeneralUtility::intExplode(',', $this->settings['corporation']) : array();
		if (\count($choosedCorporation) != 1) {
			$this->addFlashMessage('No or to many corporations selected!', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
			$this->redirect('index');
		}
		$hasCorpMemberListAccess = \FALSE;
		$corporation = $this->corporationRepository->findByUid($choosedCorporation);
		if ($corporation instanceof \Gerh\Evecorp\Domain\Model\Corporation) {
			$hasCorpMemberListAccess = $corporation->hasAccessTo(\Gerh\Evecorp\Domain\Constants\AccessMask\Corporation::MEMBERTRACKINGLIMITED);
		}

		if (! $hasCorpMemberListAccess) {
			$this->addFlashMessage('No access to corporation member list!',	'',	\TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
			$this->redirect('index');
		}

		$corporationApiKey = $corporation->findFirstApiKeyByAccessMask(\Gerh\Evecorp\Domain\Constants\AccessMask\Corporation::MEMBERTRACKINGLIMITED);
		if (! $corporationApiKey instanceof \Gerh\Evecorp\Domain\Model\ApiKeyCorporation) {
			$this->addFlashMessage('No corporation API key found for accessing corporation member list!', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
			$this->redirect('index');
		}

		$corpMemberListUpdater = new \Gerh\Evecorp\Domain\Mapper\CorporationMemberList();
		$corpMemberListUpdater->setCorporationApiKey($corporationApiKey);
		$corpMemberListUpdater->setCorporation($corporation);
		$result = $corpMemberListUpdater->updateCorpMemberList();

		if ($result) {
			$this->addFlashMessage('Corporation member list updated successfully.');
		} else {
			$this->addFlashMessage('Error while updating corporation member list! Reason: ' . $corpMemberListUpdater->getErrorMessage(), '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
		}

		$this->redirect('index');

	}

}
