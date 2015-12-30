<?php

/***************************************************************
 * Copyright notice
 *
 * (c) 2015 Henning Gerhardt
 *
 * All rights reserved
 *
 * This script is part of the TYPO3 project. The TYPO3 project is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 *
 * This script is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

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
					'Gerh\\Evecorp\\Service\\PhealService',
					$this->corporationApiKey->getKeyId(),
					$this->corporationApiKey->getVCode()
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
