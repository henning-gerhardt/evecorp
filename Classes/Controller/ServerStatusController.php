<?php

/***************************************************************
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
 ***************************************************************/

namespace Gerh\Evecorp\Controller;

/**
 *
 *
 * @package evecorp
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class ServerStatusController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	/**
	 * @var \Gerh\Evecorp\Service\PhealService
	 * @inject
	 */
	protected $phealService;

	/**
	 *
	 * @var \Pheal\Pheal
	 */
	private $pheal;

	/**
	 *
	 */
	public function initializeAction() {
		$this->phealService =  \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('Gerh\Evecorp\Service\PhealService');
		$this->pheal = $this->phealService->getPhealInstance();
	}
	/**
	 * action index
	 *
	 * @return void
	 */
	public function indexAction() {

		try {
			$response = $this->pheal->serverScope->ServerStatus();
			$serverStatus = $response->serverOpen;
			$onlinePlayers = $response->onlinePlayers;
		} catch (\Pheal\Exceptions\PhealException $e) {
			$serverStatus = false;
			$onlinePlayers = 0;
		}

		$this->view->assign('server_status', $serverStatus);
		$this->view->assign('online_players', $onlinePlayers);
	}
}
