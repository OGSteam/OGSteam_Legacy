<?php
/**
 * install.php 
 * @package HofRC
 * @author Shad
 * @link http://www.ogsteam.fr
 * @version : 0.0.1
 */
if (!defined('IN_SPYOGAME')) {
    die("Hacking attempt");
}

global $db;
if (!isset($table_prefix)) 
	global $table_prefix;

$is_ok = false;	
$mod_folder = "hofrc";
$is_ok = install_mod($mod_folder);
if ($is_ok == true)
	{
		define('TABLE_HOFRC_ATTACK',$table_prefix.'hofrc_attack');
		define('TABLE_HOFRC_CONFIG',$table_prefix.'hofrc_config');
		define('TABLE_HOFRC_DEFENCE',$table_prefix.'hofrc_defence');
		define('TABLE_HOFRC_INFO_RC',$table_prefix.'hofrc_info_rc');
		define('TABLE_HOFRC_RP',$table_prefix.'hofrc_rp');
		define('TABLE_HOFRC_SKIN',$table_prefix.'hofrc_skin');
		define('TABLE_HOFRC_TITLE',$table_prefix.'hofrc_title');

// création de la table d'enregistrement des préférences (pour les joueurs)
		$query = "CREATE TABLE `".TABLE_HOFRC_ATTACK."` ("
			."  `id` int(11) NOT NULL auto_increment,"
			."  `id_rc` int(11) NOT NULL default '1' COMMENT 'id du hof',"
			."  `round` int(11) NOT NULL default '1',"
			."	player varchar(30) NOT NULL default '0',"
			."	ally varchar(30) NOT NULL default '0',"
			."	coordinates varchar(9) NOT NULL default '0',"
			."	armes smallint(2) NOT NULL default '0',"
			."	bouclier smallint(2) NOT NULL default '0',"
			."	protection smallint(2) NOT NULL default '0',"
			."	pt int(11) NOT NULL default '0',"
			."	gt int(11) NOT NULL default '0',"
			."	cle int(11) NOT NULL default '0',"
			."	clo int(11) NOT NULL default '0',"
			."	cr int(11) NOT NULL default '0',"
			."	vb int(11) NOT NULL default '0',"
			."	vc int(11) NOT NULL default '0',"
			."	rec int(11) NOT NULL default '0',"
			."	se int(11) NOT NULL default '0',"
			."	bmd int(11) NOT NULL default '0',"
			."	dst int(11) NOT NULL default '0',"
			."	edlm int(11) NOT NULL default '0',"
			."	tra int(11) NOT NULL default '0',"
			."  PRIMARY KEY  (`id`)"
			."  ) COMMENT='Composition flotte avant et après hof'";
			$db->sql_query($query);		
			
		$query = "CREATE TABLE `".TABLE_HOFRC_CONFIG."` ("
			."	`config_name` varchar(255) NOT NULL DEFAULT '',"
			."	`config_value` varchar(255) NOT NULL DEFAULT '',"
			."	PRIMARY KEY  (`config_name`)"
			."  ) COMMENT='Configuration générale pour le mod'";
			$db->sql_query($query);		
			
		$query = "CREATE TABLE `".TABLE_HOFRC_DEFENCE."` ("
			."  `id` int(11) NOT NULL auto_increment,"
			."  `id_rc` int(11) NOT NULL default '1' COMMENT 'id du hof',"
			."  `round` int(11) NOT NULL default '1',"
			."	player varchar(30) NOT NULL default '0',"
			."	ally varchar(30) NOT NULL default '0',"
			."	coordinates varchar(9) NOT NULL default '0',"
			."	armes smallint(2) NOT NULL default '0',"
			."	bouclier smallint(2) NOT NULL default '0',"
			."	protection smallint(2) NOT NULL default '0',"
			."	pt int(11) NOT NULL default '0',"
			."	gt int(11) NOT NULL default '0',"
			."	cle int(11) NOT NULL default '0',"
			."	clo int(11) NOT NULL default '0',"
			."	cr int(11) NOT NULL default '0',"
			."	vb int(11) NOT NULL default '0',"
			."	vc int(11) NOT NULL default '0',"
			."	rec int(11) NOT NULL default '0',"
			."	se int(11) NOT NULL default '0',"
			."	bmd int(11) NOT NULL default '0',"
			."	dst int(11) NOT NULL default '0',"
			."	edlm int(11) NOT NULL default '0',"
			."	tra int(11) NOT NULL default '0',"
			."	sat int(11) NOT NULL default '0',"
			."	lm int(11) NOT NULL default '0',"
			."	lle int(11) NOT NULL default '0',"
			."	llo int(11) NOT NULL default '0',"
			."	cg int(11) NOT NULL default '0',"
			."	ai int(11) NOT NULL default '0',"
			."	lp int(11) NOT NULL default '0',"
			."	pb int(11) NOT NULL default '0',"
			."	gb int(11) NOT NULL default '0',"
			."  PRIMARY KEY  (`id`)"
			."  ) COMMENT='Composition flotte et défense avant et après hof'";
			$db->sql_query($query);	
			
			$query = "CREATE TABLE `".TABLE_HOFRC_INFO_RC."` ("
			."  `id` int(11) NOT NULL auto_increment,"
			."  `id_rc` int(11) NOT NULL default '1' COMMENT 'id du hof',"
			."  `id_rcround` int(11) NOT NULL default '1' COMMENT 'id du round',"
			."	daterc int(11) NOT NULL default '0',"
			."	type_hof varchar(30) NOT NULL default '0',"
			."	coordinates varchar(30) NOT NULL default '0',"
			."	victoire varchar(1) NOT NULL default '0',"
			."	nb_rounds int(11) NOT NULL default '0',"
			."	metal_taken int(11) NOT NULL default '0',"
			."	cristal_taken int(11) NOT NULL default '0',"
			."	deut_taken int(11) NOT NULL default '0',"
			."	metal_cdr int(11) NOT NULL default '0',"
			."	cristal_cdr int(11) NOT NULL default '0',"
			."	lost_attack int(11) NOT NULL default '0',"
			."	lost_defence int(11) NOT NULL default '0',"
			."	lune int(11) NOT NULL default '0',"
			."	publicated int(11) NOT NULL default '0',"
			."	ignored int(11) NOT NULL default '0',"
			."  PRIMARY KEY  (`id`)"
			."  ) COMMENT='Informations sur le hof'";
			$db->sql_query($query);	
			
			$query = "CREATE TABLE `".TABLE_HOFRC_RP."` ("
			."  `id` int(11) NOT NULL auto_increment,"
			."  `id_rc` int(11) NOT NULL default '1' COMMENT 'id du hof',"
			."	title int(11) NOT NULL default '0',"
			."	rp LONGTEXT NOT NULL,"
			."	beetween int(11) NOT NULL default '0',"
			."	howto LONGTEXT NOT NULL,"
			."	dedicaces LONGTEXT NOT NULL,"
			."  PRIMARY KEY  (`id`)"
			."  ) COMMENT='Histoire du rc'";
			$db->sql_query($query);	
		
			$query = "CREATE TABLE `".TABLE_HOFRC_SKIN."` ("
			."  `id` int(11) NOT NULL auto_increment,"
			."	title varchar(20) NOT NULL default '0',"
			."	pt varchar(20) NOT NULL default '0',"
			."	gt varchar(20) NOT NULL default '0',"
			."	cle varchar(20) NOT NULL default '0',"
			."	clo varchar(20) NOT NULL default '0',"
			."	cr varchar(20) NOT NULL default '0',"
			."	vb varchar(20) NOT NULL default '0',"
			."	vc varchar(20) NOT NULL default '0',"
			."	rec varchar(20) NOT NULL default '0',"
			."	se varchar(20) NOT NULL default '0',"
			."	bmd varchar(20) NOT NULL default '0',"
			."	dst varchar(20) NOT NULL default '0',"
			."	edlm varchar(20) NOT NULL default '0',"
			."	tra varchar(20) NOT NULL default '0',"
			."	sat varchar(20) NOT NULL default '0',"
			."	lm varchar(20) NOT NULL default '0',"
			."	lleger varchar(20) NOT NULL default '0',"
			."	llourd varchar(20) NOT NULL default '0',"
			."	cg varchar(20) NOT NULL default '0',"
			."	ai varchar(20) NOT NULL default '0',"
			."	lp varchar(20) NOT NULL default '0',"
			."	pb varchar(20) NOT NULL default '0',"
			."	gb varchar(20) NOT NULL default '0',"
			."	ally varchar(20) NOT NULL default '0',"
			."	player_att varchar(50) NOT NULL default '0',"
			."	player_def varchar(50) NOT NULL default '0',"
			."	techno varchar(20) NOT NULL default '0',"
			."	detruit varchar(20) NOT NULL default '0',"
			."	ressources_piller_min varchar(20) NOT NULL default '0',"
			."	ressources_piller_max varchar(20) NOT NULL default '0',"
			."	pertes_fleet_def varchar(20) NOT NULL default '0',"
			."	seuil_pertes varchar(20) NOT NULL default '0',"
			."	seuil_pillage varchar(20) NOT NULL default '0',"
			."	seuil_cdr varchar(20) NOT NULL default '0',"
			."	pertes_min_att varchar(20) NOT NULL default '0',"
			."	pertes_max_att varchar(20) NOT NULL default '0',"
			."	pertes_min_def varchar(20) NOT NULL default '0',"
			."	pertes_max_def varchar(20) NOT NULL default '0',"
			."	debris_min varchar(20) NOT NULL default '0',"
			."	debris_max varchar(20) NOT NULL default '0',"
			."	renta_min varchar(20) NOT NULL default '0',"
			."	renta_max varchar(20) NOT NULL default '0',"
			."	pic_header varchar(20) NOT NULL default '0',"
			."	pic_round varchar(20) NOT NULL default '0',"
			."	pic_separator varchar(20) NOT NULL default '0',"
			."	pic_result varchar(20) NOT NULL default '0',"
			."	pic_background varchar(20) NOT NULL default '0',"
			."  PRIMARY KEY  (`id`)"
			."  ) COMMENT='Config de conversion RC'";
			$db->sql_query($query);	
			
			$query = "CREATE TABLE `".TABLE_HOFRC_TITLE."` ("
			."  `id` int(11) NOT NULL default '0',"
			."  `id_rc` int(11) NOT NULL default '1' COMMENT 'id du hof',"
			."	board_url varchar(255) NOT NULL default '0',"
			."	title  varchar(255) NOT NULL default '0',"
			."	pillage varchar(255) NOT NULL default '0',"
			."  PRIMARY KEY  (`id`)"
			."  ) COMMENT='Information pour la création de l\'image'";
			$db->sql_query($query);	
			
			$query = "INSERT INTO `".TABLE_HOFRC_SKIN."` VALUES ('','ogsteam', '#0BED05', '#0BED05', '#DDEF03', '#DDEF03', '#EE7404', '#EE7404', '#0BED05', '#EE7404', '#EE7404', '#EE7404', '#EE7404', '#DC0106', '#CB0000', '#0BED05', '#00F700', '#00E700', '#00D700', '#00C700', '#00B700', '#00A700', '#009700', '#008700', '#4040FF', '#4040FF', '#4040FF', '#FF4000', '#FF4000', '#FFFFFF', '#FFFFFF', '#FF0000', '1000000', '1000000', '1000000', '#FFFFFF', '#FFFFFF', '#FFFFFF', '#FFFFFF', '#FFFFFF', '#FFFFFF', '#FFFFFF', '#FFFFFF', 'header.gif', 'round.gif', 'separator.jpg','result.jpg', 'background.png')";
			$db->sql_query($query);
			
			
			$query = "INSERT INTO `".TABLE_HOFRC_CONFIG."` VALUES ('hofrc_skin', 'ogsteam')";	$db->sql_query($query);
			$query = "INSERT INTO `".TABLE_HOFRC_CONFIG."` VALUES ('font_historique', 'verdanab')";	$db->sql_query($query);
			$query = "INSERT INTO `".TABLE_HOFRC_CONFIG."` VALUES ('font_size_historique', '10')";	$db->sql_query($query);
			$query = "INSERT INTO `".TABLE_HOFRC_CONFIG."` VALUES ('largeur_historique', '500')";	$db->sql_query($query);
			$query = "INSERT INTO `".TABLE_HOFRC_CONFIG."` VALUES ('hauteur_historique', '20')";	$db->sql_query($query);
			$query = "INSERT INTO `".TABLE_HOFRC_CONFIG."` VALUES ('pos_horiz_historique_1', '5')";	$db->sql_query($query);
			$query = "INSERT INTO `".TABLE_HOFRC_CONFIG."` VALUES ('pos_horiz_historique_2', '25')";	$db->sql_query($query);
			$query = "INSERT INTO `".TABLE_HOFRC_CONFIG."` VALUES ('pos_horiz_historique_3', '45')";	$db->sql_query($query);
			$query = "INSERT INTO `".TABLE_HOFRC_CONFIG."` VALUES ('pos_horiz_historique_4', '155')";	$db->sql_query($query);
			$query = "INSERT INTO `".TABLE_HOFRC_CONFIG."` VALUES ('pos_horiz_historique_5', '175')";	$db->sql_query($query);
			$query = "INSERT INTO `".TABLE_HOFRC_CONFIG."` VALUES ('color_txt_historique_1', '255,255,255')";	$db->sql_query($query);
			$query = "INSERT INTO `".TABLE_HOFRC_CONFIG."` VALUES ('color_txt_historique_2', '255,255,255')";	$db->sql_query($query);
			$query = "INSERT INTO `".TABLE_HOFRC_CONFIG."` VALUES ('color_txt_historique_3', '255,128,0')";	$db->sql_query($query);
			$query = "INSERT INTO `".TABLE_HOFRC_CONFIG."` VALUES ('color_txt_historique_4', '255,255,255')";	$db->sql_query($query);
			$query = "INSERT INTO `".TABLE_HOFRC_CONFIG."` VALUES ('color_txt_historique_5', '156,227,254')";	$db->sql_query($query);
			$query = "INSERT INTO `".TABLE_HOFRC_CONFIG."` VALUES ('pos_verti_historique', '15')";	$db->sql_query($query);
			$query = "INSERT INTO `".TABLE_HOFRC_CONFIG."` VALUES ('angle_historique', '0')";	$db->sql_query($query);
			$query = "INSERT INTO `".TABLE_HOFRC_CONFIG."` VALUES ('hofrc_percent_resizing', '20')";	$db->sql_query($query);
			$query = "INSERT INTO `".TABLE_HOFRC_CONFIG."` VALUES ('start_universe', '".mktime(0, 0, 0, date("m"), date("j"), date("Y"))."')";	$db->sql_query($query);
			$query = "INSERT INTO `".TABLE_HOFRC_CONFIG."` VALUES ('size_initial', '2000000')";	$db->sql_query($query);
			$query = "INSERT INTO `".TABLE_HOFRC_CONFIG."` VALUES ('size_courant', '5000000')";	$db->sql_query($query);
			$query = "INSERT INTO `".TABLE_HOFRC_CONFIG."` VALUES ('size_basic', '10000000')";	$db->sql_query($query);
			$query = "INSERT INTO `".TABLE_HOFRC_CONFIG."` VALUES ('size_normal', '20000000')";	$db->sql_query($query);
			$query = "INSERT INTO `".TABLE_HOFRC_CONFIG."` VALUES ('size_avance', '50000000')";	$db->sql_query($query);
			$query = "INSERT INTO `".TABLE_HOFRC_CONFIG."` VALUES ('size_stratege', '100000000')";	$db->sql_query($query);
			$query = "INSERT INTO `".TABLE_HOFRC_CONFIG."` VALUES ('size_expert', '150000000')";	$db->sql_query($query);
			$query = "INSERT INTO `".TABLE_HOFRC_CONFIG."` VALUES ('size_guerrier', '250000000')";	$db->sql_query($query);
			$query = "INSERT INTO `".TABLE_HOFRC_CONFIG."` VALUES ('size_devastateur', '500000000')";	$db->sql_query($query);
			$query = "INSERT INTO `".TABLE_HOFRC_CONFIG."` VALUES ('size_champion', '1000000000')";	$db->sql_query($query);
			$query = "INSERT INTO `".TABLE_HOFRC_CONFIG."` VALUES ('size_legendaire', '2000000000')";	$db->sql_query($query);
			$query = "INSERT INTO `".TABLE_HOFRC_CONFIG."` VALUES ('end_initial_solo', '".mktime(0, 0, 0, date("m")+4, date("j"), date("Y"))."')";	$db->sql_query($query);
			$query = "INSERT INTO `".TABLE_HOFRC_CONFIG."` VALUES ('end_initial_groupe', '".mktime(0, 0, 0, date("m")+3, date("j"), date("Y"))."')";	$db->sql_query($query);
			$query = "INSERT INTO `".TABLE_HOFRC_CONFIG."` VALUES ('end_courant_solo', '".mktime(0, 0, 0, date("m")+5, date("j"), date("Y"))."')";	$db->sql_query($query);
			$query = "INSERT INTO `".TABLE_HOFRC_CONFIG."` VALUES ('end_courant_groupe', '".mktime(0, 0, 0, date("m")+4, date("j"), date("Y"))."')";	$db->sql_query($query);
			$query = "INSERT INTO `".TABLE_HOFRC_CONFIG."` VALUES ('end_basic_solo', '".mktime(0, 0, 0, date("m")+7, date("j"), date("Y"))."')";	$db->sql_query($query);
			$query = "INSERT INTO `".TABLE_HOFRC_CONFIG."` VALUES ('end_basic_groupe', '".mktime(0, 0, 0, date("m")+6, date("j"), date("Y"))."')";	$db->sql_query($query);
			$query = "INSERT INTO `".TABLE_HOFRC_CONFIG."` VALUES ('end_normal_solo', '".mktime(0, 0, 0, date("m")+8, date("j"), date("Y"))."')";	$db->sql_query($query);
			$query = "INSERT INTO `".TABLE_HOFRC_CONFIG."` VALUES ('end_normal_groupe', '".mktime(0, 0, 0, date("m")+7, date("j"), date("Y"))."')";	$db->sql_query($query);
			$query = "INSERT INTO `".TABLE_HOFRC_CONFIG."` VALUES ('end_avance_solo', '".mktime(0, 0, 0, date("m")+10, date("j"), date("Y"))."')";	$db->sql_query($query);
			$query = "INSERT INTO `".TABLE_HOFRC_CONFIG."` VALUES ('end_avance_groupe', '".mktime(0, 0, 0, date("m")+9, date("j"), date("Y"))."')";	$db->sql_query($query);
			$query = "INSERT INTO `".TABLE_HOFRC_CONFIG."` VALUES ('end_stratege_solo', '".mktime(0, 0, 0, date("m")+13, date("j"), date("Y"))."')";	$db->sql_query($query);
			$query = "INSERT INTO `".TABLE_HOFRC_CONFIG."` VALUES ('end_stratege_groupe', '".mktime(0, 0, 0, date("m")+12, date("j"), date("Y"))."')";	$db->sql_query($query);
			
			// Changement de la structure de la table round_attack
			$query = "UPDATE ".TABLE_ROUND_ATTACK." SET `PT` = REPLACE(PT, '-1', '0'), `GT` = REPLACE(GT, '-1', '0'), `CLE` = REPLACE(CLE, '-1', '0'), `CLO` = REPLACE(CLO, '-1', '0'), `CR` = REPLACE(CR, '-1', '0'), `VB` = REPLACE(VB, '-1', '0'), `VC` = REPLACE(VC, '-1', '0'),  `REC` = REPLACE(REC, '-1', '0'), `SE` = REPLACE(SE, '-1', '0'), `BMD` = REPLACE(BMD, '-1', '0'), `DST` = REPLACE(DST, '-1', '0'), `EDLM` = REPLACE(EDLM, '-1', '0'), `TRA` = REPLACE(TRA, '-1', '0');";
			$db->sql_query($query);
		
			
			// Changement de la structure de la table round_attack
			$query ="UPDATE ".TABLE_ROUND_DEFENSE." SET `PT` = REPLACE(PT, '-1', '0'), `GT` = REPLACE(GT, '-1', '0'), `CLE` = REPLACE(CLE, '-1', '0'), `CLO` = REPLACE(CLO, '-1', '0'), `CR` = REPLACE(CR, '-1', '0'), `VB` = REPLACE(VB, '-1', '0'), `VC` = REPLACE(VC, '-1', '0'), `REC` = REPLACE(REC, '-1', '0'), `SE` = REPLACE(SE, '-1', '0'), `BMD` = REPLACE(BMD, '-1', '0'), `DST` = REPLACE(DST, '-1', '0'), `EDLM` = REPLACE(EDLM, '-1', '0'), `SAT` = REPLACE(SAT, '-1', '0'), `TRA` = REPLACE(TRA, '-1', '0'), `LM` = REPLACE(LM, '-1', '0'), `LLE` = REPLACE(LLE, '-1', '0'), `LLO` = REPLACE(LLO, '-1', '0'), `CG` = REPLACE(CG, '-1', '0'), `AI` = REPLACE(AI , '-1', '0'), `LP` = REPLACE(LP, '-1', '0'), `PB` = REPLACE(PB, '-1', '0'), `GB` = REPLACE(GB, '-1', '0')";
			$db->sql_query($query);	
			
			$query ="ALTER TABLE ".TABLE_ROUND_ATTACK." ALTER COLUMN `PT` SET DEFAULT '0', ALTER COLUMN `GT` SET DEFAULT '0', ALTER COLUMN `CLE` SET DEFAULT '0', ALTER COLUMN `CLO` SET DEFAULT '0', ALTER COLUMN `CR` SET DEFAULT '0', ALTER COLUMN `VB` SET DEFAULT '0', ALTER COLUMN `VC` SET DEFAULT '0', ALTER COLUMN `REC` SET DEFAULT '0', ALTER COLUMN `SE` SET DEFAULT '0', ALTER COLUMN `BMD` SET DEFAULT '0', ALTER COLUMN `DST` SET DEFAULT '0', ALTER COLUMN `EDLM` SET DEFAULT '0', ALTER COLUMN `TRA` SET DEFAULT '0'";
			$db->sql_query($query);	
			
			$query ="ALTER TABLE ".TABLE_ROUND_DEFENSE." ALTER COLUMN `PT` SET DEFAULT '0', ALTER COLUMN `GT` SET DEFAULT '0', ALTER COLUMN `CLE` SET DEFAULT '0', ALTER COLUMN `CLO` SET DEFAULT '0', ALTER COLUMN `CR` SET DEFAULT '0', ALTER COLUMN `VB` SET DEFAULT '0', ALTER COLUMN `VC` SET DEFAULT '0', ALTER COLUMN `REC` SET DEFAULT '0', ALTER COLUMN `SE` SET DEFAULT '0', ALTER COLUMN `BMD` SET DEFAULT '0', ALTER COLUMN `DST` SET DEFAULT '0', ALTER COLUMN `EDLM` SET DEFAULT '0', ALTER COLUMN `SAT` SET DEFAULT '0', ALTER COLUMN `TRA` SET DEFAULT '0', ALTER COLUMN `LM` SET DEFAULT '0', ALTER COLUMN `LLE` SET DEFAULT '0', ALTER COLUMN `LLO` SET DEFAULT '0', ALTER COLUMN `CG` SET DEFAULT '0', ALTER COLUMN `AI` SET DEFAULT '0', ALTER COLUMN `LP` SET DEFAULT '0', ALTER COLUMN `PB` SET DEFAULT '0', ALTER COLUMN `GB` SET DEFAULT '0'";
			$db->sql_query($query);	
	}
else
	{
		echo  "<script>alert('Désolé, un problème a eu lieu pendant l'installation, corrigez les problèmes survenue et réessayez.');</script>";
	}
?>