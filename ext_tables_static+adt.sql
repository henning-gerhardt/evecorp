--
-- Table structure for table `tx_evecorp_domain_model_evemapregion`
--

DROP TABLE IF EXISTS `tx_evecorp_domain_model_evemapregion`;
CREATE TABLE IF NOT EXISTS `tx_evecorp_domain_model_evemapregion` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL DEFAULT '0',
  `region_id` int(11) NOT NULL DEFAULT '0',
  `region_name` varchar(255) NOT NULL DEFAULT '',
  `tstamp` int(11) unsigned NOT NULL DEFAULT '0',
  `crdate` int(11) unsigned NOT NULL DEFAULT '0',
  `deleted` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `hidden` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid`),
  KEY `parent` (`pid`),
  KEY `region_id` (`region_id`),
  KEY `region_name` (`region_name`)
);

--
-- Dumping data for table `tx_evecorp_domain_model_evemapregion`
--

INSERT INTO `tx_evecorp_domain_model_evemapregion` VALUES(10000001, 1, 10000001, 'Derelik', 4294967295, 4294967295, 0, 0);
INSERT INTO `tx_evecorp_domain_model_evemapregion` VALUES(10000002, 1, 10000002, 'The Forge', 4294967295, 4294967295, 0, 0);
INSERT INTO `tx_evecorp_domain_model_evemapregion` VALUES(10000003, 1, 10000003, 'Vale of the Silent', 4294967295, 4294967295, 0, 0);
INSERT INTO `tx_evecorp_domain_model_evemapregion` VALUES(10000004, 1, 10000004, 'UUA-F4', 4294967295, 4294967295, 0, 0);
INSERT INTO `tx_evecorp_domain_model_evemapregion` VALUES(10000005, 1, 10000005, 'Detorid', 4294967295, 4294967295, 0, 0);
INSERT INTO `tx_evecorp_domain_model_evemapregion` VALUES(10000006, 1, 10000006, 'Wicked Creek', 4294967295, 4294967295, 0, 0);
INSERT INTO `tx_evecorp_domain_model_evemapregion` VALUES(10000007, 1, 10000007, 'Cache', 4294967295, 4294967295, 0, 0);
INSERT INTO `tx_evecorp_domain_model_evemapregion` VALUES(10000008, 1, 10000008, 'Scalding Pass', 4294967295, 4294967295, 0, 0);
INSERT INTO `tx_evecorp_domain_model_evemapregion` VALUES(10000009, 1, 10000009, 'Insmother', 4294967295, 4294967295, 0, 0);
INSERT INTO `tx_evecorp_domain_model_evemapregion` VALUES(10000010, 1, 10000010, 'Tribute', 4294967295, 4294967295, 0, 0);
INSERT INTO `tx_evecorp_domain_model_evemapregion` VALUES(10000011, 1, 10000011, 'Great Wildlands', 4294967295, 4294967295, 0, 0);
INSERT INTO `tx_evecorp_domain_model_evemapregion` VALUES(10000012, 1, 10000012, 'Curse', 4294967295, 4294967295, 0, 0);
INSERT INTO `tx_evecorp_domain_model_evemapregion` VALUES(10000013, 1, 10000013, 'Malpais', 4294967295, 4294967295, 0, 0);
INSERT INTO `tx_evecorp_domain_model_evemapregion` VALUES(10000014, 1, 10000014, 'Catch', 4294967295, 4294967295, 0, 0);
INSERT INTO `tx_evecorp_domain_model_evemapregion` VALUES(10000015, 1, 10000015, 'Venal', 4294967295, 4294967295, 0, 0);
INSERT INTO `tx_evecorp_domain_model_evemapregion` VALUES(10000016, 1, 10000016, 'Lonetrek', 4294967295, 4294967295, 0, 0);
INSERT INTO `tx_evecorp_domain_model_evemapregion` VALUES(10000017, 1, 10000017, 'J7HZ-F', 4294967295, 4294967295, 0, 0);
INSERT INTO `tx_evecorp_domain_model_evemapregion` VALUES(10000018, 1, 10000018, 'The Spire', 4294967295, 4294967295, 0, 0);
INSERT INTO `tx_evecorp_domain_model_evemapregion` VALUES(10000019, 1, 10000019, 'A821-A', 4294967295, 4294967295, 0, 0);
INSERT INTO `tx_evecorp_domain_model_evemapregion` VALUES(10000020, 1, 10000020, 'Tash-Murkon', 4294967295, 4294967295, 0, 0);
INSERT INTO `tx_evecorp_domain_model_evemapregion` VALUES(10000021, 1, 10000021, 'Outer Passage', 4294967295, 4294967295, 0, 0);
INSERT INTO `tx_evecorp_domain_model_evemapregion` VALUES(10000022, 1, 10000022, 'Stain', 4294967295, 4294967295, 0, 0);
INSERT INTO `tx_evecorp_domain_model_evemapregion` VALUES(10000023, 1, 10000023, 'Pure Blind', 4294967295, 4294967295, 0, 0);
INSERT INTO `tx_evecorp_domain_model_evemapregion` VALUES(10000025, 1, 10000025, 'Immensea', 4294967295, 4294967295, 0, 0);
INSERT INTO `tx_evecorp_domain_model_evemapregion` VALUES(10000027, 1, 10000027, 'Etherium Reach', 4294967295, 4294967295, 0, 0);
INSERT INTO `tx_evecorp_domain_model_evemapregion` VALUES(10000028, 1, 10000028, 'Molden Heath', 4294967295, 4294967295, 0, 0);
INSERT INTO `tx_evecorp_domain_model_evemapregion` VALUES(10000029, 1, 10000029, 'Geminate', 4294967295, 4294967295, 0, 0);
INSERT INTO `tx_evecorp_domain_model_evemapregion` VALUES(10000030, 1, 10000030, 'Heimatar', 4294967295, 4294967295, 0, 0);
INSERT INTO `tx_evecorp_domain_model_evemapregion` VALUES(10000031, 1, 10000031, 'Impass', 4294967295, 4294967295, 0, 0);
INSERT INTO `tx_evecorp_domain_model_evemapregion` VALUES(10000032, 1, 10000032, 'Sinq Laison', 4294967295, 4294967295, 0, 0);
INSERT INTO `tx_evecorp_domain_model_evemapregion` VALUES(10000033, 1, 10000033, 'The Citadel', 4294967295, 4294967295, 0, 0);
INSERT INTO `tx_evecorp_domain_model_evemapregion` VALUES(10000034, 1, 10000034, 'The Kalevala Expanse', 4294967295, 4294967295, 0, 0);
INSERT INTO `tx_evecorp_domain_model_evemapregion` VALUES(10000035, 1, 10000035, 'Deklein', 4294967295, 4294967295, 0, 0);
INSERT INTO `tx_evecorp_domain_model_evemapregion` VALUES(10000036, 1, 10000036, 'Devoid', 4294967295, 4294967295, 0, 0);
INSERT INTO `tx_evecorp_domain_model_evemapregion` VALUES(10000037, 1, 10000037, 'Everyshore', 4294967295, 4294967295, 0, 0);
INSERT INTO `tx_evecorp_domain_model_evemapregion` VALUES(10000038, 1, 10000038, 'The Bleak Lands', 4294967295, 4294967295, 0, 0);
INSERT INTO `tx_evecorp_domain_model_evemapregion` VALUES(10000039, 1, 10000039, 'Esoteria', 4294967295, 4294967295, 0, 0);
INSERT INTO `tx_evecorp_domain_model_evemapregion` VALUES(10000040, 1, 10000040, 'Oasa', 4294967295, 4294967295, 0, 0);
INSERT INTO `tx_evecorp_domain_model_evemapregion` VALUES(10000041, 1, 10000041, 'Syndicate', 4294967295, 4294967295, 0, 0);
INSERT INTO `tx_evecorp_domain_model_evemapregion` VALUES(10000042, 1, 10000042, 'Metropolis', 4294967295, 4294967295, 0, 0);
INSERT INTO `tx_evecorp_domain_model_evemapregion` VALUES(10000043, 1, 10000043, 'Domain', 4294967295, 4294967295, 0, 0);
INSERT INTO `tx_evecorp_domain_model_evemapregion` VALUES(10000044, 1, 10000044, 'Solitude', 4294967295, 4294967295, 0, 0);
INSERT INTO `tx_evecorp_domain_model_evemapregion` VALUES(10000045, 1, 10000045, 'Tenal', 4294967295, 4294967295, 0, 0);
INSERT INTO `tx_evecorp_domain_model_evemapregion` VALUES(10000046, 1, 10000046, 'Fade', 4294967295, 4294967295, 0, 0);
INSERT INTO `tx_evecorp_domain_model_evemapregion` VALUES(10000047, 1, 10000047, 'Providence', 4294967295, 4294967295, 0, 0);
INSERT INTO `tx_evecorp_domain_model_evemapregion` VALUES(10000048, 1, 10000048, 'Placid', 4294967295, 4294967295, 0, 0);
INSERT INTO `tx_evecorp_domain_model_evemapregion` VALUES(10000049, 1, 10000049, 'Khanid', 4294967295, 4294967295, 0, 0);
INSERT INTO `tx_evecorp_domain_model_evemapregion` VALUES(10000050, 1, 10000050, 'Querious', 4294967295, 4294967295, 0, 0);
INSERT INTO `tx_evecorp_domain_model_evemapregion` VALUES(10000051, 1, 10000051, 'Cloud Ring', 4294967295, 4294967295, 0, 0);
INSERT INTO `tx_evecorp_domain_model_evemapregion` VALUES(10000052, 1, 10000052, 'Kador', 4294967295, 4294967295, 0, 0);
INSERT INTO `tx_evecorp_domain_model_evemapregion` VALUES(10000053, 1, 10000053, 'Cobalt Edge', 4294967295, 4294967295, 0, 0);
INSERT INTO `tx_evecorp_domain_model_evemapregion` VALUES(10000054, 1, 10000054, 'Aridia', 4294967295, 4294967295, 0, 0);
INSERT INTO `tx_evecorp_domain_model_evemapregion` VALUES(10000055, 1, 10000055, 'Branch', 4294967295, 4294967295, 0, 0);
INSERT INTO `tx_evecorp_domain_model_evemapregion` VALUES(10000056, 1, 10000056, 'Feythabolis', 4294967295, 4294967295, 0, 0);
INSERT INTO `tx_evecorp_domain_model_evemapregion` VALUES(10000057, 1, 10000057, 'Outer Ring', 4294967295, 4294967295, 0, 0);
INSERT INTO `tx_evecorp_domain_model_evemapregion` VALUES(10000058, 1, 10000058, 'Fountain', 4294967295, 4294967295, 0, 0);
INSERT INTO `tx_evecorp_domain_model_evemapregion` VALUES(10000059, 1, 10000059, 'Paragon Soul', 4294967295, 4294967295, 0, 0);
INSERT INTO `tx_evecorp_domain_model_evemapregion` VALUES(10000060, 1, 10000060, 'Delve', 4294967295, 4294967295, 0, 0);
INSERT INTO `tx_evecorp_domain_model_evemapregion` VALUES(10000061, 1, 10000061, 'Tenerifis', 4294967295, 4294967295, 0, 0);
INSERT INTO `tx_evecorp_domain_model_evemapregion` VALUES(10000062, 1, 10000062, 'Omist', 4294967295, 4294967295, 0, 0);
INSERT INTO `tx_evecorp_domain_model_evemapregion` VALUES(10000063, 1, 10000063, 'Period Basis', 4294967295, 4294967295, 0, 0);
INSERT INTO `tx_evecorp_domain_model_evemapregion` VALUES(10000064, 1, 10000064, 'Essence', 4294967295, 4294967295, 0, 0);
INSERT INTO `tx_evecorp_domain_model_evemapregion` VALUES(10000065, 1, 10000065, 'Kor-Azor', 4294967295, 4294967295, 0, 0);
INSERT INTO `tx_evecorp_domain_model_evemapregion` VALUES(10000066, 1, 10000066, 'Perrigen Falls', 4294967295, 4294967295, 0, 0);
INSERT INTO `tx_evecorp_domain_model_evemapregion` VALUES(10000067, 1, 10000067, 'Genesis', 4294967295, 4294967295, 0, 0);
INSERT INTO `tx_evecorp_domain_model_evemapregion` VALUES(10000068, 1, 10000068, 'Verge Vendor', 4294967295, 4294967295, 0, 0);
INSERT INTO `tx_evecorp_domain_model_evemapregion` VALUES(10000069, 1, 10000069, 'Black Rise', 4294967295, 4294967295, 0, 0);
INSERT INTO `tx_evecorp_domain_model_evemapregion` VALUES(11000001, 1, 11000001, 'A-R00001', 4294967295, 4294967295, 0, 0);
INSERT INTO `tx_evecorp_domain_model_evemapregion` VALUES(11000002, 1, 11000002, 'A-R00002', 4294967295, 4294967295, 0, 0);
INSERT INTO `tx_evecorp_domain_model_evemapregion` VALUES(11000003, 1, 11000003, 'A-R00003', 4294967295, 4294967295, 0, 0);
INSERT INTO `tx_evecorp_domain_model_evemapregion` VALUES(11000004, 1, 11000004, 'B-R00004', 4294967295, 4294967295, 0, 0);
INSERT INTO `tx_evecorp_domain_model_evemapregion` VALUES(11000005, 1, 11000005, 'B-R00005', 4294967295, 4294967295, 0, 0);
INSERT INTO `tx_evecorp_domain_model_evemapregion` VALUES(11000006, 1, 11000006, 'B-R00006', 4294967295, 4294967295, 0, 0);
INSERT INTO `tx_evecorp_domain_model_evemapregion` VALUES(11000007, 1, 11000007, 'B-R00007', 4294967295, 4294967295, 0, 0);
INSERT INTO `tx_evecorp_domain_model_evemapregion` VALUES(11000008, 1, 11000008, 'B-R00008', 4294967295, 4294967295, 0, 0);
INSERT INTO `tx_evecorp_domain_model_evemapregion` VALUES(11000009, 1, 11000009, 'C-R00009', 4294967295, 4294967295, 0, 0);
INSERT INTO `tx_evecorp_domain_model_evemapregion` VALUES(11000010, 1, 11000010, 'C-R00010', 4294967295, 4294967295, 0, 0);
INSERT INTO `tx_evecorp_domain_model_evemapregion` VALUES(11000011, 1, 11000011, 'C-R00011', 4294967295, 4294967295, 0, 0);
INSERT INTO `tx_evecorp_domain_model_evemapregion` VALUES(11000012, 1, 11000012, 'C-R00012', 4294967295, 4294967295, 0, 0);
INSERT INTO `tx_evecorp_domain_model_evemapregion` VALUES(11000013, 1, 11000013, 'C-R00013', 4294967295, 4294967295, 0, 0);
INSERT INTO `tx_evecorp_domain_model_evemapregion` VALUES(11000014, 1, 11000014, 'C-R00014', 4294967295, 4294967295, 0, 0);
INSERT INTO `tx_evecorp_domain_model_evemapregion` VALUES(11000015, 1, 11000015, 'C-R00015', 4294967295, 4294967295, 0, 0);
INSERT INTO `tx_evecorp_domain_model_evemapregion` VALUES(11000016, 1, 11000016, 'D-R00016', 4294967295, 4294967295, 0, 0);
INSERT INTO `tx_evecorp_domain_model_evemapregion` VALUES(11000017, 1, 11000017, 'D-R00017', 4294967295, 4294967295, 0, 0);
INSERT INTO `tx_evecorp_domain_model_evemapregion` VALUES(11000018, 1, 11000018, 'D-R00018', 4294967295, 4294967295, 0, 0);
INSERT INTO `tx_evecorp_domain_model_evemapregion` VALUES(11000019, 1, 11000019, 'D-R00019', 4294967295, 4294967295, 0, 0);
INSERT INTO `tx_evecorp_domain_model_evemapregion` VALUES(11000020, 1, 11000020, 'D-R00020', 4294967295, 4294967295, 0, 0);
INSERT INTO `tx_evecorp_domain_model_evemapregion` VALUES(11000021, 1, 11000021, 'D-R00021', 4294967295, 4294967295, 0, 0);
INSERT INTO `tx_evecorp_domain_model_evemapregion` VALUES(11000022, 1, 11000022, 'D-R00022', 4294967295, 4294967295, 0, 0);
INSERT INTO `tx_evecorp_domain_model_evemapregion` VALUES(11000023, 1, 11000023, 'D-R00023', 4294967295, 4294967295, 0, 0);
INSERT INTO `tx_evecorp_domain_model_evemapregion` VALUES(11000024, 1, 11000024, 'E-R00024', 4294967295, 4294967295, 0, 0);
INSERT INTO `tx_evecorp_domain_model_evemapregion` VALUES(11000025, 1, 11000025, 'E-R00025', 4294967295, 4294967295, 0, 0);
INSERT INTO `tx_evecorp_domain_model_evemapregion` VALUES(11000026, 1, 11000026, 'E-R00026', 4294967295, 4294967295, 0, 0);
INSERT INTO `tx_evecorp_domain_model_evemapregion` VALUES(11000027, 1, 11000027, 'E-R00027', 4294967295, 4294967295, 0, 0);
INSERT INTO `tx_evecorp_domain_model_evemapregion` VALUES(11000028, 1, 11000028, 'E-R00028', 4294967295, 4294967295, 0, 0);
INSERT INTO `tx_evecorp_domain_model_evemapregion` VALUES(11000029, 1, 11000029, 'E-R00029', 4294967295, 4294967295, 0, 0);
INSERT INTO `tx_evecorp_domain_model_evemapregion` VALUES(11000030, 1, 11000030, 'F-R00030', 4294967295, 4294967295, 0, 0);