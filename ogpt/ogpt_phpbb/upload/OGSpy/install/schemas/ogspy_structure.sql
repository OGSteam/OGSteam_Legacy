#
# OGSpy version Beta 1.00
# 22 Aout 00:00:00
# 

## ########################################################

## 
## Structure de la table `ogspy_config`
## 

CREATE TABLE ogspy_config (
  config_name varchar(255) NOT NULL default '',
  config_value varchar(255) NOT NULL default '',
  PRIMARY KEY  (config_name)
) ;

## ########################################################

## 
## Structure de la table `ogspy_group`
## 

CREATE TABLE ogspy_group (
  group_id mediumint(8) NOT NULL auto_increment,
  group_name varchar(30) NOT NULL,
  server_set_system enum('0','1') NOT NULL default '0',
  server_set_spy enum('0','1') NOT NULL default '0',
  server_set_ranking enum('0','1') NOT NULL default '0',
  server_show_positionhided enum('0','1') NOT NULL default '0',
  ogs_connection enum('0','1') NOT NULL default '0',
  ogs_set_system enum('0','1') NOT NULL default '0',
  ogs_get_system enum('0','1') NOT NULL default '0',
  ogs_set_spy enum('0','1') NOT NULL default '0',
  ogs_get_spy enum('0','1') NOT NULL default '0',
  ogs_set_ranking enum('0','1') NOT NULL default '0',
  ogs_get_ranking enum('0','1') NOT NULL default '0',
  PRIMARY KEY  (group_id)
) ;

## ########################################################

## 
## Structure de la table `ogspy_mod`
## 

CREATE TABLE ogspy_mod (
  id int(11) NOT NULL auto_increment,
  title varchar(255) NOT NULL COMMENT 'Nom du mod',
  menu varchar(255) NOT NULL COMMENT 'Titre du lien dans le menu',
  `action` varchar(255) NOT NULL COMMENT 'Action transmise en get et traitée dans index.php',
  root varchar(255) NOT NULL COMMENT 'Répertoire où se situe le mod (relatif au répertoire mods)',
  link varchar(255) NOT NULL COMMENT 'fichier principale du mod',
  version varchar(5) NOT NULL COMMENT 'Version du mod',
  position int(11) NOT NULL default '-1',
  active tinyint(1) NOT NULL COMMENT 'Permet de désactiver un mod sans le désinstaller, évite les mods#pirates',
  PRIMARY KEY  (id),
  UNIQUE KEY `action` (`action`),
  UNIQUE KEY title (title),
  UNIQUE KEY menu (menu),
  UNIQUE KEY root (root)
) ;

## ########################################################

## 
## Structure de la table `ogspy_rank_ally_fleet`
## 

CREATE TABLE ogspy_rank_ally_fleet (
  datadate int(11) NOT NULL default '0',
  rank int(11) NOT NULL default '0',
  ally varchar(30) NOT NULL,
  number_member int(11) NOT NULL,
  points int(11) NOT NULL default '0',
  points_per_member int(11) NOT NULL,
  sender_id int(11) NOT NULL default '0',
  PRIMARY KEY  (rank,datadate),
  KEY datadate (datadate,ally),
  KEY ally (ally)
) ;

## ########################################################

## 
## Structure de la table `ogspy_rank_ally_points`
## 

CREATE TABLE ogspy_rank_ally_points (
  datadate int(11) NOT NULL default '0',
  rank int(11) NOT NULL default '0',
  ally varchar(30) NOT NULL,
  number_member int(11) NOT NULL,
  points int(11) NOT NULL default '0',
  points_per_member int(11) NOT NULL,
  sender_id int(11) NOT NULL default '0',
  PRIMARY KEY  (rank,datadate),
  KEY datadate (datadate,ally),
  KEY ally (ally)
) ;

## ########################################################

## 
## Structure de la table `ogspy_rank_ally_research`
## 

CREATE TABLE ogspy_rank_ally_research (
  datadate int(11) NOT NULL default '0',
  rank int(11) NOT NULL default '0',
  ally varchar(30) NOT NULL,
  number_member int(11) NOT NULL,
  points int(11) NOT NULL default '0',
  points_per_member int(11) NOT NULL,
  sender_id int(11) NOT NULL default '0',
  PRIMARY KEY  (rank,datadate),
  KEY datadate (datadate,ally),
  KEY ally (ally)
) ;

## ########################################################

## 
## Structure de la table `ogspy_rank_player_fleet`
## 

CREATE TABLE ogspy_rank_player_fleet (
  datadate int(11) NOT NULL default '0',
  rank int(11) NOT NULL default '0',
  player varchar(30) NOT NULL default '',
  ally varchar(100) NOT NULL default '',
  points int(11) NOT NULL default '0',
  sender_id int(11) NOT NULL default '0',
  PRIMARY KEY  (rank,datadate),
  KEY datadate (datadate,player),
  KEY player (player)
) ;

## ########################################################

## 
## Structure de la table `ogspy_rank_player_points`
## 

