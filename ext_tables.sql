#
# Table structure for table 'tx_evecorp_domain_model_eveitem'
#
CREATE TABLE `tx_evecorp_domain_model_eveitem` (
	`uid` int(11) NOT NULL auto_increment,
	`pid` int(11) DEFAULT '0' NOT NULL,

	`eve_name` varchar(255) DEFAULT '' NOT NULL,
	`eve_id` int(11) DEFAULT '0' NOT NULL,
	`buy_price` decimal(20,3) DEFAULT '0.000' NOT NULL,
	`sell_price` decimal(20,3) DEFAULT '0.000' NOT NULL,
	`cache_time` int(11) DEFAULT '0' NOT NULL,
	`time_to_cache` int(11) DEFAULT '1' NOT NULL,
	`region` int(11) DEFAULT '0' NOT NULL,
	`solar_system` int(11) DEFAULT '0' NOT NULL,

	`tstamp` int(11) unsigned DEFAULT '0' NOT NULL,
	`crdate` int(11) unsigned DEFAULT '0' NOT NULL,
	`cruser_id` int(11) unsigned DEFAULT '0' NOT NULL,
	`deleted` tinyint(4) unsigned DEFAULT '0' NOT NULL,
	`hidden` tinyint(4) unsigned DEFAULT '0' NOT NULL,
	`starttime` int(11) unsigned DEFAULT '0' NOT NULL,
	`endtime` int(11) unsigned DEFAULT '0' NOT NULL,

	`t3ver_oid` int(11) DEFAULT '0' NOT NULL,
	`t3ver_id` int(11) DEFAULT '0' NOT NULL,
	`t3ver_wsid` int(11) DEFAULT '0' NOT NULL,
	`t3ver_label` varchar(255) DEFAULT '' NOT NULL,
	`t3ver_state` tinyint(4) DEFAULT '0' NOT NULL,
	`t3ver_stage` int(11) DEFAULT '0' NOT NULL,
	`t3ver_count` int(11) DEFAULT '0' NOT NULL,
	`t3ver_tstamp` int(11) DEFAULT '0' NOT NULL,
	`t3ver_move_id` int(11) DEFAULT '0' NOT NULL,
	`sorting` int(11) DEFAULT '0' NOT NULL,
	`t3_origuid` int(11) DEFAULT '0' NOT NULL,
	`sys_language_uid` int(11) DEFAULT '0' NOT NULL,
	`l10n_parent` int(11) DEFAULT '0' NOT NULL,
	`l10n_diffsource` mediumblob,

	PRIMARY KEY (`uid`),
	KEY parent (`pid`),
	KEY t3ver_oid (`t3ver_oid`,`t3ver_wsid`),
	KEY language (`l10n_parent`,`sys_language_uid`)
);

#
# Table structure for table 'tx_evecorp_domain_model_evemapregion'
#
CREATE TABLE `tx_evecorp_domain_model_evemapregion` (
	`uid` int(11) NOT NULL auto_increment,
	`pid` int(11) DEFAULT '0' NOT NULL,

	`region_id` int(11) DEFAULT '0' NOT NULL,
	`region_name` varchar(255) DEFAULT '' NOT NULL,

	`tstamp` int(11) unsigned DEFAULT '0' NOT NULL,
	`crdate` int(11) unsigned DEFAULT '0' NOT NULL,
	`deleted` tinyint(3) unsigned DEFAULT '0' NOT NULL,
	`hidden` tinyint(3) unsigned DEFAULT '0' NOT NULL,

	PRIMARY KEY (`uid`),
	KEY parent (`pid`),
	KEY region_id (`region_id`),
	KEY region_name (`region_name`)
);

#
# Table structure for table 'tx_evecorp_domain_model_evemapsolarsystem'
#
CREATE TABLE `tx_evecorp_domain_model_evemapsolarsystem` (
	`uid` int(11) NOT NULL auto_increment,
	`pid` int(11) DEFAULT '0' NOT NULL,

	`solar_system_id` int(11) DEFAULT '0' NOT NULL,
	`solar_system_name` varchar(255) DEFAULT '' NOT NULL,

	`tstamp` int(11) unsigned DEFAULT '0' NOT NULL,
	`crdate` int(11) unsigned DEFAULT '0' NOT NULL,
	`deleted` tinyint(3) unsigned DEFAULT '0' NOT NULL,
	`hidden` tinyint(3) unsigned DEFAULT '0' NOT NULL,

	PRIMARY KEY (`uid`),
	KEY parent (`pid`),
	KEY solar_system_id (`solar_system_id`),
	KEY solar_system_name (`solar_system_name`)
);

