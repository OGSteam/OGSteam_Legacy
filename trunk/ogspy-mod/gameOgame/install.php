<?php
if (!defined('IN_SPYOGAME')) die('Hacking attempt');
//include('./parameters/id.php');
global $table_prefix;

$queries = array();

$queries[]  = 'INSERT INTO '.TABLE_MOD.' (id,title,menu,action,root,link,version,active) VALUES (\'\',\'gameOgame\',\'gameOgame\',\'gameOgame\',\'gameOgame\',\'index.php\',\'2.1b\',\'1\')';

//$queries[] = 'INSERT INTO '.TABLE_CONFIG.' (config_name,config_value) VALUES (\'gameOgame\',\'-1,1,3,4,10\')';

$queries[] = 'CREATE TABLE '.$table_prefix.'game (
  id INT(11) UNSIGNED NOT NULL auto_increment,
  sender INT(11) UNSIGNED NOT NULL DEFAULT \'0\',
  date INT(11) UNSIGNED NOT NULL DEFAULT \'0\',
  attaquant VARCHAR(255) NOT NULL DEFAULT \'0\',
  coord_att VARCHAR( 8 ) NOT NULL ,
  defenseur VARCHAR(255) NOT NULL DEFAULT \'0\',
  coord_def VARCHAR( 8 ) NOT NULL ,
  pertesA BIGINT UNSIGNED NOT NULL DEFAULT \'0\',
  pertesD BIGINT UNSIGNED NOT NULL DEFAULT \'0\',
  `%lune` mediumINT(2) UNSIGNED NOT NULL DEFAULT \'0\',
  lune TINYINT(1) UNSIGNED NOT NULL DEFAULT \'0\',
  pillageM BIGINT UNSIGNED NOT NULL DEFAULT \'0\',
  pillageC BIGINT UNSIGNED NOT NULL DEFAULT \'0\',
  pillageD BIGINT UNSIGNED NOT NULL DEFAULT \'0\',
  recyclageM BIGINT UNSIGNED NOT NULL DEFAULT \'0\',
  recyclageC BIGINT UNSIGNED NOT NULL DEFAULT \'0\',
  recycleM BIGINT UNSIGNED NOT NULL DEFAULT \'0\',
  recycleC BIGINT UNSIGNED NOT NULL DEFAULT \'0\',
  points BIGINT NOT NULL DEFAULT \'0\',
  rawdata text NOT NULL,
  PRIMARY KEY  (id),
  KEY sender (sender))';

$queries[] = 'CREATE TABLE '.$table_prefix.'game_users (
  id INT(11) UNSIGNED NOT NULL DEFAULT \'0\',
  admin TINYINT(1) UNSIGNED NOT NULL DEFAULT \'0\',
  user TINYINT(1) UNSIGNED NOT NULL DEFAULT \'0\',
  nb_rapport BIGINT NOT NULL COMMENT \'Nb de rapports supprimés\' DEFAULT \'0\',
  point BIGINT NOT NULL COMMENT \'points des rapports supprimés\' DEFAULT \'0\',
  PRIMARY KEY  (id))';
  
$queries[] = 'CREATE TABLE '.$table_prefix.'game_recyclage (
  id INT(11) UNSIGNED NOT NULL auto_increment,
  rc INT(11) UNSIGNED NOT NULL DEFAULT \'0\',
  recycleurs INT(11) UNSIGNED NOT NULL DEFAULT \'0\',
  capacite BIGINT(20) UNSIGNED NOT NULL DEFAULT \'0\',
  dispoM BIGINT(20) UNSIGNED NOT NULL DEFAULT \'0\',
  dispoC BIGINT(20) UNSIGNED NOT NULL DEFAULT \'0\',
  collecteM BIGINT(20) UNSIGNED NOT NULL DEFAULT \'0\',
  collecteC BIGINT(20) UNSIGNED NOT NULL DEFAULT \'0\',
  timestamp BIGINT UNSIGNED NOT NULL,
  PRIMARY KEY (id),
  KEY rc_id (rc))';
  

        ////////////////////////////////////////////////////////
        // DEBUT // Test enregistrement des rounds du combats //
        ////////////////////////////////////////////////////////
