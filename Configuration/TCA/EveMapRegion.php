<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$TCA['tx_evecorp_domain_model_evemapregion'] = array(
	'ctrl' => $TCA['tx_evecorp_domain_model_evemapregion']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'region_id, region_name, hidden',
	),
	'types' => array(
		'1' => array('showitem' => 'region_id, region_name, hidden'),
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
		'region_id' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:evecorp/Resources/Private/Language/locallang_db.xlf:tx_evecorp_domain_model_evemapregion.region_id',
			'config'  => array(
				'type' => 'input',
				'size' => '10',
				'eval' => 'trim,int,required',
			)
		),
		'region_name' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:evecorp/Resources/Private/Language/locallang_db.xlf:tx_evecorp_domain_model_evemapregion.region_name',
			'config'  => array(
				'type' => 'input',
				'size' => '20',
				'eval' => 'trim,required',
				'max'  => '256'
			)
		),
	),
);
