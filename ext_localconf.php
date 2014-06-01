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
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks']['Gerh\\Evecorp\\Task\\UpdateEveItemListTask'] = array(
	'extension' => $_EXTKEY,
	'title' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang.xlf:task.updateEveItemListTask.name',
	'description' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang.xlf:task.updateEveItemListTask.description',
	'additionalFields' => '',
);

// Register Account API Key update task
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks']['Gerh\\Evecorp\\Task\\UpdateApiKeyAccountTask'] = array(
	'extension' => $_EXTKEY,
	'title' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang.xlf:task.updateApiKeyAccountTask.name',
	'description' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang.xlf:task.updateApiKeyAccountTask.description',
	'additionalFields' => '',
);

// Register Corp member user group update task
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks']['Gerh\\Evecorp\\Task\\UpdateCorpMemberUserGroupsTask'] = array(
	'extension' => $_EXTKEY,
	'title' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang.xlf:task.updateCorpMemberUserGroupsTask.name',
	'description' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang.xlf:task.updateCorpMemberUserGroupsTask.description',
	'additionalFields' => '',
);

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['extbase']['commandControllers'][] = 'Gerh\\Evecorp\\Task\\CorpMemberUserGroupCommandController';