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

if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Gerh.' . $_EXTKEY, 'Pi1', ['App' => 'index'], ['App' => 'index']
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Gerh.' . $_EXTKEY, 'Pi2', ['ServerStatus' => 'index'], ['ServerStatus' => 'index']
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Gerh.' . $_EXTKEY, 'Pi3', ['ApiKeyManagement' => 'index,new,create,delete,update', 'CharacterManagement' => 'show'], ['ApiKeyManagement' => 'index,new,create,delete,update', 'CharacterManagement' => 'show']
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Gerh.' . $_EXTKEY, 'Pi4', ['CorpMemberList' => 'showLight', 'CharacterManagement' => 'show'], []
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Gerh.' . $_EXTKEY, 'Pi5', ['ApiKeyCorporationManagement' => 'index,new,create,delete', 'CorporationTitleManagement' => 'index,fetch,edit,update', 'CorpMemberList' => 'index,update', 'CharacterManagement' => 'show'], ['ApiKeyCorporationManagement' => 'index,new,create,delete', 'CorporationTitleManagement' => 'index,fetch,edit,update', 'CorpMemberList' => 'index,update'
    ]
);

// Register EVE item list update task
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks']['Gerh\\Evecorp\\Scheduler\\UpdateEveItemListTask'] = [
    'extension' => $_EXTKEY,
    'title' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang.xlf:scheduler.updateEveItemListTask.name',
    'description' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang.xlf:scheduler.updateEveItemListTask.description',
    'additionalFields' => '',
];

// Register update corp member data based on account API key
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['extbase']['commandControllers'][] = 'Gerh\\Evecorp\\Scheduler\\ApiKeyAccountCommandController';

// Register update of user group membership for corp member
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['extbase']['commandControllers'][] = 'Gerh\\Evecorp\\Scheduler\\CorpMemberUserGroupCommandController';

// Register corporation member list updater
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['extbase']['commandControllers'][] = 'Gerh\\Evecorp\\Scheduler\\UpdateCorporationMemberListCommandController';
