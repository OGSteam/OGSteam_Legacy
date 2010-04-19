<?php
/** $Id$ **/
/**
* Panneau d'affichage de vues galaxies
* @package OGSpy
* @subpackage main
* @author Kyser
* @copyright Copyright &copy; 2007, http://ogsteam.fr/
* @version 4.00 ($Rev$)
* @modified $Date$
* @link $HeadURL$
*/
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

$info_system = galaxy_show(intval($server_config['num_of_galaxies']),intval($server_config['num_of_systems']));
$population = $info_system["population"];

$galaxy = $info_system["galaxy"];
$system = $info_system["system"];

$galaxy_down = (($galaxy-1) < 1) ? 1 : $galaxy - 1;
$galaxy_up = (($galaxy-1) > intval($server_config['num_of_galaxies'])) ? intval($server_config['num_of_galaxies']) : $galaxy + 1;

$system_down = (($system-1) < 1) ? 1 : $system - 1;
$system_up = (($system-1) > intval($server_config['num_of_systems'])) ? intval($server_config['num_of_systems']) : $system + 1;

$show_position_hidden = user_get_permissions('server_show_positionhided',$user_data['user_id']);
$show_friendlyphalanx = ($server_config["friendly_phalanx"] != "0" && $server_config["friendly_phalanx"] != "") && $show_position_hidden;

// Affichage du header
require_once("views/page_header.php");

// Creation du template
if (file_exists($user_data['user_skin'].'\templates\galaxy.tpl'))
{
    $tpl = new template($user_data['user_skin'].'\templates\galaxy.tpl');
}
elseif (file_exists($server_config['default_skin'].'\templates\galaxy.tpl'))
{
    $tpl = new template($server_config['default_skin'].'\templates\galaxy.tpl');
}
else
{
    $tpl = new template('galaxy.tpl');
}

// Creation de la liste des favoris
$favorites = galaxy_getfavorites();
if(count($favorites) != 0){
	$tpl->checkIf('is_favorite', true);
	$tpl->checkIf('exist_favorite', in_array(Array ( "galaxy" => $galaxy, "system" => $system ), $favorites));
	$tpl->checkIf('too_favorite', sizeof($favorites) > $server_config['max_favorites']);
	$tpl->SimpleVar(Array('MAX_FAVORITE' => L_("message_MaxFavorites",$server_config['max_favorites'])));

	foreach ($favorites as $v)
		$tpl->loopVar('SHOW_FAVORITE', Array(
			'coordinates' => $v["galaxy"].":".$v["system"],
			'selected' => ($v['galaxy']==$galaxy && $v['system']==$system)?'selected="selected"':''
		));
}

// Creation de la liste des planetes
foreach ($population as $i => $v){
	if($v['moon']==1){
		$moon = L_('ogame_Moons_abbrev');
		if($v['phalanx']!=0)
			$moon .= ' - '.L_('ogame_Phallanx_abbrev').$v['phalanx'];
		if($v['gate'] == 1)
			$moon .= "(".L_('ogame_Gate_abbrev').")";
	} else 
		$moon = '';
	$tpl->loopVar('SHOW_GALAXY', Array(
		'row' => $i,
		'planet' => $v['planet']!=""?get_formated_string('planet',$v['planet']):'',
		'player' => $v['player']!=""?get_formated_string('player',$v['player']):'',
		'ally' => $v['ally']!=""?get_formated_string('ally',$v['ally']):'',
		'moon' => $moon,
		'status' => $v["status"],
		'spy' => ($v['report_spy']>0)?get_formated_string('spy',Array(
						'text' => $v['report_spy'].L_('search_SpyReport_abbrev'),
						'galaxy' => $galaxy, 'system' => $system, 'row' => $i
					)):'',
		'rc' => ($v['report_rc']>0)?get_formated_string('combat',Array(
						'text' => $v['report_rc'].L_('search_battlesreport_abbrev'),
						'galaxy' => $galaxy, 'system' => $system, 'row' => $i
					)):'',
		'sender' => $v["poster"],
		'date' => strftime("%d %b %Y %H:%M", $v["timestamp"]),
		
		'is_hided' => $v["hided"] != "",
		'is_planet_name' => $v["planet"] != "",
		'is_ally' => $v["ally"] != "",
		'is_spy' => $v["report_spy"] > 0,
		'is_rc' => $v["report_rc"] > 0,
		'is_moon' => $v["moon"] == 1,
		'is_phalanx' => ($v["last_update_moon"] > 0 && $v["gate"] == 1),
		'is_date' => $v["timestamp"] != 0,
		'phalanx' => $v["phalanx"],
	));
} // Fin Galaxie

