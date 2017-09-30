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
        $collected = [];
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
