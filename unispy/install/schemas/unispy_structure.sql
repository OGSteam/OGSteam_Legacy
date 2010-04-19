## ########################################################

## 
## Structure de la table `unispy_config`
## 

CREATE TABLE unispy_config (
  config_name varchar(255) NOT NULL default '',
  config_value varchar(255) NOT NULL default '',
  PRIMARY KEY  (config_name)
) ;

## ########################################################

## 
## Structure de la table `unispy_group`
## 

CREATE TABLE unispy_group (
  group_id mediumint(8) NOT NULL auto_increment,
  group_name varchar(30) NOT NULL default '',
  server_set_system enum('0','1') NOT NULL default '0',
  server_set_spy enum('0','1') NOT NULL default '0',
  server_set_ranking enum('0','1') NOT NULL default '0',
  server_show_positionhided enum('0','1') NOT NULL default '0',
  ogs_connection enum('0','1') NOT NULL default '0',
  ogs_set_system enum('0','1') NOT NULL default '0',
  ogs_get_system enum('0','1') NOT NULL default '0',
  ogs_set_spy enum('0','1') NOT NULL default '0',
  ogs_get_spy enum('0','1') NOT NULL default '0',
  unlimited_ratio enum('0','1') NOT NULL default '0',
  ogs_set_ranking enum('0','1') NOT NULL default '0',
  ogs_get_ranking enum('0','1') NOT NULL default '0',
  `hidden_allys` varchar(255) NOT NULL COMMENT 'alliances cachees pour le groupe',
  PRIMARY KEY  (group_id)
) ;

## ########################################################

## 
## Structure de la table `unispy_group_perms`
## 

CREATE TABLE unispy_group_perms (
  group_id mediumint(8) NOT NULL default '0',
  mod_id mediumint(8) NOT NULL default '0',
  PRIMARY KEY  (group_id, mod_id)
) ;

## ########################################################

## 
## Structure de la table `unispy_mod`
## 

CREATE TABLE unispy_mod (
  id int(11) NOT NULL auto_increment,
  title varchar(255) NOT NULL default '',
  menu varchar(255) NOT NULL default '',
  `action` varchar(255) NOT NULL default '',
  `menupos` tinyint(1) unsigned NOT NULL default '0',
  `tooltip` text collate latin1_general_ci NOT NULL default '',
  `dateinstall` int(11) NOT NULL default '0',
  `updated` tinyint(1) NOT NULL default '0',
  `noticeifnew` tinyint(1) NOT NULL default '0',
  `catuser` tinyint(1) unsigned NOT NULL default '0',  
  root varchar(255) NOT NULL default '',
  link varchar(255) NOT NULL default '',
  version varchar(5) NOT NULL default '',
  `position` int(11) NOT NULL default '-1',
  active tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (id),
  UNIQUE KEY `action` (`action`),
  UNIQUE KEY title (title),
  UNIQUE KEY menu (menu),
  UNIQUE KEY root (root)
) ;

## ########################################################

## 
## Structure de la table `unispy_rank_ally_fleet`
## 

CREATE TABLE unispy_rank_ally_fleet (
  datadate int(11) NOT NULL default '0',
  rank int(11) NOT NULL default '0',
  ally varchar(30) NOT NULL default '',
  nom_ally tinytext NOT NULL,
  points bigint(13) NOT NULL default '0',
  sender_id int(11) NOT NULL default '0',
  PRIMARY KEY  (rank,datadate),
  KEY datadate (datadate,ally),
  KEY ally (ally)
) ;

## ########################################################

## 
## Structure de la table `unispy_rank_ally_points`
## 

CREATE TABLE unispy_rank_ally_points (
  datadate int(11) NOT NULL default '0',
  rank int(11) NOT NULL default '0',
  ally varchar(30) NOT NULL default '',
  nom_ally tinytext NOT NULL,
  points bigint(13) NOT NULL default '0',
  sender_id int(11) NOT NULL default '0',
  PRIMARY KEY  (rank,datadate),
  KEY datadate (datadate,ally),
  KEY ally (ally)
) ;

