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

return [
    'ctrl' => [
        'title' => 'LLL:EXT:evecorp/Resources/Private/Language/locallang_db.xlf:tx_evecorp_domain_model_eveitem',
        'label' => 'eve_name',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'dividers2tabs' => TRUE,
        'sortby' => 'sorting',
        'versioningWS' => 2,
        'versioning_followPages' => TRUE,
        'origUid' => 't3_origuid',
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ],
        'searchFields' => 'eve_name,eve_id,',
        'iconfile' => 'EXT:evecorp/Resources/Public/Icons/tx_evecorp_domain_model_eveitem.gif'
    ],
    'interface' => [
        'showRecordFieldList' => 'eve_name, eve_id, hidden',
    ],
    'types' => [
        '1' => [
            'showitem' => 'eve_name, eve_id, solar_system, region, time_to_cache, hidden'
        ],
    ],
    'columns' => [
        'hidden' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
            'config' => [
                'type' => 'check',
            ],
        ],
        'eve_name' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:evecorp/Resources/Private/Language/locallang_db.xlf:tx_evecorp_domain_model_eveitem.eve_name',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required'
            ],
        ],
        'eve_id' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:evecorp/Resources/Private/Language/locallang_db.xlf:tx_evecorp_domain_model_eveitem.eve_id',
            'config' => [
                'type' => 'input',
                'size' => 10,
                'eval' => 'int,required',
                'range' => [
                    'lower' => 0
                ]
            ],
        ],
        'buy_price' => [
            'exclude' => 0,
            'label' => 'buy_price',
            'config' => [],
        ],
        'sell_price' => [
            'exclude' => 0,
            'label' => 'sell_price',
            'config' => [],
        ],
        'cache_time' => [
            'exclude' => 0,
            'label' => 'cache_time',
            'config' => [],
        ],
        'solar_system' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:evecorp/Resources/Private/Language/locallang_db.xlf:tx_evecorp_domain_model_eveitem.solarsystem',
            'readOnly' => 1,
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'tx_evecorp_domain_model_evemapsolarsystem',
                'size' => 1,
                'minitems' => 0,
                'maxitems' => 1,
                'disableNoMatchingValueElement' => 1,
                'items' => [
                    ['LLL:EXT:evecorp/Resources/Private/Language/locallang_db.xlf:tx_evecorp_domain_model_eveitem.solarsystem.noSolarSystemSelected', '0'],
                    ['', '--div--'],
                ],
                'wizards' => [
                    'suggest' => [
                        'type' => 'suggest',
                        'default' => [
                            'searchWholePhrase' => 1,
                        ],
                    ],
                ],
            ],
        ],
        'region' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:evecorp/Resources/Private/Language/locallang_db.xlf:tx_evecorp_domain_model_eveitem.region',
            'readOnly' => 1,
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'tx_evecorp_domain_model_evemapregion',
                'size' => 1,
                'minitems' => 0,
                'maxitems' => 1,
                'disableNoMatchingValueElement' => 1,
                'items' => [
                    ['LLL:EXT:evecorp/Resources/Private/Language/locallang_db.xlf:tx_evecorp_domain_model_eveitem.region.noRegionSelected', '0'],
                    ['', '--div--'],
                ],
                'wizards' => [
                    'suggest' => [
                        'type' => 'suggest',
                        'default' => [
                            'searchWholePhrase' => 1,
                        ],
                    ],
                ],
            ],
        ],
        'time_to_cache' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:evecorp/Resources/Private/Language/locallang_db.xlf:tx_evecorp_domain_model_eveitem.time_to_cache',
            'config' => [
                'type' => 'input',
                'size' => 10,
                'eval' => 'int,required',
                'default' => 5,
                'range' => [
                    'lower' => 1,
                ]
            ],
        ],
    ],
];