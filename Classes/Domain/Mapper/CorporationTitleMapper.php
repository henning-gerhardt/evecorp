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

namespace Gerh\Evecorp\Domain\Mapper;

/**
 *
 *
 * @package evecorp
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class CorporationTitleMapper {

    /**
     *
     * @var \Gerh\Evecorp\Domain\Model\ApiKeyCorporation
     */
    private $corporationApiKey;

    /**
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Gerh\Evecorp\Domain\Model\CorporationTitle>
     */
    private $corporationTitles;

    /**
     * map data and attach it to object store
     *
     * @param \Pheal\Core\RowSet $titleObjects
     */
    protected function mapRetrievedInformation(\Pheal\Core\RowSet $titleObjects) {

        foreach ($titleObjects as $retrievedTitle) {
            $corporationTitle = new \Gerh\Evecorp\Domain\Model\CorporationTitle();
            $corporationTitle->setCorporation($this->corporationApiKey->getCorporation());
            $corporationTitle->setTitleId(intval($retrievedTitle->titleID));
            // strip every html tags (used for coloring titles)
            $corporationTitle->setTitleName(strip_tags($retrievedTitle->titleName));
            $this->corporationTitles->attach($corporationTitle);
        }
    }

    /**
     * class constuctor
     *
     * @param \Gerh\Evecorp\Domain\Model\ApiKeyCorporation $corporationApiKey
     */
    public function __construct(\Gerh\Evecorp\Domain\Model\ApiKeyCorporation $corporationApiKey) {
        $this->corporationApiKey = $corporationApiKey;
        $this->corporationTitles = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }

    /**
     * fetch corporation titles from CCP
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
     */
    public function fetchCorporationTitles() {
        try {
            $phealService = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
                            'Gerh\\Evecorp\\Service\\PhealService', $this->corporationApiKey->getKeyId(), $this->corporationApiKey->getVCode()
            );
            $pheal = $phealService->getPhealInstance();

            $response = $pheal->corpScope->Titles();
            $this->mapRetrievedInformation($response->titles);
        } catch (\Pheal\Exceptions\PhealException $ex) {
            // TODO: handle exception usage
        }

        return $this->corporationTitles;
    }

}
