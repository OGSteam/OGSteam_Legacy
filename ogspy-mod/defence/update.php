<?php
/***************************************************************************
*	filename	: update.php
*	desc.		: Mise à jour de 'Optimisation de la défence'
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

// Récupération de la version du module
$query = "SELECT version FROM ".TABLE_MOD." WHERE action='defence' LIMIT 1";
$result = $db->sql_query($query);
if ($db->sql_numrows($result) != 0) {
	$info_mod = $db->sql_fetch_assoc($result); }

switch ($info_mod["version"]) {
	case "0.1b":
		// Nettoyage des champs créés par la version 0.1b
		$sql = "SELECT * FROM ".TABLE_USER;
		$result = $db->sql_query($sql);
		$row = $db->sql_fetch_assoc($result);
		if (isset($row['def_zero_active'])) {
			$query="ALTER TABLE ".TABLE_USER." DROP def_zero_active";
			$db->sql_query($query); }

		if (isset($row['def_select'])) {
			$query="ALTER TABLE ".TABLE_USER." DROP def_select";
			$db->sql_query($query); }

	case "0.2b":
		// Suppression des tables
		$query = "DROP TABLE IF EXISTS ".TABLE_DEFENCE_OPTION.";";
		$db->sql_query($query);
		$query = "DROP TABLE IF EXISTS ".TABLE_DEFENCE_COEF.";";
		$db->sql_query($query);

		// Création des nouvelles tables
		$query = "CREATE TABLE ".TABLE_DEFENCE_OPTION." ("
			. " user_id int(11) NOT NULL, "
			. " def_zero_active enum('0','1') NOT NULL default '0', "
			. " def_select varchar(8) NOT NULL default 'attaque', "
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

	case "0.3b":
		// Mise à jour de la table des coefs (à partir de la version 0.3b)
		$query = "ALTER TABLE ".TABLE_DEFENCE_COEF
			. " CHANGE LM LM FLOAT UNSIGNED NOT NULL DEFAULT '100', "
			. " CHANGE LLE LLE FLOAT UNSIGNED NOT NULL DEFAULT '100', "
			. " CHANGE LLO LLO FLOAT UNSIGNED NOT NULL DEFAULT '100', "
			. " CHANGE CG CG FLOAT UNSIGNED NOT NULL DEFAULT '100', "
			. " CHANGE AI AI FLOAT UNSIGNED NOT NULL DEFAULT '100', "
			. " CHANGE LP LP FLOAT UNSIGNED NOT NULL DEFAULT '100' ;";
		$db->sql_query($query); 
		
		// Ajout du champ manquant
		$query = "ALTER TABLE ".TABLE_DEFENCE_COEF." ADD defence_coef_rapport FLOAT UNSIGNED NOT NULL DEFAULT '1'";
		$db->sql_query($query);
		
		// Création des clés primaires
		$query = "ALTER TABLE ".TABLE_DEFENCE_COEF." ADD PRIMARY KEY (`user_id`, `planet_id`)";
		$db->sql_query($query);

	case "0.4b":
		// Pas de changement pour la version 0.4b

	case "0.5b":
		// Mise à jour de la table TABLE_DEFENCE
		$query = "UPDATE ".TABLE_DEFENCE." SET bouclier=1, attaque=12000, metal=12500, cristal=2500, deut=10000 WHERE unit='MIP' LIMIT 1";
		$db->sql_query($query);

		// Ajout du champ manquant
		$query = "ALTER TABLE ".TABLE_DEFENCE_OPTION." ADD def_simulator varchar(10) NOT NULL default 'speedsim'";
		$db->sql_query($query);

		// Création de la table des attaques
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
			. " PRIMARY KEY (`attack_id`)"
			. " );";
		$db->sql_query($query);

	case "0.6b":
		// Pas de changement pour la version 0.6b

	case "0.7b":
		// Ajout des champs manquants
		$query = "ALTER TABLE ".TABLE_DEFENCE_ATTACK." ADD attack_quai enum('0','1') NOT NULL default '0'";
		$db->sql_query($query);
		$query = "ALTER TABLE ".TABLE_DEFENCE_ATTACK." ADD attack_techno_armes int(3) NOT NULL default '0'";
		$db->sql_query($query);
		$query = "ALTER TABLE ".TABLE_DEFENCE_ATTACK." ADD attack_techno_bouclier int(3) NOT NULL default '0'";
		$db->sql_query($query);
		$query = "ALTER TABLE ".TABLE_DEFENCE_ATTACK." ADD attack_techno_protection int(3) NOT NULL default '0'";
		$db->sql_query($query);
		break; }

// Mise à jour de la version du module
$query = "UPDATE ".TABLE_MOD." SET version='0.8b' WHERE action='defence' LIMIT 1";
$db->sql_query($query);
?>
