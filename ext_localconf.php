<?php
if (!defined ('TYPO3_MODE')) {
    die ('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'gerh.' . $_EXTKEY,
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
    'gerh.' . $_EXTKEY,
    'Pi2',
    array(
        'ServerStatus' => 'index',
    ),
    // non-cacheable actions
    array(
        'ServerStatus' => 'index',
    )
);

// Register EVE item list update task
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks']['gerh\\Evecorp\\Task\\UpdateEveItemListTask'] = array(
	'extension' => $_EXTKEY,
	'title' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang.xlf:task.updateEveItemListTask.name',
	'description' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang.xlf:task.updateEveItemListTask.description',
	'additionalFields' => '',
);
