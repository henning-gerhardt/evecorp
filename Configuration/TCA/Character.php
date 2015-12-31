<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$TCA['tx_evecorp_domain_model_character'] = array(
	'ctrl' => $TCA['tx_evecorp_domain_model_character']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'character_name, character_id, hidden',
	),
	'types' => array(
		'1' => array('showitem' => 'character_name, character_id, current_corporation, employments, race, security_status, api_key, corp_member, titles, hidden'),
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
			),
		),
		'api_key' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:evecorp/Resources/Private/Language/locallang_db.xlf:tx_evecorp_domain_model_apikey.account',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_evecorp_domain_model_apikeyaccount',
				'items' => array(
					array('--none--', 0),
				),
			),
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
		'character_name' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:evecorp/Resources/Private/Language/locallang_db.xlf:tx_evecorp_domain_model_character.character_name',
			'config' => array(
				'type' => 'input',
				'size' => 64,
				'eval' => 'trim,required',
			),
		),
		'character_id' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:evecorp/Resources/Private/Language/locallang_db.xlf:tx_evecorp_domain_model_character.character_id',
			'config' => array(
				'type' => 'input',
				'size' => 10,
				'eval' => 'trim,int,required'
			),
		),
		'current_corporation' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:evecorp/Resources/Private/Language/locallang_db.xlf:tx_evecorp_domain_model_corporation',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_evecorp_domain_model_corporation',
				'items' => array(
					array('--none--', 0),
				),
			),
		),
		'employments' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:evecorp/Resources/Private/Language/locallang_db.xlf:tx_evecorp_domain_model_employmenthistory',
			'config' => array(
				'type' => 'inline',
				'foreign_table' => 'tx_evecorp_domain_model_employmenthistory',
				'foreign_field' => 'character_uid',
				'appearance' => array(
					'levelLinksPosition' => 'none',
				),
			),
		),
		'race' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:evecorp/Resources/Private/Language/locallang_db.xlf:tx_evecorp_domain_model_character.race',
			'config' => array(
				'type' => 'input',
				'size' => 20,
				'eval' => 'trim'
			),
		),
		'security_status' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:evecorp/Resources/Private/Language/locallang_db.xlf:tx_evecorp_domain_model_character.security_status',
			'config' => array(
				'type' => 'input',
				'size' => 20,
				'eval' => 'trim',
				'default' => '0.00000000000000',
			),
		),
		'titles' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:evecorp/Resources/Private/Language/locallang_db.xlf:tx_evecorp_domain_model_corporation_title',
			'config' => array(
				'type' => 'select',
				'size' => 10,
				'minitems' => 0,
				'multiple' => TRUE,
				'maxitems' => 9999,
				'autoSizeMax' => 5,
				'foreign_table' => 'tx_evecorp_domain_model_corporationtitle',
				'foreign_table_where' => ' AND tx_evecorp_domain_model_corporationtitle.corporation=###REC_FIELD_current_corporation###',
				'MM' => 'tx_evecorp_domain_model_corporationtitle_character_mm',
				'MM_hasUidField' => TRUE,
				'MM_opposite_field' => 'characters', // only needed on one side of n:m relation
			),
		),
	),
);
