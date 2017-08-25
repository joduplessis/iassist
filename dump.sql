# MySQL Navigator Xport
# Database: inotes
# root@localhost

# CREATE DATABASE inotes;
# USE inotes;

#
# Table structure for table 'error'
#

# DROP TABLE IF EXISTS error;
CREATE TABLE `error` (
  `id` int(11) NOT NULL auto_increment,
  `section` varchar(255) default NULL,
  `description` blob,
  `date` date default NULL,
  `user` varchar(40) NOT NULL default '',
  `fixed` varchar(5) NOT NULL default '',
  `fdate` date NOT NULL default '0000-00-00',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

#
# Table structure for table 'inv_codes'
#

# DROP TABLE IF EXISTS inv_codes;
CREATE TABLE `inv_codes` (
  `code` varchar(30) default NULL
) TYPE=MyISAM;

#
# Table structure for table 'modules'
#

# DROP TABLE IF EXISTS modules;
CREATE TABLE `modules` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(50) default NULL,
  `description` blob,
  `location` text NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

#
# Table structure for table 'notes'
#

# DROP TABLE IF EXISTS notes;
CREATE TABLE `notes` (
  `id` int(11) NOT NULL auto_increment,
  `type` varchar(20) default NULL,
  `code` varchar(20) default NULL,
  `user` varchar(50) default NULL,
  `content` blob,
  `amount` varchar(50) default NULL,
  `start_date` date default NULL,
  `end_date` date default NULL,
  `created_date` date default NULL,
  `see_all` varchar(5) default NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

#
# Table structure for table 'paid'
#

# DROP TABLE IF EXISTS paid;
CREATE TABLE `paid` (
  `id` int(11) NOT NULL auto_increment,
  `user` varchar(50) NOT NULL default '',
  `number` varchar(5) default NULL,
  `type` varchar(10) default NULL,
  `amount` varchar(20) NOT NULL default '',
  `date` date NOT NULL default '0000-00-00',
  `ctype` varchar(10) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `id` (`id`)
) TYPE=MyISAM;

#
# Table structure for table 'rules'
#

# DROP TABLE IF EXISTS rules;
CREATE TABLE `rules` (
  `id` int(11) NOT NULL auto_increment,
  `cust_id` varchar(5) default NULL,
  `pdf_html` varchar(4) default NULL,
  `cust_name` text NOT NULL,
  `email` varchar(50) NOT NULL default '',
  `type` varchar(10) NOT NULL default '',
  KEY `id` (`id`)
) TYPE=MyISAM;

#
# Table structure for table 'settings'
#

# DROP TABLE IF EXISTS settings;
CREATE TABLE `settings` (
  `dsn` varchar(50) default NULL,
  `username` varchar(50) default NULL,
  `password` varchar(50) default NULL,
  `display` int(2) default NULL,
  `totalzeroitems` char(1) NOT NULL default '0',
  `anchor` tinyint(1) NOT NULL default '1',
  `highlight_from` varchar(10) NOT NULL default '',
  `flash` varchar(255) NOT NULL default '',
  `VAT` text NOT NULL,
  `CK` text NOT NULL,
  `address_01` text NOT NULL,
  `address_02` text NOT NULL,
  `tel` text NOT NULL,
  `fax` text NOT NULL,
  `email` text NOT NULL,
  `URL` text NOT NULL,
  `logo_img` text NOT NULL,
  `admin_01` text NOT NULL,
  `company` varchar(255) NOT NULL default '',
  `host` text NOT NULL,
  `server_address` text NOT NULL,
  `mail_user` text NOT NULL,
  `mail_pass` text NOT NULL,
  `prefer_format` text NOT NULL,
  `cache` varchar(11) NOT NULL default '0',
  `dsn2` varchar(50) NOT NULL default '',
  `dsn2_user` varchar(50) NOT NULL default '',
  `dsn2_pass` varchar(50) NOT NULL default ''
) TYPE=MyISAM;

#
# Table structure for table 'users'
#

# DROP TABLE IF EXISTS users;
CREATE TABLE `users` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(20) default NULL,
  `password` varchar(20) default NULL,
  `name` varchar(30) NOT NULL default '',
  `surname` varchar(30) NOT NULL default '',
  `date_created` date default NULL,
  `date_expire` date NOT NULL default '0000-00-00',
  `sec_type` varchar(20) default NULL,
  `email` varchar(30) default NULL,
  `display_limit` int(11) NOT NULL default '5',
  `zeroclients` char(1) NOT NULL default '1',
  `highlight_from` varchar(10) NOT NULL default '',
  `view_type` varchar(10) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

