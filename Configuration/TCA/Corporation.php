<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$TCA['tx_evecorp_domain_model_corporation'] = array(
	'ctrl' => $TCA['tx_evecorp_domain_model_corporation']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'hidden, corporation_name, corporation_id',
	),
	'types' => array(
		'1' => array('showitem' => 'hidden, corporation_name, corporaion_id'),
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
	),
);
