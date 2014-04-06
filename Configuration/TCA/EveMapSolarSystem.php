<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
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
			'label'   => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
			'config'  => array(
				'type' => 'check'
			)
		),
		'solar_system_id' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:evecorp/Resources/Private/Language/locallang_db.xlf:tx_evecorp_domain_model_evemapsolarsystem.solar_system_id',
			'config'  => array(
				'type' => 'input',
				'size' => '10',
				'eval' => 'trim,int,required',
			)
		),
		'solar_system_name' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:evecorp/Resources/Private/Language/locallang_db.xlf:tx_evecorp_domain_model_evemapsolarsystem.solar_system_name',
			'config'  => array(
				'type' => 'input',
				'size' => '20',
				'eval' => 'trim,required',
				'max'  => '256'
			)
		),
	),
);
