<?php
/** $Id$ **/
/**
* Affiche d'un raport d'espionnage
* @package OGSpy
* @subpackage main
* @author Kyser
* @copyright Copyright &copy; 2007-2010, http://www.ogsteam.fr/
* @version 4.00 ($Rev$)
* @modified $Date$
* @link $HeadURL$
*/
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

// Récupération des variables envoyé par l'url
$spy_galaxy = isset($pub_galaxy)?$pub_galaxy:0;
$spy_system = isset($pub_system)?$pub_system:0;
$spy_row = isset($pub_row)?$pub_row:0;
$spy_id = isset($pub_spy_id)?$pub_spy_id:0;

/// Initialisation des autres variables
$tpl_loop = $tpl_checkIf = $tpl_SimpleVar = Array();

$spies = get_spy_info($spy_galaxy,$spy_system,$spy_row,$spy_id,false);
$spies_moon = get_spy_info($spy_galaxy,$spy_system,$spy_row,$spy_id,true);

if(sizeof($spies)<1 && sizeof($spies_moon)<1){
	$tpl_checkIf['no_re'] = true;
} else {
	if(sizeof($spies)>0)
		$tpl_checkIf['planet_re'] = true;
	if(sizeof($spies_moon)>0)
		$tpl_checkIf['moon_re'] = true;
}
if(sizeof($spies)<1) $spies = $spies_moon;
if(sizeof($spies)<1) 
	list($spy_galaxy,$spy_system,$spy_row) = Array('?','?','?');
else
	list($spy_galaxy,$spy_system,$spy_row) = Array($spies[0]['galaxy'],$spies[0]['system'],$spies[0]['row']);
require_once("views/page_header_2.php");

if (file_exists($user_data['user_skin'].'\templates\report_spy.tpl'))
{
    $tpl = new template($user_data['user_skin'].'\templates\report_spy.tpl');
}
elseif (file_exists($server_config['default_skin'].'\templates\report_spy.tpl'))
{
    $tpl = new template($server_config['default_skin'].'\templates\report_spy.tpl');
}
else
{
    $tpl = new template('report_spy.tpl');
}
foreach($tpl_checkIf as $i => $v)
{
	$tpl->checkIf($i,$v);
}
foreach($tpl_loop as $i => $v)
{
	foreach($v as $a)
	{	
		$tpl->loopVar($i,$a);
	}
}
foreach($tpl_SimpleVar as $v)
{
	$tpl->SimpleVar($v);
}

$tpl->SimpleVar(Array(
	"reportspy_ViewGlobalRe" => L_('reporspy_ViewGlobalRe'),
	"ogame_Metal" => L_('ogame_Metal'),
	"ogame_Crystal" => L_('ogame_Crystal'),
	"ogame_Deuterium" => L_('ogame_Deuterium'),
	"ogame_Energy" => L_('ogame_Energy'),
	"incgal_fleet" => L_('incgal_fleet'),
	"incgal_defense" => L_('incgal_defense'),
	"incgal_buildings" => L_('incgal_buildings'),
	"incgal_research" => L_('incgal_research'),
	"reportspy_nobattles" => L_("reportspy_nobattles"),
	"title" => L_('reportspy_PositionDetail',"{$spy_galaxy}:{$spy_system}:{$spy_row}"),
	"reportspy_DelReport" => L_("reportspy_DelReport"),
));

$tpl->parse();

require_once("views/page_tail_2.php");


