<?php
namespace Gerh\Evecorp\Controller;

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
class ApiKeyManagementController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController{

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
		$frontendUser = $this->accessControlService->getFrontendUserId();
		$this->apiKeyAccountRepository
				->setDefaultOrderings(array(
					'key_id' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
				));
		$apiKeyAccountList = $this->apiKeyAccountRepository
				->findByCorpMember($frontendUser);

		$this->view->assign('apiKeyAccountList', $apiKeyAccountList);
	}

	/**
	 * show form for new api key
	 *
	 * @param \Gerh\Evecorp\Domain\Model\ApiKey $newApiKey
	 * @ignorevalidation $newApiKey
	 * @return void
	 */
	public function newAction(\Gerh\Evecorp\Domain\Model\ApiKey $newApiKey = NULL) {
		$this->view->assign('newApiKey', $newApiKey);

		$accessMask = \Gerh\Evecorp\Domain\Utility\AccessMaskUtility::getAccessMask();
		$this->view->assign('accessMask', $accessMask);
	}

	/**
	 *
	 * @param \Gerh\Evecorp\Domain\Model\ApiKey $newApiKeyAccount
	 * @validate $newApiKeyAccount \Gerh\Evecorp\Domain\Validator\ApiKeyAccountValidator
	 */
	public function createAction(\Gerh\Evecorp\Domain\Model\ApiKeyAccount $newApiKeyAccount) {
		$frontendUser = $this->accessControlService->getFrontendUser();
		$newApiKeyAccount->setCorpMember($frontendUser);

		$mapper = new \Gerh\Evecorp\Domain\Mapper\ApiKeyMapper();
		$result = $mapper->fillUpModel($newApiKeyAccount);

		if ($result ===  TRUE) {
			$this->apiKeyAccountRepository->add($newApiKeyAccount);
		} else {
			$this->addFlashMessage($mapper->getErrorMessage(), 'Error happening', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
		}

		$this->redirect('index');
	}

	/**
	 *
	 * @param \Gerh\Evecorp\Domain\Model\ApiKeyAccount $apiKeyAccount
	 * @ignorevalidation $apiKeyAccount
	 * @return void
	 */
	public function deleteAction(\Gerh\Evecorp\Domain\Model\ApiKeyAccount $apiKeyAccount) {
		$this->apiKeyAccountRepository->remove($apiKeyAccount);

		$this->redirect('index');
	}
}
