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
class ApiKeyCorporationManagementController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController{

	/**
	 * @var \Gerh\Evecorp\Domain\Repository\ApiKeyCorporationRepository
	 * @inject
	 */
	protected $apiKeyCorporationRepository;

	/**
	 * @var \Gerh\Evecorp\Domain\Repository\CorporationRepository
	 * @inject
	 */
	protected $corporationRepository;

	/**
	 * index action
	 *
	 * @return void
	 */
	public function indexAction() {
		$apiKeys = array();
		$choosedCorporation = (\strlen($this->settings['corporation']) > 0) ?
				\TYPO3\CMS\Core\Utility\GeneralUtility::intExplode(',', $this->settings['corporation']) : array();

		if (\count($choosedCorporation) > 0) {
			$apiKeys = $this->apiKeyCorporationRepository->findByCorporation($choosedCorporation);
		}

		$this->view->assign('keys', $apiKeys);
		$this->view->assign('amountOfChoosedCorporations', count($choosedCorporation));
		
	}

	/**
	 * show form for new api key
	 *
	 * @param \Gerh\Evecorp\Domain\Model\ApiKeyCorporation $newApiKeyCorporation
	 * @ignorevalidation $newApiKeyCorporation
	 * @return void
	 */
	public function newAction(\Gerh\Evecorp\Domain\Model\ApiKeyCorporation $newApiKeyCorporation = NULL) {
		$this->view->assign('newApiKeyCorporation', $newApiKeyCorporation);
	}

	/**
	 * Add new api key corporation
	 *
	 * @param \Gerh\Evecorp\Domain\Model\ApiKeyCorporation $newApiKeyCorporation
	 * @validate $newApiKeyCorporation \Gerh\Evecorp\Domain\Validator\ApiKeyCorporationValidator
	 * @return void
	 */
	public function createAction(\Gerh\Evecorp\Domain\Model\ApiKeyCorporation $newApiKeyCorporation) {
		$corporationId = (\strlen($this->settings['corporation']) > 0) ?
				\TYPO3\CMS\Core\Utility\GeneralUtility::intExplode(',', $this->settings['corporation']) : 0;
		$corporation = $this->corporationRepository->findByUid($corporationId);
		$newApiKeyCorporation->setCorporation($corporation);

		$mapper = new \Gerh\Evecorp\Domain\Mapper\ApiKeyInfoMapper();
		$mapper->setKeyId($newApiKeyCorporation->getKeyId());
		$mapper->setVcode($newApiKeyCorporation->getVCode());		
		$apiKeyInfo = $mapper->retrieveApiKeyInfo();
		$newApiKeyCorporation->setAccessMask($apiKeyInfo->getAccessMask());

		$this->apiKeyCorporationRepository->add($newApiKeyCorporation);
		$this->redirect('index');
	}

	/**
	 * Deleting api key corporation
	 *
	 * @param \Gerh\Evecorp\Domain\Model\ApiKeyCorporation $apiKeyCorporation
	 * @ignorevalidation $apiKeyCorporation
	 * @return void
	 */
	public function deleteAction(\Gerh\Evecorp\Domain\Model\ApiKeyCorporation $apiKeyCorporation) {
		$this->apiKeyCorporationRepository->remove($apiKeyCorporation);

		$this->redirect('index');
	}

}
