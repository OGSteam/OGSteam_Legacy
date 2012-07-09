<?php
/**
* Mise à jour d'OGSpy : update_to_latest.php
* @package OGSpy
* @subpackage install
* @created 28/11/2005
* @modified 30/09/2007
* @version 3.0.7
*/
?>
<html>
<head>
<title>Mise à jour OGSpy</title>
<link rel="stylesheet" type="text/css" href="../skin/OGSpy_skin/formate.css" />
</head>
<body>

<?php
define("IN_SPYOGAME", true);
define("UPGRADE_IN_PROGRESS", true);

require_once("../common.php");

// on réinitialise la sequense config
// evite d utiliser le cache ( qui sera périmé ))
$request = "select * from " . TABLE_CONFIG;
$result = mysql_query($request);
 while (list($name, $value) = mysql_fetch_row($result)) {
        $server_config[$name] = stripslashes($value);
    }
    

$request = "SELECT config_value FROM ".TABLE_CONFIG." WHERE config_name = 'version'";
$result = $db->sql_query($request);
list($ogsversion) = $db->sql_fetch_row($result);

$requests = array();
$up_to_date = false;
switch ($ogsversion) {
	case "0.3" :
	$requests[] = "UPDATE ".TABLE_CONFIG." SET config_value = '0.300c' WHERE config_name = 'version'";
	$ogsversion = "0.300c";
	break;


	case "0.300c" :
	$requests[] = "DROP TABLE if exists ".TABLE_SESSIONS;

	$requests[] = "CREATE TABLE ".TABLE_SESSIONS." (".
	" session_id char(32) NOT NULL default '',".
	" session_user_id int(11) NOT NULL default '0',".
	" session_start int(11) NOT NULL default '0',".
	" session_expire int(11) NOT NULL default '0',".
	" session_ip char(32) NOT NULL default '',".
	" session_ogs ENUM('0','1') NOT NULL default '0',".
	" unique key session_id (session_id,session_ip)".
	")";

	$requests[] = "UPDATE ".TABLE_CONFIG." SET config_value = '0.300d' WHERE config_name = 'version'";
	$ogsversion = "0.300d";
	break;


	case "0.300d" :
	$requests[] = "INSERT INTO ".TABLE_CONFIG." (config_name, config_value)".
	" VALUES ('url_forum', 'http://www.ogsteam.fr/index.php')";

	$requests[] = "UPDATE ".TABLE_CONFIG." SET config_value = '0.300e' WHERE config_name = 'version'";
	$ogsversion = "0.300e";
	break;


	case "0.300e":
	$requests[] = "UPDATE ".TABLE_CONFIG." SET config_value = '0.300f' WHERE config_name = 'version'";
	$ogsversion = "0.300f";
	break;


	case "0.300f":
	$requests[] = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value)".
	" VALUES ('url_forum', 'http://ogsteam.fr/index.php')"; //Requete préventive pour cause d'erreur lors de la mise à jour 0.300d-0.300e

	$requests[] = "ALTER TABLE ".$table_prefix."rank_fleet ADD index (datadate, player)";

	$requests[] = "ALTER TABLE ".$table_prefix."rank_points ADD index (datadate, player)";

	$requests[] = "ALTER TABLE ".$table_prefix."rank_research ADD index (datadate, player)";

	$requests[] = "ALTER TABLE ".TABLE_SESSIONS." ADD session_lastvisit int NOT NULL";

	$requests[] = "INSERT INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('max_keeprank', '30')";

	$requests[] = "INSERT INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('keeprank_criterion', 'quantity')";

	$requests[] = "INSERT INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('max_keepspyreport', '30')";

	$requests[] = "INSERT INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('servername', 'Serveur d\'alliance')";

	$requests[] = "ALTER TABLE ".TABLE_UNIVERSE." CHANGE status status varchar(5) NOT NULL";

	$requests[] = "ALTER TABLE ".TABLE_USER." ADD rank_added_web int NOT NULL after spy_added_ogs, ADD rank_added_ogs int NOT NULL after rank_added_web";

	$requests[] = "UPDATE ".TABLE_CONFIG." SET config_value = '0.301' WHERE config_name = 'version'";
	$ogsversion = "0.301";
	break;


	case "0.301":
	$requests[] = "UPDATE ".TABLE_CONFIG." SET config_value = '0.301b' WHERE config_name = 'version'";
	$ogsversion = "0.301b";
	break;


	case "0.301b":
	$requests[] = "INSERT INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('allied', '')";

	$requests[] = "INSERT INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('max_favorites_spy', '10')";

	$requests[] = "INSERT INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('last_maintenance_action', '0')";

	$requests[] = "CREATE TABLE ".TABLE_GROUP." (".
	" group_id mediumint(8) NOT NULL auto_increment,".
	" group_name varchar(30) NOT NULL,".
	" server_set_system ENUM('0','1') NOT NULL default '0',".
	" server_set_spy ENUM('0','1') NOT NULL default '0',".
	" server_set_ranking ENUM('0','1') NOT NULL default '0',".
	" server_show_positionhided ENUM('0','1') NOT NULL default '0',".
	" ogs_connection ENUM('0','1') NOT NULL default '0',".
	" ogs_set_system ENUM('0','1') NOT NULL default '0',".
	" ogs_get_system ENUM('0','1') NOT NULL default '0',".
	" ogs_set_spy ENUM('0','1') NOT NULL default '0',".
	" ogs_get_spy ENUM('0','1') NOT NULL default '0',".
	" ogs_set_ranking ENUM('0','1') NOT NULL default '0',".
	" ogs_get_ranking ENUM('0','1') NOT NULL default '0',".
	" primary key ( group_id )".
	")";

	$requests[] = "INSERT INTO ".TABLE_GROUP." (group_id, group_name) VALUES (1, 'Standard')";

	$requests[] = "ALTER TABLE ".TABLE_UNIVERSE." change status status varchar(5) NOT NULL";

	$requests[] = "ALTER TABLE ".TABLE_USER." DROP user_moderator, DROP user_auth_import_web, DROP user_auth_import_ogs, DROP user_auth_export_ogs";

	$requests[] = "ALTER TABLE ".TABLE_USER." ADD management_user ENUM('0','1') NOT NULL DEFAULT '0',".
	"ADD management_ranking ENUM('0','1') NOT NULL DEFAULT '0',".
	"ADD user_stat_name VARCHAR(50) NOT NULL AFTER user_skin";

	$requests[] = "ALTER TABLE ".TABLE_USER." ADD user_coadmin ENUM('0', '1') NOT NULL DEFAULT '0' AFTER user_admin";

	$requests[] = "CREATE TABLE ".TABLE_USER_GROUP." (".
	" group_id mediumint(8) NOT NULL default '0',".
	" user_id mediumint(8) NOT NULL default '0',".
	" UNIQUE KEY group_id (group_id,user_id)".
	" )";

	$requests[] = "INSERT INTO ".TABLE_USER_GROUP." (group_id, user_id) SELECT 1, user_id FROM ".TABLE_USER;

	$requests[] = "ALTER TABLE ".TABLE_UNIVERSE." ADD phalanx TINYINT(1) NOT NULL AFTER moon, ADD gate ENUM('0','1') NOT NULL DEFAULT '0' AFTER phalanx, ADD last_update_moon INT NOT NULL DEFAULT '0' AFTER last_update;";

	$requests[] = "ALTER TABLE ".TABLE_SPY." ADD active ENUM('0','1') NOT NULL DEFAULT '1'";

	$requests[] = "CREATE TABLE ".TABLE_USER_DEFENCE." (".
	" user_id int(11) NOT NULL default '0',".
	" planet_id int(11) NOT NULL default '0',".
	" LM smallint(5) NOT NULL default '0',".
	" LLE smallint(5) NOT NULL default '0',".
	" LLO smallint(5) NOT NULL default '0',".
	" CG smallint(5) NOT NULL default '0',".
	" AI smallint(5) NOT NULL default '0',".
	" LP smallint(5) NOT NULL default '0',".
	" PB smallint(1) NOT NULL default '0',".
	" GB smallint(1) NOT NULL default '0',".
	" MIC smallint(3) NOT NULL default '0',".
	" MIP smallint(3) NOT NULL default '0',".
	" PRIMARY KEY  (user_id, planet_id)".
	" )";

	$requests[] = "ALTER TABLE ".TABLE_USER_BUILDING." ADD BaLu SMALLINT( 2 ) NOT NULL DEFAULT '0',".
	" ADD Pha SMALLINT( 2 ) NOT NULL DEFAULT '0',".
	" ADD PoSa SMALLINT( 2 ) NOT NULL DEFAULT '0'";

	$requests[] = "CREATE TABLE ".TABLE_RANK_ALLY_FLEET." (".
	" datadate int(11) NOT NULL default '0',".
	" rank int(11) NOT NULL default '0',".
	" ally varchar(30) NOT NULL,".
	" number_member int(11) NOT NULL,".
	" points int(11) NOT NULL default '0',".
	" points_per_member int(11) NOT NULL,".
	" sender_id int(11) NOT NULL default '0',".
	" PRIMARY KEY  (rank,datadate),".
	" KEY datadate (datadate,ally),".
	" KEY ally (ally)".
	" )";

	$requests[] = "CREATE TABLE ".TABLE_RANK_ALLY_POINTS." (".
	" datadate int(11) NOT NULL default '0',".
	" rank int(11) NOT NULL default '0',".
	" ally varchar(30) NOT NULL,".
	" number_member int(11) NOT NULL,".
	" points int(11) NOT NULL default '0',".
	" points_per_member int(11) NOT NULL,".
	" sender_id int(11) NOT NULL default '0',".
	" PRIMARY KEY  (rank,datadate),".
	" KEY datadate (datadate,ally),".
	" KEY ally (ally)".
	" )";

	$requests[] = "CREATE TABLE ".TABLE_RANK_ALLY_RESEARCH." (".
	" datadate int(11) NOT NULL default '0',".
	" rank int(11) NOT NULL default '0',".
	" ally varchar(30) NOT NULL,".
	" number_member int(11) NOT NULL,".
	" points int(11) NOT NULL default '0',".
	" points_per_member int(11) NOT NULL,".
	" sender_id int(11) NOT NULL default '0',".
	" PRIMARY KEY  (rank,datadate),".
	" KEY datadate (datadate,ally),".
	" KEY ally (ally)".
	" )";

	$requests[] = "ALTER TABLE ".$table_prefix."rank_fleet RENAME ".TABLE_RANK_PLAYER_FLEET;

	$requests[] = "ALTER TABLE ".$table_prefix."rank_points RENAME ".TABLE_RANK_PLAYER_POINTS;

	$requests[] = "ALTER TABLE ".$table_prefix."rank_research RENAME ".TABLE_RANK_PLAYER_RESEARCH;

	$requests[] = "ALTER TABLE ".TABLE_RANK_PLAYER_FLEET." ADD INDEX ( player )";

	$requests[] = "ALTER TABLE ".TABLE_RANK_PLAYER_POINTS." ADD INDEX ( player )";

	$requests[] = "ALTER TABLE ".TABLE_RANK_PLAYER_RESEARCH." ADD INDEX ( player )";

	$requests[] = "UPDATE ".TABLE_USER." SET planet_added_web = planet_added_web + planet_modified_web, planet_added_ogs = planet_added_ogs + planet_modified_ogs";

	$requests[] = "ALTER TABLE ".TABLE_USER." DROP planet_modified_web , DROP planet_modified_ogs";

	$requests[] = "ALTER TABLE ".TABLE_USER." ADD planet_exported INT NOT NULL AFTER planet_added_ogs";

	$requests[] = "ALTER TABLE ".TABLE_USER." ADD spy_exported INT NOT NULL AFTER spy_added_ogs";

	$requests[] = "ALTER TABLE ".TABLE_USER." ADD rank_exported INT NOT NULL AFTER rank_added_ogs";

	$requests[] = "ALTER TABLE ".TABLE_USER_DEFENCE.
	" CHANGE LM LM INT NOT NULL DEFAULT '0',".
	" CHANGE LLE LLE INT NOT NULL DEFAULT '0',".
	" CHANGE LLO LLO INT NOT NULL DEFAULT '0',".
	" CHANGE CG CG INT NOT NULL DEFAULT '0',".
	" CHANGE AI AI INT NOT NULL DEFAULT '0',".
	" CHANGE LP LP INT NOT NULL DEFAULT '0'";

	$requests[] = "CREATE TABLE ".TABLE_MOD." (".
	" id int(11) NOT NULL auto_increment,".
	" title varchar(255) NOT NULL COMMENT 'Nom du mod',".
	" menu varchar(255) NOT NULL COMMENT 'Titre du lien dans le menu',".
	" action varchar(255) NOT NULL COMMENT 'Action transmise en get et traitée dans index.php',".
	" root varchar(255) NOT NULL COMMENT 'Répertoire où se situe le mod (relatif au répertoire mods)',".
	" link varchar(255) NOT NULL COMMENT 'fichier principale du mod',".
	" version varchar(5) NOT NULL COMMENT 'Version du mod',".
	" active tinyint(1) NOT NULL COMMENT 'Permet de désactiver un mod sans le désinstaller, évite les mods#pirates',".
	" PRIMARY KEY  (id),".
	" UNIQUE KEY action (action),".
	" UNIQUE KEY title (title),".
	" UNIQUE KEY menu (menu),".
	" UNIQUE KEY root (root)".
	" )";

	$requests[] = "ALTER TABLE ".TABLE_UNIVERSE_TEMPORARY." ADD status VARCHAR( 5 ) NOT NULL AFTER ally";

	$requests[] = "UPDATE ".TABLE_CONFIG." SET config_value = '3.02' WHERE config_name = 'version'";
	$ogsversion = "3.02";
	break;


	case "3.02":
	$requests[] = "UPDATE ".TABLE_CONFIG." SET config_value = '3.02b' WHERE config_name = 'version'";	
	$ogsversion = "3.02b";
	break;


	case "3.02b":	
	$requests[] = "INSERT INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('disable_ip_check', '0')";
	
	$requests[] = "ALTER TABLE ".TABLE_USER." ADD disable_ip_check ENUM( '0', '1' ) NOT NULL DEFAULT '0'";
	
	$requests[] = "ALTER TABLE ".TABLE_MOD." ADD position INT NOT NULL DEFAULT '-1'";
	
	$requests[] = "UPDATE ".TABLE_CONFIG." SET config_value = '3.02c' WHERE config_name = 'version'";
	$ogsversion = "3.02c";
	break;
	
	//nevada51
	case "3.02c":
		$requests[] = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('galaxy_by_line_stat','10')";
		$requests[] = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('system_by_line_stat','25')";
		$requests[] = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('enable_stat_view','1')";
		$requests[] = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('enable_members_view','1')";
		$requests[] = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('galaxy_by_line_ally','10')";
		$requests[] = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('system_by_line_ally','25')";
		$requests[] = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('color_ally1','Magenta')";
		$requests[] = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('color_ally2','Yellow')";
		$requests[] = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('color_ally3','Red')";
		$num_of_galaxies = ( isset ( $num_of_galaxies ) ) ? $num_of_galaxies:9;
		$num_of_systems = ( isset ( $num_of_systems ) ) ? $num_of_systems:499;
		$requests[] = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('num_of_galaxies','$num_of_galaxies')";
		$requests[] = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('num_of_systems','$num_of_systems')";
		$requests[] = "UPDATE ".TABLE_CONFIG." SET config_value = '3.03' WHERE config_name = 'version'";
		$ogsversion = "3.03";		//Identificateur de la version:
		break;
		//fin nevada51
	case "3.03":

		$sgbd_tableprefix = $table_prefix;
		$ogsversion = "3.04";
		$num_of_galaxies = ( isset ( $num_of_galaxies ) ) ? $num_of_galaxies:9;
		$num_of_systems = ( isset ( $num_of_systems ) ) ? $num_of_systems:499;
		$requests[] = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('num_of_galaxies','$num_of_galaxies')";
		$requests[] = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('num_of_systems','$num_of_systems')";
		$requests[] = "UPDATE ".TABLE_CONFIG." SET config_value = '3.04' WHERE config_name = 'version'";
		$query="SELECT id FROM ".TABLE_MOD." WHERE action='xtense'";
		$result=$db->sql_query($query);
		if ( $db->sql_numrows($result) == 0 ) {
			require_once("../mod/Xtense/install.php");
		}
		else {
			require_once("../mod/Xtense/update.php");
		}
		$query="SELECT id FROM ".TABLE_MOD." WHERE action='autoupdate'";
		$result=$db->sql_query($query);
		if ( $db->sql_numrows($result) == 0 ) {
			require_once("../mod/autoupdate/install.php");
		}
		else {
			require_once("../mod/autoupdate/update.php");
		}
		$ogsversion = "3.04";
		break;
		
	case "3.04":
		$requests[] = "CREATE TABLE ".TABLE_MOD_CFG." ( `mod` varchar(50) NOT NULL DEFAULT '', `config` varchar(255) NOT NULL DEFAULT '', `value` varchar(255) NOT NULL DEFAULT '', PRIMARY KEY  (`mod`,`config`) );";
		$requests[] = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('log_phperror','0')";
		$up_to_date = true;
		$requests[] = "ALTER TABLE ".TABLE_MOD." ADD `admin_only` ENUM( '0', '1' ) NOT NULL DEFAULT '0' COMMENT 'Affichage des mods de l utilisateur';";
		$requests[] = "UPDATE ".TABLE_CONFIG." SET config_value = '3.04b' WHERE config_name = 'version'";
		$query="SELECT id FROM ".TABLE_MOD." WHERE action='xtense'";
		$result=$db->sql_query($query);
		if ( $db->sql_numrows($result) == 0 ) {
			require_once("../mod/Xtense/install.php");
		}
		else {
			require_once("../mod/Xtense/update.php");
		}
		$query="SELECT id, root FROM ".TABLE_MOD." WHERE action='autoupdate'";
		$result=$db->sql_query($query);
		if ( $db->sql_numrows($result) == 0 ) {
			require_once("../mod/autoupdate/install.php");
		}
		else {
			list ( $pub_mod_id, $pub_modroot ) = $db->sql_fetch_row ( $result );
			require_once("../mod/autoupdate/update.php");
		}
		$ogsversion = "3.04b";
		break;
		
	case "3.04b":
		$requests[] = "INSERT INTO ".TABLE_CONFIG." VALUES ('enable_register_view', '0');";
		$requests[] = "INSERT INTO ".TABLE_CONFIG." VALUES ('register_forum', '');";
		$requests[] = "INSERT INTO ".TABLE_CONFIG." VALUES ('register_alliance', '');";
		$requests[] = "DELETE FROM ".TABLE_CONFIG." WHERE config_name = 'color_ally1';";
		$requests[] = "DELETE FROM ".TABLE_CONFIG." WHERE config_name = 'color_ally2';";
		$requests[] = "DELETE FROM ".TABLE_CONFIG." WHERE config_name = 'color_ally3';";
		$requests[] = "INSERT INTO ".TABLE_CONFIG." VALUES ('color_ally', 'Magenta_Yellow_Red');";
		$requests[] = "INSERT INTO ".TABLE_CONFIG." VALUES ('nb_colonnes_ally', '3');";
		$requests[] = "INSERT INTO ".TABLE_CONFIG." VALUES ('block_ratio', '0');";
		$requests[] = "INSERT INTO ".TABLE_CONFIG." VALUES ('ratio_limit', '0');";
		$requests[] = "INSERT INTO ".TABLE_CONFIG." VALUES ('speed_uni', '1');";
		$requests[] = "INSERT INTO ".TABLE_CONFIG." VALUES ('ddr', 'false');";
		$requests[] = "ALTER TABLE ".TABLE_GROUP." ADD server_set_rc enum('0','1') NOT NULL default '0';";
		$query = 'SHOW FIELDS FROM ' . TABLE_USER_TECHNOLOGY;
		$res = $db->sql_query ( $query );
		$exped_ok = false;
		while ( list ( $techno ) = $db->sql_fetch_row ( $res ) )
		{
			if ( $techno == 'Expeditions' )
			{
				$exped_ok = true;
				break;
			}
		}
		if ( $exped_ok == false )
			$requests[] = "ALTER TABLE ".TABLE_USER_TECHNOLOGY." ADD Expeditions SMALLINT(2) NOT NULL default '0'";
		$requests[] = "ALTER TABLE ".TABLE_USER_BUILDING." ADD DdR SMALLINT(2) NOT NULL default '0'";
		$requests[] = "CREATE TABLE IF NOT EXISTS `".TABLE_PARSEDSPY."` (
			  `id_spy` int(11) NOT NULL auto_increment,
			  `planet_name` varchar(20) NOT NULL default '',
			  `coordinates` varchar(9) NOT NULL default '',
			  `metal` int(7) NOT NULL default '-1',
			  `cristal` int(7) NOT NULL default '-1',
			  `deuterium` int(7) NOT NULL default '-1',
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
			  `Ter` smallint(2) NOT NULL default '-1',
			  `DdR` smallint(2) NOT NULL default '-1',
			  `Silo` smallint(2) NOT NULL default '-1',
			  `BaLu` smallint(2) NOT NULL default '-1',
			  `Pha` smallint(2) NOT NULL default '-1',
			  `PoSa` smallint(2) NOT NULL default '-1',
			  `LM` int(11) NOT NULL default '-1',
			  `LLE` int(11) NOT NULL default '-1',
			  `LLO` int(11) NOT NULL default '-1',
			  `CG` int(11) NOT NULL default '-1',
			  `AI` int(11) NOT NULL default '-1',
			  `LP` int(11) NOT NULL default '-1',
			  `PB` smallint(1) NOT NULL default '-1',
			  `GB` smallint(1) NOT NULL default '-1',
			  `MIC` smallint(3) NOT NULL default '-1',
			  `MIP` smallint(3) NOT NULL default '-1',
			  `PT` int(11) NOT NULL default '-1',
			  `GT` int(11) NOT NULL default '-1',
			  `CLE` int(11) NOT NULL default '-1',
			  `CLO` int(11) NOT NULL default '-1',
			  `CR` int(11) NOT NULL default '-1',
			  `VB` int(11) NOT NULL default '-1',
			  `VC` int(11) NOT NULL default '-1',
			  `REC` int(11) NOT NULL default '-1',
			  `SE` int(11) NOT NULL default '-1',
			  `BMD` int(11) NOT NULL default '-1',
			  `DST` int(11) NOT NULL default '-1',
			  `EDLM` int(11) NOT NULL default '-1',
			  `SAT` int(11) default '-1',
			  `TRA` int(11) NOT NULL default '-1',
			  `Esp` smallint(2) NOT NULL default '-1',
			  `Ordi` smallint(2) NOT NULL default '-1',
			  `Armes` smallint(2) NOT NULL default '-1',
			  `Bouclier` smallint(2) NOT NULL default '-1',
			  `Protection` smallint(2) NOT NULL default '-1',
			  `NRJ` smallint(2) NOT NULL default '-1',
			  `Hyp` smallint(2) NOT NULL default '-1',
			  `RC` smallint(2) NOT NULL default '-1',
			  `RI` smallint(2) NOT NULL default '-1',
			  `PH` smallint(2) NOT NULL default '-1',
			  `Laser` smallint(2) NOT NULL default '-1',
			  `Ions` smallint(2) NOT NULL default '-1',
			  `Plasma` smallint(2) NOT NULL default '-1',
			  `RRI` smallint(2) NOT NULL default '-1',
			  `Graviton` smallint(2) NOT NULL default '-1',
			  `Expeditions` smallint(2) NOT NULL default '-1',
			  `dateRE` int(11) NOT NULL default '0',
			  `proba` smallint(2) NOT NULL default '-1',
			  `active` enum('0','1') NOT NULL default '1',
			  `sender_id` int(11) NOT NULL,
			  PRIMARY KEY  (`id_spy`),
			  KEY `coordinates` (`coordinates`)
			);";
		$requests[] = "CREATE TABLE IF NOT EXISTS `".TABLE_PARSEDRC."` (
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
			);";
		$requests[] = "CREATE TABLE IF NOT EXISTS `".TABLE_PARSEDRCROUND."` (
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
			);";
		$requests[] = "CREATE TABLE IF NOT EXISTS `".TABLE_ROUND_ATTACK."` (
			  `id_roundattack` int(11) NOT NULL auto_increment,
			  `id_rcround` int(11) NOT NULL ,
			  `player` varchar(30) NOT NULL default '',
			  `coordinates` varchar(9) NOT NULL default '',
			  `Armes` smallint(2) NOT NULL default '-1',
			  `Bouclier` smallint(2) NOT NULL default '-1',
			  `Protection` smallint(2) NOT NULL default '-1',
			  `PT` int(11) NOT NULL default '-1',
			  `GT` int(11) NOT NULL default '-1',
			  `CLE` int(11) NOT NULL default '-1',
			  `CLO` int(11) NOT NULL default '-1',
			  `CR` int(11) NOT NULL default '-1',
			  `VB` int(11) NOT NULL default '-1',
			  `VC` int(11) NOT NULL default '-1',
			  `REC` int(11) NOT NULL default '-1',
			  `SE` int(11) NOT NULL default '-1',
			  `BMD` int(11) NOT NULL default '-1',
			  `DST` int(11) NOT NULL default '-1',
			  `EDLM` int(11) NOT NULL default '-1',
			  `TRA` int(11) NOT NULL default '-1',
			  PRIMARY KEY  (`id_roundattack`),
			  KEY `id_rcround` (`id_rcround`),
			  KEY `player` (`player`,`coordinates`)
			);";
		$requests[] = "CREATE TABLE IF NOT EXISTS `".TABLE_ROUND_DEFENSE."` (
			  `id_rounddefense` int(11) NOT NULL auto_increment,
			  `id_rcround` int(11) NOT NULL ,
			  `player` varchar(30) NOT NULL default '',
			  `coordinates` varchar(9) NOT NULL default '',
			  `Armes` smallint(2) NOT NULL default '-1',
			  `Bouclier` smallint(2) NOT NULL default '-1',
			  `Protection` smallint(2) NOT NULL default '-1',
			  `PT` int(11) NOT NULL default '-1',
			  `GT` int(11) NOT NULL default '-1',
			  `CLE` int(11) NOT NULL default '-1',
			  `CLO` int(11) NOT NULL default '-1',
			  `CR` int(11) NOT NULL default '-1',
			  `VB` int(11) NOT NULL default '-1',
			  `VC` int(11) NOT NULL default '-1',
			  `REC` int(11) NOT NULL default '-1',
			  `SE` int(11) NOT NULL default '-1',
			  `BMD` int(11) NOT NULL default '-1',
			  `DST` int(11) NOT NULL default '-1',
			  `EDLM` int(11) NOT NULL default '-1',
			  `SAT` int(11) default '-1',
			  `TRA` int(11) NOT NULL default '-1',
			  `LM` int(11) NOT NULL default '-1',
			  `LLE` int(11) NOT NULL default '-1',
			  `LLO` int(11) NOT NULL default '-1',
			  `CG` int(11) NOT NULL default '-1',
			  `AI` int(11) NOT NULL default '-1',
			  `LP` int(11) NOT NULL default '-1',
			  `PB` smallint(1) NOT NULL default '-1',
			  `GB` smallint(1) NOT NULL default '-1',
			  PRIMARY KEY  (`id_rounddefense`),
			  KEY `id_rcround` (`id_rcround`),
			  KEY `player` (`player`,`coordinates`)
			);";
		$requests[] = "UPDATE ".TABLE_CONFIG." SET config_value = '3.05beta' WHERE config_name = 'version'";
		$query="SELECT id FROM ".TABLE_MOD." WHERE action='xtense'";
		$result=$db->sql_query($query);
		if ( $db->sql_numrows($result) == 0 && file_exists ("../mod/Xtense/install.php")) {
			require_once("../mod/Xtense/install.php");
		}
		elseif ( $db->sql_numrows($result) > 0 && file_exists ("../mod/Xtense/update.php")) {
			require_once("../mod/Xtense/update.php");
		}
		$query="SELECT id, root FROM ".TABLE_MOD." WHERE action='autoupdate'";
		$result=$db->sql_query($query);
		if ( $db->sql_numrows($result) == 0 && file_exists ("../mod/autoupdate/install.php")) {
			require_once("../mod/autoupdate/install.php");
		}
		elseif ( $db->sql_numrows($result) > 0 && file_exists ("../mod/autoupdate/update.php")) {
			list ( $pub_mod_id, $pub_modroot ) = $db->sql_fetch_row ( $result );
			require_once("../mod/autoupdate/update.php");
		}
		$ogsversion = '3.05beta';
		break;
	  case '3.05beta':
		$rq = "SHOW FIELDS FROM ".TABLE_USER;
		$result = $db->sql_query ( $rq );
		$off_ok = false;
		while ( list ( $field ) = $db->sql_fetch_row ( $result ) )
		{
		  if ( $field == 'off_ingenieur' )
		  {
			$off_ok = true;
			break;
		  }
		}
		if ( $off_ok === false )
			$requests[] = "ALTER TABLE ".TABLE_USER." ADD off_amiral enum('0','1') NOT NULL default '0', ADD off_ingenieur enum('0','1') NOT NULL default '0', ADD off_geologue enum('0','1') NOT NULL default '0', ADD off_technocrate enum('0','1') NOT NULL default '0'";
		$requests[] = "UPDATE ".TABLE_CONFIG." SET config_value = '3.05' WHERE config_name = 'version'";
		$ogsversion = '3.05';
		$up_to_date = true;
		break;
	case '3.05':
		$requests[] = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('portee_missil','1')";
		$requests[] = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('open_user','')";
		$requests[] = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('open_admin','')";
		$requests[] = "ALTER TABLE ".TABLE_USER_BUILDING." ADD temperature_min SMALLINT(2) NOT NULL default '0'";
		$requests[] = "ALTER TABLE ".TABLE_USER_BUILDING." CHANGE temperature temperature_max SMALLINT(2)";
		$requests[] = "UPDATE ".TABLE_CONFIG." SET config_value = '3.06' WHERE config_name = 'version'";
		$ogsversion = '3.06';
		$up_to_date = true;
		break;
	case '3.06':
		$requests[] = "ALTER TABLE ".TABLE_USER_TECHNOLOGY." CHANGE Expeditions Astrophysique SMALLINT(2) NOT NULL default '0'";
		$requests[] = "ALTER TABLE ".TABLE_PARSEDSPY." CHANGE Expeditions Astrophysique SMALLINT(2) NOT NULL default '0'";
		$requests[] = "ALTER TABLE ".TABLE_MOD." MODIFY version VARCHAR(10)";
		$requests[] = "UPDATE ".TABLE_CONFIG." SET config_value = '3.0.7' WHERE config_name = 'version'";
		$requests[] = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('astro_strict','1')";
        $requests[] = "UPDATE ".TABLE_USER_BUILDING." SET planet_id = (planet_id + 100) WHERE planet_id < 10";
        $requests[] = "UPDATE ".TABLE_USER_BUILDING." SET planet_id = (planet_id + 191) WHERE planet_id > 9 and planet_id < 19 ";
        $requests[] = "UPDATE ".TABLE_USER_DEFENCE." SET planet_id = (planet_id + 100) WHERE planet_id < 10";
        $requests[] = "UPDATE ".TABLE_USER_DEFENCE." SET planet_id = (planet_id + 191) WHERE planet_id > 9 and planet_id < 19 ";
        $ogsversion = '3.0.7';
		$up_to_date = true;
		break;
		
	case '3.0.7':
		$requests[] = "UPDATE ".TABLE_CONFIG." SET config_value = '3.0.8' WHERE config_name = 'version'";
		$requests[] = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('config_cache', '3600')";
		$requests[] = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('mod_cache', '604800')";
        $ogsversion = '3.0.8';
		$up_to_date = true;
		break;
		
	case '3.0.8':
        // modif building
	   $requests[] = "UPDATE ".TABLE_CONFIG." SET config_value = '3.1.0' WHERE config_name = 'version'";
       $requests[] = "ALTER TABLE `".TABLE_USER_BUILDING."` ADD `CD` SMALLINT(2) NOT NULL default '0' AFTER `HD`"; // cache deut
	   $requests[] = "ALTER TABLE `".TABLE_USER_BUILDING."` ADD `CC` SMALLINT(2) NOT NULL default '0' AFTER `HD`"; // cache cristal
	   $requests[] = "ALTER TABLE `".TABLE_USER_BUILDING."` ADD `CM` SMALLINT(2) NOT NULL default '0' AFTER `HD`"; // cache metal
	   $requests[] = "ALTER TABLE `".TABLE_PARSEDSPY."` ADD `CD` SMALLINT(2) NOT NULL default '-1' AFTER `HD`"; // cache deut
	   $requests[] = "ALTER TABLE `".TABLE_PARSEDSPY."` ADD `CC` SMALLINT(2) NOT NULL default '-1' AFTER `HD`"; // cache cristal
	   $requests[] = "ALTER TABLE `".TABLE_PARSEDSPY."` ADD `CM` SMALLINT(2) NOT NULL default '-1' AFTER `HD`"; // cache metal
        // fin modif building
        
        // ajout classement alliance //
        // economique
        $requests[] = "CREATE TABLE ".TABLE_RANK_ALLY_ECO." (".
	        " datadate int(11) NOT NULL default '0',".
	        " rank int(11) NOT NULL default '0',".
	        " ally varchar(30) NOT NULL,".
        	" number_member int(11) NOT NULL,".
        	" points int(11) NOT NULL default '0',".
        	" sender_id int(11) NOT NULL default '0',".
        	" PRIMARY KEY  (rank,datadate),".
        	" KEY datadate (datadate,ally),".
        	" KEY ally (ally)".
        	" )";
        
      // recherche
        $requests[] = "CREATE TABLE ".TABLE_RANK_ALLY_TECHNOLOGY." (".
	         " datadate int(11) NOT NULL default '0',".
	         " rank int(11) NOT NULL default '0',".
	        " ally varchar(30) NOT NULL,".
        	" number_member int(11) NOT NULL,".
        	" points int(11) NOT NULL default '0',".
         	" sender_id int(11) NOT NULL default '0',".
        	" PRIMARY KEY  (rank,datadate),".
        	" KEY datadate (datadate,ally),".
        	" KEY ally (ally)".
        	" )";
        
     // militaire
        $requests[] = "CREATE TABLE ".TABLE_RANK_ALLY_MILITARY." (".
	         " datadate int(11) NOT NULL default '0',".
	         " rank int(11) NOT NULL default '0',".
	        " ally varchar(30) NOT NULL,".
        	" number_member int(11) NOT NULL,".
        	" points int(11) NOT NULL default '0',".
        	" sender_id int(11) NOT NULL default '0',".
        	" PRIMARY KEY  (rank,datadate),".
        	" KEY datadate (datadate,ally),".
        	" KEY ally (ally)".
        	" )";
        // militaire construit
        $requests[] = "CREATE TABLE ".TABLE_RANK_ALLY_MILITARY_BUILT." (".
        	         " datadate int(11) NOT NULL default '0',".
        	         " rank int(11) NOT NULL default '0',".
        	        " ally varchar(30) NOT NULL,".
                	" number_member int(11) NOT NULL,".
                	" points int(11) NOT NULL default '0',".
                	" sender_id int(11) NOT NULL default '0',".
                	" PRIMARY KEY  (rank,datadate),".
                	" KEY datadate (datadate,ally),".
                	" KEY ally (ally)".
                	" )";
    
     // militaire perdu
        $requests[] = "CREATE TABLE ".TABLE_RANK_ALLY_MILITARY_LOOSE." (".
	         " datadate int(11) NOT NULL default '0',".
	         " rank int(11) NOT NULL default '0',".
	        " ally varchar(30) NOT NULL,".
        	" number_member int(11) NOT NULL,".
        	" points int(11) NOT NULL default '0',".
        	" sender_id int(11) NOT NULL default '0',".
        	" PRIMARY KEY  (rank,datadate),".
        	" KEY datadate (datadate,ally),".
        	" KEY ally (ally)".
        	" )";
        
     // militaire detruit
        $requests[] = "CREATE TABLE ".TABLE_RANK_ALLY_MILITARY_DESTRUCT." (".
	         " datadate int(11) NOT NULL default '0',".
	         " rank int(11) NOT NULL default '0',".
	        " ally varchar(30) NOT NULL,".
        	" number_member int(11) NOT NULL,".
        	" points int(11) NOT NULL default '0',".
        	" sender_id int(11) NOT NULL default '0',".
        	" PRIMARY KEY  (rank,datadate),".
        	" KEY datadate (datadate,ally),".
        	" KEY ally (ally)".
        	" )";
        
    // point honneur
        $requests[] = "CREATE TABLE ".TABLE_RANK_ALLY_HONOR." (".
	         " datadate int(11) NOT NULL default '0',".
	         " rank int(11) NOT NULL default '0',".
	        " ally varchar(30) NOT NULL,".
        	" number_member int(11) NOT NULL,".
        	" points int(11) NOT NULL default '0',".
        	" sender_id int(11) NOT NULL default '0',".
        	" PRIMARY KEY  (rank,datadate),".
        	" KEY datadate (datadate,ally),".
        	" KEY ally (ally)".
        	" )";
        
    // fin classement alliance
    
   /// classement joueur
            // economique
        $requests[] = "CREATE TABLE ".TABLE_RANK_PLAYER_ECO." (".
	        " datadate int(11) NOT NULL default '0',".
	        " rank int(11) NOT NULL default '0',".
	        " player varchar(30) NOT NULL,".
        	" ally varchar(100) NOT NULL,".
        	" points int(11) NOT NULL default '0',".
        	" sender_id int(11) NOT NULL default '0',".
        	" PRIMARY KEY  (rank,datadate),".
        	" KEY datadate (datadate,player),".
        	" KEY player (player)".
        	" )";
   
   
   // technologie
        $requests[] = "CREATE TABLE ".TABLE_RANK_PLAYER_TECHNOLOGY." (".
	        " datadate int(11) NOT NULL default '0',".
	        " rank int(11) NOT NULL default '0',".
	        " player varchar(30) NOT NULL,".
        	" ally varchar(100) NOT NULL,".
        	" points int(11) NOT NULL default '0',".
        	" sender_id int(11) NOT NULL default '0',".
        	" PRIMARY KEY  (rank,datadate),".
        	" KEY datadate (datadate,player),".
        	" KEY player (player)".
        	" )";
   
   
