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
class ApiKeyManagementController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	/**
	 * @var \Gerh\Evecorp\Domain\Repository\ApiKeyAccountRepository
	 * @inject
	 */
	protected $apiKeyAccountRepository;

	/**
	 * @var \Gerh\Evecorp\Service\AccessControlService
	 * @inject
	 */
	protected $accessControlService;

	/**
	 * index action
	 *
	 * @return void
	 */
	public function indexAction() {
		$corpMember = $this->accessControlService->getCorpMember();

		$displayName = $corpMember->getName();
		if (empty($displayName)) {
			$displayName = $corpMember->getUsername();
		}

		$this->view->assign('corpMember', $corpMember);
		$this->view->assign('displayName', $displayName);
	}

	/**
	 * show form for new api key
	 *
	 * @param \Gerh\Evecorp\Domain\Model\ApiKey $newApiKey
	 * @ignorevalidation $newApiKey
	 * @return void
	 */
	public function newAction(\Gerh\Evecorp\Domain\Model\ApiKey $newApiKey = \NULL) {
		$this->view->assign('newApiKey', $newApiKey);

		$accessMask = \Gerh\Evecorp\Domain\Utility\AccessMaskUtility::getAccessMask();
		$this->view->assign('accessMask', $accessMask);
	}

	/**
	 * Add new api key account
	 *
	 * @param \Gerh\Evecorp\Domain\Model\ApiKey $newApiKeyAccount
	 * @validate $newApiKeyAccount \Gerh\Evecorp\Domain\Validator\ApiKeyAccountValidator
	 */
	public function createAction(\Gerh\Evecorp\Domain\Model\ApiKeyAccount $newApiKeyAccount) {
		$corpMember = $this->accessControlService->getCorpMember();

		if (($corpMember === \NULL) || (!$corpMember instanceof \Gerh\Evecorp\Domain\Model\CorpMember)) {
			$this->addFlashMessage('FE user not defined as Gerh_Evecorp_Domain_Model_CorpMember. Notice your local Typo3 administrator to change your account to correct record type!', 'Error happening', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
			$this->redirect('index');
			return;
		}

		$newApiKeyAccount->setCorpMember($corpMember);

		$mapper = $this->objectManager->get('Gerh\\Evecorp\\Domain\\Mapper\\ApiKeyMapper');
		$result = $mapper->fillUpModel($newApiKeyAccount);

		if ($result === \TRUE) {
			$this->apiKeyAccountRepository->add($newApiKeyAccount);
		} else {
			$this->addFlashMessage($mapper->getErrorMessage(), 'Error happening', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
		}

		$utility = new \Gerh\Evecorp\Domain\Utility\CorpMemberUtility();
		$utility->adjustFrontendUserGroups($corpMember);

		$this->redirect('index');
	}

	/**
	 * Deleting api key account
	 *
	 * @param \Gerh\Evecorp\Domain\Model\ApiKeyAccount $apiKeyAccount
	 * @ignorevalidation $apiKeyAccount
	 * @return void
	 */
	public function deleteAction(\Gerh\Evecorp\Domain\Model\ApiKeyAccount $apiKeyAccount) {
		$this->apiKeyAccountRepository->remove($apiKeyAccount);

		$corpMember = $this->accessControlService->getCorpMember();
		$utility = new \Gerh\Evecorp\Domain\Utility\CorpMemberUtility();
		$utility->adjustFrontendUserGroups($corpMember);

		$this->redirect('index');
	}

	/**
	 * Updating api key account
	 *
	 * @param \Gerh\Evecorp\Domain\Model\ApiKeyAccount $apiKeyAccount
	 * @ignorevalidation $apiKeyAccount
	 * @return void
	 */
	public function updateAction(\Gerh\Evecorp\Domain\Model\ApiKeyAccount $apiKeyAccount) {
		$mapper = $this->objectManager->get('Gerh\\Evecorp\\Domain\\Mapper\\ApiKeyMapper');

		$result = $mapper->updateApiKeyAccount($apiKeyAccount);
		if ($result === \TRUE) {
			$this->apiKeyAccountRepository->update($apiKeyAccount);
		} else {
			$this->addFlashMessage($mapper->getErrorMessage(), 'Error happening', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
		}

		$corpMember = $this->accessControlService->getCorpMember();
		$utility = new \Gerh\Evecorp\Domain\Utility\CorpMemberUtility();
		$utility->adjustFrontendUserGroups($corpMember);

		$this->redirect('index');
	}

}