CREATE TABLE ogspy_rank_player_points (
  datadate int(11) NOT NULL default '0',
  rank int(11) NOT NULL default '0',
  player varchar(30) NOT NULL default '',
  ally varchar(100) NOT NULL default '',
  points int(11) NOT NULL default '0',
  sender_id int(11) NOT NULL default '0',
  PRIMARY KEY  (rank,datadate),
  KEY datadate (datadate,player),
  KEY player (player)
) ;

## ########################################################

## 
## Structure de la table `ogspy_rank_player_research`
## 

CREATE TABLE ogspy_rank_player_research (
  datadate int(11) NOT NULL default '0',
  rank int(11) NOT NULL default '0',
  player varchar(30) NOT NULL default '',
  ally varchar(100) NOT NULL default '',
  points int(11) NOT NULL default '0',
  sender_id varchar(30) NOT NULL default '',
  PRIMARY KEY  (rank,datadate),
  KEY datadate (datadate,player),
  KEY player (player)
) ;

## ########################################################

## 
## Structure de la table `ogspy_sessions`
## 

CREATE TABLE ogspy_sessions (
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
## Structure de la table `ogspy_spy`
## 

CREATE TABLE ogspy_spy (
  spy_id int(11) NOT NULL auto_increment,
  spy_galaxy enum('1','2','3','4','5','6','7','8','9') NOT NULL default '1',
  spy_system smallint(3) NOT NULL default '0',
  spy_row enum('1','2','3','4','5','6','7','8','9','10','11','12','13','14','15') NOT NULL default '1',
  sender_id int(11) NOT NULL default '0',
  datadate int(11) NOT NULL default '0',
  rawdata mediumtext NOT NULL,
  active enum('0','1') NOT NULL default '1',
  PRIMARY KEY  (spy_id),
  UNIQUE KEY spy_galaxy (spy_galaxy,spy_system,spy_row,datadate)
) ;

## ########################################################

## 
## Structure de la table `ogspy_statistics`
## 

CREATE TABLE ogspy_statistics (
  statistic_name varchar(255) NOT NULL default '',
  statistic_value varchar(255) NOT NULL default '0',
  PRIMARY KEY  (statistic_name)
) ;

## ########################################################

## 
## Structure de la table `ogspy_universe`
## 

CREATE TABLE ogspy_universe (
  galaxy enum('1','2','3','4','5','6','7','8','9') NOT NULL default '1',
  system smallint(3) NOT NULL default '0',
  `row` enum('1','2','3','4','5','6','7','8','9','10','11','12','13','14','15') NOT NULL default '1',
  moon enum('0','1') NOT NULL default '0',
  phalanx tinyint(1) NOT NULL,
  gate enum('0','1') NOT NULL default '0',
  `name` varchar(20) NOT NULL default '',
  ally varchar(20) default NULL,
  player varchar(20) default NULL,
  `status` varchar(5) NOT NULL,
  last_update int(11) NOT NULL default '0',
  last_update_moon int(11) NOT NULL default '0',
  last_update_user_id int(11) NOT NULL default '0',
  UNIQUE KEY univers (galaxy,system,`row`),
  KEY player (player)
) ;

## ########################################################

## 
## Structure de la table `ogspy_universe_temporary`
## 

CREATE TABLE ogspy_universe_temporary (
  player varchar(20) NOT NULL default '',
  ally varchar(20) NOT NULL default '',
  `status` varchar(5) NOT NULL,
  `timestamp` int(11) NOT NULL default '0'
) ;

## ########################################################

## 
## Structure de la table `ogspy_user_building`
## 

CREATE TABLE ogspy_user_building (
  user_id int(11) NOT NULL default '0',
  planet_id int(11) NOT NULL default '0',
  planet_name varchar(20) NOT NULL default '',
  coordinates varchar(8) NOT NULL default '',
  `fields` smallint(3) NOT NULL default '0',
  temperature smallint(2) NOT NULL default '0',
  Sat smallint(5) NOT NULL default '0',
  Sat_percentage smallint(3) NOT NULL default '100',
  M smallint(2) NOT NULL default '0',
  M_percentage smallint(3) NOT NULL default '100',
  C smallint(2) NOT NULL default '0',
  C_Percentage smallint(3) NOT NULL default '100',
  D smallint(2) NOT NULL default '0',
  D_percentage smallint(3) NOT NULL default '100',
  CES smallint(2) NOT NULL default '0',
  CES_percentage smallint(3) NOT NULL default '100',
  CEF smallint(2) NOT NULL default '0',
  CEF_percentage smallint(3) NOT NULL default '100',
  UdR smallint(2) NOT NULL default '0',
  UdN smallint(2) NOT NULL default '0',
  CSp smallint(2) NOT NULL default '0',
  HM smallint(2) NOT NULL default '0',
  HC smallint(2) NOT NULL default '0',
  HD smallint(2) NOT NULL default '0',
  Lab smallint(2) NOT NULL default '0',
  Ter smallint(2) NOT NULL default '0',
  Silo smallint(2) NOT NULL default '0',
  BaLu smallint(2) NOT NULL default '0',
  Pha smallint(2) NOT NULL default '0',
  PoSa smallint(2) NOT NULL default '0',
  PRIMARY KEY  (user_id,planet_id)
) ;

## ########################################################

## 
## Structure de la table `ogspy_user_defence`
## 

CREATE TABLE ogspy_user_defence (
  user_id int(11) NOT NULL default '0',
  planet_id int(11) NOT NULL default '0',
  LM int(11) NOT NULL default '0',
  LLE int(11) NOT NULL default '0',
  LLO int(11) NOT NULL default '0',
  CG int(11) NOT NULL default '0',
  AI int(11) NOT NULL default '0',
  LP int(11) NOT NULL default '0',
  PB smallint(1) NOT NULL default '0',
  GB smallint(1) NOT NULL default '0',
  MIC smallint(3) NOT NULL default '0',
  MIP smallint(3) NOT NULL default '0',
  PRIMARY KEY  (user_id,planet_id)
) ;

## ########################################################

## 
## Structure de la table `ogspy_user_favorite`
## 

CREATE TABLE ogspy_user_favorite (
  user_id int(11) NOT NULL default '0',
  galaxy enum('1','2','3','4','5','6','7','8','9') NOT NULL default '1',
  system smallint(3) NOT NULL default '0',
  UNIQUE KEY user_id (user_id,galaxy,system)
) ;

## ########################################################

## 
## Structure de la table `ogspy_user_spy`
## 

CREATE TABLE ogspy_user_spy (
  user_id int(11) NOT NULL default '0',
  spy_id int(11) NOT NULL default '0',
  PRIMARY KEY  (user_id,spy_id)
) ;

## ########################################################

## 
## Structure de la table `ogspy_user_technology`
## 

CREATE TABLE ogspy_user_technology (
  user_id int(11) NOT NULL default '0',
  Esp smallint(2) NOT NULL default '0',
  Ordi smallint(2) NOT NULL default '0',
  Armes smallint(2) NOT NULL default '0',
  Bouclier smallint(2) NOT NULL default '0',
  Protection smallint(2) NOT NULL default '0',
  NRJ smallint(2) NOT NULL default '0',
  Hyp smallint(2) NOT NULL default '0',
  RC smallint(2) NOT NULL default '0',
  RI smallint(2) NOT NULL default '0',
  PH smallint(2) NOT NULL default '0',
  Laser smallint(2) NOT NULL default '0',
  Ions smallint(2) NOT NULL default '0',
  Plasma smallint(2) NOT NULL default '0',
  RRI smallint(2) NOT NULL default '0',
  Graviton smallint(2) NOT NULL default '0',
  PRIMARY KEY  (user_id)
) ;

## ########################################################

## 
## Contenu de la table `ogspy_config`
## 

INSERT INTO `ogspy_config` VALUES ('allied', '');
INSERT INTO `ogspy_config` VALUES ('ally_protection', '');
INSERT INTO `ogspy_config` VALUES ('debug_log', '0');
INSERT INTO `ogspy_config` VALUES ('default_skin', 'skin/OGSpy_moderniste/');
INSERT INTO `ogspy_config` VALUES ('disable_ip_check', '1');
INSERT INTO `ogspy_config` VALUES ('keeprank_criterion', 'day');
INSERT INTO `ogspy_config` VALUES ('last_maintenance_action', '0');
INSERT INTO `ogspy_config` VALUES ('max_battlereport', '10');
INSERT INTO `ogspy_config` VALUES ('max_favorites', '20');
INSERT INTO `ogspy_config` VALUES ('max_favorites_spy', '10');
INSERT INTO `ogspy_config` VALUES ('max_keeplog', '7');
INSERT INTO `ogspy_config` VALUES ('max_keeprank', '30');
INSERT INTO `ogspy_config` VALUES ('max_keepspyreport', '30');
INSERT INTO `ogspy_config` VALUES ('max_spyreport', '10');
INSERT INTO `ogspy_config` VALUES ('reason', '');
INSERT INTO `ogspy_config` VALUES ('servername', 'Cartographie');
INSERT INTO `ogspy_config` VALUES ('server_active', '1');
INSERT INTO `ogspy_config` VALUES ('session_time', '30');
INSERT INTO `ogspy_config` VALUES ('url_forum', 'http://www.ogsteam.fr/index.php');
INSERT INTO `ogspy_config` VALUES ('version', 'Beta 1.00');

## ########################################################

## 
## Contenu de la table `ogspy_group`
## 

INSERT INTO `ogspy_group` VALUES (1, 'Anonyme', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `ogspy_group` VALUES (2, 'Standard', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `ogspy_group` VALUES (3, 'Membres', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1');
INSERT INTO `ogspy_group` VALUES (4, 'Moderateurs', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1');
INSERT INTO `ogspy_group` VALUES (5, 'Admin', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1');
INSERT INTO `ogspy_group` VALUES (6, 'Bots', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');