#
# Table structure for table 'tx_evecorp_domain_model_apikeyaccount'
#
CREATE TABLE `tx_evecorp_domain_model_apikeyaccount` (
	`uid` int(11) NOT NULL auto_increment,
	`pid` int(11) DEFAULT '0' NOT NULL,

	`key_id` int(11) DEFAULT '0' NOT NULL,
	`v_code` varchar(255) DEFAULT '' NOT NULL,
	`corp_member` int(11) DEFAULT '0' NOT NULL,
	`access_mask` int(11) DEFAULT '0' NOT NULL,
	`expires` int(11) DEFAULT '0' NOT NULL,
	`characters` int(11) DEFAULT '0' NOT NULL,

	`tstamp` int(11) unsigned DEFAULT '0' NOT NULL,
	`crdate` int(11) unsigned DEFAULT '0' NOT NULL,
	`deleted` tinyint(3) unsigned DEFAULT '0' NOT NULL,
	`hidden` tinyint(3) unsigned DEFAULT '0' NOT NULL,

	PRIMARY KEY (`uid`),
	KEY parent (`pid`)
);

#
# Table structure for table 'tx_evecorp_domain_model_alliance'
#
CREATE TABLE `tx_evecorp_domain_model_alliance` (
	`uid` int(11) NOT NULL auto_increment,
	`pid` int(11) DEFAULT '0' NOT NULL,

	`alliance_id` int(11) DEFAULT '0' NOT NULL,
	`alliance_name` varchar(255) DEFAULT '' NOT NULL,
	`corporations` int(11) DEFAULT '0' NOT NULL,

	`tstamp` int(11) unsigned DEFAULT '0' NOT NULL,
	`crdate` int(11) unsigned DEFAULT '0' NOT NULL,
	`deleted` tinyint(3) unsigned DEFAULT '0' NOT NULL,
	`hidden` tinyint(3) unsigned DEFAULT '0' NOT NULL,

	PRIMARY KEY (`uid`),
	KEY parent (`pid`)
);

#
# Table structure for table 'tx_evecorp_domain_model_corporation'
#
CREATE TABLE `tx_evecorp_domain_model_corporation` (
	`uid` int(11) NOT NULL auto_increment,
	`pid` int(11) DEFAULT '0' NOT NULL,

	`corporation_id` int(11) DEFAULT '0' NOT NULL,
	`corporation_name` varchar(255) DEFAULT '' NOT NULL,
	`current_alliance` int(11) DEFAULT '0',
	`usergroup` int(11) DEFAULT '0',

	`tstamp` int(11) unsigned DEFAULT '0' NOT NULL,
	`crdate` int(11) unsigned DEFAULT '0' NOT NULL,
	`deleted` tinyint(3) unsigned DEFAULT '0' NOT NULL,
	`hidden` tinyint(3) unsigned DEFAULT '0' NOT NULL,

	PRIMARY KEY (`uid`),
	KEY parent (`pid`)
);

#
# Table structure for table 'tx_evecorp_domain_model_character'
#
CREATE TABLE `tx_evecorp_domain_model_character` (
	`uid` int(11) NOT NULL auto_increment,
	`pid` int(11) DEFAULT '0' NOT NULL,

	`api_key` int(11) DEFAULT '0' NOT NULL,
	`character_id` int(11) DEFAULT '0' NOT NULL,
	`character_name` varchar(255) DEFAULT '' NOT NULL,
	`corp_member` int(11) DEFAULT '0' NOT NULL,
	`current_corporation` int(11) DEFAULT '0' NOT NULL,
	`employments` int(11) DEFAULT '0' NOT NULL,
	`race` varchar(255) DEFAULT '' NOT NULL,
	`security_status` DECIMAL(16,14) DEFAULT '0.00000000000000' NOT NULL,

	`tstamp` int(11) unsigned DEFAULT '0' NOT NULL,
	`crdate` int(11) unsigned DEFAULT '0' NOT NULL,
	`deleted` tinyint(3) unsigned DEFAULT '0' NOT NULL,
	`hidden` tinyint(3) unsigned DEFAULT '0' NOT NULL,

	PRIMARY KEY (`uid`),
	KEY parent (`pid`)
);

#
# Table structure for table 'tx_evecorp_domain_model_employmenthistory'
#
CREATE TABLE `tx_evecorp_domain_model_employmenthistory` (
	`uid` int(11) NOT NULL auto_increment,
	`pid` int(11) DEFAULT '0' NOT NULL,

	`character_uid` int(11) DEFAULT '0' NOT NULL,
	`record_id` int(11) DEFAULT '0' NOT NULL,
	`corporation_uid` int(11) DEFAULT '0' NOT NULL,
	`start_date` int(11) DEFAULT '0' NOT NULL,

	`tstamp` int(11) unsigned DEFAULT '0' NOT NULL,
	`crdate` int(11) unsigned DEFAULT '0' NOT NULL,
	`deleted` tinyint(3) unsigned DEFAULT '0' NOT NULL,
	`hidden` tinyint(3) unsigned DEFAULT '0' NOT NULL,

	PRIMARY KEY (`uid`),
	KEY parent (`pid`)
);

#
# Extending table 'fe_users'
#
CREATE TABLE fe_users {

	`api_keys` int(11) DEFAULT '0' NOT NULL,
	`characters` int(11) DEFAULT '0' NOT NULL,
	`eve_corp_groups` tinytext,

};
