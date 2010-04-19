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

lang_load_page('galaxy');

$info_sector = galaxy_show_sector();

$population = $info_sector["population"];
$galaxy = $info_sector["galaxy"];
$system_down = $info_sector["system_down"];
$system_up = $info_sector["system_up"];
$system = $system_down;
$totalsystem = abs($system_up - $system_down);
$nbsystem = 0;

$scolor_count = $server_config['scolor_count'];
$scolor_type = explode("_", $server_config['scolor_type']);
$scolor_text = explode("_|_", $server_config['scolor_text']);	
$scolor_color = explode("_", $server_config['scolor_color']);

require_once("views/page_header.php");
if (file_exists($user_data['user_skin'].'\templates\galaxy_sector.tpl'))
{
    $tpl = new template($user_data['user_skin'].'\templates\galaxy_sector.tpl');
}
elseif (file_exists($server_config['default_skin'].'\templates\galaxy_sector.tpl'))
{
    $tpl = new template($server_config['default_skin'].'\templates\galaxy_sector.tpl');
}
else
{
    $tpl = new template('galaxy_sector.tpl');
}

$link1 = $link2 = "";
if (($system_down-$totalsystem-1) >= 1)
	$link1= "?action=galaxy_sector&amp;galaxy=".$galaxy."&amp;system_down=".($system_down-$totalsystem-1)."&amp;system_up=".($system_down-1);

if (($system_down+$totalsystem+1) <= intval($server_config['num_of_systems'])) 
	$link2 = "?action=galaxy_sector&amp;galaxy=".$galaxy."&amp;system_down=".($system_up+1)."&amp;system_up=".($system_up+$totalsystem+1);

$tpl->SimpleVar(Array(
	'link_galaxysector_Previous' => ($link1==''?'':"<a href='{$link1}'>").L_('galaxysector_Previous').($link1==''?'':"</a>"),
	'link_galaxysector_Next' => ($link2==''?'':"<a href='{$link2}'>").L_('galaxysector_Next').($link2==''?'':"</a>"),
	'galaxy' => $galaxy,
	'system_up' => $system_up,
	'system_down' => $system_down,
));

for ($lines=0 ; $lines<ceil($totalsystem/5) ; $lines++) {
	for ($cols=$system ; $cols<$system+5 ; $cols++) {
		$last_update = "&nbsp;";
		if (isset($population[$cols]["last_update"])) 
			$last_update = strftime("%d %b %Y %H:%M", $population[$cols]["last_update"]);
		
		for ($row=1 ; $row<=15 ; $row++) {
			$status = $moon = $spyreport = $planet = $player = $ally = "&nbsp;";
			if (isset($population[$cols][$row])) {
				$status = $moon = $spyreport = $planet = $player = $ally = "&nbsp;";
				
				$player = $population[$cols][$row]["player"];
				$ally = $population[$cols][$row]["ally"];
				$planet = $population[$cols][$row]["planet"];
				
				// Faut-il colorer le nom du joueur ou de l'alliance ?
				foreach($scolor_text as $j => $text){
					$v = $population[$cols][$row];
					if ($text != "")
					if(
					(preg_match('`(^|,)'.$v["player"].'($|,)`',$text) && $scolor_type[$j]=="J") ||
					(preg_match('`(^|,)\{mine\}($|,)`',$text)&&$v["player"]==$user_data["user_stat_name"]&&$scolor_type[$j]=="J"))
					{
						$player = $tpl_global_defined->GetDefined($scolor_color[$j]==""?'hided_blink':'hided_color',Array(
							'color' => $scolor_color[$j],
							'content' => $player));
					}
					if (preg_match('`(^|,)'.$v["ally"].'($|,)`',$text) && $scolor_type[$j]=="A") 
					{
						$ally = $tpl_global_defined->GetDefined($scolor_color[$j]==""?'hided_blink':'hided_color',Array(
							'color' => $scolor_color[$j],
							'content' => $ally));
					}
				}
				if ($population[$cols][$row]["hided"]) {
					$color = $server_config['ally_protection_color'];
					$planet = $tpl_global_defined->GetDefined($color==""?'hided_blink':'hided_color',Array(
						'color' => $color,
						'content' => $planet));
					$player = $tpl_global_defined->GetDefined($color==""?'hided_blink':'hided_color',Array(
						'color' => $color,
						'content' => $player));
					$ally = $tpl_global_defined->GetDefined($color==""?'hided_blink':'hided_color',Array(
						'color' => $color,
						'content' => $ally));
				}

				if ($population[$cols][$row]["moon"] == 1) {
					$detail = "";
					if ($population[$cols][$row]["last_update_moon"] > 0) {
						$detail .= $population[$cols][$row]["phalanx"];
					}
					if ($population[$cols][$row]["gate"] == 1) 
						$detail .= L_('ogame_Gate_abbrev');
					
					if ($detail != "") $detail = " - ".$detail;

					$moon = $tpl->GetDefined('cell_nolink', Array(	
					'content' => L_('ogame_Moons_abbrev').$detail,
					'color' => 'lime'));
				}
				if ($population[$cols][$row]["report_spy"] > 0) {
					$spyreport = $tpl->GetDefined('cell_windowopen', Array(
					'link' => "?action=show_reportspy&amp;galaxy=".$galaxy."&amp;system=".$cols."&amp;row=".$row,
					'content' =>  $population[$cols][$row]["report_spy"].L_('search_SpyReport_abbrev')));
				}
				$status = $population[$cols][$row]["status"]!=""?$tpl->GetDefined('cell_nolink',Array('color'=>'red','content'=>$population[$cols][$row]["status"])):"&nbsp;";

				$planet = $population[$cols][$row]["planet"]!=""? $tpl->GetDefined('cell_planet',Array(
					'link' => "?action=search&amp;type_search=planet&amp;string_search=".urlencode($population[$cols][$row]["planet"])."&amp;strict=on",
					'content' => $planet,
				)):"&nbsp;";
				$player = $population[$cols][$row]["player"]!=""? $tpl->GetDefined('cell_player',Array(
					'link' => "?action=search&amp;type_search=player&amp;string_search=".urlencode($population[$cols][$row]["player"])."&amp;strict=on",
					'content' => $player,
				)):"&nbsp;";
				$ally = $population[$cols][$row]["ally"]!=""? $tpl->GetDefined('cell_ally',Array(
					'link' => "?action=search&amp;type_search=ally&amp;string_search=".urlencode($population[$cols][$row]["ally"])."&amp;strict=on",
					'content' => $ally,
				)):"&nbsp;";
			}
			$position_info[] = $tpl->GetDefined('line.cell.row', Array(
				'position' => $row,
				'moon' => $moon,
				'status' => $status,
				'spyreport' => $spyreport,
				
				'planet' => $planet,
				'player' => $player,
				'ally' => $ally,
			));
		}
		$system_table[] = $tpl->GetDefined('line.cell',Array(
			'link' => "?action=galaxy&amp;galaxy={$galaxy}&amp;system={$cols}",
			'galaxy' => $galaxy,
			'cols' => $cols,
			'last_update' => $last_update,
			'row' => implode("\n",$position_info),
		));
		$position_info = Array();

		$nbsystem++;
	}
	$system = $cols;
	$table_content[] = $tpl->GetDefined('line',Array('cell'=>implode("\n",$system_table)));
	$system_table = Array();
}
$tpl->SimpleVar(Array('line' => implode("\n",$table_content)));
$tpl->parse();
require_once("views/page_tail.php");
?>
