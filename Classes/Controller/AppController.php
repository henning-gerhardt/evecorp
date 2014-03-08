<?php
namespace gerh\Evecorp\Controller;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 - 2014 Henning Gerhardt 
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

    private $allMappings = array();

    private $needsUpdate = array();

    /**
     * eveitemRepository
     *
     * @var \gerh\Evecorp\Domain\Repository\EveitemRepository
     * @inject
     */
    protected $eveitemRepository;

    public function initializeAction() {
        $timeToCache = $this->settings['cachingtime'];
        foreach($this->eveitemRepository->findAllForStoragePids(array($this->settings['storagepid'])) as $entry) {
            if ($entry->isUpToDate($timeToCache) === false) {
                $this->needsUpdate[$entry->getEveId()] = $entry->getEveName();
            }
            array_push($this->allMappings, $entry);
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
        $fetcher->setSystemId($this->settings['systemid']);
        $fetcher->setTypeIds($this->needsUpdate);
        $updateResult = $fetcher->query();

        $result = array();
        foreach($this->allMappings as $dbEntry) { {
            foreach($updateResult as $eveName => $values)
                if ($dbEntry->getEveName() == $eveName) {
                    $dbEntry->setBuyPrice($values['buy']);
                    $dbEntry->setSellPrice($values['sell']);
                    $dbEntry->setCacheTime(time());
                    $this->eveitemRepository->update($dbEntry);
                }
            }
            $result[$dbEntry->getEveName()] = array(
                'buy' =>$dbEntry->getBuyPrice(),
                'buyCorp' => round($dbEntry->getBuyPrice() * $this->settings['corptax'], 2),
                'sell' =>$dbEntry->getSellPrice()
                );
        }
        ksort($result);

        $this->view->assign('result', $result);
        $this->view->assign('tableTypeContent', $this->settings['tabletypecontent']);
        $this->view->assign('preTableText', $this->settings['pretabletext']);
        $this->view->assign('postTableText', $this->settings['posttabletext']);
        $this->view->assign('showBuyCorpColumn', $this->settings['showbuycorpcolumn']);
    }

}
