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

$localLangDb = 'LLL:EXT:evecorp/Resources/Private/Language/locallang_db.xlf';

return [
    'ctrl' => [
        'title' => $localLangDb . ':tx_evecorp_domain_model_alliance',
        'label' => 'alliance_name',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden'
        ],
        'searchFields' => 'alliance_id, alliance_name',
        'iconfile' => 'EXT:evecorp/Resources/Public/Icons/tx_evecorp_domain_model_eveitem.gif'
    ],
    'interface' => [
        'showRecordFieldList' => 'hidden, alliance_name, alliance_id',
    ],
    'types' => [
        '1' => [
            'showitem' => 'hidden, alliance_name, alliance_id, corporations'
        ],
    ],
    'columns' => [
        'hidden' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/Resources/Private/Language/locallang_general.xlf:LGL.hidden',
            'config' => [
                'type' => 'check'
            ],
        ],
        'alliance_id' => [
            'exclude' => 0,
            'label' => $localLangDb . ':tx_evecorp_domain_model_alliance.alliance_id',
            'config' => [
                'type' => 'input',
                'size' => 10,
                'eval' => 'trim,int,required',
            ],
        ],
        'alliance_name' => [
            'exclude' => 0,
            'label' => $localLangDb . ':tx_evecorp_domain_model_alliance.alliance_name',
            'config' => [
                'type' => 'input',
                'size' => 32,
                'eval' => 'trim,required',
            ]
        ],
        'corporations' => [
            'exclude' => 0,
            'label' => $localLangDb . ':tx_evecorp_domain_model_alliance.corporation',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_evecorp_domain_model_corporation',
                'foreign_field' => 'current_alliance',
                'appearance' => [
                    'levelLinksPosition' => 'none',
                ],
            ]
        ],
    ],
];
