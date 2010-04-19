<?php
/** $Id$ **/
/**
* Page "recherche alliance"
* @package OGSpy
* @subpackage main
* @author Kyser
* @copyright Copyright &copy; 2007, http://ogsteam.fr/
* @version 4.00 ($Rev$)
* @modified $Date$
* @link $HeadURL$
*/
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

$galaxy_step=$server_config['galaxy_by_line_ally'];
$galaxy_down=1;
$galaxy=1;
$step = $server_config['system_by_line_ally'];
$nb_colonnes_ally = $server_config['nb_colonnes_ally'];
$color_ally_n = $server_config['color_ally'];
$color_ally = explode("_", $color_ally_n);

$galaxy_ally_position = galaxy_ally_position($step);
$position = array_keys($galaxy_ally_position);

// L'utilisateur peut-il voir les alliances cachées et le 1er champ est-il vide? Si oui, on les préselectionne
if (($user_auth["server_show_positionhided"] == 1 || $user_data["user_admin"] == 1 || $user_data["user_coadmin"] == 1)
	&& !isset($pub_search_ally[1])){
	$pub_search_ally[1] = $server_config["ally_protection"];
}

require_once("views/page_header.php");
if (file_exists($user_data['user_skin'].'\templates\cartography.tpl'))
{
    $tpl = new template($user_data['user_skin'].'\templates\cartography.tpl');
}
elseif (file_exists($server_config['default_skin'].'\templates\cartography.tpl'))
{
    $tpl = new template($server_config['default_skin'].'\templates\cartography.tpl');
}
else
{
    $tpl = new template('cartography.tpl');
}

$table_result = '';
do{
	$galaxy_up = $galaxy_down + $galaxy_step;

	$tmp = Array();
	for ($i=$galaxy_down ; $i<$galaxy_up ; $i++){
		$title = ($i<=intval($server_config['num_of_galaxies']))? L_("cartography_GalaxyShortcut",$i):'&nbsp;';
		$tmp[] = $tpl->GetDefined('table.1st_row.cell',Array('title' => $title));
	}
	$table_result.= $tpl->GetDefined('table.1st_row',Array('cell' => implode("\n",$tmp)));
	
	//$system = 1;
	for ($system=1 ; $system<=intval($server_config['num_of_systems']) ; $system=$system+$step) {
		$up = $system+$step-1;
		if ($up > intval($server_config['num_of_systems'])) $up = intval($server_config['num_of_systems']);
		// colone systeme gauche
		//$table_result.= "\t"."<td class='c' align='center' nowrap>".$system." - ".$up."</td>";
		//for ($galaxy=1 ; $galaxy<=intval($server_config['num_of_galaxies']) ; $galaxy++) {
		$tmp = Array();
		for ($galaxy=$galaxy_down ; $galaxy<$galaxy_up ; $galaxy++) {
			for ($i = 1 ; $i <= $nb_colonnes_ally ; $i ++){
				$nb_player[$i-1] = "&nbsp;" ;
				$tooltip[$i-1] = "" ;
			}
			$i=0;
			foreach ($position as $ally_name) {
				if (isset($galaxy_ally_position[$ally_name][$galaxy]) 
					&& $galaxy_ally_position[$ally_name][$galaxy][$system]["planet"] > 0) {
					$last_player = "";
					$tip_row = Array();
					foreach ($galaxy_ally_position[$ally_name][$galaxy][$system]["population"] as $value) {
						$player = "";
						if ($last_player != $value["player"]) {
							$player = "<a href=\"?action=search&amp;type_search=player&amp;string_search=".urlencode($value["player"])."&amp;strict=on\">".$value["player"]."</a>";
							if($value['ally']!="") $player .= "<a href=\"?action=search&amp;type_search=ally&amp;string_search=".urlencode($value["ally"])."&amp;strict=on\">(".$value["ally"].")</a>";
						}
						$row = "<a href=\"?action=galaxy&amp;galaxy=".$value["galaxy"]."&amp;system=".$value["system"]."\">".$value["galaxy"].":".$value["system"].":".$value["row"]."</a>";

						$last_player = $value["player"];
						$tip_row[] = $tpl->GetDefined('tooltip.row',Array('player'=>$player,'position'=>$row));
					}
					$tooltip[$i] = TipFormat($tpl->GetDefined('tooltip',Array('row'=> implode('',$tip_row))));
					$nb_player[$i] = $galaxy_ally_position[$ally_name][$galaxy][$system]["planet"];
				}
				$i++;
			}
			for ($i = 1 ; $i <= $nb_colonnes_ally ; $i ++){
				//$table_result.= "\t"."<th width='20'><a style='cursor:pointer'".$tooltip[$i-1]."><font color='".$color_ally[$i-1]."'>".$nb_player[$i-1]."</font></a></th>"."\n";
				if($tooltip[$i-1]!="")
					$tmp[] = $tpl->GetDefined('table.row.cell',Array('tip'=>$tooltip[$i-1],'color'=>$color_ally[$i-1],'nb_player'=>$nb_player[$i-1]));
				else
					$tmp[] = $tpl->GetDefined('table.row.cell_empty');
			}
		}
		// colone systeme droite
		//$table_result.= "\t"."<td class='c' align='center' nowrap>".$system." - ".$up."</td>";
		//$table_result.= "</tr>"."\n";
		$table_result .= $tpl->GetDefined('table.row',Array('system'=>$system,'up'=>$up,'cell'=>implode("\n",$tmp)));
	}
	$galaxy_down = $galaxy_up;
}while($galaxy_up<=intval($server_config['num_of_galaxies']));