## ########################################################

## 
## Structure de la table `unispy_rank_ally_research`
## 

CREATE TABLE unispy_rank_ally_research (
  datadate int(11) NOT NULL default '0',
  rank int(11) NOT NULL default '0',
  ally varchar(30) NOT NULL default '',
  nom_ally tinytext NOT NULL,
  points bigint(13) NOT NULL default '0',
  sender_id int(11) NOT NULL default '0',
  PRIMARY KEY  (rank,datadate),
  KEY datadate (datadate,ally),
  KEY ally (ally)
) ;

## ########################################################

## 
## Structure de la table `unispy_rank_player_fleet`
## 

CREATE TABLE unispy_rank_player_fleet (
  datadate int(11) NOT NULL default '0',
  rank int(11) NOT NULL default '0',
  player varchar(30) NOT NULL default '',
  ally varchar(100) NOT NULL default '',
  points bigint(13) NOT NULL default '0',
  sender_id int(11) NOT NULL default '0',
  PRIMARY KEY  (rank,datadate),
  KEY datadate (datadate,player),
  KEY player (player)
) ;

## ########################################################

## 
## Structure de la table `unispy_rank_player_points`
## 

CREATE TABLE unispy_rank_player_points (
  datadate int(11) NOT NULL default '0',
  rank int(11) NOT NULL default '0',
  player varchar(30) NOT NULL default '',
  ally varchar(100) NOT NULL default '',
  points bigint(13) NOT NULL default '0',
  sender_id int(11) NOT NULL default '0',
  PRIMARY KEY  (rank,datadate),
  KEY datadate (datadate,player),
  KEY player (player)
) ;

## ########################################################

## 
## Structure de la table `unispy_rank_player_research`
## 

CREATE TABLE unispy_rank_player_research (
  datadate int(11) NOT NULL default '0',
  rank int(11) NOT NULL default '0',
  player varchar(30) NOT NULL default '',
  ally varchar(100) NOT NULL default '',
  points bigint(13) NOT NULL default '0',
  sender_id varchar(30) NOT NULL default '',
  PRIMARY KEY  (rank,datadate),
  KEY datadate (datadate,player),
  KEY player (player)
) ;

## ########################################################

## 
## Structure de la table `unispy_sessions`
## 

CREATE TABLE unispy_sessions (
  session_id char(32) NOT NULL default '',
  session_user_id int(11) NOT NULL default '0',
  session_start int(11) NOT NULL default '0',
  session_expire int(11) NOT NULL default '0',
  session_ip char(32) NOT NULL default '',
  session_ogs enum('0','1') NOT NULL default '0',
  session_lastvisit int(11) NOT NULL default '0',
  UNIQUE KEY session_id (session_id,session_ip)
) ;

## ########################################################

## 
## Structure de la table `unispy_spy`
## 

CREATE TABLE unispy_spy (
  spy_id int(11) NOT NULL auto_increment,
  spy_galaxy smallint(2) NOT NULL default '1',
  spy_system smallint(3) NOT NULL default '0',
  spy_row smallint(2) NOT NULL default '1',
  sender_id int(11) NOT NULL default '0',
  datadate int(11) NOT NULL default '0',
  rawdata mediumtext NOT NULL default '',
  active enum('0','1') NOT NULL default '1',
  PRIMARY KEY  (spy_id),
  UNIQUE KEY spy_galaxy (spy_galaxy,spy_system,spy_row,datadate)
) ;

## ########################################################

## 
## Structure de la table `unispy_statistics`
## 

CREATE TABLE unispy_statistics (
  statistic_name varchar(255) NOT NULL default '',
  statistic_value varchar(255) NOT NULL default '0',
  PRIMARY KEY  (statistic_name)
) ;

## ########################################################

## 
## Structure de la table `unispy_universe`
##
 

