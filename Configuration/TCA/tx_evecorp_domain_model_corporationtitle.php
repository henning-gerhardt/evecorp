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
        'title' => $localLangDb . ':tx_evecorp_domain_model_corporation_title',
        'label' => 'title_name',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden'
        ],
        'searchFields' => 'title_id, title_name',
        'iconfile' => 'EXT:evecorp/Resources/Public/Icons/tx_evecorp_domain_model_eveitem.gif'
    ],
    'interface' => [
        'showRecordFieldList' => 'title_id, title_name, corporation, hidden',
    ],
    'types' => [
        '1' => [
            'showitem' => 'title_id, title_name, corporation, usergroup, characters, hidden'
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
        'title_id' => [
            'exclude' => 0,
            'label' => $localLangDb . ':tx_evecorp_domain_model_corporation_title.titleid',
            'config' => [
                'type' => 'input',
                'eval' => 'trim,int,required'
            ]
        ],
        'title_name' => [
            'exclude' => 0,
            'label' => $localLangDb . ':tx_evecorp_domain_model_corporation_title.titlename',
            'config' => [
                'type' => 'input',
                'eval' => 'trim,required'
            ]
        ],
        'corporation' => [
            'exclude' => 0,
            'label' => $localLangDb . ':tx_evecorp_domain_model_corporation',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'tx_evecorp_domain_model_corporation',
            ],
        ],
        'usergroup' => [
            'exclude' => 0,
            'label' => $localLangDb . ':tx_evecorp_domain_model_corporation.usergroup',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'fe_groups',
                'items' => [
                    ['--none--', 0],
                ]
            ],
        ],
        'characters' => [
            'exclude' => 0,
            'label' => $localLangDb . ':tx_evecorp_domain_model_character',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectCheckBox',
                'size' => 10,
                'minitems' => 0,
                'multiple' => TRUE,
                'maxitems' => 9999,
                'autoSizeMax' => 5,
                'foreign_table' => 'tx_evecorp_domain_model_character',
                'foreign_table_where' => ' AND tx_evecorp_domain_model_character.current_corporation=###REC_FIELD_corporation###',
                'MM' => 'tx_evecorp_domain_model_corporationtitle_character_mm',
                'MM_hasUidField' => TRUE,
            ],
        ],
    ],
];
