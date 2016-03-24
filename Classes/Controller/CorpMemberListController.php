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

namespace Gerh\Evecorp\Controller;

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
	 * @var mixed
	 */
	protected $choosedCorporation;

	/**
	 * @var \Gerh\Evecorp\Domain\Repository\CorporationRepository
	 * @inject
	 */
	protected $corporationRepository;

	/**
	 * @var boolean
	 */
	protected $showApiKeyState;

	/**
	 * @var boolean
	 */
	protected $showCorporationJoinDate;

	/**
	 * @var boolean
	 */
	protected $showCurrentCorporation;

	/**
	 * @var boolean
	 */
	protected $showLoginUser;

	/**
	 *
	 * @param string $booleanString
	 * @return boolean
	 */
	private function convertCheckboxValueToBoolean($booleanString) {
		// an activated chechkbox returning string with value one
		return ($booleanString == '1') ? \TRUE : \FALSE;
	}

	/**
	 *
	 * @param array $setting
	 * @param string $checkBoxName
	 * @return boolean
	 */
	private function hasCheckboxBooleanValue($setting, $checkBoxName) {
		if ((\array_key_exists($checkBoxName, $setting)) && (\strlen($setting[$checkBoxName]) > 0)) {
			return $this->convertCheckboxValueToBoolean($setting[$checkBoxName]);
		}
		return \FALSE;
	}

	/**
	 *
	 * @return boolean
	 */
	private function hasCorpMemberListAccess() {
		if (\count($this->choosedCorporation) == 1) {
			$corporation = $this->corporationRepository->findByUid($this->choosedCorporation[0]);
			if ($corporation instanceof \Gerh\Evecorp\Domain\Model\Corporation) {
				return $corporation->hasAccessTo(\Gerh\Evecorp\Domain\Constants\AccessMask\Corporation::MEMBERTRACKINGLIMITED);
			}
		}
		return \FALSE;
	}

	/**
	 * Called before every action method call.
	 */
	public function initializeAction() {

		$this->showApiKeyState = $this->hasCheckboxBooleanValue($this->settings, 'showApiKeyState');
		$this->showCorporationJoinDate = $this->hasCheckboxBooleanValue($this->settings, 'showCorporationJoinDate');
		$this->showCurrentCorporation = $this->hasCheckboxBooleanValue($this->settings, 'showCurrentCorporation');
		$this->showLoginUser = $this->hasCheckboxBooleanValue($this->settings, 'showLoginUser');

		$this->choosedCorporation = (\strlen($this->settings['corporation']) > 0) ?
				\TYPO3\CMS\Core\Utility\GeneralUtility::intExplode(',', $this->settings['corporation']) : array();
	}

	/**
	 * Show corporation member list
	 *
	 * @return void
	 */
	public function indexAction() {
		$corpMembers = $this->characterRepository->findAllCharactersSortedByCharacterName($this->choosedCorporation);
		$this->view->assign('corpMembers', $corpMembers);
		$this->view->assign('hasCorpMemberListAccess', $this->hasCorpMemberListAccess());
		$this->view->assign('showApiKeyState', $this->showApiKeyState);
		$this->view->assign('showCorporationJoinDate', $this->showCorporationJoinDate);
		$this->view->assign('showLoginUser', $this->showLoginUser);
	}

	/**
	 * Show corporation member list (light)
	 *
	 * @return void
	 */
	public function showLightAction() {
		$corpMembers = $this->characterRepository->findAllCharactersSortedByCharacterName($this->choosedCorporation);
		$this->view->assign('corpMembers', $corpMembers);
		$this->view->assign('showApiKeyState', $this->showApiKeyState);
		$this->view->assign('showCorporationJoinDate', $this->showCorporationJoinDate);
		$this->view->assign('showCurrentCorporation', $this->showCurrentCorporation);
		$this->view->assign('showLoginUser', $this->showLoginUser);
	}

	/**
	 * Update corporation member list
	 */
	public function updateAction() {
		if (\count($this->choosedCorporation) != 1) {
			$this->addFlashMessage('No or to many corporations selected!', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
			$this->redirect('index');
			return;
		}

		if (!$this->hasCorpMemberListAccess()) {
			$this->addFlashMessage('No access to corporation member list!', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
			$this->redirect('index');
			return;
		}

		$corporation = $this->corporationRepository->findByUid($this->choosedCorporation[0]);
		$corporationApiKey = $corporation->findFirstApiKeyByAccessMask(\Gerh\Evecorp\Domain\Constants\AccessMask\Corporation::MEMBERTRACKINGLIMITED);
		if (!$corporationApiKey instanceof \Gerh\Evecorp\Domain\Model\ApiKeyCorporation) {
			$this->addFlashMessage('No corporation API key found for accessing corporation member list!', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
			$this->redirect('index');
			return;
		}

		$corpMemberListUpdater = $this->objectManager->get('\\Gerh\Evecorp\\Domain\\Mapper\\CorporationMemberList');
		$corpMemberListUpdater->setCorporationApiKey($corporationApiKey);
		$corpMemberListUpdater->setCorporation($corporation);
		$result = $corpMemberListUpdater->updateCorpMemberList();

		$flashMessage = array(
			'message' => 'Corporation member list updated successfully.',
			'title' => '',
			'severity' => \TYPO3\CMS\Core\Messaging\AbstractMessage::OK
		);

		if ($result === \FALSE) {
			$flashMessage['message'] = 'Error while updating corporation member list!Reason: ' . $corpMemberListUpdater->getErrorMessage();
			$flashMessage['severity'] = \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR;
		}

		$this->addFlashMessage($flashMessage['message'], $flashMessage['title'], $flashMessage['severity']);
		$this->redirect('index');
	}

}
