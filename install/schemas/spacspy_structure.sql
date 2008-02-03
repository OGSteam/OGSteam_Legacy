#
# spacspy version 0.1
# 26 Septembre 2007
# 

## ########################################################

## 
## Structure de la table `spacspy_config`
## 

CREATE TABLE spacspy_config (
  config_name varchar(255) NOT NULL default '',
  config_value varchar(255) NOT NULL default '',
  PRIMARY KEY  (config_name)
) ;

## ########################################################

## 
## Structure de la table `spacspy_group`
## 

CREATE TABLE spacspy_group (
  group_id mediumint(8) NOT NULL auto_increment,
  group_name varchar(30) NOT NULL,
  server_set_system enum('0','1') NOT NULL default '0',
  server_set_spy enum('0','1') NOT NULL default '0',
  server_set_rc enum('0','1') NOT NULL default '0',
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
## Structure de la table `spacspy_mod`
## 

CREATE TABLE spacspy_mod (
  id int(11) NOT NULL auto_increment,
  title varchar(255) NOT NULL COMMENT 'Nom du mod',
  menu varchar(255) NOT NULL COMMENT 'Titre du lien dans le menu',
  `action` varchar(255) NOT NULL COMMENT 'Action transmise en get et traitée dans index.php',
  root varchar(255) NOT NULL COMMENT 'Répertoire où se situe le mod (relatif au répertoire mods)',
  link varchar(255) NOT NULL COMMENT 'fichier principale du mod',
  version varchar(5) NOT NULL COMMENT 'Version du mod',
  position int(11) NOT NULL default '-1',
  active tinyint(1) NOT NULL COMMENT 'Permet de désactiver un mod sans le désinstaller, évite les mods#pirates',
  admin_only enum('0','1') NOT NULL default '0' COMMENT 'Affichage des mods de l utilisateur',
  PRIMARY KEY  (id),
  UNIQUE KEY `action` (`action`),
  UNIQUE KEY title (title),
  UNIQUE KEY menu (menu),
  UNIQUE KEY root (root)
) ;

## ########################################################

## 
## Structure de la table `spacspy_rank_ally_fleet`
## 

CREATE TABLE spacspy_rank_ally_fleet (
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
## Structure de la table `spacspy_rank_ally_points`
## 

CREATE TABLE spacspy_rank_ally_points (
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
## Structure de la table `spacspy_rank_ally_research`
## 

CREATE TABLE spacspy_rank_ally_research (
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
## Structure de la table `spacspy_rank_ally_defenses`
## 

CREATE TABLE spacspy_rank_ally_defenses (
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
## Structure de la table `spacspy_rank_ally_mines`
## 

CREATE TABLE spacspy_rank_ally_mines (
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
## Structure de la table `spacspy_rank_player_fleet`
## 

CREATE TABLE spacspy_rank_player_fleet (
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
## Structure de la table `spacspy_rank_player_points`
## 

CREATE TABLE spacspy_rank_player_points (
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
## Structure de la table `spacspy_rank_player_research`
## 

CREATE TABLE spacspy_rank_player_research (
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
## Structure de la table `spacspy_rank_player_defenses`
## 

CREATE TABLE spacspy_rank_player_defenses (
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
## Structure de la table `spacspy_rank_player_mines`
## 

CREATE TABLE spacspy_rank_player_mines (
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
## Structure de la table `spacspy_sessions`
## 

CREATE TABLE spacspy_sessions (
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
## Structure de la table `spacspy_spy`
## 

CREATE TABLE spacspy_spy (
  spy_id int(11) NOT NULL auto_increment,
  spy_GALAXY_ENUM
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
## Structure de la table `spacspy_statistics`
## 

CREATE TABLE spacspy_statistics (
  statistic_name varchar(255) NOT NULL default '',
  statistic_value varchar(255) NOT NULL default '0',
  PRIMARY KEY  (statistic_name)
) ;

## ########################################################

## 
## Structure de la table `spacspy_universe`
## 

CREATE TABLE spacspy_universe (
  GALAXY_ENUM
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
## Structure de la table `spacspy_universe_temporary`
## 

CREATE TABLE spacspy_universe_temporary (
  player varchar(20) NOT NULL default '',
  ally varchar(20) NOT NULL default '',
  `status` varchar(5) NOT NULL,
  `timestamp` int(11) NOT NULL default '0'
) ;

## ########################################################

## 
## Structure de la table `spacspy_user`
## 

CREATE TABLE spacspy_user (
  user_id int(11) NOT NULL auto_increment,
  user_name varchar(20) NOT NULL default '',
  user_password varchar(32) NOT NULL default '',
  user_admin enum('0','1') NOT NULL default '0',
  user_coadmin enum('0','1') NOT NULL default '0',
  user_active enum('0','1') NOT NULL default '0',
  user_regdate int(11) NOT NULL default '0',
  user_lastvisit int(11) NOT NULL default '0',
  user_GALAXY_ENUM
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
  management_user enum('0','1') NOT NULL default '0',
  management_ranking enum('0','1') NOT NULL default '0',
  disable_ip_check enum('0','1') NOT NULL default '0',
  PRIMARY KEY  (user_id),
  UNIQUE KEY user_name (user_name)
) ;

## ########################################################

## 
## Structure de la table `spacspy_user_building`
## 

CREATE TABLE spacspy_user_building (
  user_id int(11) NOT NULL default '0',
  planet_id int(11) NOT NULL default '0',
  planet_name varchar(20) NOT NULL default '',
  coordinates varchar(8) NOT NULL default '',
  `fields` smallint(3) NOT NULL default '0',
  temperature smallint(2) NOT NULL default '0',
  ReSo smallint(5) NOT NULL default '0',
  ReSo_percentage smallint(3) NOT NULL default '100',
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
  CdC smallint(2) NOT NULL default '0',
  Silo smallint(2) NOT NULL default '0',
  Cc smallint(2) NOT NULL default '0',
  CrAt smallint(2) NOT NULL default '0',
  Pha smallint(2) NOT NULL default '0',
  PoSa smallint(2) NOT NULL default '0',
  PRIMARY KEY  (user_id,planet_id)
) ;

## ########################################################

## 
## Structure de la table `spacspy_user_defence`
## 

CREATE TABLE spacspy_user_defence (
  user_id int(11) NOT NULL default '0',
  planet_id int(11) NOT NULL default '0',
  CA int(11) NOT NULL default '0',
  TLM int(11) NOT NULL default '0',
  ASA int(11) NOT NULL default '0',
  CP int(11) NOT NULL default '0',
  AM int(11) NOT NULL default '0',
  Dem int(11) NOT NULL default '0',
  PB smallint(1) NOT NULL default '0',
  GB smallint(1) NOT NULL default '0',
  MIC smallint(3) NOT NULL default '0',
  MIP smallint(3) NOT NULL default '0',
  PRIMARY KEY  (user_id,planet_id)
) ;

## ########################################################

## 
## Structure de la table `spacspy_user_favorite`
## 

CREATE TABLE spacspy_user_favorite (
  user_id int(11) NOT NULL default '0',
  GALAXY_ENUM
  system smallint(3) NOT NULL default '0',
  UNIQUE KEY user_id (user_id,galaxy,system)
) ;

## ########################################################

## 
## Structure de la table `spacspy_user_group`
## 

CREATE TABLE spacspy_user_group (
  group_id mediumint(8) NOT NULL default '0',
  user_id mediumint(8) NOT NULL default '0',
  UNIQUE KEY group_id (group_id,user_id)
) ;

## ########################################################

## 
## Structure de la table `spacspy_user_spy`
## 

CREATE TABLE spacspy_user_spy (
  user_id int(11) NOT NULL default '0',
  spy_id int(11) NOT NULL default '0',
  PRIMARY KEY  (user_id,spy_id)
) ;

## ########################################################

## 
## Structure de la table `spacspy_user_technology`
## 

CREATE TABLE spacspy_user_technology (
  user_id int(11) NOT NULL default '0',
  Esp smallint(2) NOT NULL default '0',
  Gestion smallint(2) NOT NULL default '0',
  Armes smallint(2) NOT NULL default '0',
  Bouclier smallint(2) NOT NULL default '0',
  Blindage smallint(2) NOT NULL default '0',
  NRJ smallint(2) NOT NULL default '0',
  Hyp smallint(2) NOT NULL default '0',
  RC smallint(2) NOT NULL default '0',
  RI smallint(2) NOT NULL default '0',
  PH smallint(2) NOT NULL default '0',
  Laser smallint(2) NOT NULL default '0',
  Ions smallint(2) NOT NULL default '0',
  Plasma smallint(2) NOT NULL default '0',
  Antimatiere smallint(2) NOT NULL default '0',
  PRIMARY KEY  (user_id)
) ;

## ########################################################

##
## Structure de la table `spacspy_mod_config`
##

CREATE TABLE `spacspy_mod_config` (
  `mod` varchar(50) NOT NULL DEFAULT '',
  `config` varchar(255) NOT NULL DEFAULT '',
  `value` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY  (`mod`,`config`)
);
## ########################################################

## 
## Contenu de la table `spacspy_config`
## 

INSERT INTO `spacspy_config` VALUES ('allied', '');
INSERT INTO `spacspy_config` VALUES ('ally_protection', '');
INSERT INTO `spacspy_config` VALUES ('debug_log', '0');
INSERT INTO `spacspy_config` VALUES ('default_skin', 'skin/spacspy_skin/');
INSERT INTO `spacspy_config` VALUES ('disable_ip_check', '1');
INSERT INTO `spacspy_config` VALUES ('keeprank_criterion', 'day');
INSERT INTO `spacspy_config` VALUES ('last_maintenance_action', '0');
INSERT INTO `spacspy_config` VALUES ('max_battlereport', '10');
INSERT INTO `spacspy_config` VALUES ('max_favorites', '20');
INSERT INTO `spacspy_config` VALUES ('max_favorites_spy', '10');
INSERT INTO `spacspy_config` VALUES ('max_keeplog', '7');
INSERT INTO `spacspy_config` VALUES ('max_keeprank', '30');
INSERT INTO `spacspy_config` VALUES ('max_keepspyreport', '30');
INSERT INTO `spacspy_config` VALUES ('max_spyreport', '10');
INSERT INTO `spacspy_config` VALUES ('reason', '');
INSERT INTO `spacspy_config` VALUES ('servername', 'Cartographie');
INSERT INTO `spacspy_config` VALUES ('server_active', '1');
INSERT INTO `spacspy_config` VALUES ('session_time', '30');
INSERT INTO `spacspy_config` VALUES ('url_forum', 'http://ogsteam.fr/index.php');
INSERT INTO `spacspy_config` VALUES ('log_phperror', '0');
INSERT INTO `spacspy_config` VALUES ('version', '3.05');

## Partie affichage

INSERT INTO `spacspy_config` VALUES ('enable_stat_view', '1');
INSERT INTO `spacspy_config` VALUES ('enable_members_view', '0');
INSERT INTO `spacspy_config` VALUES ('enable_register_view', '0');
INSERT INTO `spacspy_config` VALUES ('register_forum', '');
INSERT INTO `spacspy_config` VALUES ('register_alliance', '');
INSERT INTO `spacspy_config` VALUES ('galaxy_by_line_stat', '9');
INSERT INTO `spacspy_config` VALUES ('system_by_line_stat', '10');
INSERT INTO `spacspy_config` VALUES ('galaxy_by_line_ally', '9');
INSERT INTO `spacspy_config` VALUES ('system_by_line_ally', '10');
INSERT INTO `spacspy_config` VALUES ('color_ally', 'Magenta_Yellow_Red');
INSERT INTO `spacspy_config` VALUES ('nb_colonnes_ally', '3');

## ########################################################

## 
## Contenu de la table `spacspy_group`
## 

INSERT INTO `spacspy_group` VALUES (1, 'Standard', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1');

## ########################################################

##
## Structure de la table `spacspy_parsedspy`
##

CREATE TABLE `spacspy_parsedspy` (
  `id_spy` int(11) NOT NULL auto_increment,
  `planet_name` varchar(20) NOT NULL default '',
  `coordinates` varchar(9) NOT NULL default '',
  `Acier` int(7) NOT NULL default '-1',
  `Silicium` int(7) NOT NULL default '-1',
  `Deutéride` int(7) NOT NULL default '-1',
  `energie` int(7) NOT NULL default '-1',
  `activite` int(2) NOT NULL default '-1',
  `M` smallint(2) NOT NULL default '-1',
  `C` smallint(2) NOT NULL default '-1',
  `D` smallint(2) NOT NULL default '-1',
  `CES` smallint(2) NOT NULL default '-1',
  `CEF` smallint(2) NOT NULL default '-1',
  `UdR` smallint(2) NOT NULL default '-1',
  `UdN` smallint(2) NOT NULL default '-1',
  `CSp` smallint(2) NOT NULL default '-1',
  `HM` smallint(2) NOT NULL default '-1',
  `HC` smallint(2) NOT NULL default '-1',
  `HD` smallint(2) NOT NULL default '-1',
  `Lab` smallint(2) NOT NULL default '-1',
  `CdC` smallint(2) NOT NULL default '-1',
  `Silo` smallint(2) NOT NULL default '-1',
  `Cc` smallint(2) NOT NULL default '-1',
  `CrAt` smallint(2) NOT NULL default '-1',
  `Pha` smallint(2) NOT NULL default '-1',
  `PoSa` smallint(2) NOT NULL default '-1',
  `CA` int(11) NOT NULL default '-1',
  `TLM` int(11) NOT NULL default '-1',
  `ASA` int(11) NOT NULL default '-1',
  `CP` int(11) NOT NULL default '-1',
  `AM` int(11) NOT NULL default '-1',
  `Dem` int(11) NOT NULL default '-1',
  `PB` smallint(1) NOT NULL default '-1',
  `GB` smallint(1) NOT NULL default '-1',
  `MIC` smallint(3) NOT NULL default '-1',
  `MIP` smallint(3) NOT NULL default '-1',  
  `PC` int(11) NOT NULL default '-1',
  `GC` int(11) NOT NULL default '-1',
  `CHA` int(11) NOT NULL default '-1',
  `CHABL` int(11) NOT NULL default '-1',
  `FREG` int(11) NOT NULL default '-1',
  `VC` int(11) NOT NULL default '-1',
  `COLO` int(11) NOT NULL default '-1',
  `REC` int(11) NOT NULL default '-1',
  `DRO` int(11) NOT NULL default '-1',
  `TORP` int(11) NOT NULL default '-1',
  `LEV` int(11) NOT NULL default '-1',
  `ECNO` int(11) NOT NULL default '-1',
  `ReSo` int(11) default '-1',
  `Esp` smallint(2) NOT NULL default '-1',
  `Gestion` smallint(2) NOT NULL default '-1',
  `Armes` smallint(2) NOT NULL default '-1',
  `Bouclier` smallint(2) NOT NULL default '-1',
  `Blindage` smallint(2) NOT NULL default '-1',
  `NRJ` smallint(2) NOT NULL default '-1',
  `Hyp` smallint(2) NOT NULL default '-1',
  `RC` smallint(2) NOT NULL default '-1',
  `RI` smallint(2) NOT NULL default '-1',
  `PH` smallint(2) NOT NULL default '-1',
  `Laser` smallint(2) NOT NULL default '-1',
  `Ions` smallint(2) NOT NULL default '-1',
  `Plasma` smallint(2) NOT NULL default '-1',
  `Antimatiere` smallint(2) NOT NULL default '-1',
  `dateRE` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id_spy`),
  KEY `coordinates` (`coordinates`)
);
## ########################################################

##
## Structure de la table `spacspy_parsedRC`
##

CREATE TABLE `spacspy_parsedRC` (
  `id_rc` int(11) NOT NULL auto_increment,
  `dateRC` int(11) NOT NULL default '0',
  `coordinates` varchar(9) NOT NULL default '',
  `nb_rounds` int(2) NOT NULL default '0',
  `victoire` char NOT NULL default 'A',
  `pertes_A` int(11) NOT NULL default '0',
  `pertes_D` int(11) NOT NULL default '0',
  `gain_M` int(11) NOT NULL default '-1',
  `gain_C` int(11) NOT NULL default '-1',
  `gain_D` int(11) NOT NULL default '-1',
  `debris_M` int(11) NOT NULL default '-1',
  `debris_C` int(11) NOT NULL default '-1',
  `lune` int(2) NOT NULL default '0',
  PRIMARY KEY  (`id_rc`),
  KEY `coordinatesrc` (`coordinates`)
);
## ########################################################

##
## Structure de la table `spacspy_parsedRCRound`
##

CREATE TABLE `spacspy_parsedRCRound` (
  `id_rcround` int(11) NOT NULL auto_increment,
  `id_rc` int(11) NOT NULL ,
  `numround` int(2) NOT NULL ,
  `attaque_tir` int(11) NOT NULL default '-1',
  `attaque_puissance` int(11) NOT NULL default '-1',
  `defense_bouclier` int(11) NOT NULL default '-1',
  `attaque_bouclier` int(11) NOT NULL default '-1',
  `defense_tir` int(11) NOT NULL default '-1',
  `defense_puissance` int(11) NOT NULL default '-1',
  PRIMARY KEY (id_rcround),
  KEY `rcround` (`id_rc`,`numround`),
  KEY `id_rc` (`id_rc`)
);
## ########################################################

##
## Structure de la table `spacspy_round_attack`
##

CREATE TABLE `spacspy_round_attack` (
  `id_roundattack` int(11) NOT NULL auto_increment,
  `id_rcround` int(11) NOT NULL ,
  `player` varchar(30) NOT NULL default '',
  `coordinates` varchar(9) NOT NULL default '',
  `Armes` smallint(2) NOT NULL default '-1',
  `Bouclier` smallint(2) NOT NULL default '-1',
  `Blindage` smallint(2) NOT NULL default '-1',
  `PC` int(11) NOT NULL default '-1',
  `GC` int(11) NOT NULL default '-1',
  `CHA` int(11) NOT NULL default '-1',
  `CHABL` int(11) NOT NULL default '-1',
  `FREG` int(11) NOT NULL default '-1',
  `VC` int(11) NOT NULL default '-1',
  `COLO` int(11) NOT NULL default '-1',
  `REC` int(11) NOT NULL default '-1',
  `DRO` int(11) NOT NULL default '-1',
  `TORP` int(11) NOT NULL default '-1',
  `LEV` int(11) NOT NULL default '-1',
  `ECNO` int(11) NOT NULL default '-1',	
  PRIMARY KEY  (`id_roundattack`),
  KEY `id_rcround` (`id_rcround`),
  KEY `player` (`player`,`coordinates`)
);
## ########################################################

##
## Structure de la table `spacspy_round_defense`
##

CREATE TABLE `spacspy_round_defense` (
  `id_rounddefense` int(11) NOT NULL auto_increment,
  `id_rcround` int(11) NOT NULL ,
  `player` varchar(30) NOT NULL default '',
  `coordinates` varchar(9) NOT NULL default '',
  `Armes` smallint(2) NOT NULL default '-1',
  `Bouclier` smallint(2) NOT NULL default '-1',
  `Blindage` smallint(2) NOT NULL default '-1',
  `PC` int(11) NOT NULL default '-1',
  `GT` int(11) NOT NULL default '-1',
  `CLE` int(11) NOT NULL default '-1',
  `CLO` int(11) NOT NULL default '-1',
  `CR` int(11) NOT NULL default '-1',
  `VB` int(11) NOT NULL default '-1',
  `VC` int(11) NOT NULL default '-1',
  `REC` int(11) NOT NULL default '-1',
  `SE` int(11) NOT NULL default '-1',
  `BMD` int(11) NOT NULL default '-1',
  `LEV` int(11) NOT NULL default '-1',
  `ECNO` int(11) NOT NULL default '-1',
  `ReSo` int(11) NOT NULL default '-1',
  `TRA` int(11) NOT NULL default '-1',
  `CA` int(11) NOT NULL default '-1',
  `TLM` int(11) NOT NULL default '-1',
  `ASA` int(11) NOT NULL default '-1',
  `CP` int(11) NOT NULL default '-1',
  `AM` int(11) NOT NULL default '-1',
  `Dem` int(11) NOT NULL default '-1',
  `PB` smallint(1) NOT NULL default '-1',
  `GB` smallint(1) NOT NULL default '-1',
  PRIMARY KEY  (`id_rounddefense`),
  KEY `id_rcround` (`id_rcround`),
  KEY `player` (`player`,`coordinates`)
);
