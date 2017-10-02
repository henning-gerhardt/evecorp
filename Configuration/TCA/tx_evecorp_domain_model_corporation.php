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
        'title' => 'LLL:EXT:evecorp/Resources/Private/Language/locallang_db.xlf:tx_evecorp_domain_model_corporation',
        'label' => 'corporation_name',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden'
        ],
        'searchFields' => 'corporation_id, corporation_name',
        'iconfile' => 'EXT:evecorp/Resources/Public/Icons/tx_evecorp_domain_model_eveitem.gif'
    ],
    'interface' => [
        'showRecordFieldList' => 'hidden, corporation_name, corporation_id, current_alliance',
    ],
    'types' => [
        '1' => [
            'showitem' => 'hidden, corporation_name, corporation_id, current_alliance, usergroup, apikeys, titles'
        ],
    ],
    'columns' => [
        'hidden' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
            'config' => [
                'type' => 'check'
            ],
        ],
        'corporation_id' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:evecorp/Resources/Private/Language/locallang_db.xlf:tx_evecorp_domain_model_corporation.corporation_id',
            'config' => [
                'type' => 'input',
                'size' => 10,
                'eval' => 'trim,int,required',
            ],
        ],
        'corporation_name' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:evecorp/Resources/Private/Language/locallang_db.xlf:tx_evecorp_domain_model_corporation.corporation_name',
            'config' => [
                'type' => 'input',
                'size' => 32,
                'eval' => 'trim,required',
            ]
        ],
        'current_alliance' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:evecorp/Resources/Private/Language/locallang_db.xlf:tx_evecorp_domain_model_alliance',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'tx_evecorp_domain_model_alliance',
                'items' => [
                    ['--none--', 0],
                ],
            ],
        ],
        'usergroup' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:evecorp/Resources/Private/Language/locallang_db.xlf:tx_evecorp_domain_model_corporation.usergroup',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'fe_groups',
                'items' => [
                    ['--none--', 0],
                ]
            ],
        ],
        'apikeys' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:evecorp/Resources/Private/Language/locallang_db.xlf:tx_evecorp_domain_model_apikey.corporation',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_evecorp_domain_model_apikeycorporation',
                'foreign_field' => 'corporation',
            ],
        ],
        'titles' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:evecorp/Resources/Private/Language/locallang_db.xlf:tx_evecorp_domain_model_corporation.titles',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_evecorp_domain_model_corporationtitle',
                'foreign_field' => 'corporation',
            ],
        ],
    ],
];