// Creation de la liste des MIPs
$mip_position = galaxy_get_mip_position($galaxy,$system);
$total_mip = 0;
if(($server_config["portee_missil"] != "0" && $server_config["portee_missil"] != "") && $show_position_hidden){
	$tpl->checkIf('SHOW_MIP', true);
	if(sizeOf($mip_position)>0){
		$tpl->checkIf('is_mip',true);
		foreach($mip_position as $mip){
			$tpl->loopVar('MIP',Array(
				'user_name' => get_formated_string('player',$mip['user_name'],false),
				'coordinates' => get_formated_string('coordinates',$mip['coordinates'],false),
				'MIP' => $mip['MIP'],
				'position_up' => $mip['position_up'],
				'position_down' => $mip['position_down'],
			));
			$total_mip += $mip['MIP'];
		}
	}
}

// Phalanges amies
$fphalanx = galaxy_get_friendly_phalanx($galaxy,$system);
$tpl->checkIf('SHOW_PHALANX_FRIEND', $show_friendlyphalanx && $show_position_hidden);
$total_FriendlyPhallanx = 0;
if ($show_friendlyphalanx && $show_position_hidden && (sizeof($fphalanx) > 0)){
	$tpl->checkIf('is_phalanx_friend', true);	
	foreach($fphalanx as $fp){
		$tpl->loopVar('PHALANX_FRIEND', Array(
			'user_name' => get_formated_string('player',$fp['user_name'],false),
			'coordinates' => get_formated_string('coordinates',$fp['coordinates'],false),
			'galaxy' => $fp['galaxy'],
			'range_down' => $fp['range_down'],
			'range_up' => $fp['range_up'],
		));
		$total_FriendlyPhallanx++;
	}
}

// Phalange hostiles
$phalanx_list = galaxy_get_phalanx($galaxy, $system);
$tpl->checkIf('is_phalanx_dangerous', sizeof($phalanx_list) > 0);
$total_DangerousPhallanx = 0;
if (sizeof($phalanx_list) > 0) {
	foreach ($phalanx_list as $value) {
		$tpl->loopVar('PHALANX_DANGEROUS',Array(
			'user_name' => get_formated_string('player',$value['user_name'],false), 
			'user_ally' => get_formated_string('ally',$value['user_ally'],false), 
			'coordinates' => get_formated_string('coordinates',$value['coordinates'],false), 
			'galaxy' => $value['galaxy'], 
			'range_down' => $value['range_down'], 
			'range_up' => $value['range_up'], 
		));
		$total_DangerousPhallanx++;
	}
}

// Simples variables texte
$tpl->simpleVar(Array(
	'GALAXY_UP' => $galaxy_up,
	'SYSTEM_UP' => $system_up,
	'GALAXY_ACTUAL' => $galaxy,
	'SYSTEM_ACTUAL' => $system,
	'GALAXY_DOWN' => $galaxy_down,
	'SYSTEM_DOWN' => $system_down,
	'total_mip' => L_('incgal_totmipsdispo',$total_mip),
	'total_FriendlyPhallanx' => ($total_FriendlyPhallanx>1)?L_('search_totFriendlyPhallanx',$total_FriendlyPhallanx):L_('search_totFriendlyPhallanx_few',$total_FriendlyPhallanx),
	'total_DangerousPhallanx' => ($total_DangerousPhallanx>1)?L_('search_totDangerousPhallanx',$total_DangerousPhallanx):L_('search_totDangerousPhallanx_few',$total_DangerousPhallanx),
	'legend_tip' => TipFormat($tpl->GetDefined('legend_content')),
	'init_display' => 'none',
	'init_picture' => 'arrow_down',
));

