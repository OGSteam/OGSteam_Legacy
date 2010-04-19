# Serveur Hôte: localhost
# Base de Données: ogamestratege
# Table: 'planet'
# 
CREATE TABLE `planet` (
  `id` int(11) NOT NULL auto_increment,
  `galaxy` int(11) NOT NULL default '0',
  `system` int(11) NOT NULL default '0',
  `numplanet` int(11) NOT NULL default '0',
  `name` varchar(100) NOT NULL default '',
  `owner` int(11) NOT NULL default '0',
  `datadate` timestamp(14) NOT NULL,
  `datasender` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM; 

# Serveur Hôte: localhost
# Base de Données: ogamestratege
# Table: 'player'
# 
CREATE TABLE `player` (
  `id` int(11) NOT NULL auto_increment,
  `universe_id` int(11) NOT NULL default '0',
  `name` varchar(50) NOT NULL default '',
  `alliance` varchar(50) NOT NULL default '',
  `maincoords` varchar(9) NOT NULL default '0:000:000',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM; 

# Serveur Hôte: localhost
# Base de Données: ogamestratege
# Table: 'spy'
# 
CREATE TABLE `spy` (
  `id` int(11) NOT NULL auto_increment,
  `planet_id` int(11) NOT NULL default '0',
  `sender_id` int(11) NOT NULL default '0',
  `datadate` timestamp(14) NOT NULL,
  `rawdata` tinyblob NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM; 

# Serveur Hôte: localhost
# Base de Données: ogamestratege
# Table: 'universe'
# 
CREATE TABLE `universe` (
  `id` int(11) NOT NULL auto_increment,
  `URL` varchar(255) NOT NULL default '',
  `name` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM; 

# Serveur Hôte: localhost
# Base de Données: ogamestratege
# Table: 'user'
# 
CREATE TABLE `user` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(30) NOT NULL default '',
  `password` varchar(50) NOT NULL default '',
  `user_email` varchar(255) NOT NULL default '',
  `user_password` varchar(40) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM; 

