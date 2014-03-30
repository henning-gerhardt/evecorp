<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$TCA['tx_evecorp_domain_model_eveitem'] = array(
	'ctrl' => $TCA['tx_evecorp_domain_model_eveitem']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, eve_name, eve_id',
	),
	'types' => array(
		'1' => array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1, eve_name, eve_id, system_id, region_id, time_to_cache,--div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.access,starttime, endtime'),
	),
	'palettes' => array(
		'1' => array('showitem' => ''),
	),
	'columns' => array(
		'sys_language_uid' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.language',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => array(
					array('LLL:EXT:lang/locallang_general.xlf:LGL.allLanguages', -1),
					array('LLL:EXT:lang/locallang_general.xlf:LGL.default_value', 0)
				),
			),
		),
		'l10n_parent' => array(
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.l18n_parent',
			'config' => array(
				'type' => 'select',
				'items' => array(
					array('', 0),
				),
				'foreign_table' => 'tx_evecorp_domain_model_eveitem',
				'foreign_table_where' => 'AND tx_evecorp_domain_model_eveitem.pid=###CURRENT_PID### AND tx_evecorp_domain_model_eveitem.sys_language_uid IN (-1,0)',
			),
		),
		'l10n_diffsource' => array(
			'config' => array(
				'type' => 'passthrough',
			),
		),
		't3ver_label' => array(
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.versionLabel',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'max' => 255,
			)
		),
		'hidden' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
			'config' => array(
				'type' => 'check',
			),
		),
		'starttime' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.starttime',
			'config' => array(
				'type' => 'input',
				'size' => 13,
				'max' => 20,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => 0,
				'range' => array(
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				),
			),
		),
		'endtime' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.endtime',
			'config' => array(
				'type' => 'input',
				'size' => 13,
				'max' => 20,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => 0,
				'range' => array(
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				),
			),
		),
		'eve_name' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:evecorp/Resources/Private/Language/locallang_db.xlf:tx_evecorp_domain_model_eveitem.eve_name',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required'
			),
		),
		'eve_id' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:evecorp/Resources/Private/Language/locallang_db.xlf:tx_evecorp_domain_model_eveitem.eve_id',
			'config' => array(
				'type' => 'input',
				'size' => 10,
				'eval' => 'int,required',
				'range' => array(
					'lower' => 0
				)
			),
		),
		'buy_price' => array(
			'exclude' => 0,
			'label' => 'buy_price',
			'config' => array(),
		),
		'sell_price' => array(
			'exclude' => 0,
			'label' => 'sell_price',
			'config' => array(),
		),
		'cache_time' => array(
			'exclude' => 0,
			'label' => 'cache_time',
			'config' => array(),
		),
		'system_id' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:evecorp/Resources/Private/Language/locallang_db.xlf:tx_evecorp_domain_model_eveitem.system_id',
			'config' => array(
				'type' => 'input',
				'size' => 10,
				'eval' => 'int',
				'default' => 0,
				'range' => array(
					'lower' => 0,
				)
			),
		),
		'region_id' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:evecorp/Resources/Private/Language/locallang_db.xlf:tx_evecorp_domain_model_eveitem.region_id',
			'config' => array(
				'type' => 'input',
				'size' => 10,
				'eval' => 'int',
				'default' => 0,
				'range' => array(
					'lower' => 0,
				)
			),
		),
		'time_to_cache' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:evecorp/Resources/Private/Language/locallang_db.xlf:tx_evecorp_domain_model_eveitem.time_to_cache',
			'config' => array(
				'type' => 'input',
				'size' => 10,
				'eval' => 'int,required',
				'default' => 5,
				'range' => array(
					'lower' => 1,					
				)
			),
		),
	),
);

?>