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
	 * @var \Gerh\Evecorp\Domain\Repository\ApiKeyRepository
	 * @inject
	 */
	protected $apiKeyRepository;

	/**
	 * @var \TYPO3\CMS\Extbase\Domain\Repository\FrontendUserRepository
	 * @inject
	 */
	protected $frontendUserRepository;

	/**
	 * index action
	 *
	 * @return void
	 */
	public function indexAction() {
		$userId = $GLOBALS['TSFE']->fe_user->user['uid'];
		$apiKeyList = $this->apiKeyRepository->findAllByUserId($userId);

		$this->view->assign('apiKeyList', $apiKeyList);
	}

	/**
	 * show form for new api key
	 */
	public function newAction(\Gerh\Evecorp\Domain\Model\ApiKey $newApiKey = NULL) {
		$this->view->assign('newApiKey', $newApiKey);
	}

	/**
	 *
	 * @param \Gerh\Evecorp\Domain\Model\ApiKey $newApiKey
	 * @validate $newApiKey \Gerh\Evecorp\Domain\Validator\ApiKeyValidator
	 */
	public function createAction(\Gerh\Evecorp\Domain\Model\ApiKey $newApiKey) {
		$userId = $GLOBALS['TSFE']->fe_user->user['uid'];
		$corpMember = $this->frontendUserRepository->findByUid($userId);
		$newApiKey->setCorpMember($corpMember);
		$this->apiKeyRepository->add($newApiKey);
		$this->redirect('index');
	}
	
	/**
	 * 
	 * @param \Gerh\Evecorp\Domain\Model\ApiKey $apiKey
	 * @ignorevalidation $apiKey
	 * @return void
	 */
	public function deleteAction(\Gerh\Evecorp\Domain\Model\ApiKey $apiKey) {
		$this->apiKeyRepository->remove($apiKey);
		$this->redirect('index');
	}
}
