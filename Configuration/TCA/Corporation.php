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

$TCA['tx_evecorp_domain_model_corporation'] = array(
    'ctrl' => $TCA['tx_evecorp_domain_model_corporation']['ctrl'],
    'interface' => array(
        'showRecordFieldList' => 'hidden, corporation_name, corporation_id, current_alliance',
    ),
    'types' => array(
        '1' => array('showitem' => 'hidden, corporation_name, corporation_id, current_alliance, usergroup, apikeys, titles'),
    ),
    'palettes' => array(
        '1' => array('showitem' => ''),
    ),
    'columns' => array(
        'hidden' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
            'config' => array(
                'type' => 'check'
            ),
        ),
        'corporation_id' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:evecorp/Resources/Private/Language/locallang_db.xlf:tx_evecorp_domain_model_corporation.corporation_id',
            'config' => array(
                'type' => 'input',
                'size' => 10,
                'eval' => 'trim,int,required',
            ),
        ),
        'corporation_name' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:evecorp/Resources/Private/Language/locallang_db.xlf:tx_evecorp_domain_model_corporation.corporation_name',
            'config' => array(
                'type' => 'input',
                'size' => 32,
                'eval' => 'trim,required',
            )
        ),
        'current_alliance' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:evecorp/Resources/Private/Language/locallang_db.xlf:tx_evecorp_domain_model_alliance',
            'config' => array(
                'type' => 'select',
                'foreign_table' => 'tx_evecorp_domain_model_alliance',
                'items' => array(
                    array('--none--', 0),
                ),
            ),
        ),
        'usergroup' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:evecorp/Resources/Private/Language/locallang_db.xlf:tx_evecorp_domain_model_corporation.usergroup',
            'config' => array(
                'type' => 'select',
                'foreign_table' => 'fe_groups',
                'items' => array(
                    array('--none--', 0),
                )
            ),
        ),
        'apikeys' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:evecorp/Resources/Private/Language/locallang_db.xlf:tx_evecorp_domain_model_apikey.corporation',
            'config' => array(
                'type' => 'inline',
                'foreign_table' => 'tx_evecorp_domain_model_apikeycorporation',
                'foreign_field' => 'corporation',
            ),
        ),
        'titles' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:evecorp/Resources/Private/Language/locallang_db.xlf:tx_evecorp_domain_model_corporation.titles',
            'config' => array(
                'type' => 'inline',
                'foreign_table' => 'tx_evecorp_domain_model_corporationtitle',
                'foreign_field' => 'corporation',
            ),
        ),
    ),
);
