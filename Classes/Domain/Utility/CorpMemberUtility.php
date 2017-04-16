<?php

/* * *************************************************************
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
 * ************************************************************* */

namespace Gerh\Evecorp\Domain\Utility;

/**
 *
 *
 * @package evecorp
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class CorpMemberUtility {

    /**
     * Returns all frontend user groups from characters corporations
     *
     * @param \Gerh\Evecorp\Domain\Model\CorpMember $corpMember
     * @return array
     */
    protected function collectCorpGroups(\Gerh\Evecorp\Domain\Model\CorpMember $corpMember) {
        $collected = array();
        foreach ($corpMember->getCharacters() as $character) {
            $corpUserGroup = $character->getCurrentCorporation()->getUserGroup();
            if ((empty($corpUserGroup) === false) && (\array_key_exists($corpUserGroup->getUid(), $collected) === false)) {
                $collected[$corpUserGroup->getUid()] = $corpUserGroup;
            }

            /* @var $corpTitle \Gerh\Evecorp\Domain\Model\CorporationTitle */
            foreach ($character->getTitles() as $corpTitle) {
                $corpTitleGroup = $corpTitle->getUsergroup();
                if ((empty($corpTitleGroup) === \FALSE) && (\array_key_exists($corpTitleGroup->getUid(), $collected) === \FALSE)) {
                    $collected[$corpTitleGroup->getUid()] = $corpTitleGroup;
                }
            }
        }
        return $collected;
    }

    /**
     * Persistence changed corp member
     *
     * @param \Gerh\Evecorp\Domain\Model\CorpMember $corpMember
     */
    protected function persistenceCorpMember(\Gerh\Evecorp\Domain\Model\CorpMember $corpMember) {
        $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
        $corpMemberRepository = $objectManager->get('\\Gerh\\Evecorp\\Domain\\Repository\\CorpMemberRepository');
        $corpMemberRepository->update($corpMember);

        // real persistence to database
        $persistenceManager = $objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager');
        $persistenceManager->persistAll();
    }

    /**
     * Adjust corp member groups
     *
     * @param \Gerh\Evecorp\Domain\Model\CorpMember $corpMember
     */
    public function adjustFrontendUserGroups(\Gerh\Evecorp\Domain\Model\CorpMember $corpMember) {

        // persistence maybe pending changes
        $this->persistenceCorpMember($corpMember);

        $currentEveGroups = clone $corpMember->getEveCorpGroups();
        $collectedCorpUserGroups = $this->collectCorpGroups($corpMember);

        // add groups
        foreach ($collectedCorpUserGroups as $frontendUserGroup) {
            if ($currentEveGroups->contains($frontendUserGroup) === false) {
                $corpMember->addEveCorpGroup($frontendUserGroup);
            }
        }

        // remove groups
        foreach ($currentEveGroups as $frontendUserGroup) {
            if (\array_key_exists($frontendUserGroup->getUid(), $collectedCorpUserGroups) === false) {
                $corpMember->removeEveCorpGroup($frontendUserGroup);
            }
        }

        // persistence changed corp member information
        $this->persistenceCorpMember($corpMember);
    }

}
