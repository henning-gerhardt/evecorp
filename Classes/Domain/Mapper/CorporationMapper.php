<?php
namespace Gerh\Evecorp\Domain\Mapper;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014 Henning Gerhardt
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
class CorporationMapper {

	/**
	 * @var \Gerh\Evecorp\Domain\Repository\AllianceRepository
	 */
	protected $allianceRepository;

	/**
	 * @var \Gerh\Evecorp\Domain\Repository\CorporationRepository
	 */
	protected $corporationRepository;

	/**
	 * @var \TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager
	 */
	protected $persistenceManager;

	/**
	 * Returns alliance model by alliance id
	 *
	 * @param \integer $allianceId
	 * @param \string $allianceName
	 * @return \Gerh\Evecorp\Domain\Model\Alliance | NULL
	 */
	protected function getAllianceModel($allianceId, $allianceName) {
		if ($allianceId > 0) {
			$searchResult = $this->allianceRepository->findOneByAllianceId($allianceId);
			if ($searchResult) {
				$alliance = $searchResult;
			} else {
				$alliance = new \Gerh\Evecorp\Domain\Model\Alliance($allianceId, $allianceName);
				$this->allianceRepository->add($alliance);
				$this->persistenceManager->persistAll();
			}
		} else {
			$alliance = NULL;
		}

		return $alliance;
	}

	/**
	 * class constructor
	 */
	public function __construct() {
		$objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
		$this->allianceRepository = $objectManager->get('Gerh\\Evecorp\\Domain\\Repository\\AllianceRepository');
		$this->corporationRepository = $objectManager->get('Gerh\\Evecorp\\Domain\\Repository\\CorporationRepository');
		$this->persistenceManager = $objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager');
	}

	/**
	 * Returns corporatoin model of given corporation id with data from CCP
	 *
	 * @param \integer $corporationId
	 * @return \Gerh\Evecorp\Domain\Model\Corporation
	 */
	public function getCorporationModelFromCorporationId($corporationId) {
		$phealService = new \Gerh\Evecorp\Service\PhealService();
		$pheal = $phealService->getPhealInstance();

		$response = $pheal->corpScope->CorporationSheet(array('CorporationID' => $corporationId));

		$corporation = new \Gerh\Evecorp\Domain\Model\Corporation();
		$corporation->setCorporationId($response->corporationID);
		$corporation->setCorporationName($response->corporationName);

		$alliance = $this->getAllianceModel($response->allianceID, $response->allianceName);
		if ($alliance !== NULL) {
			$corporation->setCurrentAlliance($alliance);
		}

		$this->corporationRepository->add($corporation);
		$this->persistenceManager->persistAll();

		return $corporation;
	}

	/**
	 * Set alliance repository from outside
	 *
	 * @param \Gerh\Evecorp\Domain\Repository\AllianceRepository $repository
	 */
	public function setAllianceRepository(\Gerh\Evecorp\Domain\Repository\AllianceRepository $repository) {
		$this->allianceRepository = $repository;
	}

	/**
	 * Set alliance repository from outside
	 *
	 * @param \Gerh\Evecorp\Domain\Repository\CorporationRepository $repository
	 */
	public function setCorporationRepository(\Gerh\Evecorp\Domain\Repository\CorporationRepository $repository) {
		$this->corporationRepository = $repository;
	}

}
