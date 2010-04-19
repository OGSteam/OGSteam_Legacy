<?php
/** $Id$ **/
/**
* 
* @package OGSpy
* @subpackage main
* @author Kyser
* @copyright Copyright &copy; 2007, http://ogsteam.fr/
* @version 4.00 ($Rev$)
* @modified $Date$
* @link $HeadURL$
*/
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

$items = Array();

if (($user_auth["server_set_system"] == 1 && $user_auth["server_set_spy"] == 1) || $user_data["user_admin"] == 1 || $user_data["user_coadmin"] == 1) {
	$items[] = array("basic", L_("sendbox_SolarSystem") . " - " . L_("sendbox_SpyReport"));
}
elseif ($user_auth["server_set_system"] == 1) {
	$items[] = array("basic", L_("sendbox_SolarSystem"));
}
elseif ($user_auth["server_set_spy"] == 1) {
	$items[] = array("basic", L_("sendbox_SpyReport"));
}
if ($user_auth["server_set_rc"] == 1 || $user_data["user_admin"] == 1 || $user_data["user_coadmin"] == 1) {
	$items[] = array("combat_report", L_("sendbox_battlesReport"));
}

if ($user_auth["server_set_ranking"] == 1 || $user_data["user_admin"] == 1 || $user_data["user_coadmin"] == 1) {
	$items[] = array("none", "&nbsp;");
	$items[] = array("none", L_("sendbox_PlayerRanking"));
	$items[] = array("general_player",L_("sendbox_RankingGeneral"));
	$items[] = array("fleet_player", L_("sendbox_RankingFleet"));
	$items[] = array("research_player", L_("sendbox_RankingResearch"));
	$items[] = array("none", "&nbsp;");
	$items[] = array("none", L_("sendbox_AllyRanking"));
	$items[] = array("general_ally", L_("sendbox_RankingGeneral"));
	$items[] = array("fleet_ally", L_("sendbox_RankingFleet"));
	$items[] = array("research_ally", L_("sendbox_RankingResearch"));
}
$d = L_('DayList');
$m = L_("MonthList");
$d = (is_array($d)?$d:Array('day','day','day','day','day','day','day'));
$m = (is_array($m)?$m:Array('- 01','- 02','- 03','- 04','- 05','- 06','- 07','- 08','- 09','- 10','- 11','- 12'));
$result = $db->sql_query("SELECT COUNT(*) AS nbre FROM ".TABLE_MP." WHERE destinataire='".$user_data['user_id']."' AND vu='0' AND (efface='0' OR efface='2')");
$nbr_non_vus = $db->sql_fetch_assoc($result);
$message_title = L_("menu_Message");
if($nbr_non_vus['nbre'] > 0) $message_title = "<span style='text-decoration: blink'>".$message_title."</span>"; 

// Creation du template
if (file_exists($user_data['user_skin'].'\templates\menu.tpl'))
{
    $tpl = new template($user_data['user_skin'].'\templates\menu.tpl');
}
elseif (file_exists($server_config['default_skin'].'\templates\menu.tpl'))
{
    $tpl = new template($server_config['default_skin'].'\templates\menu.tpl');
}
else
{
    $tpl = new template('menu.tpl');
}

// Traitement des conditions
$tpl->checkIf('server_desactive',($server_config["server_active"] == 0)); // bloc serveur offline ?
$tpl->checkIf('admin_menu',($user_data["user_admin"] == 1 || $user_data["user_coadmin"] == 1 || $user_data["management_user"] == 1)); // bouton admin ?
$tpl->checkIf('url_forum',$server_config["url_forum"]!=""); // lien vers le forum ?
$tpl->checkIf('item_list',(sizeof($items) > 0)); // Liste de lien pour l'importation?