CREATE TABLE unispy_universe (
  galaxy smallint(2) NOT NULL default '1',
  system smallint(3) NOT NULL default '0',
  `row` smallint(2) NOT NULL default '1',
  `impulsion` tinyint(1) NOT NULL COMMENT 'niveau techno impulsion pour portee missile',
  `silo` tinyint(1) NOT NULL COMMENT 'niveau silo, sert a afficher info si >4 (MI)',
  `name` varchar(20) NOT NULL default '',
  ally varchar(20) default NULL default '',
  player varchar(20) default NULL default '',
  `status` varchar(5) NOT NULL default '',
  last_update int(11) NOT NULL default '0',
  last_update_user_id int(11) NOT NULL default '0',
  UNIQUE KEY univers (galaxy,system,`row`),
  KEY player (player)
) ;

## ########################################################

## 
## Structure de la table `unispy_universe_temporary`
## 

CREATE TABLE unispy_universe_temporary (
  player varchar(20) NOT NULL default '',
  ally varchar(20) NOT NULL default '',
  `status` varchar(5) NOT NULL default '',
  `timestamp` int(11) NOT NULL default '0'
) ;

## ########################################################

## 
## Structure de la table `unispy_user`
## 
##

CREATE TABLE unispy_user (
  user_id int(11) NOT NULL auto_increment,
  user_name varchar(20) NOT NULL default '',
  user_password varchar(32) NOT NULL default '',
  user_admin enum('0','1') NOT NULL default '0',
  user_coadmin enum('0','1') NOT NULL default '0',
  user_active enum('0','1') NOT NULL default '0',
  user_regdate int(11) NOT NULL default '0',
  user_lastvisit int(11) NOT NULL default '0',
  user_galaxy smallint(3) NOT NULL default '1',
  user_system smallint(3) NOT NULL default '1',
  planet_added_web int(11) NOT NULL default '0',
  planet_added_ogs int(11) NOT NULL default '0',
  planet_exported int(11) NOT NULL default '0',
  search int(11) NOT NULL default '0',
  spy_added_web int(11) NOT NULL default '0',
  spy_added_ogs int(11) NOT NULL default '0',
  spy_exported int(11) NOT NULL default '0',
  rank_added_web int(11) NOT NULL default '0',
  rank_added_ogs int(11) NOT NULL default '0',
  rank_exported int(11) NOT NULL default '0',
  user_skin varchar(255) NOT NULL default '',
  user_stat_name varchar(50) NOT NULL default '',
  `user_ally_name` varchar(20) NOT NULL default '',
  management_user enum('0','1') NOT NULL default '0',
  management_ranking enum('0','1') NOT NULL default '0',
  disable_ip_check enum('0','1') NOT NULL default '0',
  user_language varchar(30) NOT NULL default '',
  PRIMARY KEY  (user_id),
  UNIQUE KEY user_name (user_name)
) ;

## ########################################################

## 
## Structure de la table `unispy_user_building`
## 

CREATE TABLE unispy_user_building (
  user_id int(11) NOT NULL default '0',
  planet_id int(11) NOT NULL default '0',
  planet_name varchar(20) NOT NULL default '',
  coordinates varchar(8) NOT NULL default '',
  `fields` smallint(3) NOT NULL default '0',
  temperature smallint(2) NOT NULL default '0',
  Sat smallint(5) NOT NULL default '0',
  Sat_percentage smallint(3) NOT NULL default '100',
  Ti smallint(2) NOT NULL default '0',
  Ti_percentage smallint(3) NOT NULL default '100',
  Ca smallint(2) NOT NULL default '0',
  Ca_Percentage smallint(3) NOT NULL default '100',
  Tr smallint(2) NOT NULL default '0',
  Tr_percentage smallint(3) NOT NULL default '100',
  CG smallint(2) NOT NULL default '0',
  CG_percentage smallint(3) NOT NULL default '100',
  CaT smallint(2) NOT NULL default '0',
  CaT_percentage smallint(3) NOT NULL default '100',
  UdD smallint(2) NOT NULL default '0',
  UdA smallint(2) NOT NULL default '0',
  UA smallint(2) NOT NULL default '0',
  STi smallint(2) NOT NULL default '0',
  SCa smallint(2) NOT NULL default '0',
  STr smallint(2) NOT NULL default '0',
  CT smallint(2) NOT NULL default '0',
  CM smallint(2) NOT NULL default '0',
  Ter smallint(2) NOT NULL default '0',
  HM smallint(2) NOT NULL default '0',
  PRIMARY KEY  (user_id,planet_id)
) ;

