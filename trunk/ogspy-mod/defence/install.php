<?php
/***************************************************************************
*	filename	: install.php
*	desc.		: Installer 'Optimisation de la défence'
*	Author		: Lothadith
*	created		: 15/12/2006
*	modified	: 03/09/2007
*	version		: 0.8b
***************************************************************************/

if (!defined('IN_SPYOGAME')) { die("Passe ton chemin manant !"); }

// Définitions
global $db;
global $table_prefix;
define("TABLE_DEFENCE", $table_prefix."defence");
define("TABLE_DEFENCE_OPTION", $table_prefix."defence_option");
define("TABLE_DEFENCE_COEF", $table_prefix."defence_coef");
define("TABLE_DEFENCE_ATTACK", $table_prefix."defence_attack");

// Si les tables du mod existent, on les supprime
$query="DROP TABLE IF EXISTS ".TABLE_DEFENCE;
$db->sql_query($query);
$query="DROP TABLE IF EXISTS ".TABLE_DEFENCE_OPTION;
$db->sql_query($query);
$query="DROP TABLE IF EXISTS ".TABLE_DEFENCE_COEF;
$db->sql_query($query);
$query="DROP TABLE IF EXISTS ".TABLE_DEFENCE_ATTACK;
$db->sql_query($query);

// Ensuite, on crée les tables nécessaires
$query = "CREATE TABLE ".TABLE_DEFENCE." ("
	. " defence_id int(3) NOT NULL, "
	. " unit varchar(5) NOT NULL, "
	. " bouclier int(5) NOT NULL default '0', "
	. " attaque int(5) NOT NULL default '0', "
	. " metal int(6) NOT NULL default '0', "
	. " cristal int(6) NOT NULL default '0', "
	. " deut int(6) NOT NULL default '0', "
	. " PRIMARY KEY  (`defence_id`)"
	. " );";
$db->sql_query($query);

$query = "CREATE TABLE ".TABLE_DEFENCE_OPTION." ("
	. " user_id int(11) NOT NULL, "
	. " def_zero_active enum('0','1') NOT NULL default '0', "
	. " def_select varchar(8) NOT NULL default 'attaque', "
	. " def_simulator varchar(10) NOT NULL default 'speedsim', "
	. " def_p1_unit varchar(3) NULL, "
	. " def_p1_nb int(11) NULL, "
	. " def_p2_unit varchar(3) NULL, "
	. " def_p2_nb int(11) NULL, "
	. " def_p3_unit varchar(3) NULL, "
	. " def_p3_nb int(11) NULL, "
	. " def_p4_unit varchar(3) NULL, "
	. " def_p4_nb int(11) NULL, "
	. " def_p5_unit varchar(3) NULL, "
	. " def_p5_nb int(11) NULL, "
	. " def_p6_unit varchar(3) NULL, "
	. " def_p6_nb int(11) NULL, "
	. " def_p7_unit varchar(3) NULL, "
	. " def_p7_nb int(11) NULL, "
	. " def_p8_unit varchar(3) NULL, "
	. " def_p8_nb int(11) NULL, "
	. " def_p9_unit varchar(3) NULL, "
	. " def_p9_nb int(11) NULL, "
	. " def_l1_unit varchar(3) NULL, "
	. " def_l1_nb int(11) NULL, "
	. " def_l2_unit varchar(3) NULL, "
	. " def_l2_nb int(11) NULL, "
	. " def_l3_unit varchar(3) NULL, "
	. " def_l3_nb int(11) NULL, "
	. " def_l4_unit varchar(3) NULL, "
	. " def_l4_nb int(11) NULL, "
	. " def_l5_unit varchar(3) NULL, "
	. " def_l5_nb int(11) NULL, "
	. " def_l6_unit varchar(3) NULL, "
	. " def_l6_nb int(11) NULL, "
	. " def_l7_unit varchar(3) NULL, "
	. " def_l7_nb int(11) NULL, "
	. " def_l8_unit varchar(3) NULL, "
	. " def_l8_nb int(11) NULL, "
	. " def_l9_unit varchar(3) NULL, "
	. " def_l9_nb int(11) NULL, "
	. " UNIQUE KEY (`user_id`)"
	. " );";
