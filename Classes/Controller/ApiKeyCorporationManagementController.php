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

use Gerh\Evecorp\Domain\Constants\AccessMask\Corporation as CorporationAccessMask;
use Gerh\Evecorp\Domain\Mapper\ApiKeyInfoMapper;
use Gerh\Evecorp\Domain\Model\ApiKeyCorporation;
use Gerh\Evecorp\Domain\Model\Corporation;
use Gerh\Evecorp\Domain\Repository\ApiKeyCorporationRepository;
use Gerh\Evecorp\Domain\Repository\CorporationRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

/**
 *
 *
 * @package evecorp
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class ApiKeyCorporationManagementController extends ActionController {

    /**
     * @var ApiKeyCorporationRepository
     */
    protected $apiKeyCorporationRepository;

    /**
     * @var CorporationRepository
     */
    protected $corporationRepository;

    /**
     * Hold selected corporation uid
     *
     * @var \integer
     */
    protected $selectedCorporation;

    /**
     * Class constructor.
     *
     * @param ApiKeyCorporationRepository $apiKeyCorporationRepository
     * @param CorporationRepository $corporationRepository
     * @return void
     */
    public function __construct(ApiKeyCorporationRepository $apiKeyCorporationRepository, CorporationRepository $corporationRepository) {
        // calling default controller constructor
        parent::__construct();

        $this->apiKeyCorporationRepository = $apiKeyCorporationRepository;
        $this->corporationRepository = $corporationRepository;
    }

    /**
     * @see ActionController::initializeAction()
     */
    public function initializeAction() {
        $selectedCorporation = (\strlen($this->settings['corporation']) > 0) ?
            GeneralUtility::intExplode(',', $this->settings['corporation']) : [];

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
     *
     * @return void
     */
    public function indexAction() {

        $hasTitleAccess = \FALSE;

        if ($this->selectedCorporation > 0) {
            $apiKeys = $this->apiKeyCorporationRepository->findByCorporation($this->selectedCorporation);
            $corporation = $this->corporationRepository->findByUid($this->selectedCorporation);
            if ($corporation instanceof Corporation) {
                $hasTitleAccess = $corporation->hasAccessTo(CorporationAccessMask::TITLES);
            }
        } else {
            $apiKeys = [];
        }

        $this->view->assign('keys', $apiKeys);
        $this->view->assign('amountOfSelectedCorporations', ($this->selectedCorporation > 0) ? 1 : $this->selectedCorporation);
        $this->view->assign('titleAccess', $hasTitleAccess);
    }

    /**
     * show form for new api key
     *
     * @param ApiKeyCorporation $newApiKeyCorporation
     * @ignorevalidation $newApiKeyCorporation
     * @return void
     */
    public function newAction(ApiKeyCorporation $newApiKeyCorporation = NULL) {
        $this->view->assign('newApiKeyCorporation', $newApiKeyCorporation);
    }

    /**
     * Add new api key corporation
     *
     * @param ApiKeyCorporation $newApiKeyCorporation
     * @validate $newApiKeyCorporation \Gerh\Evecorp\Domain\Validator\CorporationApiKeyValidator
     * @return void
     */
    public function createAction(ApiKeyCorporation $newApiKeyCorporation) {

        if ($this->selectedCorporation <= 0) {
            $this->addFlashMessage('No or to many corporations selected!');
            $this->redirect('index');
            return;
        }

        $corporation = $this->corporationRepository->findByUid($this->selectedCorporation);
        $newApiKeyCorporation->setCorporation($corporation);

        $mapper = new ApiKeyInfoMapper();
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
     * @param ApiKeyCorporation $apiKeyCorporation
     * @ignorevalidation $apiKeyCorporation
     * @return void
     */
    public function deleteAction(ApiKeyCorporation $apiKeyCorporation) {
        $this->apiKeyCorporationRepository->remove($apiKeyCorporation);

        $this->redirect('index');
    }

}
