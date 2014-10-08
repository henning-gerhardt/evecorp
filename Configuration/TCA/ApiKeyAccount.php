<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$TCA['tx_evecorp_domain_model_apikeyaccount'] = array(
	'ctrl' => $TCA['tx_evecorp_domain_model_apikeyaccount']['ctrl'],
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
			'label' => 'LLL:EXT:evecorp/Resources/Private/Language/locallang_db.xlf:tx_evecorp_domain_model_apikey.account.corpmember',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'fe_users',
				'items' => array(
					array('--none--', 0),
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
				'type' => 'inline',
				'foreign_table' => 'tx_evecorp_domain_model_character',
				'foreign_field' => 'api_key',
				'maxitems' => 3,
				'appearance' => array(
					'levelLinksPosition' => 'none',
				),

			)
		)
	),
);