$db->sql_query($query);

$query = "CREATE TABLE ".TABLE_DEFENCE_COEF." ("
	. " user_id INT(11) NOT NULL , "
	. " planet_id INT(11) NOT NULL , "
	. " LM FLOAT UNSIGNED NOT NULL DEFAULT '100', "
	. " LLE FLOAT UNSIGNED NOT NULL DEFAULT '100', "
	. " LLO FLOAT UNSIGNED NOT NULL DEFAULT '100', "
	. " CG FLOAT UNSIGNED NOT NULL DEFAULT '100', "
	. " AI FLOAT UNSIGNED NOT NULL DEFAULT '100', "
	. " LP FLOAT UNSIGNED NOT NULL DEFAULT '100', "
	. " defence_coef_rapport FLOAT UNSIGNED NOT NULL DEFAULT '1', "
	. " PRIMARY KEY (`user_id`, `planet_id`)"
	. " );";
$db->sql_query($query);

$query = "CREATE TABLE ".TABLE_DEFENCE_ATTACK." ("
	. " attack_id int(11) NOT NULL auto_increment, "
	. " user_id int(11) NOT NULL, "
	. " attack_PT int(11) NOT NULL default '0', "
	. " attack_GT int(11) NOT NULL default '0', "
	. " attack_CLE int(11) NOT NULL default '0', "
	. " attack_CLO int(11) NOT NULL default '0', "
	. " attack_CR int(11) NOT NULL default '0', "
	. " attack_VB int(11) NOT NULL default '0', "
	. " attack_VC int(11) NOT NULL default '0', "
	. " attack_RE int(11) NOT NULL default '0', "
	. " attack_SE int(11) NOT NULL default '0', "
	. " attack_BO int(11) NOT NULL default '0', "
	. " attack_DE int(11) NOT NULL default '0', "
	. " attack_EM int(11) NOT NULL default '0', "
	. " attack_TR int(11) NOT NULL default '0', "
	. " attack_quai enum('0','1') NOT NULL default '0', "
	. " attack_techno_armes int(3) NOT NULL default '0', "
	. " attack_techno_bouclier int(3) NOT NULL default '0', "
	. " attack_techno_protection int(3) NOT NULL default '0', "
	. " PRIMARY KEY (`attack_id`)"
	. " );";
$db->sql_query($query);

// On rempli la table 'ogspy_defence'
$query = "INSERT INTO ".TABLE_DEFENCE." (defence_id, unit, bouclier, attaque, metal, cristal, deut)"
	. " VALUES (1, 'LM', 20, 80, 2000, 0, 0),"
	. " (2, 'LLE', 25, 100, 1500, 500, 0),"
	. " (3, 'LLO', 100, 250, 6000, 2000, 0),"
	. " (4, 'CG', 200, 1100, 20000, 15000, 2000),"
	. " (5, 'AI', 500, 150, 2000, 6000, 0),"
	. " (6, 'LP', 300, 3000, 50000, 50000, 30000),"
	. " (7, 'PB', 2000, 1, 10000, 10000, 0),"
	. " (8, 'GB', 1000, 1, 50000, 50000, 0),"
	. " (9, 'MIC', 1, 1, 8000, 0, 2000),"
	. " (10, 'MIP', 1, 12000, 12500, 2500, 10000)";
$db->sql_query($query);

// Enfin on insère les données du mod, dans la table mod.
$query = "INSERT INTO ".TABLE_MOD." ( title, menu, action, root, link, version, active) VALUES ( 'Optimisation de la défense', 'Optimisation de<br>la défense', 'defence', 'defence', 'defence.php', '0.8b', '1')";
$db->sql_query($query);

?>
