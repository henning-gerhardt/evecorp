<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$TCA['tx_evecorp_domain_model_employmenthistory'] = array(
	'ctrl' => $TCA['tx_evecorp_domain_model_employmenthistory']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'character_uid, hidden',
	),
	'types' => array(
		'1' => array('showitem' => 'character_uid, corporation_uid, start_date, record_id, hidden'),
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
		'character_uid' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:evecorp/Resources/Private/Language/locallang_db.xlf:tx_evecorp_domain_model_character',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_evecorp_domain_model_character',
				'items' => array(
					array('--none--', 0),
				),
			),
		),
		'corporation_uid' => array(
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
		'record_id' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:evecorp/Resources/Private/Language/locallang_db.xlf:tx_evecorp_domain_model_employmenthistory.record_id',
			'config' => array(
				'type' => 'input',
				'size' => 16,
				'eval' => 'trim,int,required'
			),
		),
		'start_date' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:evecorp/Resources/Private/Language/locallang_db.xlf:tx_evecorp_domain_model_employmenthistory.start_date',
			'config' => array(
				'type' => 'input',
				'size' => 16,
				'eval' => 'trim,datetime,required'
			),
		),
	),
);