// Simples variables texte
$tpl->simpleVar(Array(
	'TIME' => (time() * 1000),
	'DAY_LIST' => '"'.implode('","',$d).'"',
	'MONTH_LIST' => '"'.implode('","',$m).'"',
	'EXPLAIN_TEXT' => L_("sendbox_ExplainText"),
	'EXPLAIN_TEXT_JS' => html_entity_decode(L_("sendbox_ExplainText"), ENT_NOQUOTES, 'UTF-8'),
	'SENDBOX_EXPLAIN' => L_("sendbox_ExplainText"),
	'SENDBOX_FORBIDDEN' => L_("sendbox_Forbidden"),
	'MENU_TIME' => L_("menu_Time"),
	'TIME_WAIT' => L_("menu_wait"),
	'LINK_CSS' => $link_css,
	'BANNER'=>$banner_selected,
	'MENU_OFFLINE' => L_('menu_Offline'),
	'ADMIN_MENU' => L_("menu_Administration"),
	'MENU_PROFILE' => L_("menu_Profile"),
	'MENU_HOME' => L_("menu_Home"),
	'MENU_MESSAGE' => $message_title,
	'MENU_GALAXY' => L_("menu_Galaxy"),
	'MENU_ALLY_TERRITORY' => L_("menu_AllyTerritory"),
	'MENU_SEARCH' => L_("menu_Search"),
	'MENU_RANKING' => L_("menu_Ranking"),
	'MENU_STATISTICS' => L_("menu_Statistics"),
	'MENU_LOGOUT' => L_("menu_Logout"),
	'MENU_FORUM' => L_("menu_Forum"),
	'URL_FORUM' => $server_config["url_forum"],
	'MENU_ABOUT' => L_("menu_About"),
	'MENU_SEND' => L_("menu_Send")
	));


//-- Emplacement mod 
if (ratio_is_ok()) {
	// Voyons la liste de catégorie et les mods
	$tmp = mod_menu();
	$cats = $tmp[0];
	$mods = $tmp[1];
	$mod_show = $lignes = Array();
	foreach($cats as $cat){
		foreach($mods as $mod){
			if(in_array($mod['id'],$cat['members'])){
				// Affichage du menu
				if(!in_array(0-$cat['id'],$user_auth['mod_restrict']))
					if(($cat['title'] === 'Admin')){
						if(($user_data['user_admin']==1||$user_data['user_coadmin']==1))
							$cat['block'][] = Array('menu' => $mod['menu'], 'action' => $mod['action']);
					} else $cat['block'][] = Array('menu' => $mod['menu'], 'action' => $mod['action']);
				$mod_show[]= $mod['id'];
			}
		}
		if(isset($cat['block'])){
			// Affichage de la catégorie :
			$lignes[] = Array('action' => "", 'menu' => $cat['menu']);
			foreach($cat['block'] as $line)
				$lignes[] = $line;
			$lignes[] = Array('action' => "", 'menu' => "");
		}
	}
	foreach($mods as $mod){ // Affichage des mods sans catégorie
		if(!in_array($mod['id'],$mod_show)){
			// Affichage du menu
			$lignes_1st[] = Array('menu' => $mod['menu'], 'action' => $mod['action']);
			$mod_show[]= $mod['id'];
		}
	}
	if(isset($lignes_1st)) {
		$lignes_1st[] = Array('action' => "", 'menu' => "");
		$lignes = isset($lignes)?array_merge($lignes_1st,$lignes):$lignes_1st;
	}	
	foreach($lignes as $ligne){
		if($ligne['action'] != "")	// Ajout d'un bouton de mod au template
			$tpl->loopVar('mod_list', Array(
				'action'=>'?action='.$ligne['action'], 'title'=>$ligne['menu'], 
				'link'=>true));
		else						// Ajout d'une categorie
			if($ligne['menu'] != "")
				$tpl->loopVar('mod_list', Array(
					'action'=>'', 'title'=>$ligne['menu'], 
					'category'=>true));
			else					// Ajout d'une séparation (image)
				$tpl->loopVar('mod_list', Array(
					'action'=>'', 'title'=>'', 
					'image'=>true));
	}
} else	// Pas de bouton de mod : le ratio n'est pas bon.
	$tpl->loopVar('mod_list', Array(
		'action'=>'', 'title'=>L_("menu_ModInac").'&nbsp;'.help("ratio_block"), 
		'category'=>true));
	
if (sizeof($items) > 0) { // Liste des importations possible
	foreach ($items as $value) {
		list($type, $text) = $value;
		$tpl->loopVar('item', Array('value'=>$type, 'text'=>$text));
	}
}

// Traitement et affichage du template
$menu = $tpl->parse('return');
?>
