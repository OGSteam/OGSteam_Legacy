<?php
/**
* calcul.php Fait toutes les recherches pour la page simu.php
* @package [MOD] Tout sur les MIP
* @author Bartheleway <contactbarthe@g.q-le-site.webou.net>
* @version 0.4
* created	: 21/08/2006
* modified	: 07/02/2007
*/

if (!defined('IN_SPYOGAME')) die("Hacking attempt");

$query = "SELECT `active` FROM `".TABLE_MOD."` WHERE `action`='lesmip' AND `active`='1' LIMIT 1";
if (!$db->sql_numrows($db->sql_query($query))) die("Hacking attempt");

if (isset($pub_sub) AND $pub_sub == 'mip') {
	/**
	*Récupère la technologie armes
	*/
	$arme = "SELECT Armes FROM ".TABLE_USER_TECHNOLOGY." WHERE user_id = '".$user_data['user_id']."'";
	$arme1 = $db->sql_query($arme);
	$arme2 = mysql_fetch_array($arme1);
	$Armes = $arme2['Armes'];
	
	/**
	*Charge un rapport d'espionnage
	*/
	if (isset($pub_charger) AND $pub_charger == $lang['lesmip_simu_loadtheRE']) {
		$rap = "SELECT rawdata FROM ".TABLE_SPY." WHERE spy_galaxy = '".$pub_galaxie."' AND spy_system = '".$pub_solaire."' AND spy_row = '".$pub_position."' ORDER by datadate DESC LIMIT 0,1";
		$rapport = $db->sql_query($rap);
		$donne = mysql_fetch_array($rapport);
		$gala = $pub_galaxie;
		$sol = $pub_solaire;
		$pos = $pub_position;
	}
	else {
		$donne['rawdata'] = $lang['lesmip_simu_REpaste'];
		$gala = "";
		$sol = "";
		$pos = "";
	}
	
	/**
	*Charge les données d'un joueur
	*/
	if (isset($pub_stat) AND $pub_stat == true) {
		$trouve = "SELECT player FROM ".TABLE_UNIVERSE." WHERE galaxy = '".$pub_galaxie."' AND system = '".$pub_solaire."' AND row = '".$pub_position."' LIMIT 0,1";
		$trouve1 = $db->sql_query($trouve);
		$trouve2 = mysql_fetch_array($trouve1);
		$name = $trouve2['player'];
		/**
		*Si il trouve un nom pour les coordonnées il recherche toutes les planètes du joueur
		*/
		if (isset($name) AND $name != "" AND $name != "NULL") {
			$bon = "oui";
			$cherche = "SELECT * FROM ".TABLE_UNIVERSE." WHERE player = '".$name."' ORDER by galaxy";
			$cherche1 = $db->sql_query($cherche);
			$classp = "SELECT * FROM ".TABLE_RANK_PLAYER_POINTS." WHERE player = '".$name."' LIMIT 1";
			$classp1 = $db->sql_query($classp);
			$classf = "SELECT * FROM ".TABLE_RANK_PLAYER_FLEET." WHERE player = '".$name."' LIMIT 1";
			$classf1 = $db->sql_query($classf);
			$classr = "SELECT * FROM ".TABLE_RANK_PLAYER_RESEARCH." WHERE player = '".$name."' LIMIT 1";
			$classr1 = $db->sql_query($classr);
		} else {
			$coord = "";
			$name = "";
			$stat1 = "";
			$ally = "";
			$profil = "";
		}
	}
}

if (isset($pub_sub) AND $pub_sub == 'info') {
	$name = $pub_name;
	if (isset($name) AND $name != "" AND !is_null($name)) {
		$bon = "oui";
		$cherche = "SELECT * FROM ".TABLE_UNIVERSE." WHERE player = '".$name."' ORDER by galaxy";
		$cherche1 = $db->sql_query($cherche);
		$cherche11 = "SELECT * FROM ".TABLE_UNIVERSE." WHERE player = '".$name."' ORDER by galaxy";
		$cherche12 = $db->sql_query($cherche11);
		$cherche3 = $db->sql_fetch_assoc($cherche12);
		$user = $cherche3['last_update_user_id'];
		$ally1 = $cherche3['ally'];
		$cherche4 = "SELECT * FROM ".TABLE_USER." WHERE user_id = '".$user."'";
		$cherche5 = $db->sql_query($cherche4);
		$cherche6 = $db->sql_fetch_assoc($cherche5);
		
		/**
		*Recherche tout ce qui a un rapport avec les classements
		*/
		$classp = "SELECT * FROM ".TABLE_RANK_PLAYER_POINTS." WHERE player = '".$name."' ORDER by datadate LIMIT 1";
		$classp1 = $db->sql_query($classp);
		$classp2 = $db->sql_fetch_assoc($classp1);
		$classf = "SELECT * FROM ".TABLE_RANK_PLAYER_FLEET." WHERE player = '".$name."' ORDER by datadate LIMIT 1";
		$classf1 = $db->sql_query($classf);
		$classf2 = $db->sql_fetch_assoc($classf1);
		$classr = "SELECT * FROM ".TABLE_RANK_PLAYER_RESEARCH." WHERE player = '".$name."' ORDER by datadate LIMIT 1";
		$classr1 = $db->sql_query($classr);
		$classr2 = $db->sql_fetch_assoc($classr1);
		$classap = "SELECT * FROM ".TABLE_RANK_ALLY_POINTS." WHERE ally = '".$ally1."' ORDER by datadate LIMIT 1";
		$classap1 = $db->sql_query($classap);
		$classap2 = $db->sql_fetch_assoc($classap1);
		$classaf = "SELECT * FROM ".TABLE_RANK_ALLY_FLEET." WHERE ally = '".$ally1."' ORDER by datadate LIMIT 1";
		$classaf1 = $db->sql_query($classaf);
		$classaf2 = $db->sql_fetch_assoc($classaf1);
		$classar = "SELECT * FROM ".TABLE_RANK_ALLY_RESEARCH." WHERE ally = '".$ally1."' ORDER by datadate LIMIT 1";
		$classar1 = $db->sql_query($classar);
		$classar2 = $db->sql_fetch_assoc($classar1);
	}
}
?>