$tpl->SimpleVar(Array('table' => $table_result));

$tpl->SimpleVar(Array(
	'common_Player' => L_('common_Player'),
	'common_Players' => L_('common_Players'),
	'common_Ally' => L_('common_Ally'),
	'common_Allys' => L_('common_Allys'),
	'nb_colonnes_ally' => $nb_colonnes_ally,
	'nb_colonnes_ally_x_2' => $nb_colonnes_ally*2,
	'cartography_ShowPosition' => L_('cartography_ShowPosition'),
	'cartography_PresentPlayer' => L_('cartography_PresentPlayer'),
	'help_separation' => help('cartography_separate_with_commat'),
	));

for ($i = 1 ; $i <= $nb_colonnes_ally ; $i ++){
	$tpl->loopVar('titles',Array("color" =>$color_ally[$i-1], "text" => L_("cartography_Search")." ".$i));
	$tpl->loopVar('form', Array(
		'i' => $i,
		'player_input' => isset($pub_search_player[$i])?$pub_search_player[$i]:'',
		'ally_input' => isset($pub_search_ally[$i])?$pub_search_ally[$i]:'',
	));
}

$tpl->parse();

require_once("views/page_tail.php");



/**
* Récupération position alliance
*/
function galaxy_ally_position ($step = 50) {
	global $db, $user_auth, $user_data, $server_config;
	global $pub_search_player, $pub_search_ally, $nb_colonnes_ally;

	for ($i = 1 ; $i <= $nb_colonnes_ally ; $i ++){
		if (!isset($pub_search_player[$i])&&!isset($pub_search_ally[$i]))	
			return array();
		if (!check_var($pub_search_player[$i], "Text") || !check_var($pub_search_ally[$i], "Text")) 
			redirection("?action=message&amp;id_message=errordata&info");
	}

	$pub_ally_protection = array();
	if ($server_config["ally_protection"] != "") $pub_ally_protection = explode(",", $server_config["ally_protection"]);

	$statictics = array();
	for ($i = 1 ; $i <= $nb_colonnes_ally ; $i ++){
		$player_name = $pub_search_player[$i];
		$ally_name = $pub_search_ally[$i];
		$pub_ally_name = $player_name.$ally_name;
		if ($player_name=="" && $ally_name=="") continue;
		$texts['name_player'] = explode(',',$player_name);
		$texts['name_ally'] = explode(',',$ally_name);		
		
		$where_in_search = Array();
		$can_see = $user_auth["server_show_positionhided"]!=0 || $user_data["user_admin"]!=0 && $user_data["user_coadmin"]!=0;
		foreach($texts as $type => $text){
			foreach($text as $string){
				$protected = in_array($string, $pub_ally_protection);
				if ( $string!="" && (!$protected || ($protected&&$can_see)) ) {
					$where_in_search[] = "{$type}  like '".trim($string)."'";
				}
			}
		}
		if(count($where_in_search)<1){
			$statictics[$pub_ally_name][0][0] = null;
			continue;
		}
		$s_where = "(".implode(' or ',$where_in_search).")";
		for ($galaxy=1 ; $galaxy<=intval($server_config['num_of_galaxies']) ; $galaxy++) {
			for ($system=1 ; $system<=intval($server_config['num_of_systems']) ; $system=$system+$step) {
				$request = "select galaxy, system, row, tp.name_player, ta.name_ally from ".TABLE_UNIVERSE." tu, ".TABLE_PLAYER." tp, ".TABLE_ALLY." ta ";
				$request .= " where tu.id_player = tp.id_player and tp.id_ally = ta.id_ally and galaxy = ".$galaxy;
				$request .= " and system between ".$system." and ".($system+$step-1);
				$request .= " and ".$s_where;
				$request .= " order by name_player, galaxy, system, row";
				$result = $db->sql_query($request);
				$nb_planet = $db->sql_numrows($result);

				$population = array();
				while (list($galaxy_, $system_, $row_, $player, $ally) = $db->sql_fetch_row($result)) {
					$population[] = array("galaxy" => $galaxy_, "system" => $system_, "row" => $row_, "player" => $player, "ally" => $ally);
				}

				$statictics[$pub_ally_name][$galaxy][$system] = array("planet" => $nb_planet, "population" => $population);
			}
		}
	}
	user_set_stat(null, null, 1);

	return $statictics;
}
