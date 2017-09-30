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

$TCA['tx_evecorp_domain_model_eveitem'] = [
    'ctrl' => $TCA['tx_evecorp_domain_model_eveitem']['ctrl'],
    'interface' => [
        'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, eve_name, eve_id',
    ],
    'types' => [
        '1' => [
            'showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1, eve_name, eve_id, solar_system, region, time_to_cache,--div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.access,starttime, endtime'
        ],
    ],
    'palettes' => [
        '1' => [
            'showitem' => ''
        ],
    ],
    'columns' => [
        'sys_language_uid' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.language',
            'config' => [
                'type' => 'select',
                'foreign_table' => 'sys_language',
                'foreign_table_where' => 'ORDER BY sys_language.title',
                'items' => [
                    ['LLL:EXT:lang/locallang_general.xlf:LGL.allLanguages', -1],
                    ['LLL:EXT:lang/locallang_general.xlf:LGL.default_value', 0]
                ],
            ],
        ],
        'l10n_parent' => [
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.l18n_parent',
            'config' => [
                'type' => 'select',
                'items' => [
                    ['', 0],
                ],
                'foreign_table' => 'tx_evecorp_domain_model_eveitem',
                'foreign_table_where' => 'AND tx_evecorp_domain_model_eveitem.pid=###CURRENT_PID### AND tx_evecorp_domain_model_eveitem.sys_language_uid IN (-1,0)',
            ],
        ],
        'l10n_diffsource' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        't3ver_label' => [
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.versionLabel',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'max' => 255,
            ]
        ],
        'hidden' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
            'config' => [
                'type' => 'check',
            ],
        ],
        'starttime' => [
            'exclude' => 1,
            'l10n_mode' => 'mergeIfNotBlank',
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.starttime',
            'config' => [
                'type' => 'input',
                'size' => 13,
                'max' => 20,
                'eval' => 'datetime',
                'checkbox' => 0,
                'default' => 0,
                'range' => [
                    'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
                ],
            ],
        ],
        'endtime' => [
            'exclude' => 1,
            'l10n_mode' => 'mergeIfNotBlank',
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.endtime',
            'config' => [
                'type' => 'input',
                'size' => 13,
                'max' => 20,
                'eval' => 'datetime',
                'checkbox' => 0,
                'default' => 0,
                'range' => [
                    'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
                ],
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
