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

$TCA['tx_evecorp_domain_model_evemapsolarsystem'] = array(
    'ctrl' => $TCA['tx_evecorp_domain_model_evemapsolarsystem']['ctrl'],
    'interface' => array(
        'showRecordFieldList' => 'solar_system_id, solar_system_name, hidden',
    ),
    'types' => array(
        '1' => array('showitem' => 'solar_system_id, solar_system_name, hidden'),
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
            )
        ),
        'solar_system_id' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:evecorp/Resources/Private/Language/locallang_db.xlf:tx_evecorp_domain_model_evemapsolarsystem.solar_system_id',
            'config' => array(
                'type' => 'input',
                'size' => '10',
                'eval' => 'trim,int,required',
            )
        ),
        'solar_system_name' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:evecorp/Resources/Private/Language/locallang_db.xlf:tx_evecorp_domain_model_evemapsolarsystem.solar_system_name',
            'config' => array(
                'type' => 'input',
                'size' => '20',
                'eval' => 'trim,required',
                'max' => '256'
            )
        ),
    ),
);
