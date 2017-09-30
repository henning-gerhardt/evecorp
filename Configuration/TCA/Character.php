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

$TCA['tx_evecorp_domain_model_character'] = [
    'ctrl' => $TCA['tx_evecorp_domain_model_character']['ctrl'],
    'interface' => [
        'showRecordFieldList' => 'character_name, character_id, hidden',
    ],
    'types' => [
        '1' => [
            'showitem' => 'character_name, character_id, corporation_date, current_corporation, employments, race, security_status, api_key, corp_member, titles, hidden'
        ],
    ],
    'palettes' => [
        '1' => [
            'showitem' => ''
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
        'api_key' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:evecorp/Resources/Private/Language/locallang_db.xlf:tx_evecorp_domain_model_apikey.account',
            'config' => [
                'type' => 'select',
                'foreign_table' => 'tx_evecorp_domain_model_apikeyaccount',
                'items' => [
                    ['--none--', 0],
                ],
            ],
        ],
        'corp_member' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:evecorp/Resources/Private/Language/locallang_db.xlf:tx_evecorp_domain_model_apikey.account.corpmember',
            'config' => [
                'type' => 'select',
                'foreign_table' => 'fe_users',
                'items' => [
                    ['--none--', 0],
                ],
            ],
        ],
        'character_name' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:evecorp/Resources/Private/Language/locallang_db.xlf:tx_evecorp_domain_model_character.character_name',
            'config' => [
                'type' => 'input',
                'size' => 64,
                'eval' => 'trim,required',
            ],
        ],
        'character_id' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:evecorp/Resources/Private/Language/locallang_db.xlf:tx_evecorp_domain_model_character.character_id',
            'config' => [
                'type' => 'input',
                'size' => 10,
                'eval' => 'trim,int,required'
            ],
        ],
        'corporation_date' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:evecorp/Resources/Private/Language/locallang_db.xlf:tx_evecorp_domain_model_employmenthistory.start_date',
            'config' => [
                'type' => 'input',
                'size' => 16,
                'eval' => 'trim,datetime,required'
            ],
        ],
        'current_corporation' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:evecorp/Resources/Private/Language/locallang_db.xlf:tx_evecorp_domain_model_corporation',
            'config' => [
                'type' => 'select',
                'foreign_table' => 'tx_evecorp_domain_model_corporation',
                'items' => [
                    ['--none--', 0],
                ],
            ],
        ],
        'employments' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:evecorp/Resources/Private/Language/locallang_db.xlf:tx_evecorp_domain_model_employmenthistory',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_evecorp_domain_model_employmenthistory',
                'foreign_field' => 'character_uid',
                'appearance' => [
                    'levelLinksPosition' => 'none',
                ],
            ],
        ],
        'race' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:evecorp/Resources/Private/Language/locallang_db.xlf:tx_evecorp_domain_model_character.race',
            'config' => [
                'type' => 'input',
                'size' => 20,
                'eval' => 'trim'
            ],
        ],
        'security_status' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:evecorp/Resources/Private/Language/locallang_db.xlf:tx_evecorp_domain_model_character.security_status',
            'config' => [
                'type' => 'input',
                'size' => 20,
                'eval' => 'trim',
                'default' => '0.00000000000000',
            ],
        ],
        'titles' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:evecorp/Resources/Private/Language/locallang_db.xlf:tx_evecorp_domain_model_corporation_title',
            'config' => [
                'type' => 'select',
                'size' => 10,
                'minitems' => 0,
                'multiple' => TRUE,
                'maxitems' => 9999,
                'autoSizeMax' => 5,
                'foreign_table' => 'tx_evecorp_domain_model_corporationtitle',
                'foreign_table_where' => ' AND tx_evecorp_domain_model_corporationtitle.corporation=###REC_FIELD_current_corporation###',
                'MM' => 'tx_evecorp_domain_model_corporationtitle_character_mm',
                'MM_hasUidField' => TRUE,
                'MM_opposite_field' => 'characters', // only needed on one side of n:m relation
            ],
        ],
    ],
];
