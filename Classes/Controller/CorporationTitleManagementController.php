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

use Gerh\Evecorp\Domain\Constants\AccessMask\Corporation as Corporation2;
use Gerh\Evecorp\Domain\Mapper\CorporationTitleMapper;
use Gerh\Evecorp\Domain\Model\ApiKeyCorporation;
use Gerh\Evecorp\Domain\Model\Corporation;
use Gerh\Evecorp\Domain\Model\CorporationTitle;
use Gerh\Evecorp\Domain\Repository\CorporationRepository;
use Gerh\Evecorp\Domain\Repository\CorporationTitleRepository;
use TYPO3\CMS\Core\Messaging\AbstractMessage;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Domain\Repository\FrontendUserGroupRepository;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings;

/**
 *
 *
 * @package evecorp
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class CorporationTitleManagementController extends ActionController
{

    /**
     * @var \Gerh\Evecorp\Domain\Repository\CorporationRepository
     */
    protected $corporationRepository;

    /**
     * @var \Gerh\Evecorp\Domain\Repository\CorporationTitleRepository
     */
    protected $corporationTitleRepository;

    /**
     * @var \TYPO3\CMS\Extbase\Domain\Repository\FrontendUserGroupRepository
     */
    protected $frontendUserGroupRepository;

    /**
     * Hold selected corporation uid
     *
     * @var \integer
     */
    protected $selectedCorporation;

    /**
     * Class constructor.
     *
     * @param CorporationRepository $corporationRepository
     * @param CorporationTitleRepository $corporationTitleRepository
     * @param FrontendUserGroupRepository $frontendUserGroupRepository
     * @return void
     */
    public function __construct(CorporationRepository $corporationRepository, CorporationTitleRepository $corporationTitleRepository, FrontendUserGroupRepository $frontendUserGroupRepository)
    {
        // calling default controller constructor
        parent::__construct();

        $this->corporationRepository = $corporationRepository;
        $this->corporationTitleRepository = $corporationTitleRepository;
        $this->frontendUserGroupRepository = $frontendUserGroupRepository;
    }

    /**
     * @see ActionController::initializeAction()
     */
    public function initializeAction()
    {
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
     */
    public function indexAction()
    {

        $hasTitleAccess = \FALSE;

        if ($this->selectedCorporation > 0) {
            $titles = $this->corporationTitleRepository->findByCorporation($this->selectedCorporation);
            $corporation = $this->corporationRepository->findByUid($this->selectedCorporation);
            if ($corporation instanceof Corporation) {
                $hasTitleAccess = $corporation->hasAccessTo(Corporation2::TITLES);
            }
        } else {
            $titles = [];
        }

        $this->view->assign('amountOfSelectedCorporations', ($this->selectedCorporation > 0) ? 1 : $this->selectedCorporation);
        $this->view->assign('titles', $titles);
        $this->view->assign('amountOfTitles', \count($titles));
        $this->view->assign('titleAccess', $hasTitleAccess);
    }

    /**
     * fetch action
     */
    public function fetchAction()
    {
        if ($this->selectedCorporation < 1) {
            $this->addFlashMessage('No corporation selected!', 'Error', AbstractMessage::ERROR);
            $this->redirect('index');
            return;
        }

        // fetch corporation from database
        $corporation = $this->corporationRepository->findByUid($this->selectedCorporation);
        if (!$corporation instanceof Corporation) {
            $this->addFlashMessage('Corporation not found!', 'Error', AbstractMessage::ERROR);
            $this->redirect('index');
            return;
        }

        // determinate api key with corp title access
        $corporationApiKey = $corporation->findFirstApiKeyByAccessMask(Corporation2::TITLES);
        if (!$corporationApiKey instanceof ApiKeyCorporation) {
            $this->addFlashMessage('No corporation api key found with title access!', 'Error', AbstractMessage::ERROR);
            $this->redirect('index');
            return;
        }

        $mapper = new CorporationTitleMapper($corporationApiKey);
        // fetch corp titles with this key
        $newCorporationTitles = $mapper->fetchCorporationTitles();
        // clear all existing corp titles
        $corporation->removeAllCorporationTitles();
        // add new corp titles (could be empty)
        $corporation->setCorporationTitles($newCorporationTitles);
        // update / persistence corporation object
        $this->corporationRepository->update($corporation);

        $this->addFlashMessage('Successful fetched corporation titles.');
        $this->redirect('index');
    }

    /**
     * edit action
     *
     * @param CorporationTitle $corporationTitle
     */
    public function editAction(CorporationTitle $corporationTitle)
    {
        $this->view->assign('corporationTitle', $corporationTitle);
        $defaultQuerySettings = new Typo3QuerySettings();
        $defaultQuerySettings->setRespectStoragePage(\FALSE);
        $this->frontendUserGroupRepository->setDefaultQuerySettings($defaultQuerySettings);
        $usergroups = [0 => 'none'];
        foreach ($this->frontendUserGroupRepository->findAll() as $frontendUserGroup) {
            $usergroups[$frontendUserGroup->getUid()] = $frontendUserGroup->getTitle();
        }

        $this->view->assign('usergroups', $usergroups);
    }

    /**
     * update action
     *
     * @param CorporationTitle $corporationTitle
     */
    public function updateAction(CorporationTitle $corporationTitle)
    {
        $this->corporationTitleRepository->update($corporationTitle);
        $this->addFlashMessage('Corporation title successful changed.');
        $this->redirect('index');
    }
}
