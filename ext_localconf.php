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

if (!defined ('TYPO3_MODE')) {
    die ('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Gerh.' . $_EXTKEY,
    'Pi1',
    array(
        'App' => 'index'
    ),
    // non-cacheable actions
    array(
        'App' => 'index'
    )
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Gerh.' . $_EXTKEY,
    'Pi2',
    array(
        'ServerStatus' => 'index',
    ),
    // non-cacheable actions
    array(
        'ServerStatus' => 'index',
    )
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Gerh.' . $_EXTKEY,
    'Pi3',
    array(
        'ApiKeyManagement' => 'index,new,create,delete,update',
        'CharacterManagement' => 'show',
    ),
    // non-cacheable actions
    array(
        'ApiKeyManagement' => 'index,new,create,delete,update',
        'CharacterManagement' => 'show',
    )
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Gerh.' . $_EXTKEY,
    'Pi4',
    array(
        'CorpMemberList' => 'showLight',
        'CharacterManagement' => 'show',
    ),
    // non-cacheable actions
    array(
    )
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Gerh.' . $_EXTKEY,
    'Pi5',
    array(
        'ApiKeyCorporationManagement' => 'index,new,create,delete',
        'CorporationTitleManagement' => 'index,fetch,edit,update',
        'CorpMemberList' => 'index,update',
        'CharacterManagement' => 'show',
    ),
    // non-cacheable actions
    array(
        'ApiKeyCorporationManagement' => 'index,new,create,delete',
        'CorporationTitleManagement' => 'index,fetch,edit,update',
        'CorpMemberList' => 'index,update',
    )
);

// Register EVE item list update task
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks']['Gerh\\Evecorp\\Scheduler\\UpdateEveItemListTask'] = array(
    'extension' => $_EXTKEY,
    'title' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang.xlf:scheduler.updateEveItemListTask.name',
    'description' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang.xlf:scheduler.updateEveItemListTask.description',
    'additionalFields' => '',
);

// Register update corp member data based on account API key
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['extbase']['commandControllers'][] = 'Gerh\\Evecorp\\Scheduler\\ApiKeyAccountCommandController';

// Register update of user group membership for corp member
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['extbase']['commandControllers'][] = 'Gerh\\Evecorp\\Scheduler\\CorpMemberUserGroupCommandController';

// Register corporation member list updater
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['extbase']['commandControllers'][] = 'Gerh\\Evecorp\\Scheduler\\UpdateCorporationMemberListCommandController';
