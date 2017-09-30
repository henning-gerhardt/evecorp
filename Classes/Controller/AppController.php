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

use Gerh\Evecorp\Domain\Model\MarketData;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

/**
 *
 *
 * @package evecorp
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class AppController extends ActionController {

    /**
     * Holds instance for market data
     *
     * @var MarketData
     * @inject
     */
    protected $marketData;

    public function initializeAction() {
        $this->marketData->setCorpTax($this->settings['corptax']);
    }

    /**
     * action index
     *
     * @return void
     */
    public function indexAction() {
        $result = $this->marketData->getMarketData();

        $this->view->assign('result', $result);
        $this->view->assign('tableTypeContent', $this->settings['tabletypecontent']);
        $this->view->assign('preTableText', $this->settings['pretabletext']);
        $this->view->assign('postTableText', $this->settings['posttabletext']);
        $this->view->assign('showBuyCorpColumn', $this->settings['showbuycorpcolumn']);
        $this->view->assign('showFetchColumn', $this->settings['showfetchcolumn']);
    }

}
