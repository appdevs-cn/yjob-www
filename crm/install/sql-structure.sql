DROP TABLE IF EXISTS `qs_crm_account`;
CREATE TABLE `qs_crm_account` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `accountname` varchar(100) NOT NULL,
  `account` varchar(100) NOT NULL,
  `bank` varchar(100) NOT NULL,
  `amount_money` int(10) unsigned NOT NULL default '0',
  `remark` text,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;


DROP TABLE IF EXISTS `qs_crm_admin`;
CREATE TABLE `qs_crm_admin` (
  `admin_id` smallint(5) unsigned NOT NULL auto_increment,
  `admin_name` varchar(40) NOT NULL,
  `email` varchar(40) NOT NULL,
  `tel` varchar(100) NOT NULL,
  `pwd` varchar(32) NOT NULL,
  `pwd_hash` varchar(30) NOT NULL,
  `purview` text NOT NULL,
  `rank` varchar(32) NOT NULL,
  `add_time` int(10) NOT NULL,
  `last_login_time` int(10) NOT NULL,
  `last_login_ip` varchar(15) NOT NULL,
  PRIMARY KEY  (`admin_id`)
) TYPE=MyISAM;


DROP TABLE IF EXISTS `qs_crm_admin_log`;
CREATE TABLE `qs_crm_admin_log` (
  `log_id` int(10) unsigned NOT NULL auto_increment,
  `admin_name` varchar(20) NOT NULL,
  `add_time` int(10) NOT NULL,
  `log_value` varchar(255) NOT NULL,
  `log_ip` varchar(20) NOT NULL,
  `log_type` tinyint(1) unsigned NOT NULL default '1',
  PRIMARY KEY  (`log_id`)
) TYPE=MyISAM;


DROP TABLE IF EXISTS `qs_crm_business_dairy`;
CREATE TABLE `qs_crm_business_dairy` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `crm_id` int(10) NOT NULL,
  `title` varchar(100) NOT NULL,
  `content` mediumtext NOT NULL,
  `addtime` int(10) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `crm_id` (`crm_id`)
) TYPE=MyISAM;


DROP TABLE IF EXISTS `qs_crm_category`;
CREATE TABLE `qs_crm_category` (
  `c_id` int(10) unsigned NOT NULL auto_increment,
  `c_parentid` int(10) unsigned NOT NULL,
  `c_alias` char(30) NOT NULL,
  `c_name` char(30) NOT NULL,
  `c_order` int(10) NOT NULL,
  `c_index` char(1) NOT NULL,
  `disabled` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`c_id`),
  KEY `c_alias` (`c_alias`)
) TYPE=MyISAM;


DROP TABLE IF EXISTS `qs_crm_category_group`;
CREATE TABLE `qs_crm_category_group` (
  `g_id` int(10) unsigned NOT NULL auto_increment,
  `g_alias` varchar(60) NOT NULL,
  `g_name` varchar(100) NOT NULL,
  `g_sys` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`g_id`)
) TYPE=MyISAM;


DROP TABLE IF EXISTS `qs_crm_client`;
CREATE TABLE `qs_crm_client` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `crm_id` int(10) unsigned NOT NULL,
  `company_id` int(10) NOT NULL,
  `companyname` varchar(80) NOT NULL,
  `trade_cn` varchar(30) NOT NULL,
  `district_cn` varchar(30) NOT NULL,
  `scale_cn` varchar(30) NOT NULL,
  `address` varchar(150) NOT NULL,
  `contact` varchar(100) NOT NULL,
  `telephone` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `website` varchar(120) NOT NULL,
  `note` text NOT NULL,
  `addtime` int(10) NOT NULL,
  `nexttime` int(10) NOT NULL,
  `followtime` int(10) NOT NULL,
  `grade_id` int(10) NOT NULL,
  `status_id` int(10) NOT NULL,
  `type_id` int(10) NOT NULL,
  `source_id` int(10) NOT NULL,
  `trustworthiness_id` int(10) NOT NULL,
  `dealtime` int(10) unsigned NOT NULL,
  `edittime` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `crm_id` (`crm_id`),
  KEY `addtime` (`addtime`),
  KEY `nexttime` (`nexttime`),
  KEY `followtime` (`followtime`)
) TYPE=MyISAM;


