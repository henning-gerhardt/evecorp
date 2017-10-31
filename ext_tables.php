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

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    $_EXTKEY, 'Pi1', 'EVE Market'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    $_EXTKEY, 'Pi2', 'EVE Server Status'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    $_EXTKEY, 'Pi3', 'EVE API Key Management'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    $_EXTKEY, 'Pi4', 'EVE Corporation Member List'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    $_EXTKEY, 'Pi5', 'EVE Corporation API Key Management'
);


$extensionName = strtolower(\TYPO3\CMS\Core\Utility\GeneralUtility::underscoredToUpperCamelCase($_EXTKEY));

// flex form for market plugin
$pluginSignature = $extensionName . '_' . strtolower('Pi1');
$TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/Index.xml');

// flex form for corporation member list plugin
$pluginSignature = $extensionName . '_' . strtolower('Pi4');
$TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/CorpMemberList.xml');

// flex form for corporation api key management
$pluginSignature = $extensionName . '_' . strtolower('Pi5');
$TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/ApiKeyCorporationManagement.xml');

// load static typoscript constants
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScript($_EXTKEY, 'constants', '<INCLUDE_TYPOSCRIPT: source="FILE:EXT:' . $_EXTKEY . '/Configuration/TypoScript/constants.txt">');

// load static typoscript setup
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScript($_EXTKEY, 'setup', '<INCLUDE_TYPOSCRIPT: source="FILE:EXT:' . $_EXTKEY . '/Configuration/TypoScript/setup.txt">');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_evecorp_domain_model_eveitem', 'EXT:evecorp/Resources/Private/Language/locallang_db.xlf');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_evecorp_domain_model_eveitem');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_evecorp_domain_model_evemapregion');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_evecorp_domain_model_evemapsolarsystem');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_evecorp_domain_model_apikeyaccount');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_evecorp_domain_model_apikeycorporation');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_evecorp_domain_model_alliance');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_evecorp_domain_model_corporation');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_evecorp_domain_model_corporationtitle');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_evecorp_domain_model_character');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_evecorp_domain_model_employmenthistory');

$feUsersExtendedColumns = [
    'characters' => [
        'exclude' => 0,
        'label' => 'LLL:EXT:evecorp/Resources/Private/Language/locallang_db.xlf:tx_evecorp_domain_model_character',
        'config' => [
            'type' => 'inline',
            'foreign_table' => 'tx_evecorp_domain_model_character',
            'foreign_field' => 'corp_member',
            'size' => 3,
            'appearance' => [
                'levelLinksPosition' => 'none',
            ],
        ],
    ],
    'api_keys' => [
        'exclude' => 0,
        'label' => 'LLL:EXT:evecorp/Resources/Private/Language/locallang_db.xlf:tx_evecorp_domain_model_apikey',
        'config' => [
            'type' => 'inline',
            'foreign_table' => 'tx_evecorp_domain_model_apikeyaccount',
            'foreign_field' => 'corp_member',
            'size' => 3,
            'appearance' => [
                'levelLinksPosition' => 'none',
            ],
        ],
    ],
    'eve_corp_groups' => [
        'exclude' => '0',
        'label' => 'LLL:EXT:evecorp/Resources/Private/Language/locallang_db.xlf:tx_evecorp_domain_model_corpmember.evecorpgroups',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectCheckBox',
            'foreign_table' => 'fe_groups',
            'foreign_table_where' => 'ORDER BY fe_groups.title',
            'size' => 5,
            'minitems' => 0,
            'maxitems' => 50,
        ],
    ],
];
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('fe_users', $feUsersExtendedColumns);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('fe_users', '--div--;EveCorp, characters, api_keys, eve_corp_groups');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTcaSelectItem('fe_users', 'tx_extbase_type', ['LLL:EXT:evecorp/Resources/Private/Language/locallang_db.xlf:Gerh_Evecorp_Domain_Model_CorpMember', 'Gerh\Evecorp\Domain\Model\CorpMember']);