## ########################################################

## 
## Structure de la table `unispy_user_defence`
##
## suite à problème de taille (eg: + de 32~k lm), augmentation smallint(1)->mediumint(8) par Naqdazar

CREATE TABLE unispy_user_defence (
  user_id int(11) NOT NULL default '0',
  planet_id int(11) NOT NULL default '0',
  `BFG` mediumint(8) unsigned NOT NULL default '0' ,
  `SBFG` mediumint(8) unsigned NOT NULL default '0',
  `PFC` mediumint(8) unsigned NOT NULL default '0',
  `DeF` mediumint(8) unsigned NOT NULL default '0',
  `PFI` mediumint(8) unsigned NOT NULL default '0',
  `AMD` mediumint(8) unsigned NOT NULL default '0',
  CF smallint(1) NOT NULL default '0',
  Ho smallint(1) NOT NULL default '0',
  CME smallint(5) NOT NULL default '0',
  EMP smallint(5) NOT NULL default '0',
  PRIMARY KEY  (user_id,planet_id)
) ;

## ########################################################

## 
## Structure de la table `unispy_user_favorite`
## 

CREATE TABLE unispy_user_favorite (
  user_id int(11) NOT NULL default '0',
  galaxy smallint(3) NOT NULL default '1',
  system smallint(3) NOT NULL default '0',
  UNIQUE KEY user_id (user_id,galaxy,system)
) ;

## ########################################################

## 
## Structure de la table `unispy_user_group`
## 

CREATE TABLE unispy_user_group (
  group_id mediumint(8) NOT NULL default '0',
  user_id mediumint(8) NOT NULL default '0',
  UNIQUE KEY group_id (group_id,user_id)
) ;



## ########################################################

## 
## Structure de la table `unispy_user_spy`
## 

CREATE TABLE unispy_user_spy (
  user_id int(11) NOT NULL default '0',
  spy_id int(11) NOT NULL default '0',
  PRIMARY KEY  (user_id,spy_id)
) ;

## ########################################################

## 
## Structure de la table `unispy_user_technology`
## 

CREATE TABLE unispy_user_technology (
  user_id int(11) NOT NULL default '0',
  Esp smallint(2) NOT NULL default '0',
  Qua smallint(2) NOT NULL default '0',
  Alli smallint(2) NOT NULL default '0',
  SC smallint(2) NOT NULL default '0',
  Raf smallint(2) NOT NULL default '0',
  Armes smallint(2) NOT NULL default '0',
  Bouclier smallint(2) NOT NULL default '0',
  Blindage smallint(2) NOT NULL default '0',
  Ther smallint(2) NOT NULL default '0',
  Anti smallint(2) NOT NULL default '0',
  HD smallint(2) NOT NULL default '0',
  Imp smallint(2) NOT NULL default '0',
  Warp smallint(2) NOT NULL default '0',
  Smart smallint(2) NOT NULL default '0',
  Ions smallint(2) NOT NULL default '0',
  Aereon smallint(2) NOT NULL default '0',
  Sca smallint(2) NOT NULL default '0',
  Graviton smallint(2) NOT NULL default '0',
  Admi smallint(2) NOT NULL default '0',
  Expl smallint(2) NOT NULL default '0',
  xp_mineur smallint(2) NOT NULL default '0',
  xp_raideur smallint(2) NOT NULL default '0',
  PRIMARY KEY  (user_id)
) ;

