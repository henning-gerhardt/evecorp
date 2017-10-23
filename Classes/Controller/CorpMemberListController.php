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
use Gerh\Evecorp\Domain\Mapper\CorporationMemberList;
use Gerh\Evecorp\Domain\Model\ApiKeyCorporation;
use Gerh\Evecorp\Domain\Model\Corporation;
use Gerh\Evecorp\Domain\Repository\CharacterRepository;
use Gerh\Evecorp\Domain\Repository\CorporationRepository;
use TYPO3\CMS\Core\Messaging\AbstractMessage;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

/**
 *
 *
 * @package evecorp
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class CorpMemberListController extends ActionController
{

    /**
     * @var \Gerh\Evecorp\Domain\Repository\CharacterRepository
     */
    protected $characterRepository;

    /**
     * @var mixed
     */
    protected $choosedCorporation;

    /**
     * @var \Gerh\Evecorp\Domain\Repository\CorporationRepository
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
    private function convertCheckboxValueToBoolean($booleanString)
    {
        // an activated chechkbox returning string with value one
        return ($booleanString == '1') ? \TRUE : \FALSE;
    }

    /**
     *
     * @param array $setting
     * @param string $checkBoxName
     * @return boolean
     */
    private function hasCheckboxBooleanValue($setting, $checkBoxName)
    {
        if ((\array_key_exists($checkBoxName, $setting)) && (\strlen($setting[$checkBoxName]) > 0)) {
            return $this->convertCheckboxValueToBoolean($setting[$checkBoxName]);
        }
        return \FALSE;
    }

    /**
     *
     * @return boolean
     */
    private function hasCorpMemberListAccess()
    {
        if (\count($this->choosedCorporation) == 1) {
            $corporation = $this->corporationRepository->findByUid($this->choosedCorporation[0]);
            if ($corporation instanceof Corporation) {
                return $corporation->hasAccessTo(Corporation2::MEMBERTRACKINGLIMITED);
            }
        }
        return \FALSE;
    }

    /**
     * Class constructor.
     *
     * @param CharacterRepository $characterRepository
     * @param CorporationRepository $corporationRepository
     * @return void
     */
    public function __construct(CharacterRepository $characterRepository, CorporationRepository $corporationRepository)
    {
        // calling default controller constructor
        parent::__construct();

        $this->characterRepository = $characterRepository;
        $this->corporationRepository = $corporationRepository;
    }

    /**
     * Called before every action method call.
     */
    public function initializeAction()
    {

        $this->showApiKeyState = $this->hasCheckboxBooleanValue($this->settings, 'showApiKeyState');
        $this->showCorporationJoinDate = $this->hasCheckboxBooleanValue($this->settings, 'showCorporationJoinDate');
        $this->showCurrentCorporation = $this->hasCheckboxBooleanValue($this->settings, 'showCurrentCorporation');
        $this->showLoginUser = $this->hasCheckboxBooleanValue($this->settings, 'showLoginUser');

        $this->choosedCorporation = (\strlen($this->settings['corporation']) > 0) ?
            GeneralUtility::intExplode(',', $this->settings['corporation']) : [];
    }

    /**
     * Show corporation member list
     *
     * @return void
     */
    public function indexAction()
    {
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
    public function showLightAction()
    {
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
    public function updateAction()
    {
        if (\count($this->choosedCorporation) != 1) {
            $this->addFlashMessage('No or to many corporations selected!', '', AbstractMessage::ERROR);
            $this->redirect('index');
            return;
        }

        if (!$this->hasCorpMemberListAccess()) {
            $this->addFlashMessage('No access to corporation member list!', '', AbstractMessage::ERROR);
            $this->redirect('index');
            return;
        }

        $corporation = $this->corporationRepository->findByUid($this->choosedCorporation[0]);
        $corporationApiKey = $corporation->findFirstApiKeyByAccessMask(Corporation2::MEMBERTRACKINGLIMITED);
        if (!$corporationApiKey instanceof ApiKeyCorporation) {
            $this->addFlashMessage('No corporation API key found for accessing corporation member list!', '', AbstractMessage::ERROR);
            $this->redirect('index');
            return;
        }

        $corpMemberListUpdater = $this->objectManager->get(CorporationMemberList::class);
        $corpMemberListUpdater->setCorporationApiKey($corporationApiKey);
        $corpMemberListUpdater->setCorporation($corporation);
        $result = $corpMemberListUpdater->updateCorpMemberList();

        $flashMessage = [
            'message' => 'Corporation member list updated successfully.',
            'title' => '',
            'severity' => AbstractMessage::OK
        ];

        if ($result === \FALSE) {
            $flashMessage['message'] = 'Error while updating corporation member list!Reason: ' . $corpMemberListUpdater->getErrorMessage();
            $flashMessage['severity'] = AbstractMessage::ERROR;
        }

        $this->addFlashMessage($flashMessage['message'], $flashMessage['title'], $flashMessage['severity']);
        $this->redirect('index');
    }
}
