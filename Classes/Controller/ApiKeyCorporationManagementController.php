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

/**
 *
 *
 * @package evecorp
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class ApiKeyCorporationManagementController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

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
     *
     * @return void
     */
    public function indexAction() {

        $hasTitleAccess = \FALSE;

        if ($this->selectedCorporation > 0) {
            $apiKeys = $this->apiKeyCorporationRepository->findByCorporation($this->selectedCorporation);
            $corporation = $this->corporationRepository->findByUid($this->selectedCorporation);
            if ($corporation instanceof \Gerh\Evecorp\Domain\Model\Corporation) {
                $hasTitleAccess = $corporation->hasAccessTo(\Gerh\Evecorp\Domain\Constants\AccessMask\Corporation::TITLES);
            }
        } else {
            $apiKeys = array();
        }

        $this->view->assign('keys', $apiKeys);
        $this->view->assign('amountOfSelectedCorporations', ($this->selectedCorporation > 0) ? 1 : $this->selectedCorporation);
        $this->view->assign('titleAccess', $hasTitleAccess);
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
     * @validate $newApiKeyCorporation \Gerh\Evecorp\Domain\Validator\CorporationApiKeyValidator
     * @return void
     */
    public function createAction(\Gerh\Evecorp\Domain\Model\ApiKeyCorporation $newApiKeyCorporation) {

        if ($this->selectedCorporation <= 0) {
            $this->addFlashMessage('No or to many corporations selected!');
            $this->redirect('index');
            return;
        }

        $corporation = $this->corporationRepository->findByUid($this->selectedCorporation);
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