## ########################################################

## 
## Structure de la table `unispy_plugin_import`
## recense les fonctions d`importation utilisable par le plugin

CREATE TABLE IF NOT EXISTS unispy_plugin_import (
  function_id int(11) NOT NULL auto_increment,
  mod_name varchar(20) NOT NULL default '',
  mod_version varchar(15) NOT NULL default '',
  mod_root_name varchar(255) NOT NULL default '',
  function_file_name varchar(255) NOT NULL default '',
  function_name varchar(30) NOT NULL default '', 
  univers_pageid_handled smallint(3) NOT NULL default '-1',
  text_content enum('0','1') NOT NULL default '1',
  function_active enum('0','1') NOT NULL default '1',  
  PRIMARY KEY  (function_id)
) ;


## ########################################################

## 
## Contenu de la table `unispy_config`
## 

INSERT INTO `unispy_config` VALUES ('nb_galaxy', '15');
INSERT INTO `unispy_config` VALUES ('nb_system', '250');
INSERT INTO `unispy_config` VALUES ('nb_row', '15');
INSERT INTO `unispy_config` VALUES ('uni_speed', '1');
INSERT INTO `unispy_config` VALUES ('allied', '');
INSERT INTO `unispy_config` VALUES ('ally_protection', '');
INSERT INTO `unispy_config` VALUES ('debug_log', '0');
INSERT INTO `unispy_config` VALUES ('default_skin', 'skin/');
INSERT INTO `unispy_config` VALUES ('disable_ip_check', '0');
INSERT INTO `unispy_config` VALUES ('keeprank_criterion', 'day');
INSERT INTO `unispy_config` VALUES ('last_maintenance_action', '0');
INSERT INTO `unispy_config` VALUES ('max_battlereport', '10');
INSERT INTO `unispy_config` VALUES ('max_favorites', '20');
INSERT INTO `unispy_config` VALUES ('max_favorites_spy', '10');
INSERT INTO `unispy_config` VALUES ('max_keeplog', '7');
INSERT INTO `unispy_config` VALUES ('max_keeprank', '30');
INSERT INTO `unispy_config` VALUES ('max_keepspyreport', '30');
INSERT INTO `unispy_config` VALUES ('max_spyreport', '10');
INSERT INTO `unispy_config` VALUES ('reason', '');
INSERT INTO `unispy_config` VALUES ('servername', 'Cartographie');
INSERT INTO `unispy_config` VALUES ('server_active', '1');
INSERT INTO `unispy_config` VALUES ('session_time', '30');
INSERT INTO `unispy_config` VALUES ('url_forum', 'http://www.ogsteam.fr');
INSERT INTO `unispy_config` VALUES ('version', '1.0');
INSERT INTO `unispy_config` VALUES ('language', 'french');
INSERT INTO `unispy_config` VALUES ('timeshift', '0');
INSERT INTO `unispy_config` VALUES ('default_login_page', '');
INSERT INTO `unispy_config` VALUES ('language_parsing', 'french');

## variable pour détemrination version interface/mod (avec tooltip etc, champ suppl)
## nécessaire pour inscription modules /mods/.../install.php

INSERT INTO `unispy_config` VALUES ('ogs_modmanver', '1.02');

## valeur ratio mini avant blocage de certaines options du menu commun

INSERT INTO `unispy_config` VALUES ('user_lower_ratio', '-99'); 

## On rajoute les couleurs par défaut pour les alliances protégées
## Naqdazar, Verite

INSERT INTO `unispy_config`  VALUES ('color_ally_hided', '#0000FF');
INSERT INTO `unispy_config`  VALUES ('color_ally_friend', '#00FF40');



## ########################################################

## 
## Contenu de la table `unispy_group`
## 

INSERT INTO `unispy_group` VALUES (1, 'Standard', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0','');
INSERT INTO `unispy_group` VALUES (2, 'Admins', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1','');