//// Structure de la table `'.$table_prefix.'game_parsedRC`
//$queries[] = "CREATE TABLE `'.$table_prefix.'game_parsedRC` (
//  `id_rc` int(11) NOT NULL auto_increment,
//  `dateRC` int(11) NOT NULL default '0',
//  `coordinates` varchar(9) NOT NULL default '',
//  `nb_rounds` int(2) NOT NULL default '0',
//  `victoire` char NOT NULL default 'A',
//  `pertes_A` int(11) NOT NULL default '0',
//  `pertes_D` int(11) NOT NULL default '0',
//  `gain_M` int(11) NOT NULL default '-1',
//  `gain_C` int(11) NOT NULL default '-1',
//  `gain_D` int(11) NOT NULL default '-1',
//  `debris_M` int(11) NOT NULL default '-1',
//  `debris_C` int(11) NOT NULL default '-1',
//  `lune` int(2) NOT NULL default '0',
//  PRIMARY KEY  (`id_rc`),
//  KEY `coordinatesrc` (`coordinates`)
//)";
//
//// Structure de la table `'.$table_prefix.'game_parsedRCRound`
//$queries[] = "CREATE TABLE `'.$table_prefix.'game_parsedRCRound` (
//  `id_rcround` int(11) NOT NULL auto_increment,
//  `id_rc` int(11) NOT NULL ,
//  `numround` int(2) NOT NULL ,
//  `attaque_tir` int(11) NOT NULL default '-1',
//  `attaque_puissance` int(11) NOT NULL default '-1',
//  `defense_bouclier` int(11) NOT NULL default '-1',
//  `attaque_bouclier` int(11) NOT NULL default '-1',
//  `defense_tir` int(11) NOT NULL default '-1',
//  `defense_puissance` int(11) NOT NULL default '-1',
//  PRIMARY KEY (id_rcround),
//  KEY `rcround` (`id_rc`,`numround`),
//  KEY `id_rc` (`id_rc`)
//)";
//
//// Structure de la table `'.$table_prefix.'game_round_attack`
//$queries[] = "CREATE TABLE `'.$table_prefix.'game_round_attack` (
//  `id_roundattack` int(11) NOT NULL auto_increment,
//  `id_rcround` int(11) NOT NULL ,
//  `player` varchar(30) NOT NULL default '',
//  `coordinates` varchar(9) NOT NULL default '',
//  `Armes` smallint(2) NOT NULL default '-1',
//  `Bouclier` smallint(2) NOT NULL default '-1',
//  `Protection` smallint(2) NOT NULL default '-1',
//  `PT` int(11) NOT NULL default '-1',
//  `GT` int(11) NOT NULL default '-1',
//  `CLE` int(11) NOT NULL default '-1',
//  `CLO` int(11) NOT NULL default '-1',
//  `CR` int(11) NOT NULL default '-1',
//  `VB` int(11) NOT NULL default '-1',
//  `VC` int(11) NOT NULL default '-1',
//  `REC` int(11) NOT NULL default '-1',
//  `SE` int(11) NOT NULL default '-1',
//  `BMD` int(11) NOT NULL default '-1',
//  `DST` int(11) NOT NULL default '-1',
//  `EDLM` int(11) NOT NULL default '-1',
//  `TRA` int(11) NOT NULL default '-1',
//  PRIMARY KEY  (`id_roundattack`),
//  KEY `id_rcround` (`id_rcround`),
//  KEY `player` (`player`,`coordinates`)
//)";
//
//// Structure de la table `'.$table_prefix.'game_round_defense`
//$queries[] = "CREATE TABLE `'.$table_prefix.'game_round_defense` (
//  `id_rounddefense` int(11) NOT NULL auto_increment,
//  `id_rcround` int(11) NOT NULL ,
//  `player` varchar(30) NOT NULL default '',
//  `coordinates` varchar(9) NOT NULL default '',
//  `Armes` smallint(2) NOT NULL default '-1',
//  `Bouclier` smallint(2) NOT NULL default '-1',
//  `Protection` smallint(2) NOT NULL default '-1',
//  `PT` int(11) NOT NULL default '-1',
//  `GT` int(11) NOT NULL default '-1',
//  `CLE` int(11) NOT NULL default '-1',
//  `CLO` int(11) NOT NULL default '-1',
//  `CR` int(11) NOT NULL default '-1',
//  `VB` int(11) NOT NULL default '-1',
//  `VC` int(11) NOT NULL default '-1',
//  `REC` int(11) NOT NULL default '-1',
//  `SE` int(11) NOT NULL default '-1',
//  `BMD` int(11) NOT NULL default '-1',
//  `DST` int(11) NOT NULL default '-1',
//  `EDLM` int(11) NOT NULL default '-1',
//  `SAT` int(11) NOT NULL default '-1',
//  `TRA` int(11) NOT NULL default '-1',
//  `LM` int(11) NOT NULL default '-1',
//  `LLE` int(11) NOT NULL default '-1',
//  `LLO` int(11) NOT NULL default '-1',
//  `CG` int(11) NOT NULL default '-1',
//  `AI` int(11) NOT NULL default '-1',
//  `LP` int(11) NOT NULL default '-1',
//  `PB` smallint(1) NOT NULL default '-1',
//  `GB` smallint(1) NOT NULL default '-1',
//  PRIMARY KEY  (`id_rounddefense`),
//  KEY `id_rcround` (`id_rcround`),
//  KEY `player` (`player`,`coordinates`)
//)";
        //////////////////////////////////////////////////////
        // FIN // Test enregistrement des rounds du combats //
        //////////////////////////////////////////////////////
    $config['pertes'] = -1;
    $config['degats'] = 1;
    $config['pillage'] = 3;
    $config['recycl'] = 4;
    $config['clune'] = 10;
    // Nouveaux paramètres
    $config['ligne'] = 20;
    $config['timer'] = time();
    $config['soft'] = 0;
    $config['autoS'] = "FALSE";
    $config['hard'] = 20;
    $config['autoH'] = "FALSE";
    $sqldata=serialize($config);