function get_spy_info($spy_galaxy,$spy_system,$spy_row,$spy_id,$moon){
	global $db,$tpl_SimpleVar,$tpl_loop,$tpl_checkIf,$server_config,$user_data;
	$favorites = user_getfavorites_spy();
	$favorite_allowed = (sizeof($favorites) < $server_config['max_favorites_spy']);

	$_m = $moon?'_2':'';
	$sql_main = Array('id_spy','planet_name','coordinates','galaxy','system','row','metal','cristal','deuterium','energie','activite','dateRE','proba','active','sender_id');
	$sql_build = $moon?Array('BaLu','UdR','UdN','CSp','HM','HC','HD','Pha','PoSa'):Array('M','C','D','CES','CEF','UdR','UdN','CSp','HM','HC','HD','Lab','Ter','DdR','Silo');
	$sql_def = Array('LM','LLE','LLO','CG','AI','LP','PB','GB','MIC','MIP');
	$sql_fleet = Array('PT','GT','CLE','CLO','CR','VB','VC','REC','SE','BMD','DST','EDLM','SAT','TRA');
	$sql_search = Array('Esp','Ordi','Armes','Bouclier','Protection','NRJ','Hyp','RC','RI','PH','Laser','Ions','Plasma','RRI','Graviton','Expeditions');
	$spy_fleet = $spy_buildings = $spy_defense = $spy_research = $spies = Array();

	// Récupération des nom des membres (une fois pour toute)
	$query = "SELECT user_id, user_name FROM ".TABLE_USER;
	$db->sql_query($query);
	while($row = $db->sql_fetch_assoc()) $users_name[$row['user_id']] = $row['user_name']; 

	// Si on a seulement le spy_id alors on cherche les coordonnées correspondante (pour peupler la liste de choix)
	if(($spy_galaxy==0||$spy_system==0||$spy_row==0)&&$spy_id>0){
		$query = "SELECT galaxy, system, row FROM ".TABLE_PARSEDSPY." WHERE id_spy=".$spy_id;
		$db->sql_query($query);
		list($spy_galaxy,$spy_system,$spy_row) = $db->sql_fetch_row();
		if(!isset($spy_galaxy)) $spy_galaxy=0;
		if(!isset($spy_system)) $spy_system=0;
		if(!isset($spy_row)) $spy_row=0;
	}
	// Recherche des espionnages pour les coordonnées données
	$query = "SELECT * FROM ".TABLE_PARSEDSPY;
	$query.= " WHERE ".("galaxy={$spy_galaxy} AND system={$spy_system} AND row={$spy_row}");
	$query.= " AND ".($moon?"":"NOT")." (planet_name LIKE '%".L_('Spy_Moon')."%' OR planet_name LIKE '".L_('Spy_Moon2')."')";
	$query.= " ORDER BY dateRE DESC";
	$db->sql_query($query);
	$row_len = $db->sql_numrows();
	while ($row = $db->sql_fetch_assoc()) {
		$row['coordinates'] = "{$row['galaxy']}:{$row['system']}:{$row['row']}";
		$row['sender_name'] = isset($users_name[$row['sender_id']])?$users_name[$row['sender_id']]:"?";
		$tpl_loop['re_list'][] = Array(
			'id'=>$row['id_spy'],
			'name'=>date('d/m/Y (H:i)',$row['dateRE']).' ['.$row['planet_name'].'] - '.$row['sender_name'],
			'selected' => ($row['id_spy']==$spy_id && $spy_id!=0) || ($spy_id==0 && $row_len==1),
		);
		if($spy_id==0 || $spy_id == $row['id_spy']) $spies[] = $row;
	}
	rsort($tpl_loop['re_list']);
	if($spy_id==0&&sizeof($spies)==1) $spy_id=$spies[0]['id_spy'];
	//if($is_report=sizeof($spies)>0){
	if(sizeof($spies)>0){
		$is_favorite = false;
		$favorite_id = $spies[0]['id_spy'];
		foreach($favorites as $i => $f)
			if($f['spy_galaxy']==$spies[0]['galaxy'] && $f['spy_system']==$spies[0]['system'] &&$f['spy_row']==$spies[0]['row']){
				$favorite_id = $i;
				$is_favorite = true;
			}
		
		// S'il y a au moins un rapport, on enregsitre d'entrée les informations de base les plus récente (stock, nom, etc.)
		foreach($sql_main as $sql_name) $tpl_SimpleVar[] = Array($sql_name.$_m => $spies[0][$sql_name]);
	
		// Ensuite, on fait défiler tous les RE, et on cherche pour chaque rubrique, le RE le plus récent
		foreach($spies as $spy){
			// Vaisseaux
			if(($spy[$sql_fleet[0]]!="-1")&&sizeof($spy_fleet)<1){
				// Les vaisseaux sont déclaré (!= -1) et on a pas encore trouvé de RE avec les vaisseaux
				foreach($sql_fleet as $sql_name) $spy_fleet[$sql_name] = $spy[$sql_name];	
				$spy_fleet['id_spy'] = $spy['id_spy'];
				$spy_fleet['dateRE'] = $spy['dateRE'];
			}
	
			// Defense
			if(($spy[$sql_def[0]]!="-1")&&sizeof($spy_defense)<1){
				// Les vaisseaux sont déclaré (!= -1) et on a pas encore trouvé de RE avec les vaisseaux
				foreach($sql_def as $sql_name) $spy_defense[$sql_name] = $spy[$sql_name];	
				$spy_defense['id_spy'] = $spy['id_spy'];
				$spy_defense['dateRE'] = $spy['dateRE'];
			}
	
			// Batiment
			if(($spy[$sql_build[0]]!="-1")&&sizeof($spy_buildings)<1){
				// Les vaisseaux sont déclaré (!= -1) et on a pas encore trouvé de RE avec les vaisseaux
				foreach($sql_build as $sql_name) $spy_buildings[$sql_name] = $spy[$sql_name];	
				$spy_buildings['id_spy'] = $spy['id_spy'];
				$spy_buildings['dateRE'] = $spy['dateRE'];
			}
	
			// Recherche
			if(($spy[$sql_search[0]]!="-1")&&sizeof($spy_research)<1){
				// Les vaisseaux sont déclaré (!= -1) et on a pas encore trouvé de RE avec les vaisseaux
				foreach($sql_search as $sql_name) $spy_research[$sql_name] = $spy[$sql_name];	
				$spy_research['id_spy'] = $spy['id_spy'];
				$spy_research['dateRE'] = $spy['dateRE'];
			}
		}
		$re_date = date ('d/m/Y (H:i)', $spies[0]['dateRE']);
		$planet_name = $spies[0]['planet_name'];
		$coordinates = "{$spy_galaxy}:{$spy_system}:{$spy_row}";
		$db->sql_query("SELECT user_name FROM ".TABLE_USER." WHERE user_id={$spies[0]['sender_id']}");
		list($spies[0]['sender_name']) = $db->sql_fetch_row();
		if(!isset($spies[0]['sender_name'])) $spies[0]['sender_name'] = "?";
	} else return Array();
	$tabID_fleet = array();
	if(sizeof($spy_fleet)>0){
		// Des vaisseaux ont été trouvé
		$index = 0;
		for($i=0;$i<sizeof($sql_fleet);$i++){
			if($spy_fleet[$sql_fleet[$i]] > 0){
				$tabID_fleet[$index] = $sql_fleet[$i];
				$index++;
			}
		}
		for($i=0;$i<sizeof($tabID_fleet);$i+=2){
			// Pour chaque vaisseaux, on peuple le tableau pour le template (par 2, car 2 type par ligne)
			$key1 = $tabID_fleet[$i];
			$key2 = isset($tabID_fleet[$i+1])?$tabID_fleet[$i+1]:NULL;
			$tpl_loop['fleet'.$_m][] = Array(
				'name1'=>L_('fleet_'.$key1),
				'count1'=>$spy_fleet[$key1],
				'name2'=>isset($key2)?L_('fleet_'.$key2):"&nbsp;",
				'count2'=>isset($key2)?$spy_fleet[$key2]:"&nbsp;"
			);
		}
		
		$tpl_SimpleVar[] = Array('fleet_date'.$_m=>date('m-d H:i:s',$spy_fleet['dateRE']));
	}
	$tabID_def = array();
	if(sizeof($spy_defense)>0){
		// Des defenses ont été trouvé
		$index = 0;
		for($i=0;$i<sizeof($sql_def);$i++){
			if($spy_defense[$sql_def[$i]] > 0){
				$tabID_def[$index] = $sql_def[$i];
				$index++;
			}
		}
		for($i=0;$i<sizeof($tabID_def);$i+=2)
		{
			// Pour chaque batiments, on peuple le tableau pour le template (par 2, car 2 type par ligne)
			$key1 = $tabID_def[$i];
			$key2 = isset($tabID_def[$i+1])?$tabID_def[$i+1]:NULL;
			$tpl_loop['defense'.$_m][] = Array(
				'name1'=>L_('defence_'.$key1),
				'count1'=>$spy_defense[$key1],
				'name2'=>isset($key2)?L_('defence_'.$key2):"&nbsp;",
				'count2'=>isset($key2)?$spy_defense[$key2]:"&nbsp;"
			);
		}	
		$tpl_SimpleVar[] = Array('defense_date'.$_m=>date('m-d H:i:s',$spy_defense['dateRE']));
	}
	$tabID_build = array();
	if(sizeof($spy_buildings)>0){
		// Des batiements ont été trouvé
		$index = 0;
		for($i=0;$i<sizeof($sql_build);$i++){
			if($spy_buildings[$sql_build[$i]] > 0){
				$tabID_build[$index] = $sql_build[$i];
				$index++;
			}
		}
		for($i=0;$i<sizeof($tabID_build);$i+=2){
			// Pour chaque batiments, on peuple le tableau pour le template (par 2, car 2 type par ligne)
			$key1 = $tabID_build[$i];
			$key2 = isset($tabID_build[$i+1])?$tabID_build[$i+1]:NULL;
			$tpl_loop['buildings'.$_m][] = Array(
				'name1'=>L_('building_'.$key1),
				'count1'=>$spy_buildings[$key1],
				'name2'=>isset($key2)?L_('building_'.$key2):"&nbsp;",
				'count2'=>isset($key2)?$spy_buildings[$key2]:"&nbsp;"
			);
		}
		$tpl_SimpleVar[] = Array('buildings_date'.$_m=>date('m-d H:i:s',$spy_buildings['dateRE']));
	}
	$tabID_research = array();
	if(sizeof($spy_research)>0){
		// Des recherche ont été trouvé
		$index = 0;
		for($i=0;$i<sizeof($sql_search);$i++){
			if($spy_research[$sql_search[$i]] > 0){
				$tabID_research[$index] = $sql_search[$i];
				$index++;
			}
		}
		for($i=0;$i<sizeof($tabID_research);$i+=2){
			// Pour chaque recherche, on peuple le tableau pour le template (par 2, car 2 type par ligne)
			$key1 = $tabID_research[$i];
			$key2 = isset($tabID_research[$i+1])?$tabID_research[$i+1]:NULL;
			$tpl_loop['research'.$_m][] = Array(
				'name1'=>L_('techno_'.$key1),
				'count1'=>$spy_research[$key1],
				'name2'=>isset($key2)?L_('techno_'.$key2):"&nbsp;",
				'count2'=>isset($key2)?$spy_research[$key2]:"&nbsp;"
			);
		}
		$tpl_SimpleVar[] = Array('research_date'.$_m=>date('m-d H:i:s',$spy_research['dateRE']));
	}

        // attribution des variables IF pour le template
	$tpl_checkIf['is_fleet'.$_m] = (sizeof($spy_fleet)>0); // && sizeof($tabID_fleet) >0);
        $tpl_checkIf['is_frow'.$_m] =  (sizeof($tabID_fleet) >0);
	$tpl_checkIf['is_defense'.$_m] = (sizeof($spy_defense)>0); // && sizeof($tabID_def) >0);
        $tpl_checkIf['is_drow'.$_m] = (sizeof($tabID_def) >0);
	$tpl_checkIf['is_buildings'.$_m] = (sizeof($spy_buildings)>0); // && sizeof($tabID_build) >0);
        $tpl_checkIf['is_brow'.$_m] = (sizeof($tabID_build) >0);
	$tpl_checkIf['is_research'.$_m] = (sizeof($spy_research)>0); // && sizeof($tabID_research) >0);
        $tpl_checkIf['is_rrow'.$_m] = (sizeof($tabID_research) >0);
	$tpl_checkIf['is_global'] = !($spy_id>0);
	$tpl_checkIf['can_delete'.$_m] = $spy_id>0&&($user_data['user_id']==$spies[0]['sender_id']||$user_data['user_admin']==1);
	$tpl_SimpleVar[] = Array(
	"spy_title" => L_(($spy_id>0?"reportspy_SenderOn":"reportspy_GlobalSpy"), $spies[0]['sender_name'], date ( 'm-d H:i:s', $spies[0]['dateRE'])),
	"incgal_ressourceson".$_m => L_('incgal_ressourceson',$spies[0]['planet_name'],$spies[0]['coordinates'],date ( 'm-d H:i:s', $spies[0]['dateRE'])),
	//"incgal_activity".$_m => $spies[0]['activite']>-1?L_('incgal_showactivity',$spies[0]['activite']):L_('incgal_noactivity'),
	"incgal_probadestruction".$_m => L_('incgal_probadestruction',$spies[0]['proba']),
	"reportspy_Favorites" => $favorite_allowed?$is_favorite?L_("reportspy_DelFavorites"):L_("reportspy_AddFavorites"):L_('reportspy_MaxFavorites',$server_config['max_favorites_spy']),
	"onclick_Favorites".$_m => htmlentities("window.location = '?action=".($is_favorite?"del_favorite_spy":"add_favorite_spy")."&amp;spy_id=".$favorite_id."&amp;galaxy={$spies[0]['galaxy']}&amp;system={$spies[0]['system']}&amp;row={$spies[0]['row']}&amp;info=".($spy_id>0&&!$is_favorite?'3':'2')."';"),
	"onclick_DelReport".$_m => htmlentities("window.location.href = '?action=del_spy&amp;spy_id=".$spies[0]['id_spy']."&amp;galaxy={$spies[0]['galaxy']}&amp;system={$spies[0]['system']}&amp;row={$spies[0]['row']}&amp;info=2';"),
	"incgal_probadestruction".$_m => L_('incgal_probadestruction',$spies[0]['proba']),
	"onclick_re_select" => "var tmp=parseInt(this.value); if(isNaN(tmp)||tmp==0) window.location=(&quot;?action=show_reportspy&amp;galaxy={$spies[0]['galaxy']}&amp;system={$spies[0]['system']}&amp;row={$spies[0]['row']}&quot;); else window.location=(&quot;?action=show_reportspy&amp;spy_id=&quot;+tmp);",
);
	
	return $spies;
}

?>