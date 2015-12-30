<?php

/***************************************************************
 * Copyright notice
 *
 * (c) 2015 Henning Gerhardt
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
 ***************************************************************/

namespace Gerh\Evecorp\Controller;

/**
 *
 *
 * @package evecorp
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class CorporationTitleManagementController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	/**
	 * @var \Gerh\Evecorp\Domain\Repository\CorporationRepository
	 * @inject
	 */
	protected $corporationRepository;

	/**
	 * @var \Gerh\Evecorp\Domain\Repository\CorporationTitleRepository
	 * @inject
	 */
	protected $corporationTitleRepository;

	/**
	 * Hold selected corporation uid
	 *
	 * @var \integer
	 */
	protected $selectedCorporation;

	/**
	 * @see \TYPO3\CMS\Extbase\Mvc\Controller\ActionController::initializeAction()
	 */
	public function initializeAction() {
		$selectedCorporation = (\strlen($this->settings['corporation']) > 0) ?
				\TYPO3\CMS\Core\Utility\GeneralUtility::intExplode(',', $this->settings['corporation']) : array();

		$amountOfSelectedCorporation = \count($selectedCorporation);
		if ($amountOfSelectedCorporation == 1) {
			$this->selectedCorporation = $selectedCorporation[0];
		} else if ($amountOfSelectedCorporation == 0) {
			$this->selectedCorporation = 0;
		} else {
			$this->selectedCorporation = -1;
		}
	}

	/**
	 * index action
	 */
	public function indexAction() {

		$hasTitleAccess = \FALSE;

		if ($this->selectedCorporation > 0) {
			$titles = $this->corporationTitleRepository->findByCorporation($this->selectedCorporation);
			$corporation = $this->corporationRepository->findByUid($this->selectedCorporation);
			if ($corporation instanceof \Gerh\Evecorp\Domain\Model\Corporation) {
				$hasTitleAccess = $corporation->hasAccessTo(\Gerh\Evecorp\Domain\Constants\AccessMask\Corporation::TITLES);
			}
		} else {
			$titles = array();
		}

		$this->view->assign('amountOfSelectedCorporations', ($this->selectedCorporation > 0) ? 1 : $this->selectedCorporation);
		$this->view->assign('titles', $titles);
		$this->view->assign('amountOfTitles', \count($titles));
		$this->view->assign('titleAccess', $hasTitleAccess);
	}

	/**
	 * fetch action
	 */
	public function fetchAction() {
		if ($this->selectedCorporation < 1) {
			$this->addFlashMessage('No corporation selected!', 'Error', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
			$this->redirect('index');
		}

		// fetch corporation from database
		$corporation = $this->corporationRepository->findByUid($this->selectedCorporation);
		if (! $corporation instanceof \Gerh\Evecorp\Domain\Model\Corporation) {
			$this->addFlashMessage('Corporation not found!', 'Error', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
			$this->redirect('index');
		}

		// determinate api key with corp title access
		$corporationApiKey = $corporation->findFirstApiKeyByAccessMask(\Gerh\Evecorp\Domain\Constants\AccessMask\Corporation::TITLES);
		if (! $corporationApiKey instanceof \Gerh\Evecorp\Domain\Model\ApiKeyCorporation) {
			$this->addFlashMessage('No corporation api key found with title access!', 'Error', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
			$this->redirect('index');
		}

		$mapper = new \Gerh\Evecorp\Domain\Mapper\CorporationTitleMapper($corporationApiKey);
		// fetch corp titles with this key
		$newCorporationTitles = $mapper->fetchCorporationTitles();
		// clear all existing corp titles
		$corporation->removeAllCorporationTitles();
		// add new corp titles (could be empty)
		$corporation->setCorporationTitles($newCorporationTitles);
		// update / persistence corporation object
		$this->corporationRepository->update($corporation);

		$this->addFlashMessage('Successful fetched corporation titles.' );
		$this->redirect('index');
	}

}
