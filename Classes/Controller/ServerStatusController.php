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

use Gerh\Evecorp\Service\PhealService;
use Pheal\Exceptions\PhealException;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

/**
 *
 *
 * @package evecorp
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class ServerStatusController extends ActionController
{

    /**
     * @var \Gerh\Evecorp\Service\PhealService
     */
    protected $phealService;

    /**
     * @var \Pheal\Pheal
     */
    private $pheal;

    /**
     * Class constructor.
     *
     * @param PhealService $phealService
     * @return void
     */
    public function __construct(PhealService $phealService)
    {
        // calling default controller constructor
        parent::__construct();

        $this->phealService = $phealService;
    }

    /**
     * Initialize later called actions
     *
     * @return void
     */
    public function initializeAction()
    {
        $this->pheal = $this->phealService->getPhealInstance();
    }

    /**
     * action index
     *
     * @return void
     */
    public function indexAction()
    {

        try {
            $response = $this->pheal->serverScope->ServerStatus();
            $serverStatus = $response->serverOpen;
            $onlinePlayers = $response->onlinePlayers;
        } catch (PhealException $e) {
            $serverStatus = false;
            $onlinePlayers = 0;
        }

        $this->view->assign('server_status', $serverStatus);
        $this->view->assign('online_players', $onlinePlayers);
    }
}