$queries[] = "INSERT INTO ".TABLE_MOD_CFG." VALUES ('gameOgame','config','".$sqldata."')";

foreach ($queries as $query) {
	$db->sql_query($query);
}
//On vérifie que la table xtense_callbacks existe (Xtense2)
if( mysql_num_rows( mysql_query("SHOW TABLES LIKE '".$table_prefix."xtense_callbacks"."'")))
  {
  // Si oui, on récupère le n° d'id du mod
  $query = "SELECT `id` FROM `".TABLE_MOD."` WHERE `action`='gameOgame' AND `active`='1' LIMIT 1";
  $result = $db->sql_query($query);
  $gog_id = $db->sql_fetch_row($result);
  $gog_id = $gog_id[0];
  // on fait du nettoyage au cas ou
  $query = "DELETE FROM `".$table_prefix."xtense_callbacks"."` WHERE `mod_id`=".$gog_id;
  $db->sql_query($query);
  // Insert les données pour récuperer les RC
  $query = "INSERT INTO ".$table_prefix."xtense_callbacks"." ( `mod_id` , `function` , `type` )
				VALUES ( '".$gog_id."', 'gog_rc', 'rc')";
  $db->sql_query($query);
  // Insert les données pour récuperer les RR
  $query = "INSERT INTO ".$table_prefix."xtense_callbacks"." ( `mod_id` , `function` , `type` )
                VALUES ( '".$gog_id."', 'gog_rr', 'rc_cdr')";
  $db->sql_query($query);
  }
?>
