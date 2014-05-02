<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$TCA['tx_evecorp_domain_model_alliance'] = array(
	'ctrl' => $TCA['tx_evecorp_domain_model_alliance']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'hidden, alliance_name, alliance_id',
	),
	'types' => array(
		'1' => array('showitem' => 'hidden, alliance_name, alliance_id'),
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
		'alliance_id' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:evecorp/Resources/Private/Language/locallang_db.xlf:tx_evecorp_domain_model_alliance.alliance_id',
			'config' => array(
				'type' => 'input',
				'size' => 10,
				'eval' => 'trim,int,required',
			),
		),
		'alliance_name' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:evecorp/Resources/Private/Language/locallang_db.xlf:tx_evecorp_domain_model_alliance.alliance_name',
			'config' => array(
				'type' => 'input',
				'size' => 32,
				'eval' => 'trim,required',
			)
		),
	),
);