// Traitement et affichage du template
$tpl->parse();
/*
//Raccourci recherche
$tooltip_begin = "<table width=\"200\">";
$tooltip_end = "</table>";

$tooltip_colonization = $tooltip_moon = $tooltip_away = $tooltip_spy = "";
for ($i=10 ; $i<=50 ; $i=$i+10) {
	if ($system - $i >= 1) $down = $system-$i;
	else $down = 1;

	if ($system + $i <= intval($server_config['num_of_systems'])) $up = $system+$i;
	else $up = intval($server_config['num_of_systems']);

	$tooltip_colonization .= "<tr><th><a href=\"?action=search&amp;type_search=colonization&amp;galaxy_down=".$galaxy."&amp;galaxy_up=".$galaxy."&amp;system_down=".$down."&amp;system_up=".$up."&amp;row_down=&amp;row_up=\">".$i." ".L_("search_SystemAround")."</a></th></tr>";
	$tooltip_moon .= "<tr><th><a href=\"?action=search&amp;type_search=moon&amp;galaxy_down=".$galaxy."&amp;galaxy_up=".$galaxy."&amp;system_down=".$down."&amp;system_up=".$up."&amp;row_down=&amp;row_up=\">".$i." ".L_("search_SystemAround")."s</a></th></tr>";
	$tooltip_away .= "<tr><th><a href=\"?action=search&amp;type_search=away&amp;galaxy_down=".$galaxy."&amp;galaxy_up=".$galaxy."&amp;system_down=".$down."&amp;system_up=".$up."&amp;row_down=&amp;row_up=\">".$i." ".L_("search_SystemAround")."</a></th></tr>";
	$tooltip_spy .= "<tr><th><a href=\"?action=search&amp;type_search=spy&amp;galaxy_down=".$galaxy."&amp;galaxy_up=".$galaxy."&amp;system_down=".$down."&amp;system_up=".$up."&amp;row_down=&amp;row_up=\">".$i." ".L_("search_SystemAround")."</a></th></tr>";
}

$tooltip_colonization = htmlentities($tooltip_begin.$tooltip_colonization.$tooltip_end);
$tooltip_moon = htmlentities($tooltip_begin.$tooltip_moon.$tooltip_end);
$tooltip_away = htmlentities($tooltip_begin.$tooltip_away.$tooltip_end);
$tooltip_spy = htmlentities($tooltip_begin.$tooltip_spy.$tooltip_end);

echo "<br /><table width='800' border='0'>";
echo "<tr><td class='c' align='center' colspan='4'>".L_("search_Research")."</td></tr>";
echo "<tr align='center'>";
echo "<th width='25%' onmouseover=\"this.T_WIDTH=210;return escape('".$tooltip_colonization."')\">".L_("search_Colonization")."</th>";
echo "<th width='25%' onmouseover=\"this.T_WIDTH=210;return escape('".$tooltip_moon."')\">".L_("common_Moons")."</th>";
echo "<th width='25%' onmouseover=\"this.T_WIDTH=210;return escape('".$tooltip_away."')\">".L_("search_InactivePlayers")."</th>";
echo "<th width='25%' onmouseover=\"this.T_WIDTH=210;return escape('".$tooltip_spy."')\">".L_("search_SpyReport")."</th>";
echo "</tr>";
echo "</table>";
*/

require_once("views/page_tail.php");
?>
