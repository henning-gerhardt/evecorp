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

$TCA['tx_evecorp_domain_model_apikeyaccount'] = [
    'ctrl' => $TCA['tx_evecorp_domain_model_apikeyaccount']['ctrl'],
    'interface' => [
        'showRecordFieldList' => 'key_id, v_code, corp_member, hidden',
    ],
    'types' => [
        '1' => [
            'showitem' => 'key_id, v_code, corp_member, type, access_mask, expires, characters, hidden'
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
            ]
        ],
        'key_id' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:evecorp/Resources/Private/Language/locallang_db.xlf:tx_evecorp_domain_model_apikey.keyid',
            'config' => [
                'type' => 'input',
                'size' => 10,
                'eval' => 'trim,int,required,unique'
            ]
        ],
        'v_code' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:evecorp/Resources/Private/Language/locallang_db.xlf:tx_evecorp_domain_model_apikey.vcode',
            'config' => [
                'type' => 'input',
                'size' => 64,
                'eval' => 'trim,required'
            ]
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
        'access_mask' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:evecorp/Resources/Private/Language/locallang_db.xlf:tx_evecorp_domain_model_apikey.accessmask',
            'config' => [
                'type' => 'none',
            ],
        ],
        'expires' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:evecorp/Resources/Private/Language/locallang_db.xlf:tx_evecorp_domain_model_apikey.expires',
            'config' => [
                'type' => 'none',
                'format' => 'date',
                'format.' => [
                    'strftime' => FALSE,
                    'option' => 'Y-m-d H:i:s e'
                ],
            ],
        ],
        'characters' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:evecorp/Resources/Private/Language/locallang_db.xlf:tx_evecorp_domain_model_character',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_evecorp_domain_model_character',
                'foreign_field' => 'api_key',
                'maxitems' => 3,
                'appearance' => [
                    'levelLinksPosition' => 'none',
                ],
            ]
        ]
    ],
];
