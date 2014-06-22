<?php
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
