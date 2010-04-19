<?php

$request = "SELECT config_value FROM ".TABLE_CONFIG." WHERE config_name = 'version'";
$result = $db->sql_query($request);
list($ogsversion) = $db->sql_fetch_row($result);

$up_to_date = false;
if (version_compare($ogsversion, "0.3", "==")) {
	$db->sql_query("UPDATE ".TABLE_CONFIG." SET config_value = '0.300c' WHERE config_name = 'version'");
	$ogsversion = "0.300c";
}
if (version_compare($ogsversion, "0.300c", "==")) {
	$db->sql_query("DROP TABLE if exists ".TABLE_SESSIONS);
	$db->sql_query(
		"CREATE TABLE ".TABLE_SESSIONS." (".
		"session_id char(32) NOT NULL default '', ".
		"session_user_id int(11) NOT NULL default '0', ".
		"session_start int(11) NOT NULL default '0', ".
		"session_expire int(11) NOT NULL default '0', ".
		"session_ip char(32) NOT NULL default '', ".
		"session_ogs ENUM('0', '1') NOT NULL default '0', ".
		"unique key session_id (session_id, session_ip)".
		")"
	);
	$db->sql_query("UPDATE ".TABLE_CONFIG." SET config_value = '0.300d' WHERE config_name = 'version'");
	$ogsversion = "0.300d";
}
if (version_compare($ogsversion, "0.300d", "==")) {
	$db->sql_query("INSERT INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('url_forum', 'http://ogsteam.fr/index.php')");
	$db->sql_query("UPDATE ".TABLE_CONFIG." SET config_value = '0.300e' WHERE config_name = 'version'");
	$ogsversion = "0.300e";
}
if (version_compare($ogsversion, "0.300e", "==")) {
	$db->sql_query("UPDATE ".TABLE_CONFIG." SET config_value = '0.300f' WHERE config_name = 'version'");
	$ogsversion = "0.300f";
}
if (version_compare($ogsversion, "0.300f", "==")) {
	$db->sql_query("INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('url_forum', 'http://ogsteam.fr/index.php')"); //Requête préventive pour cause d'erreur lors de la mise à jour 0.300d-0.300e
	$db->sql_query("ALTER TABLE ".$table_prefix."rank_fleet ADD index (datadate, player)");
	$db->sql_query("ALTER TABLE ".$table_prefix."rank_points ADD index (datadate, player)");
	$db->sql_query("ALTER TABLE ".$table_prefix."rank_research ADD index (datadate, player)");
	$db->sql_query("ALTER TABLE ".TABLE_SESSIONS." ADD session_lastvisit int NOT NULL");
	$db->sql_query("INSERT INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('max_keeprank', '30')");
	$db->sql_query("INSERT INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('keeprank_criterion', 'quantity')");
	$db->sql_query("INSERT INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('max_keepspyreport', '30')");
	$db->sql_query("INSERT INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('servername', 'Serveur d\'alliance')");
	$db->sql_query("ALTER TABLE ".TABLE_UNIVERSE." CHANGE status status varchar(5) NOT NULL");
	$db->sql_query("ALTER TABLE ".TABLE_USER." ADD rank_added_web int NOT NULL after spy_added_ogs, ADD rank_added_ogs int NOT NULL after rank_added_web");
	$db->sql_query("UPDATE ".TABLE_CONFIG." SET config_value = '0.301' WHERE config_name = 'version'");
	$ogsversion = "0.301";
}
if (version_compare($ogsversion, "0.301", "==")) {
	$db->sql_query("UPDATE ".TABLE_CONFIG." SET config_value = '0.301b' WHERE config_name = 'version'");
	$ogsversion = "0.301b";
}
if (version_compare($ogsversion, "0.301b", "==")) {
	$db->sql_query("INSERT INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('allied', '')");
	$db->sql_query("INSERT INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('max_favorites_spy', '10')");
	$db->sql_query("INSERT INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('last_maintenance_action', '0')");
	$db->sql_query(
		"CREATE TABLE ".TABLE_GROUP." (".
		"group_id mediumint(8) NOT NULL auto_increment, ".
		"group_name varchar(30) NOT NULL, ".
		"server_set_system ENUM('0', '1') NOT NULL default '0', ".
		"server_set_spy ENUM('0', '1') NOT NULL default '0', ".
		"server_set_ranking ENUM('0', '1') NOT NULL default '0', ".
		"server_show_positionhided ENUM('0', '1') NOT NULL default '0', ".
		"ogs_connection ENUM('0', '1') NOT NULL default '0', ".
		"ogs_set_system ENUM('0', '1') NOT NULL default '0', ".
		"ogs_get_system ENUM('0', '1') NOT NULL default '0', ".
		"ogs_set_spy ENUM('0', '1') NOT NULL default '0', ".
		"ogs_get_spy ENUM('0', '1') NOT NULL default '0', ".
		"ogs_set_ranking ENUM('0', '1') NOT NULL default '0', ".
		"ogs_get_ranking ENUM('0', '1') NOT NULL default '0', ".
		"primary key (group_id)".
		")"
	);
	$db->sql_query("INSERT INTO ".TABLE_GROUP." (group_id, group_name) VALUES (1, 'Standard')");
	$db->sql_query("ALTER TABLE ".TABLE_UNIVERSE." change status status varchar(5) NOT NULL");
	$db->sql_query("ALTER TABLE ".TABLE_USER." DROP user_moderator, DROP user_auth_import_web, DROP user_auth_import_ogs, DROP user_auth_export_ogs");
	$db->sql_query(
		"ALTER TABLE ".TABLE_USER." ADD management_user ENUM('0', '1') NOT NULL DEFAULT '0', ".
		"ADD management_ranking ENUM('0', '1') NOT NULL DEFAULT '0', ".
		"ADD user_stat_name VARCHAR(50) NOT NULL AFTER user_skin"
	);
	$db->sql_query("ALTER TABLE ".TABLE_USER." ADD user_coadmin ENUM('0', '1') NOT NULL DEFAULT '0' AFTER user_admin");
	$db->sql_query(
		"CREATE TABLE ".TABLE_USER_GROUP." (".
		"group_id mediumint(8) NOT NULL default '0', ".
		"user_id mediumint(8) NOT NULL default '0', ".
		"UNIQUE KEY group_id (group_id, user_id)".
		")"
	);
	$db->sql_query("INSERT INTO ".TABLE_USER_GROUP." (group_id, user_id) SELECT 1, user_id FROM ".TABLE_USER);
	$db->sql_query("ALTER TABLE ".TABLE_UNIVERSE." ADD phalanx TINYINT(1) NOT NULL AFTER moon, ADD gate ENUM('0', '1') NOT NULL DEFAULT '0' AFTER phalanx, ADD last_update_moon INT NOT NULL DEFAULT '0' AFTER last_update");
	$db->sql_query("ALTER TABLE ".TABLE_SPY." ADD active ENUM('0', '1') NOT NULL DEFAULT '1'");
	$db->sql_query(
		"CREATE TABLE ".TABLE_USER_DEFENCE." (".
		"user_id int(11) NOT NULL default '0', ".
		"planet_id int(11) NOT NULL default '0', ".
		"LM smallint(5) NOT NULL default '0', ".
		"LLE smallint(5) NOT NULL default '0', ".
		"LLO smallint(5) NOT NULL default '0', ".
		"CG smallint(5) NOT NULL default '0', ".
		"AI smallint(5) NOT NULL default '0', ".
		"LP smallint(5) NOT NULL default '0', ".
		"PB smallint(1) NOT NULL default '0', ".
		"GB smallint(1) NOT NULL default '0', ".
		"MIC smallint(3) NOT NULL default '0', ".
		"MIP smallint(3) NOT NULL default '0', ".
		"PRIMARY KEY (user_id, planet_id)".
		")"
	);
	$db->sql_query(
		"ALTER TABLE ".TABLE_USER_BUILDING." ADD BaLu SMALLINT(2) NOT NULL DEFAULT '0', ".
		"ADD Pha SMALLINT(2) NOT NULL DEFAULT '0', ".
		"ADD PoSa SMALLINT(2) NOT NULL DEFAULT '0'"
	);
	$db->sql_query(
		"CREATE TABLE ".TABLE_RANK_ALLY_FLEET." (".
		"datadate int(11) NOT NULL default '0', ".
		"rank int(11) NOT NULL default '0', ".
		"ally varchar(30) NOT NULL, ".
		"number_member int(11) NOT NULL, ".
		"points int(11) NOT NULL default '0', ".
		"points_per_member int(11) NOT NULL, ".
		"sender_id int(11) NOT NULL default '0', ".
		"PRIMARY KEY (rank, datadate), ".
		"KEY datadate (datadate, ally), ".
		"KEY ally (ally)".
		")"
	);
	$db->sql_query(
		"CREATE TABLE ".TABLE_RANK_ALLY_POINTS." (".
		"datadate int(11) NOT NULL default '0', ".
		"rank int(11) NOT NULL default '0', ".
		"ally varchar(30) NOT NULL, ".
		"number_member int(11) NOT NULL, ".
		"points int(11) NOT NULL default '0', ".
		"points_per_member int(11) NOT NULL, ".
		"sender_id int(11) NOT NULL default '0', ".
		"PRIMARY KEY (rank, datadate), ".
		"KEY datadate (datadate, ally), ".
		"KEY ally (ally)".
		")"
	);
	$db->sql_query(
		"CREATE TABLE ".TABLE_RANK_ALLY_RESEARCH." (".
		"datadate int(11) NOT NULL default '0', ".
		"rank int(11) NOT NULL default '0', ".
		"ally varchar(30) NOT NULL, ".
		"number_member int(11) NOT NULL, ".
		"points int(11) NOT NULL default '0', ".
		"points_per_member int(11) NOT NULL, ".
		"sender_id int(11) NOT NULL default '0', ".
		"PRIMARY KEY (rank, datadate), ".
		"KEY datadate (datadate, ally), ".
		"KEY ally (ally)".
		")"
	);
	$db->sql_query("ALTER TABLE ".$table_prefix."rank_fleet RENAME ".TABLE_RANK_PLAYER_FLEET);
	$db->sql_query("ALTER TABLE ".$table_prefix."rank_points RENAME ".TABLE_RANK_PLAYER_POINTS);
	$db->sql_query("ALTER TABLE ".$table_prefix."rank_research RENAME ".TABLE_RANK_PLAYER_RESEARCH);
	$db->sql_query("ALTER TABLE ".TABLE_RANK_PLAYER_FLEET." ADD INDEX (player)");
	$db->sql_query("ALTER TABLE ".TABLE_RANK_PLAYER_POINTS." ADD INDEX (player)");
	$db->sql_query("ALTER TABLE ".TABLE_RANK_PLAYER_RESEARCH." ADD INDEX (player)");
	$db->sql_query(
		"UPDATE ".TABLE_USER." SET".
		"planet_added_web = planet_added_web + planet_modified_web, ".
		"planet_added_ogs = planet_added_ogs + planet_modified_ogs"
	);
	$db->sql_query("ALTER TABLE ".TABLE_USER." DROP planet_modified_web, DROP planet_modified_ogs");
	$db->sql_query("ALTER TABLE ".TABLE_USER." ADD planet_exported INT NOT NULL AFTER planet_added_ogs");
	$db->sql_query("ALTER TABLE ".TABLE_USER." ADD spy_exported INT NOT NULL AFTER spy_added_ogs");
	$db->sql_query("ALTER TABLE ".TABLE_USER." ADD rank_exported INT NOT NULL AFTER rank_added_ogs");
	$db->sql_query(
		"ALTER TABLE ".TABLE_USER_DEFENCE.
		" CHANGE LM LM INT NOT NULL DEFAULT '0', ".
		"CHANGE LLE LLE INT NOT NULL DEFAULT '0', ".
		"CHANGE LLO LLO INT NOT NULL DEFAULT '0', ".
		"CHANGE CG CG INT NOT NULL DEFAULT '0', ".
		"CHANGE AI AI INT NOT NULL DEFAULT '0', ".
		"CHANGE LP LP INT NOT NULL DEFAULT '0'"
	);
	$db->sql_query(
		"CREATE TABLE ".TABLE_MOD." (".
		"id int(11) NOT NULL auto_increment, ".
		"title varchar(64) NOT NULL COMMENT 'Nom du mod', ".
		"menu varchar(256) NOT NULL COMMENT 'Titre du lien dans le menu', ".
		"action varchar(64) NOT NULL COMMENT 'Action transmise en get et traitée dans index.php', ".
		"root varchar(64) NOT NULL COMMENT 'Répertoire où se situe le mod (relatif au répertoire mods)', ".
		"link varchar(64) NOT NULL COMMENT 'fichier principal du mod', ".
		"version varchar(5) NOT NULL COMMENT 'Version du mod', ".
		"active tinyint(1) NOT NULL COMMENT 'Permet de désactiver un mod sans le désinstaller, évite les mods pirates', ".
		"PRIMARY KEY (id), ".
		"UNIQUE KEY action (action), ".
		"UNIQUE KEY title (title), ".
		"UNIQUE KEY menu (menu), ".
		"UNIQUE KEY root (root)".
		")"
	);
	$db->sql_query("ALTER TABLE ".TABLE_UNIVERSE_TEMPORARY." ADD status VARCHAR(5) NOT NULL AFTER ally");
	$db->sql_query("UPDATE ".TABLE_CONFIG." SET config_value = '3.02' WHERE config_name = 'version'");
	$ogsversion = "3.02";
}
if (version_compare($ogsversion, "3.02", "==")) {
	$db->sql_query("UPDATE ".TABLE_CONFIG." SET config_value = '3.02b' WHERE config_name = 'version'");	
	$ogsversion = "3.02b";
}
if (version_compare($ogsversion, "3.02b", "==")) {
	$db->sql_query("INSERT INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('disable_ip_check', '0')");
	$db->sql_query("ALTER TABLE ".TABLE_USER." ADD disable_ip_check ENUM('0', '1') NOT NULL DEFAULT '0'");
	$db->sql_query("ALTER TABLE ".TABLE_MOD." ADD position INT NOT NULL DEFAULT '-1'");
	$db->sql_query("UPDATE ".TABLE_CONFIG." SET config_value = '3.02c' WHERE config_name = 'version'");
	$ogsversion = "3.02c";
}
if (version_compare($ogsversion, "3.02c", "==")) {
	//nevada51
	$db->sql_query("INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('galaxy_by_line_stat', '10')");
	$db->sql_query("INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('system_by_line_stat', '25')");
	$db->sql_query("INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('enable_stat_view', '1')");
	$db->sql_query("INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('enable_members_view', '1')");
	$db->sql_query("INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('galaxy_by_line_ally', '10')");
	$db->sql_query("INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('system_by_line_ally', '25')");
	$db->sql_query("INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('color_ally1', 'Magenta')");
	$db->sql_query("INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('color_ally2', 'Yellow')");
	$db->sql_query("INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('color_ally3', 'Red')");
	$num_of_galaxies = (isset($num_of_galaxies))?$num_of_galaxies:9;
	$num_of_systems = (isset($num_of_systems))?$num_of_systems:499;
	$db->sql_query("INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('num_of_galaxies', '".$num_of_galaxies."')");
	$db->sql_query("INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('num_of_systems', '".$num_of_systems."')");
	$db->sql_query("UPDATE ".TABLE_CONFIG." SET config_value = '3.03' WHERE config_name = 'version'");
	$ogsversion = "3.03"; // Identificateur de la version
	//fin nevada51
}
if (version_compare($ogsversion, "3.03", "==")) {
	$sgbd_tableprefix = $table_prefix;
	$ogsversion = "3.04";
	$num_of_galaxies = (isset($num_of_galaxies))?$num_of_galaxies:9;
	$num_of_systems = (isset($num_of_systems))?$num_of_systems:499;
	$db->sql_query("INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('num_of_galaxies', '".$num_of_galaxies."')");
	$db->sql_query("INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('num_of_systems', '".$num_of_systems."')");
	$db->sql_query("UPDATE ".TABLE_CONFIG." SET config_value = '3.04' WHERE config_name = 'version'");
	$ogsversion = "3.04";
}
if (version_compare($ogsversion, "3.04", "==")) {
	$db->sql_query("INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('log_phperror', '0')");
	$up_to_date = true;
	$db->sql_query("ALTER TABLE ".TABLE_MOD." ADD `admin_only` ENUM('0', '1') NOT NULL DEFAULT '0' COMMENT 'Affichage des mods de l utilisateur'");
	$db->sql_query("UPDATE ".TABLE_CONFIG." SET config_value = '3.04b' WHERE config_name = 'version'");
	$ogsversion = "3.04b";
}
if (version_compare($ogsversion, "3.04b", "==")) {
	$db->sql_query("INSERT INTO ".TABLE_CONFIG." VALUES ('enable_register_view', '0')");
	$db->sql_query("INSERT INTO ".TABLE_CONFIG." VALUES ('register_forum', '')");
	$db->sql_query("INSERT INTO ".TABLE_CONFIG." VALUES ('register_alliance', '')");
	$db->sql_query("DELETE FROM ".TABLE_CONFIG." WHERE config_name = 'color_ally1'");
	$db->sql_query("DELETE FROM ".TABLE_CONFIG." WHERE config_name = 'color_ally2'");
	$db->sql_query("DELETE FROM ".TABLE_CONFIG." WHERE config_name = 'color_ally3'");
	$db->sql_query("INSERT INTO ".TABLE_CONFIG." VALUES ('color_ally', 'Magenta_Yellow_Red')");
	$db->sql_query("INSERT INTO ".TABLE_CONFIG." VALUES ('nb_colonnes_ally', '3')");
	$db->sql_query("INSERT INTO ".TABLE_CONFIG." VALUES ('block_ratio', '0')");
	$db->sql_query("INSERT INTO ".TABLE_CONFIG." VALUES ('ratio_limit', '0')");
	$db->sql_query("INSERT INTO ".TABLE_CONFIG." VALUES ('speed_uni', '1')");
	$db->sql_query("INSERT INTO ".TABLE_CONFIG." VALUES ('ddr', 'false')");
	$db->sql_query("ALTER TABLE ".TABLE_GROUP." ADD server_set_rc enum('0', '1') NOT NULL default '0'");
	$res = $db->sql_query('SHOW FIELDS FROM '.TABLE_USER_TECHNOLOGY);
	$exped_ok = false;
	while (list($techno) = $db->sql_fetch_row($res)) {
		if ($techno == 'Expeditions') {
			$exped_ok = true;
			break;
		}
	}
	if ($exped_ok == false) $db->sql_query("ALTER TABLE ".TABLE_USER_TECHNOLOGY." ADD Expeditions SMALLINT(2) NOT NULL default '0'");
	$db->sql_query("ALTER TABLE ".TABLE_USER_BUILDING." ADD DdR SMALLINT(2) NOT NULL default '0'");
	$db->sql_query("CREATE TABLE IF NOT EXISTS `".TABLE_PARSEDSPY."` (".
		"`id_spy` int(11) NOT NULL auto_increment, ".
		"`planet_name` varchar(20) NOT NULL default '', ".
		"`coordinates` varchar(9) NOT NULL default '', ".
		"`metal` int(7) NOT NULL default '-1', ".
		"`cristal` int(7) NOT NULL default '-1', ".
		"`deuterium` int(7) NOT NULL default '-1', ".
		"`energie` int(7) NOT NULL default '-1', ".
		"`activite` int(2) NOT NULL default '-1', ".
		"`M` smallint(2) NOT NULL default '-1', ".
		"`C` smallint(2) NOT NULL default '-1', ".
		"`D` smallint(2) NOT NULL default '-1', ".
		"`CES` smallint(2) NOT NULL default '-1', ".
		"`CEF` smallint(2) NOT NULL default '-1', ".
		"`UdR` smallint(2) NOT NULL default '-1', ".
		"`UdN` smallint(2) NOT NULL default '-1', ".
		"`CSp` smallint(2) NOT NULL default '-1', ".
		"`HM` smallint(2) NOT NULL default '-1', ".
		"`HC` smallint(2) NOT NULL default '-1', ".
		"`HD` smallint(2) NOT NULL default '-1', ".
		"`Lab` smallint(2) NOT NULL default '-1', ".
		"`Ter` smallint(2) NOT NULL default '-1', ".
		"`DdR` smallint(2) NOT NULL default '-1', ".
		"`Silo` smallint(2) NOT NULL default '-1', ".
		"`BaLu` smallint(2) NOT NULL default '-1', ".
		"`Pha` smallint(2) NOT NULL default '-1', ".
		"`PoSa` smallint(2) NOT NULL default '-1', ".
		"`LM` int(11) NOT NULL default '-1', ".
		"`LLE` int(11) NOT NULL default '-1', ".
		"`LLO` int(11) NOT NULL default '-1', ".
		"`CG` int(11) NOT NULL default '-1', ".
		"`AI` int(11) NOT NULL default '-1', ".
		"`LP` int(11) NOT NULL default '-1', ".
		"`PB` smallint(1) NOT NULL default '-1', ".
		"`GB` smallint(1) NOT NULL default '-1', ".
		"`MIC` smallint(3) NOT NULL default '-1', ".
		"`MIP` smallint(3) NOT NULL default '-1', ".
		"`PT` int(11) NOT NULL default '-1', ".
		"`GT` int(11) NOT NULL default '-1', ".
		"`CLE` int(11) NOT NULL default '-1', ".
		"`CLO` int(11) NOT NULL default '-1', ".
		"`CR` int(11) NOT NULL default '-1', ".
		"`VB` int(11) NOT NULL default '-1', ".
		"`VC` int(11) NOT NULL default '-1', ".
		"`REC` int(11) NOT NULL default '-1', ".
		"`SE` int(11) NOT NULL default '-1', ".
		"`BMD` int(11) NOT NULL default '-1', ".
		"`DST` int(11) NOT NULL default '-1', ".
		"`EDLM` int(11) NOT NULL default '-1', ".
		"`SAT` int(11) default '-1', ".
		"`TRA` int(11) NOT NULL default '-1', ".
		"`Esp` smallint(2) NOT NULL default '-1', ".
		"`Ordi` smallint(2) NOT NULL default '-1', ".
		"`Armes` smallint(2) NOT NULL default '-1', ".
		"`Bouclier` smallint(2) NOT NULL default '-1', ".
		"`Protection` smallint(2) NOT NULL default '-1', ".
		"`NRJ` smallint(2) NOT NULL default '-1', ".
		"`Hyp` smallint(2) NOT NULL default '-1', ".
		"`RC` smallint(2) NOT NULL default '-1', ".
		"`RI` smallint(2) NOT NULL default '-1', ".
		"`PH` smallint(2) NOT NULL default '-1', ".
		"`Laser` smallint(2) NOT NULL default '-1', ".
		"`Ions` smallint(2) NOT NULL default '-1', ".
		"`Plasma` smallint(2) NOT NULL default '-1', ".
		"`RRI` smallint(2) NOT NULL default '-1', ".
		"`Graviton` smallint(2) NOT NULL default '-1', ".
		"`Expeditions` smallint(2) NOT NULL default '-1', ".
		"`dateRE` int(11) NOT NULL default '0', ".
		"`proba` smallint(2) NOT NULL default '-1', ".
		"`active` enum('0', '1') NOT NULL default '1', ".
		"`sender_id` int(11) NOT NULL, ".
		"PRIMARY KEY (`id_spy`), ".
		"KEY `coordinates` (`coordinates`)".
		")"
	);
	$db->sql_query("CREATE TABLE IF NOT EXISTS `".TABLE_PARSEDRC."` (".
		"`id_rc` int(11) NOT NULL auto_increment, ".
		"`dateRC` int(11) NOT NULL default '0', ".
		"`coordinates` varchar(9) NOT NULL default '', ".
		"`nb_rounds` int(2) NOT NULL default '0', ".
		"`victoire` char NOT NULL default 'A', ".
		"`pertes_A` int(11) NOT NULL default '0', ".
		"`pertes_D` int(11) NOT NULL default '0', ".
		"`gain_M` int(11) NOT NULL default '-1', ".
		"`gain_C` int(11) NOT NULL default '-1', ".
		"`gain_D` int(11) NOT NULL default '-1', ".
		"`debris_M` int(11) NOT NULL default '-1', ".
		"`debris_C` int(11) NOT NULL default '-1', ".
		"`lune` int(2) NOT NULL default '0', ".
		"PRIMARY KEY (`id_rc`), ".
		"KEY `coordinatesrc` (`coordinates`)".
		")"
	);
	$db->sql_query("CREATE TABLE IF NOT EXISTS `".TABLE_PARSEDRCROUND."` (".
		"`id_rcround` int(11) NOT NULL auto_increment, ".
		"`id_rc` int(11) NOT NULL, ".
		"`numround` int(2) NOT NULL, ".
		"`attaque_tir` int(11) NOT NULL default '-1', ".
		"`attaque_puissance` int(11) NOT NULL default '-1', ".
		"`defense_bouclier` int(11) NOT NULL default '-1', ".
		"`attaque_bouclier` int(11) NOT NULL default '-1', ".
		"`defense_tir` int(11) NOT NULL default '-1', ".
		"`defense_puissance` int(11) NOT NULL default '-1', ".
		"PRIMARY KEY (id_rcround), ".
		"KEY `rcround` (`id_rc`, `numround`), ".
		"KEY `id_rc` (`id_rc`)".
		")"
	);
	$db->sql_query("CREATE TABLE IF NOT EXISTS `".TABLE_ROUND_ATTACK."` (".
		"`id_roundattack` int(11) NOT NULL auto_increment, ".
		"`id_rcround` int(11) NOT NULL, ".
		"`player` varchar(30) NOT NULL default '', ".
		"`coordinates` varchar(9) NOT NULL default '', ".
		"`Armes` smallint(2) NOT NULL default '-1', ".
		"`Bouclier` smallint(2) NOT NULL default '-1', ".
		"`Protection` smallint(2) NOT NULL default '-1', ".
		"`PT` int(11) NOT NULL default '-1', ".
		"`GT` int(11) NOT NULL default '-1', ".
		"`CLE` int(11) NOT NULL default '-1', ".
		"`CLO` int(11) NOT NULL default '-1', ".
		"`CR` int(11) NOT NULL default '-1', ".
		"`VB` int(11) NOT NULL default '-1', ".
		"`VC` int(11) NOT NULL default '-1', ".
		"`REC` int(11) NOT NULL default '-1', ".
		"`SE` int(11) NOT NULL default '-1', ".
		"`BMD` int(11) NOT NULL default '-1', ".
		"`DST` int(11) NOT NULL default '-1', ".
		"`EDLM` int(11) NOT NULL default '-1', ".
		"`TRA` int(11) NOT NULL default '-1', ".
		"PRIMARY KEY (`id_roundattack`), ".
		"KEY `id_rcround` (`id_rcround`), ".
		"KEY `player` (`player`, `coordinates`)".
		")"
	);
	$db->sql_query("CREATE TABLE IF NOT EXISTS `".TABLE_ROUND_DEFENSE."` (".
		"`id_rounddefense` int(11) NOT NULL auto_increment, ".
		"`id_rcround` int(11) NOT NULL, ".
		"`player` varchar(30) NOT NULL default '', ".
		"`coordinates` varchar(9) NOT NULL default '', ".
		"`Armes` smallint(2) NOT NULL default '-1', ".
		"`Bouclier` smallint(2) NOT NULL default '-1', ".
		"`Protection` smallint(2) NOT NULL default '-1', ".
		"`PT` int(11) NOT NULL default '-1', ".
		"`GT` int(11) NOT NULL default '-1', ".
		"`CLE` int(11) NOT NULL default '-1', ".
		"`CLO` int(11) NOT NULL default '-1', ".
		"`CR` int(11) NOT NULL default '-1', ".
		"`VB` int(11) NOT NULL default '-1', ".
		"`VC` int(11) NOT NULL default '-1', ".
		"`REC` int(11) NOT NULL default '-1', ".
		"`SE` int(11) NOT NULL default '-1', ".
		"`BMD` int(11) NOT NULL default '-1', ".
		"`DST` int(11) NOT NULL default '-1', ".
		"`EDLM` int(11) NOT NULL default '-1', ".
		"`SAT` int(11) default '-1', ".
		"`TRA` int(11) NOT NULL default '-1', ".
		"`LM` int(11) NOT NULL default '-1', ".
		"`LLE` int(11) NOT NULL default '-1', ".
		"`LLO` int(11) NOT NULL default '-1', ".
		"`CG` int(11) NOT NULL default '-1', ".
		"`AI` int(11) NOT NULL default '-1', ".
		"`LP` int(11) NOT NULL default '-1', ".
		"`PB` smallint(1) NOT NULL default '-1', ".
		"`GB` smallint(1) NOT NULL default '-1', ".
		"PRIMARY KEY (`id_rounddefense`), ".
		"KEY `id_rcround` (`id_rcround`), ".
		"KEY `player` (`player`, `coordinates`)".
		")"
	);
	$db->sql_query("UPDATE ".TABLE_CONFIG." SET config_value = '3.05beta' WHERE config_name = 'version'");
	$ogsversion = '3.05beta';
}
if (version_compare($ogsversion, "3.05beta", "==")) {
	$result = $db->sql_query("SHOW FIELDS FROM ".TABLE_USER);
	$off_ok = false;
	while (list($field) = $db->sql_fetch_row($result)) {
		if ($field == 'off_ingenieur') {
			$off_ok = true;
			break;
		}
	}
	if ($off_ok === false) $db->sql_query("ALTER TABLE ".TABLE_USER." ADD off_amiral enum('0', '1') NOT NULL default '0', ADD off_ingenieur enum('0', '1') NOT NULL default '0', ADD off_geologue enum('0', '1') NOT NULL default '0', ADD off_technocrate enum('0', '1') NOT NULL default '0'");
	$db->sql_query("UPDATE ".TABLE_CONFIG." SET config_value = '3.05' WHERE config_name = 'version'");
	if (function_exists('import_RE')) import_RE();
	$ogsversion = '3.05';
}
if (version_compare($ogsversion, "4.0", "<")) {
	// Champ user_language ajouté à la table user
	$result = $db->sql_query("SHOW FIELDS FROM ".TABLE_USER);
	$uLang_ok = false;
	$uRow_ok = false;
	while (list($field) = $db->sql_fetch_row($result)) {
		if ($field == 'user_language') $uLang_ok = true;
		if ($field == 'user_row') $uRow_ok = true;
	}
	if ($uLang_ok === false) $db->sql_query("ALTER TABLE ".TABLE_USER." ADD user_language varchar(8) NOT NULL default '0' AFTER `user_active` ");
	if ($uRow_ok === false) $db->sql_query("ALTER TABLE ".TABLE_USER." ADD user_row smallint(3) NOT NULL default 1 AFTER `user_system` ");

	// Champ galaxy, system, row ajoutés aux tables parsed_spy et parsed_rc
	// Tables à modifier :
	$t_table = Array(
		Array (TABLE_PARSEDSPY, 'id_spy'),
		Array (TABLE_PARSEDRC, 'id_rc'),
		Array (TABLE_ROUND_ATTACK, 'id_roundattack'),
		Array (TABLE_ROUND_DEFENSE, 'id_rounddefense')
	);
	foreach($t_table as $table_to_edit) {
		$rq = "SHOW FIELDS FROM ".$table_to_edit[0];
		$result = $db->sql_query($rq);
		$galaxy = $system = $row = false;
		while (list($field) = $db->sql_fetch_row($result)) {
			if ($field == 'galaxy') $galaxy = true;
			if ($field == 'system') $system = true;
			if ($field == 'row') $row = true;
		}
		if ($galaxy === false) $db->sql_query("ALTER TABLE ".$table_to_edit[0]." ADD `galaxy` smallint(3)  NOT NULL default '0' AFTER `coordinates` ");
		if ($system === false) $db->sql_query("ALTER TABLE ".$table_to_edit[0]." ADD `system` smallint(3)  NOT NULL default '0' AFTER `galaxy` ");
		if ($row === false) $db->sql_query("ALTER TABLE ".$table_to_edit[0]." ADD `row` smallint(3)  NOT NULL default '0' AFTER `system` ");
	}

	check_coords_parsedRE(); // Rempli les champs galaxy, system, row de la table parsedRE

	// Ajout de la table de restriction des modules en fonction des groupes 
	$db->sql_query(
		"CREATE TABLE IF NOT EXISTS `".TABLE_MOD_RESTRICT."` (".
		"`group_id` MEDIUMINT(8) NOT NULL, ".
		"`mod_id` MEDIUMINT(8) NOT NULL, ".
		"UNIQUE KEY (`group_id`, `mod_id`)".
		")"
	);

	// Ajout de la table des categories
	$db->sql_query(
		"CREATE TABLE IF NOT EXISTS `".TABLE_MOD_CAT."` (".
		"`id` int(11) NOT NULL auto_increment, ".
		"`title` varchar(255) NOT NULL COMMENT 'Nom du mod', ".
		"`menu` varchar(255) NOT NULL COMMENT 'Titre du lien dans le menu', ".
		"`position` int(11) NOT NULL default '-1', ".
		"`mods` varchar(255) NOT NULL default 'index des modules dans cette categorie', ".
		"`active` tinyint(1) NOT NULL COMMENT 'Permet de désactiver un mod sans le désinstaller, évite les mods#pirates', ".
		"`admin_only` enum('0', '1') NOT NULL default '0' COMMENT 'Affichage des mods de l utilisateur', ".
		"PRIMARY KEY (`id`), ".
		"UNIQUE KEY `title` (`title`), ".
		"UNIQUE KEY `menu` (`menu`)".
		")"
	);
	
	// Ajout de la table des MPs
	$db->sql_query(
		"CREATE TABLE IF NOT EXISTS `".TABLE_MP."` (".
		"`id` int(11) NOT NULL auto_increment, ".
		" `sujet` varchar(255) NOT NULL default '', ".
		" `expediteur` int(11) NOT NULL, ".
		" `destinataire` int(11) NOT NULL, ".
		" `message` text NOT NULL, ".
		" `timestamp` int(11) NOT NULL default '0', ".
		" `vu` enum('0', '1') NOT NULL default '0', ".
		" `efface` enum('0', '1', '2') NOT NULL default '0', ".
		" KEY `id` (`id`)".
		")"
	);

	// Ajout de la table des vaisseaux
	$db->sql_query(
		"CREATE TABLE IF NOT EXISTS `".TABLE_USER_FLEET."` (".
		"`user_id` int(11) NOT NULL DEFAULT '0', ".
		"`planet_id` int(11) NOT NULL DEFAULT '0', ".
		"`PT` int(11) NOT NULL DEFAULT '0', ".
		"`GT` int(11) NOT NULL DEFAULT '0', ".
		"`CLE` int(11) NOT NULL DEFAULT '0', ".
		"`CLO` int(11) NOT NULL DEFAULT '0', ".
		"`CR` int(11) NOT NULL DEFAULT '0', ".
		"`VB` int(11) NOT NULL DEFAULT '0', ".
		"`VC` int(11) NOT NULL DEFAULT '0', ".
		"`REC` int(11) NOT NULL DEFAULT '0', ".
		"`SE` int(11) NOT NULL DEFAULT '0', ".
		"`BMD` int(11) NOT NULL DEFAULT '0', ".
		"`SAT` int(11) NOT NULL DEFAULT '0', ".
		"`DST` int(11) NOT NULL DEFAULT '0', ".
		"`EDLM` int(11) NOT NULL DEFAULT '0', ".
		"`TRA` int(11) NOT NULL DEFAULT '0', ".
		"PRIMARY KEY (`user_id`, `planet_id`)".
		")"
	);

	// Suppression du champs "satellites" de la table des vaisseaux (elle est déjà présente dans la table des bâtiments)
	$db->sql_query("INSERT IGNORE INTO ".TABLE_USER_FLEET." (user_id) VALUES ('0')");
	$quet = mysql_query("SELECT * FROM `".TABLE_USER_FLEET."` LIMIT 1");
	while ($row = mysql_fetch_assoc($quet)) {
		if (isset($row["SAT"])) $db->sql_query("ALTER TABLE `".TABLE_USER_FLEET."` DROP `SAT`");
	}
	$db->sql_query("DELETE FROM `".TABLE_USER_FLEET."` WHERE `user_id` = 0");

	// Nettoyage des tables user_building et user_defence (suppression des id < 0)
	$request = "DELETE FROM %s WHERE planet_id < 0";
	$db->sql_query(sprintf($request, TABLE_USER_BUILDING));
	$db->sql_query(sprintf($request, TABLE_USER_DEFENCE));

	$db->sql_query("INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('log_langerror', '0')");
	$db->sql_query("INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('portee_missil', '1')");
	$db->sql_query("INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('friendly_phalanx', '1')");
	$db->sql_query("INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('open_user', '')");
	$db->sql_query("INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('open_admin', '')");
	$db->sql_query("INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('language', '".$lang_install."')");
	$db->sql_query("INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('language_parsing', '".$lang_install."')");
	$db->sql_query("INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('ally_protection_color', '')");
	$db->sql_query("INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('scolor_count', '2')");
	$db->sql_query("INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('scolor_text', '{mine}_|_".(isset($server_config["allied"])?$server_config["allied"]:"")."')");
	$db->sql_query("INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('scolor_type', 'J_A')");
	$db->sql_query("INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('scolor_color', 'Green_Red')");
	$db->sql_query("INSERT IGNORE INTO ".TABLE_MOD_CAT." (title, menu, position, active) VALUES ('Admin', 'Administration', '10', '1')");
	$db->sql_query("UPDATE ".TABLE_CONFIG." SET config_value = '".$install_version."' WHERE config_name = 'version'");
	$db->sql_query("DROP TABLE ".$table_prefix."mod_config");
	$db->sql_query("ALTER TABLE `".TABLE_MOD."` DROP `title`, DROP `menu`");

	// Modification de l'encodage vers UTF-8
	// Pour la base de donnée 
	$db->sql_query("ALTER DATABASE `".$db->dbname."` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci");

	// Pour chaque table
	$db->sql_query("SHOW TABLES FROM ".$db->dbname);
	while (list($tmp) = $db->sql_fetch_row()) $tables[] = $tmp;
	foreach ($tables as $table) {
		$db->sql_query("ALTER TABLE `".$table."` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci");

		// Pour chaque champ text ou varchar de la table
		$fields = Array();
		$db->sql_query("SHOW FIELDS FROM ".$table);
		while ($tmp = $db->sql_fetch_row()) $fields[] = $tmp;
		foreach ($fields as $field) {
			if (preg_match('/varchar/', $field[1]) || preg_match('/text/', $field[1]) || preg_match('/enum/', $field[1])) {
			// Au passage, on augmente et uniformise la capacité de stockages des nom/ally/planète
			if (($field[0] == "name" || $field[0] == "player" || $field[0] == "planet_name" || $field[0] == "ally") && preg_match('/varchar/', $field[1]))
				$field[1] = "varchar(64)";
				$db->sql_query(
					"ALTER TABLE `".$table."` ".
					"MODIFY `".$field[0]."` ".$field[1]." ".
					"CHARACTER SET utf8 COLLATE utf8_general_ci ".
					($field[2]=='NO'?"NOT NULL":"NULL")." ".
					($field[4]!=""?"DEFAULT '".$field[4]."'":"")
				);
			}
		}
		"ALTER TABLE `".TABLE_MOD."` MODIFY `menu` varchar(256)";
	}

	$ogsversion = $install_version;
	$up_to_date = true;
}

?>
