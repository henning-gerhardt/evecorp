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

    private function buildQuery() {
        $result = $this->settings['evecentralurl'] . '?usesystem=' . $this->settings['systemid'];
        foreach(array_keys($this->mapping) as $key) {
            $result .= '&typeid=' . $key;
        }
        return $result;
    }

    private function query($url) {
        $content = file_get_contents($url);
        $result = $this->parse($content);
        return $result;
    }

    /**
     * action index
     *
     * @return void
     */
    public function indexAction() {
        $query = $this->buildQuery();
        $result = $this->query($query);
        ksort($result);
        $this->view->assign('result', $result);
        $this->view->assign('tableTypeContent', $this->settings['tabletypecontent']);
        $this->view->assign('preTableText', $this->settings['pretabletext']);
        $this->view->assign('postTableText', $this->settings['posttabletext']);
        $this->view->assign('showBuyCorpColumn', $this->settings['showbuycorpcolumn']);
    }

    private function parse($content) {
        $result = array();

        $doc = new \DOMDocument();
        $doc->loadXML($content);
        $xpath = new \DOMXPath($doc);

        $resourceTypes = $xpath->evaluate('.//type');
        for ($i = 0 ; $i < $resourceTypes->length; $i++) {
            $resource = $resourceTypes->item($i);
            $resourceId = $resource->getAttribute('id');
            $resourceBuyMax = $xpath->evaluate('.//buy/max', $resource)->item(0)->textContent;
            $resourceSellMin = $xpath->evaluate('.//sell/min', $resource)->item(0)->textContent;
            $interim = array(
                'buy' => $resourceBuyMax,
                'buyCorp' => round($resourceBuyMax * $this->settings['corptax'], 2),
                'sell' => $resourceSellMin,
            );
            $result[$this->mapping[$resourceId]] = $interim;
        }

        return $result;
    }
}
