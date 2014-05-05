<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$TCA['tx_evecorp_domain_model_apikey'] = array(
	'ctrl' => $TCA['tx_evecorp_domain_model_apikey']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'key_id, v_code, corp_member, hidden',
	),
	'types' => array(
		'1' => array('showitem' => 'key_id, v_code, corp_member, type, access_mask, expires, characters, hidden'),
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
		'type' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:evecorp/Resources/Private/Language/locallang_db.xlf:tx_evecorp_domain_model_apikey.type',
			'config' => array(
				'type' => 'select',
				'items' => array(
					array('Account', 'Account'),
				),
			),
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
		'characters' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:evecorp/Resources/Private/Language/locallang_db.xlf:tx_evecorp_domain_model_character',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_evecorp_domain_model_character',
				'size' => 3,
				'readOnly' => 1,
			)
		)
	),
);