// militaire
        $requests[] = "CREATE TABLE ".TABLE_RANK_PLAYER_MILITARY." (".
	        " datadate int(11) NOT NULL default '0',".
	        " rank int(11) NOT NULL default '0',".
	        " player varchar(30) NOT NULL,".
        	" ally varchar(100) NOT NULL,".
        	" points int(11) NOT NULL default '0',".
        	" sender_id int(11) NOT NULL default '0',".        	
        	" PRIMARY KEY  (rank,datadate),".
        	" KEY datadate (datadate,player),".
        	" KEY player (player)".
        	" )";
        
// militaire constuit
        $requests[] = "CREATE TABLE ".TABLE_RANK_PLAYER_MILITARY_BUILT." (".
        	        " datadate int(11) NOT NULL default '0',".
        	        " rank int(11) NOT NULL default '0',".
        	        " player varchar(30) NOT NULL,".
                	" ally varchar(100) NOT NULL,".
                	" points int(11) NOT NULL default '0',".
                	" sender_id int(11) NOT NULL default '0',".
                	" PRIMARY KEY  (rank,datadate),".
                	" KEY datadate (datadate,player),".
                	" KEY player (player)".
                	" )";
        
   
// militaire perdu
        $requests[] = "CREATE TABLE ".TABLE_RANK_PLAYER_MILITARY_LOOSE." (".
	        " datadate int(11) NOT NULL default '0',".
	        " rank int(11) NOT NULL default '0',".
	        " player varchar(30) NOT NULL,".
        	" ally varchar(100) NOT NULL,".
        	" points int(11) NOT NULL default '0',".
        	" sender_id int(11) NOT NULL default '0',".
        	" PRIMARY KEY  (rank,datadate),".
        	" KEY datadate (datadate,player),".
        	" KEY player (player)".
        	" )";
   
   // militaire detruit
        $requests[] = "CREATE TABLE ".TABLE_RANK_PLAYER_MILITARY_DESTRUCT." (".
	        " datadate int(11) NOT NULL default '0',".
	        " rank int(11) NOT NULL default '0',".
	        " player varchar(30) NOT NULL,".
        	" ally varchar(100) NOT NULL,".
        	" points int(11) NOT NULL default '0',".
        	" sender_id int(11) NOT NULL default '0',".
        	" PRIMARY KEY  (rank,datadate),".
        	" KEY datadate (datadate,player),".
        	" KEY player (player)".
        	" )";
      

    // militaire honneur
        $requests[] = "CREATE TABLE ".TABLE_RANK_PLAYER_HONOR." (".
	        " datadate int(11) NOT NULL default '0',".
	        " rank int(11) NOT NULL default '0',".
	        " player varchar(30) NOT NULL,".
        	" ally varchar(100) NOT NULL,".
        	" points int(11) NOT NULL default '0',".
        	" sender_id int(11) NOT NULL default '0',".
        	" PRIMARY KEY  (rank,datadate),".
        	" KEY datadate (datadate,player),".
        	" KEY player (player)".
        	" )";

    
        $ogsversion = '3.1.0';
		$up_to_date = true;
		break;
		
	case '3.1.0':
		$requests[] = "UPDATE ".TABLE_CONFIG." SET config_value = '3.1.1' WHERE config_name = 'version'";
        // MODIF TABLE_USER
        $requests[] = "ALTER TABLE `".TABLE_USER."` ADD `xtense_type` enum('FF','GMFF','GMGC') AFTER `rank_added_ogs`"; // Type de barre utilisée par le user
		$requests[] = "ALTER TABLE `".TABLE_USER."` ADD `xtense_version` VARCHAR(10) AFTER `xtense_type`"; // Type de barre utilisée par le user
		
		// MODIF TABLE_RANK_PLAYER_MILITARY
		$requests[] = "ALTER TABLE `".TABLE_RANK_PLAYER_MILITARY."` ADD `nb_spacecraft` int(11) NOT NULL default '0' AFTER `sender_id`"; // Ajout nombre de vaisseaux au classement militaire joueur
		                                          
		// SUPPRESSIONS ANCIENS CLASSEMENTS : TABLE_RANK_PLAYER_FLEET, TABLE_RANK_PLAYER_RESEARCH, TABLE_RANK_ALLY_FLEET & TABLE_RANK_ALLY_RESEARCH
		$requests[] = "DROP TABLE `".TABLE_RANK_PLAYER_FLEET."`"; 	// ancien classement flotte
		$requests[] = "DROP TABLE `".TABLE_RANK_PLAYER_RESEARCH."`";// ancien classement recherche
		$requests[] = "DROP TABLE `".TABLE_RANK_ALLY_FLEET."`";		// ancien classement flotte
		$requests[] = "DROP TABLE `".TABLE_RANK_ALLY_RESEARCH."`";	// ancien classement recherche
		$requests[] = "DROP TABLE `".TABLE_SPY."`";					// ancienne table des RE
		$requests[] = "DROP TABLE `".TABLE_UNIVERSE_TEMPORARY."`";	// ancienne table temporaire univers
		
		
		$ogsversion = '3.1.1';
		$up_to_date = true;
		break;
	default:
	die("Aucune mise … jour n'est disponible");
}


foreach ($requests as $request) {
	$db->sql_query($request);
}

if ( $ogsversion == '3.1.0' && function_exists ( 'import_RE' ) ) {
    import_RE(); 
    }
  
// on supprime tous les fichiers du cache
// pour prendre en compte toutes les modifications
$files = glob('../cache/*.php');
foreach ($files as $filename){unlink($filename);}  


  
?>
	<h3 align='center'><font color='yellow'>Mise à jour du serveur OGSpy vers la version <?php echo $ogsversion;?> effectuée avec succès</font></h3>
	<center>
	<b><i>Le script a seulement modifié la base de données, pensez à mettre à jour vos fichiers</i></b><br />
<?php
if ($up_to_date) {
	echo "\t"."<b><i>Pensez à supprimer le dossier 'install'</i></b><br />"."\n";
	echo "\t"."<br /><a href='../index.php'>Retour</a>"."\n";
}
else {
	echo "\t"."<br><font color='orange'><b>Cette version n'est pas la dernière en date, veuillez réexécuter le script</font><br />"."\n";
	echo "\t"."<a href=''>Recommencer l'opération</a>"."\n";
}
?>
	</center>
</body>
</html>
