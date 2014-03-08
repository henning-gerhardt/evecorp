<?php
namespace gerh\Evecorp\Controller;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Henning Gerhardt 
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
class AppController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

    private $mapping;

    /**
     * eveitemRepository
     *
     * @var \gerh\Evecorp\Domain\Repository\EveitemRepository
     * @inject
     */
    protected $eveitemRepository;

    public function initializeAction() {
        foreach( $this->eveitemRepository->findAllForStoragePids(array($this->settings['storagepid'])) as $entry) {
            $this->mapping[$entry->getEveId()] = $entry->getEveName();
        }
    }

    /**
     * action index
     *
     * @return void
     */
    public function indexAction() {
        $fetcher = new \gerh\Evecorp\Domain\Model\EveCentralFetcher();
        $fetcher->setBaseUri($this->settings['evecentralurl']);
        $fetcher->setCorpTax($this->settings['corptax']);
        $fetcher->setSystemId($this->settings['systemid']);
        $fetcher->setTypeIds($this->mapping);
        $result = $fetcher->query();
        ksort($result);

        $this->view->assign('result', $result);
        $this->view->assign('tableTypeContent', $this->settings['tabletypecontent']);
        $this->view->assign('preTableText', $this->settings['pretabletext']);
        $this->view->assign('postTableText', $this->settings['posttabletext']);
        $this->view->assign('showBuyCorpColumn', $this->settings['showbuycorpcolumn']);
    }

}
