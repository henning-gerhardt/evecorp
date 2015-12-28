<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$TCA['tx_evecorp_domain_model_corporation_title'] = array(
	'ctrl' => $TCA['tx_evecorp_domain_model_corporation_title']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'title_id, title_name, corporation, hidden',
	),
	'types' => array(
		'1' => array('showitem' => 'title_id, title_name, corporation, usergroup, hidden'),
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
		'title_id' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:evecorp/Resources/Private/Language/locallang_db.xlf:tx_evecorp_domain_model_corporation_title.titleid',
			'config' => array(
				'type' => 'input',
				'size' => 10,
				'eval' => 'trim,int,required,unique'
			)
		),
		'title_name' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:evecorp/Resources/Private/Language/locallang_db.xlf:tx_evecorp_domain_model_corporation_title.titlename',
			'config' => array(
				'type' => 'input',
				'eval' => 'trim,required'
			)
		),
		'corporation' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:evecorp/Resources/Private/Language/locallang_db.xlf:tx_evecorp_domain_model_corporation',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_evecorp_domain_model_corporation',
			),
		),
		'usergroup' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:evecorp/Resources/Private/Language/locallang_db.xlf:tx_evecorp_domain_model_corporation.usergroup',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'fe_groups',
				'items' => array(
					array('--none--', 0),
				)
			),
		),
	),
);
