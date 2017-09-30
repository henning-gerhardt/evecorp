<?php

/*
 * Copyright notice
 *
 * (c) 2017 Henning Gerhardt
 *
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 3
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

namespace Gerh\Evecorp\Controller;

use Gerh\Evecorp\Domain\Mapper\ApiKeyMapper;
use Gerh\Evecorp\Domain\Model\ApiKey;
use Gerh\Evecorp\Domain\Model\ApiKeyAccount;
use Gerh\Evecorp\Domain\Model\CorpMember;
use Gerh\Evecorp\Domain\Repository\ApiKeyAccountRepository;
use Gerh\Evecorp\Domain\Utility\AccessMaskUtility;
use Gerh\Evecorp\Domain\Utility\CorpMemberUtility;
use Gerh\Evecorp\Service\AccessControlService;
use TYPO3\CMS\Core\Messaging\AbstractMessage;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

/**
 *
 *
 * @package evecorp
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class ApiKeyManagementController extends ActionController {

    /**
     * @var ApiKeyAccountRepository
     * @inject
     */
    protected $apiKeyAccountRepository;

    /**
     * @var AccessControlService
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
     * @param ApiKey $newApiKey
     * @ignorevalidation $newApiKey
     * @return void
     */
    public function newAction(ApiKey $newApiKey = \NULL) {
        $this->view->assign('newApiKey', $newApiKey);

        $accessMask = AccessMaskUtility::getAccessMask();
        $this->view->assign('accessMask', $accessMask);
    }

    /**
     * Add new api key account
     *
     * @param ApiKey $newApiKeyAccount
     * @validate $newApiKeyAccount \Gerh\Evecorp\Domain\Validator\AccountApiKeyValidator
     */
    public function createAction(ApiKeyAccount $newApiKeyAccount) {
        $corpMember = $this->accessControlService->getCorpMember();

        if (($corpMember === \NULL) || (!$corpMember instanceof CorpMember)) {
            $this->addFlashMessage('FE user not defined as Gerh_Evecorp_Domain_Model_CorpMember. Notice your local TYPO3 administrator to change your account to correct record type!', 'Error happening', AbstractMessage::ERROR);
            $this->redirect('index');
            return;
        }

        $newApiKeyAccount->setCorpMember($corpMember);

        $mapper = $this->objectManager->get(ApiKeyMapper::class);
        $result = $mapper->fillUpModel($newApiKeyAccount);

        if ($result === \FALSE) {
            $this->addFlashMessage($mapper->getErrorMessage(), 'Error happening', AbstractMessage::ERROR);
            $this->redirect('index');
            return;
        }

        $this->apiKeyAccountRepository->add($newApiKeyAccount);

        $utility = new CorpMemberUtility();
        $utility->adjustFrontendUserGroups($corpMember);

        $this->redirect('index');
    }

    /**
     * Deleting api key account
     *
     * @param ApiKeyAccount $apiKeyAccount
     * @ignorevalidation $apiKeyAccount
     * @return void
     */
    public function deleteAction(ApiKeyAccount $apiKeyAccount) {
        $this->apiKeyAccountRepository->remove($apiKeyAccount);

        $corpMember = $this->accessControlService->getCorpMember();
        $utility = new CorpMemberUtility();
        $utility->adjustFrontendUserGroups($corpMember);

        $this->redirect('index');
    }

    /**
     * Updating api key account
     *
     * @param ApiKeyAccount $apiKeyAccount
     * @ignorevalidation $apiKeyAccount
     * @return void
     */
    public function updateAction(ApiKeyAccount $apiKeyAccount) {
        $mapper = $this->objectManager->get(ApiKeyMapper::class);

        $result = $mapper->updateApiKeyAccount($apiKeyAccount);

        if ($result === \FALSE) {
            $this->addFlashMessage($mapper->getErrorMessage(), 'Error happening', AbstractMessage::ERROR);
            $this->redirect('index');
            return;
        }

        $this->apiKeyAccountRepository->update($apiKeyAccount);

        $corpMember = $this->accessControlService->getCorpMember();
        $utility = new CorpMemberUtility();
        $utility->adjustFrontendUserGroups($corpMember);

        $this->redirect('index');
    }

}