DROP TABLE IF EXISTS `qs_crm_client_demand`;
CREATE TABLE `qs_crm_client_demand` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `client_id` int(10) unsigned NOT NULL,
  `client_other` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `client_id` (`client_id`)
) TYPE=MyISAM;


DROP TABLE IF EXISTS `qs_crm_client_financial`;
CREATE TABLE `qs_crm_client_financial` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `client_id` int(10) unsigned NOT NULL,
  `client_bank` varchar(60) NOT NULL,
  `client_bank_acc` varchar(80) NOT NULL,
  `client_note` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `client_id` (`client_id`)
) TYPE=MyISAM;


DROP TABLE IF EXISTS `qs_crm_client_log`;
CREATE TABLE `qs_crm_client_log` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `client_id` int(10) unsigned NOT NULL,
  `addtime` int(10) NOT NULL,
  `client_log` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `client_id` (`client_id`)
) TYPE=MyISAM;


DROP TABLE IF EXISTS `qs_crm_client_other`;
CREATE TABLE `qs_crm_client_other` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `client_id` int(10) unsigned NOT NULL,
  `client_other` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `client_id` (`client_id`)
) TYPE=MyISAM;


DROP TABLE IF EXISTS `qs_crm_client_tmp`;
CREATE TABLE `qs_crm_client_tmp` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `crm_id` int(10) unsigned NOT NULL,
  `company_id` int(10) NOT NULL,
  `companyname` varchar(80) NOT NULL,
  `trade_cn` varchar(30) NOT NULL,
  `district_cn` varchar(30) NOT NULL,
  `scale_cn` varchar(30) NOT NULL,
  `address` varchar(150) NOT NULL,
  `contact` varchar(100) NOT NULL,
  `telephone` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `website` varchar(120) NOT NULL,
  `note` text NOT NULL,
  `addtime` int(10) NOT NULL,
  `nexttime` int(10) NOT NULL,
  `followtime` int(10) NOT NULL,
  `grade_id` int(10) NOT NULL,
  `status_id` int(10) NOT NULL,
  `type_id` int(10) NOT NULL,
  `source_id` int(10) NOT NULL,
  `trustworthiness_id` int(10) NOT NULL,
  `dealtime` int(10) unsigned NOT NULL,
  `edittime` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `crm_id` (`crm_id`)
) TYPE=MyISAM;


DROP TABLE IF EXISTS `qs_crm_contacts`;
CREATE TABLE `qs_crm_contacts` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `crm_id` int(10) NOT NULL,
  `fullname` varchar(120) NOT NULL,
  `tel` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `qq` varchar(100) NOT NULL,
  `web` varchar(150) NOT NULL,
  `address` varchar(200) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `w_word` (`fullname`),
  KEY `w_hot` (`tel`),
  KEY `crm_id` (`crm_id`)
) TYPE=MyISAM;


DROP TABLE IF EXISTS `qs_crm_crons`;
CREATE TABLE `qs_crm_crons` (
  `cronid` smallint(5) unsigned NOT NULL auto_increment,
  `available` tinyint(1) unsigned NOT NULL,
  `admin_set` tinyint(1) unsigned NOT NULL default '0',
  `name` varchar(60) NOT NULL,
  `filename` varchar(60) NOT NULL,
  `lastrun` int(10) unsigned NOT NULL,
  `nextrun` int(10) unsigned NOT NULL,
  `weekday` tinyint(1) NOT NULL,
  `day` tinyint(2) NOT NULL,
  `hour` tinyint(2) NOT NULL,
  `minute` varchar(60) NOT NULL,
  PRIMARY KEY  (`cronid`)
) TYPE=MyISAM;


