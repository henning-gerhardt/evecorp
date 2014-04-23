<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$TCA['tx_evecorp_domain_model_apikey'] = array(
	'ctrl' => $TCA['tx_evecorp_domain_model_apikey']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'hidden',
	),
	'types' => array(
		'1' => array('showitem' => 'hidden'),
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
	),
);
