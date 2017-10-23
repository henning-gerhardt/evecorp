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
        'title' => 'LLL:EXT:evecorp/Resources/Private/Language/locallang_db.xlf:tx_evecorp_domain_model_apikey.corporation',
        'label' => 'key_id',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden'
        ],
        'searchFields' => 'key_id, v_code',
        'iconfile' => 'EXT:evecorp/Resources/Public/Icons/tx_evecorp_domain_model_eveitem.gif'
    ],
    'interface' => [
        'showRecordFieldList' => 'key_id, v_code, corporation, hidden',
    ],
    'types' => [
        '1' => [
            'showitem' => 'corporation, key_id, v_code, type, access_mask, expires, hidden'
        ],
    ],
    'columns' => [
        'hidden' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/Resources/Private/Language/locallang_general.xlf:LGL.hidden',
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
        'corporation' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:evecorp/Resources/Private/Language/locallang_db.xlf:tx_evecorp_domain_model_corporation',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'tx_evecorp_domain_model_corporation',
            ],
        ],
    ],
];
