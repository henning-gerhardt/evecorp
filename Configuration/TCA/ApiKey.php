<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$TCA['tx_evecorp_domain_model_apikey'] = array(
	'ctrl' => $TCA['tx_evecorp_domain_model_apikey']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'hidden, key_id, v_code, corp_member',
	),
	'types' => array(
		'1' => array('showitem' => 'hidden, key_id, v_code, corp_member'),
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
				'eval' => 'trim,int,required'
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
		'corp_member' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:evecorp/Resources/Private/Language/locallang_db.xlf:tx_evecorp_domain_model_apikey.corpmember',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'fe_users',
				'items' => array(
					array('--none--', 0),
				),
			),
		),
	),
);
