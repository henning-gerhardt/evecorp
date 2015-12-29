<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$TCA['tx_evecorp_domain_model_apikeycorporation'] = array(
	'ctrl' => $TCA['tx_evecorp_domain_model_apikeycorporation']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'key_id, v_code, corporation, hidden',
	),
	'types' => array(
		'1' => array('showitem' => 'corporation, key_id, v_code, type, access_mask, expires, hidden'),
	),
	'palettes' => array(
		'1' => array('showitem' => ''),
	),
	'columns' => array(
		'hidden' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
			'config'  => array(
				'type' => 'check'
			)
		),
		'key_id' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:evecorp/Resources/Private/Language/locallang_db.xlf:tx_evecorp_domain_model_apikey.keyid',
			'config' => array(
				'type' => 'input',
				'size' => 10,
				'eval' => 'trim,int,required,unique'
			)
		),
		'v_code' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:evecorp/Resources/Private/Language/locallang_db.xlf:tx_evecorp_domain_model_apikey.vcode',
			'config' => array(
				'type' => 'input',
				'size' => 64,
				'eval' => 'trim,required'
			)
		),
		'access_mask' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:evecorp/Resources/Private/Language/locallang_db.xlf:tx_evecorp_domain_model_apikey.accessmask',
			'config' => array(
				'type' => 'none',
			),
		),
		'expires' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:evecorp/Resources/Private/Language/locallang_db.xlf:tx_evecorp_domain_model_apikey.expires',
			'config' => array(
				'type' => 'none',
				'format' => 'date',
				'format.' => array(
					'strftime' => FALSE,
					'option' => 'Y-m-d H:i:s e'
				),
			),
		),
		'corporation' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:evecorp/Resources/Private/Language/locallang_db.xlf:tx_evecorp_domain_model_corporation',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_evecorp_domain_model_corporation',
			),
		),
	),
);