DROP TABLE IF EXISTS `qs_crm_doc`;
CREATE TABLE `qs_crm_doc` (
  `h_id` int(10) unsigned NOT NULL auto_increment,
  `h_typeid` smallint(5) unsigned NOT NULL,
  `h_filename` varchar(200) NOT NULL,
  `h_fileurl` varchar(200) NOT NULL,
  `h_order` int(10) NOT NULL default '0',
  `h_color` varchar(7) NOT NULL,
  `h_strong` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`h_id`)
) TYPE=MyISAM;


DROP TABLE IF EXISTS `qs_crm_doc_category`;
CREATE TABLE `qs_crm_doc_category` (
  `c_id` smallint(5) unsigned NOT NULL auto_increment,
  `c_name` varchar(80) NOT NULL,
  `c_order` int(11) NOT NULL default '0',
  `c_adminset` tinyint(3) NOT NULL default '0',
  PRIMARY KEY  (`c_id`)
) TYPE=MyISAM;


DROP TABLE IF EXISTS `qs_crm_employee`;
CREATE TABLE `qs_crm_employee` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(100) NOT NULL,
  `sex` varchar(5) NOT NULL default 'ÄÐ',
  `birthday` int(10) unsigned NOT NULL,
  `education` varchar(20) NOT NULL,
  `email` varchar(80) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `mobile` varchar(11) NOT NULL,
  `department` int(11) unsigned NOT NULL default '0',
  `job_position` varchar(20) NOT NULL default '',
  `wage` varchar(50) NOT NULL default '',
  `address` varchar(255) NOT NULL default '',
  `postalcode` int(6) NOT NULL default '0',
  `remark` text NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;


DROP TABLE IF EXISTS `qs_crm_my_contacts`;
CREATE TABLE `qs_crm_my_contacts` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `crm_id` int(10) NOT NULL,
  `fullname` varchar(120) NOT NULL,
  `tel` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `qq` varchar(100) NOT NULL,
  `web` varchar(150) NOT NULL,
  `address` varchar(200) NOT NULL,
  `group_id` int(11) unsigned NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `w_word` (`fullname`),
  KEY `w_hot` (`tel`),
  KEY `crm_id` (`crm_id`)
) TYPE=MyISAM;


DROP TABLE IF EXISTS `qs_crm_my_contacts_group`;
CREATE TABLE `qs_crm_my_contacts_group` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `group_name` varchar(30) NOT NULL,
  `admin_id` int(11) unsigned NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;


DROP TABLE IF EXISTS `qs_crm_report`;
CREATE TABLE `qs_crm_report` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `crm_id` int(11) unsigned NOT NULL,
  `addtime` int(10) unsigned NOT NULL,
  `client_number` int(11) unsigned NOT NULL,
  `client_name` varchar(255) NOT NULL,
  `contact` varchar(255) NOT NULL,
  `tel` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `client_addtime` int(10) unsigned NOT NULL,
  `last_followtime` int(10) NOT NULL,
  `last_follow_text` text NOT NULL,
  `next_followtime` int(10) unsigned NOT NULL,
  `client_status` varchar(255) NOT NULL,
  `client_demand` text NOT NULL,
  `client_remark` text NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;


DROP TABLE IF EXISTS `qs_crm_sendemail`;
CREATE TABLE `qs_crm_sendemail` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `email` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text,
  `addtime` int(10) unsigned NOT NULL,
  `admin_id` int(11) unsigned NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;


DROP TABLE IF EXISTS `qs_crm_sms`;
CREATE TABLE `qs_crm_sms` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `mobile` varchar(255) NOT NULL default '',
  `content` text,
  `addtime` int(10) unsigned NOT NULL,
  `admin_id` int(11) unsigned NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;


DROP TABLE IF EXISTS `qs_crm_users_config`;
CREATE TABLE `qs_crm_users_config` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `config_name` varchar(255) NOT NULL,
  `config_value` int(5) unsigned NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;


DROP TABLE IF EXISTS `qs_crm_workplan`;
CREATE TABLE `qs_crm_workplan` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `crm_id` int(10) NOT NULL,
  `title` varchar(100) NOT NULL,
  `content` mediumtext NOT NULL,
  `addtime` int(10) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `crm_id` (`crm_id`)
) TYPE=MyISAM;
