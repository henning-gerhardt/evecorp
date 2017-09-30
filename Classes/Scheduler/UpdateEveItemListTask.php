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

namespace Gerh\Evecorp\Scheduler;

/**
 *
 *
 * @package evecorp
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class UpdateEveItemListTask extends \TYPO3\CMS\Scheduler\Task\AbstractTask {

    /**
     * @var $eveItemRepository \Gerh\Evecorp\Domain\Repository\EveitemRepository
     */
    protected $eveItemRepository;

    /**
     * @var $eveCentralFetcher \Gerh\Evecorp\Domain\Model\EveCentralFetcher
     */
    protected $eveCentralFetcher;

    /**
     * Update outdated stored EVE item
     *
     * @return void
     */
    protected function updateEveItemList() {

        /** @var $objectManager \TYPO3\CMS\Extbase\Object\ObjectManager */
        $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
        $this->eveItemRepository = $objectManager->get('Gerh\\Evecorp\\Domain\\Repository\\EveitemRepository');
        $this->eveCentralFetcher = $objectManager->get('Gerh\\Evecorp\\Domain\\Model\\EveCentralFetcher');

        $extconf = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['evecorp']);
        $this->eveCentralFetcher->setBaseUri($extconf['evecentralUri']);

        $this->updateItemsBasedOnSystemId();

        $this->updateItemsBasedOnRegionId();

        /** @var $persistenceManager \TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager */
        $persistenceManager = $objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager');
        $persistenceManager->persistAll();
    }

    /**
     * Update out of date EVE items on base of region id
     */
    protected function updateItemsBasedOnRegionId() {
        foreach ($this->eveItemRepository->getListOfUniqueRegionId() as $regionId) {
            // get out dated items
            $listOfOutdatedItems = $this->getListOfOutdatedItemsForRegion($regionId);

            // fetch current values for this items
            $newValuesForDb = $this->fetchUpdateableItemsForRegion($listOfOutdatedItems, $regionId);

            // update database
            $this->updateEveItemsForRegion($newValuesForDb, $regionId);
        }
    }

    /**
     * Update out date EVE items on base of system id
     */
    protected function updateItemsBasedOnSystemId() {
        foreach ($this->eveItemRepository->getListOfUniqueSystemId() as $systemId) {
            // get out dated items
            $listOfOutdatedItems = $this->getListOfOutdatedItemsForSystem($systemId);

            // fetch current values for this items
            $newValuesForDb = $this->fetchUpdateableItemsForSystem($listOfOutdatedItems, $systemId);

            // update database
            $this->updateEveItemsForSystem($newValuesForDb, $systemId);
        }
    }

    /**
     * Get list of out dated EVE items for a specific region
     *
     * @param \integer $regionId
     * @return array
     */
    protected function getListOfOutdatedItemsForRegion($regionId) {
        $fetchList = [];

        if (($regionId == null) || ($regionId == 0)) {
            return $fetchList;
        }

        foreach ($this->eveItemRepository->findAllUpdateableItemsForRegion($regionId) as $entry) {
            $fetchList[] = $entry->getEveId();
        }
        return $fetchList;
    }

    /**
     * Get list of out dated EVE items for a specific system
     *
     * @param \integer $systemId
     * @return array
     */
    protected function getListOfOutdatedItemsForSystem($systemId) {
        $fetchList = [];

        if (($systemId == null) || ($systemId == 0)) {
            return $fetchList;
        }

        foreach ($this->eveItemRepository->findAllUpdateableItemsForSystem($systemId) as $entry) {
            $fetchList[] = $entry->getEveId();
        }
        return $fetchList;
    }

    /**
     * Fetch current EVE item values for a specific region
     *
     * @param array $fetchList
     * @param \integer $regionId
     * @return array
     */
    protected function fetchUpdateableItemsForRegion($fetchList, $regionId) {

        if ((count($fetchList) == 0) || ($regionId == null) || ($regionId == 0)) {
            return [];
        }

        $this->eveCentralFetcher->setRegionId($regionId);
        $this->eveCentralFetcher->setTypeIds($fetchList);
        $result = $this->eveCentralFetcher->query();

        return $result;
    }

    /**
     * Fetch current EVE item values for a specific system
     *
     * @param array $fetchList
     * @param \integer $systemId
     * @return array
     */
    protected function fetchUpdateableItemsForSystem($fetchList, $systemId) {

        if ((count($fetchList) == 0) || ($systemId == null) || ($systemId == 0)) {
            return [];
        }

        $this->eveCentralFetcher->setSystemId($systemId);
        $this->eveCentralFetcher->setTypeIds($fetchList);
        $result = $this->eveCentralFetcher->query();

        return $result;
    }

    /**
     * Update changed EVE items with new values
     *
     * @param array $eveItemUpdateList
     * @param \integer $regionId
     */
    protected function updateEveItemsForRegion($eveItemUpdateList, $regionId) {

        if ((count($eveItemUpdateList) == 0) || ($regionId == null) || $regionId == 0) {
            return;
        }

        foreach ($eveItemUpdateList as $eveId => $values) {
            foreach ($this->eveItemRepository->findByEveIdAndRegionId($eveId, $regionId) as $dbEntry) {
                $dbEntry->setBuyPrice($values['buy']);
                $dbEntry->setSellPrice($values['sell']);
                $dbEntry->setCacheTime(time());
                $this->eveItemRepository->update($dbEntry);
            }
        }
    }

    /**
     * Update changed EVE items with new values
     *
     * @param array $eveItemUpdateList
     * @param \integer $systemId
     */
    protected function updateEveItemsForSystem($eveItemUpdateList, $systemId) {

        if ((count($eveItemUpdateList) == 0) || ($systemId == null) || $systemId == 0) {
            return;
        }

        foreach ($eveItemUpdateList as $eveId => $values) {
            foreach ($this->eveItemRepository->findByEveIdAndSystemId($eveId, $systemId) as $dbEntry) {
                $dbEntry->setBuyPrice($values['buy']);
                $dbEntry->setSellPrice($values['sell']);
                $dbEntry->setCacheTime(time());
                $this->eveItemRepository->update($dbEntry);
            }
        }
    }

    /**
     * Public method, called by scheduler.
     *
     * @return boolean TRUE on success
     */
    public function execute() {
        $this->updateEveItemList();

        return true;
    }

}
