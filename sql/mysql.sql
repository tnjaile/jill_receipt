CREATE TABLE `jill_receipt` (
  `rsn` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '流水號',
  `create_date` datetime NOT NULL COMMENT '建立時間',
  `account` varchar(255) NOT NULL COMMENT '入款帳戶',
  `usn` smallint(6) unsigned NOT NULL COMMENT '補助單位編號',
  `title` text NOT NULL COMMENT '補助事由',
  `amount` int(10) unsigned NOT NULL COMMENT '金額',
  `uid` mediumint(8) unsigned NOT NULL COMMENT '申請人員',
  `in_date` date NOT NULL COMMENT '收入日期',
  `tax_id` varchar(255) NOT NULL COMMENT '統一編號',
  `status` enum('0','1','2','3') NOT NULL COMMENT '是否製單',
  `note` varchar(300) NOT NULL COMMENT '備註',
  PRIMARY KEY (`rsn`)
) ENGINE=MyISAM COMMENT='領據';

CREATE TABLE `jill_unit` (
  `usn` smallint(6) unsigned NOT NULL auto_increment COMMENT '補助單位編號',
  `unit` varchar(255) NOT NULL default '' COMMENT '補助單位',
  `unit_code` varchar(255) NOT NULL default '' COMMENT '單位代碼',
  `sort` smallint(6) unsigned NOT NULL default '0' COMMENT '排序',
PRIMARY KEY  (`usn`)
) ENGINE=MyISAM;

