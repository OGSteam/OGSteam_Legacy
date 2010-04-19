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


if(!isset($pub_subaction)||($pub_subaction!="ally"&&$pub_subaction!="player"))
	$pub_subaction = "player";

if($pub_subaction=="player")
	list($order, $ranking, $ranking_available, $maxrank) = galaxy_show_ranking_player();
else
	list($order, $ranking, $ranking_available, $maxrank) = galaxy_show_ranking_ally();

$order_by = $pub_order_by;
$interval = $pub_interval;

require_once("views/page_header.php");
if (file_exists($user_data['user_skin'].'\templates\ranking.tpl'))
{
    $tpl = new template($user_data['user_skin'].'\templates\ranking.tpl');
}
elseif (file_exists($server_config['default_skin'].'\templates\ranking.tpl'))
{
    $tpl = new template($server_config['default_skin'].'\templates\ranking.tpl');
}
else
{
    $tpl = new template('ranking.tpl');
}

// Formattage des liens du form et des entêtes (depent du type de subaction)
if($pub_subaction=="player"){
	$form_action = "?action=ranking&amp;subaction={$pub_subaction}&amp;order_by={$order_by}";
	$link_general = "<a href='?action=ranking&amp;subaction=player&amp;order_by=general'>".($a=L_("ranking_Ptsgeneral"))."</a>";
	$link_fleet = "<a href='?action=ranking&amp;subaction=player&amp;order_by=fleet'>".($b=L_("ranking_Ptsfleet"))."</a>";
	$link_research = "<a href='?action=ranking&amp;subaction=player&amp;order_by=research'>".($c=L_("ranking_Ptsresearch"))."</a>";
}else{
	if (!empty($pub_suborder)) $suborder = $pub_suborder; else $suborder = "rank"; 
	$form_action = "?action=ranking&amp;subaction={$pub_subaction}&amp;order_by={$order_by}&amp;pub_suborder={$suborder}";
	$tooltip = TipFormat($tpl->GetDefined('sort_selection'));
	$tooltip = 	addslashes($tooltip);

	$link_general = "<a href=\"?action=ranking&amp;subaction=ally&amp;order_by=general\" onmouseover=\"Tip('".str_replace("type", "general", $tooltip)."',CLICKCLOSE,true)\">".($a=L_("ranking_Ptsgeneral"))."</a>";
	$link_fleet = "<a href=\"?action=ranking&amp;subaction=ally&amp;order_by=fleet\" onmouseover=\"Tip('".str_replace("type", "fleet", $tooltip)."',CLICKCLOSE,true)\">".($b=L_("ranking_Ptsfleet"))."</a>";
	$link_research = "<a href=\"?action=ranking&amp;subaction=ally&amp;order_by=research\" onmouseover=\"Tip('".str_replace("type", "research", $tooltip)."',CLICKCLOSE,true)\">".($c=L_("ranking_Ptsresearch"))."</a>";
}
// Ajout des images de tri au titre des colonnes
$img_asc = "<img src='images/asc.png' alt='' />";
switch ($order_by) {
	case "general": 
	$link_general = str_replace($a, "{$img_asc}&nbsp;{$a}&nbsp;{$img_asc}", $link_general);
	break;
	case "fleet": 
	$link_fleet = str_replace($b, "{$img_asc}&nbsp;{$b}&nbsp;{$img_asc}", $link_fleet);
	break;
	case "research": 
	$link_research = str_replace($c, "{$img_asc}&nbsp;{$c}&nbsp;{$img_asc}", $link_research);
	break;
}

// Récupération des configurations sur les nom de joueur et d'alliance
$scolor_type = explode("_",$server_config['scolor_type']);
$scolor_color = explode("_",$server_config['scolor_color']);
$scolor_text = explode("_|_",$server_config['scolor_text']);

// Creation de la liste des classements disponible
foreach ($ranking_available as $v) {
	$selected = "";
	if (!isset($pub_date_selected) && !isset($datadate)) {
		$datadate = $v;
		$date_selected = strftime("%d %b %Y %Hh", $v);
	}
	if ($pub_date == $v) {
		$selected = "selected='selected'";
		$datadate = $v;
		$date_selected = strftime("%d %b %Y %Hh", $v);
	}
	$string_date = strftime("%d %b %Y %Hh", $v);
	$date_select_option[] = "<option value='{$v}' {$selected}>{$string_date}</option>";
}
// Creation de la liste des pages de classements disponible pour la date affiché
if (sizeof($ranking_available) > 0) {
	for ($i=1 ; $i<=$maxrank ; $i=$i+100) {
		$selected = "";
		if ($i == $interval) $selected = "selected='selected'";
		$interval_option[] = "<option value='{$i}' {$selected}>{$i} - ".($i+99)."</option>";
	}
}
// Création du tableau de variable des classements
while ($value = current($order)) {
	
	// Classement des joueurs :
	if($pub_subaction=="player"){
	$player = "<a href='?action=search&amp;type_search=player&amp;string_search=".urlencode($value)."&amp;strict=on'>"; 
	
		// Faut-il colorer le nom du joueur ?
	$tag = $tag_in = $tag_out = "";
	foreach($scolor_text as $i => $text){
		if((preg_match('`(^|,)'.$value.'($|,)`',$text) && $scolor_type[$i]=="J") ||
		(preg_match('`(^|,)\{mine\}($|,)`',$text)&&$value==$user_data["user_stat_name"]&&$scolor_type[$i]=="J"))
		{
			if($scolor_color[$i]!=""){
				$tag_in = "<span style='color:".$scolor_color[$i].";'>";
				$tag_out = "</span>";
				break;
			} else {
				$tag_in = "<span style='text-decoration:blink;'>";
				$tag_out = "</span>";
				break;
			}
		}
	}

	$player .= $tag_in.$value.$tag_out;
	$player .= "</a>";

	$ally = "<a href='?action=search&amp;type_search=ally&amp;string_search=".urlencode($ranking[$value]["ally"])."&amp;strict=on'>";
	$tag = $tag_in = $tag_out = "";
	foreach($scolor_text as $i => $text){
		if((preg_match('`(^|;)'.$ranking[$value]["ally"].'($|;)`',$text) && $scolor_type[$i]=="A"))
		{
			if($scolor_color[$i]!=""){
				$tag_in = "<span style='color:".$scolor_color[$i].";'>";
				$tag_out = "</span>";
				break;
			} else {
				$tag_in = "<span style='text-decoration:blink;'>";
				$tag_out = "</span>";
				break;
			}
		}
	}

	$ally .= $tag_in.$ranking[$value]["ally"].$tag_out;
	$ally .= "</a>";

	$general_pts = "&nbsp;";
	$general_rank = "&nbsp;";
	$fleet_pts = "&nbsp;";
	$fleet_rank = "&nbsp;";
	$research_pts = "&nbsp;";
	$research_rank = "&nbsp;";

	if (isset($ranking[$value]["general"]["points"])) {
		$general_pts = formate_number($ranking[$value]["general"]["points"]);
		$general_rank = formate_number($ranking[$value]["general"]["rank"]);
	}
	if (isset($ranking[$value]["fleet"]["points"])) {
		$fleet_pts = formate_number($ranking[$value]["fleet"]["points"]);
		$fleet_rank = formate_number($ranking[$value]["fleet"]["rank"]);
	}
	if (isset($ranking[$value]["research"]["points"])) {
		$research_pts = formate_number($ranking[$value]["research"]["points"]);
		$research_rank = formate_number($ranking[$value]["research"]["rank"]);
	}

		$ranking_line[] = Array(
			'rank' => formate_number(key($order)),
			'player' => $player,
			'ally' => $ally,
			'general_pts' => $general_pts,
			'general_rank' => $general_rank,
			'fleet_pts' => $fleet_pts,
			'fleet_rank' => $fleet_rank,
			'research_pts' => $research_pts,
			'research_rank' => $research_rank,
		);

	}
	else // Classement des Alliances
	{		
	$ally = "<a href='?action=search&amp;type_search=ally&amp;string_search=".urlencode($value)."&amp;strict=on'>";
		// Faut-il colorer le nom de l'alliance ?
	$tag_in = $tag_out = "";
	foreach($scolor_text as $i => $text){
		if(	(preg_match('`(^|,)'.$value.'($|,)`',$text) && $scolor_type[$i]=="A") ) 
		{
			if($scolor_color[$i]!=""){
				$tag_in = "<span style='color:".$scolor_color[$i].";'>";
				$tag_out = "</span>";
				break;
			}else{
				$tag_in = "<span style='text-decoration:blink;'>";
				$tag_out = "</span>";
				break;
			}
		}
	}		
	$ally .= $tag_in.$value.$tag_out;
	$ally .= "</a>";

	$member = formate_number($ranking[$value]["number_member"]);

	$general_pts = "&nbsp;";
	$general_pts_per_member = "&nbsp;";
	$general_rank = "&nbsp;";
	$fleet_pts = "&nbsp;";
	$fleet_pts_per_member = "&nbsp;";
	$fleet_rank = "&nbsp;";
	$research_pts = "&nbsp;";
	$research_pts_per_member = "&nbsp;";
	$research_rank = "&nbsp;";

	if (isset($ranking[$value]["general"]["points"])) {
		$general_pts = formate_number($ranking[$value]["general"]["points"]);
		$general_pts_per_member = formate_number($ranking[$value]["general"]["points_per_member"]);
		$general_rank = formate_number($ranking[$value]["general"]["rank"]);
	}
	if (isset($ranking[$value]["fleet"]["points"])) {
		$fleet_pts = formate_number($ranking[$value]["fleet"]["points"]);
		$fleet_pts_per_member = formate_number($ranking[$value]["fleet"]["points_per_member"]);
		$fleet_rank = formate_number($ranking[$value]["fleet"]["rank"]);
	}
	if (isset($ranking[$value]["research"]["points"])) {
		$research_pts = formate_number($ranking[$value]["research"]["points"]);
		$research_pts_per_member = formate_number($ranking[$value]["research"]["points_per_member"]);
		$research_rank = formate_number($ranking[$value]["research"]["rank"]);
	}
	
		$ranking_line[] = Array(
			'rank' => formate_number(key($order)),
			'ally' => $ally,
			'nbmember' => $member,
			'general_pts' => $general_pts,
			'general_pts_per_member' => $general_pts_per_member,
			'general_rank' => $general_rank,
			'fleet_pts' => $fleet_pts,
			'fleet_pts_per_member' => $fleet_pts_per_member,
			'fleet_rank' => $fleet_rank,
			'research_pts' => $research_pts,
			'research_pts_per_member' => $research_pts_per_member,
			'research_rank' => $research_rank,
		);
	}
	next($order);
}

$tpl->CheckIf("player_selected", $pub_subaction=="player" );
$tpl->CheckIf("is_rank", isset($ranking_line));
if(isset($ranking_line)&&sizeof($ranking_line)>0)
	foreach($ranking_line as $i)
		$tpl->loopVar('line',$i);
$tpl->SimpleVar(Array(
	"form_action" => $form_action,
	"ranking_Players" => L_('ranking_Players'),
	"ranking_Allys" => L_('ranking_Allys'),
	"ranking_Areyousure" => L_('ranking_Areyousure'),
	"ranking_Place" => L_('ranking_Place'),
	"ranking_Member" => L_('ranking_Member'),
	"ranking_Ally" => L_('ranking_Ally'),
	"date_select_option" => isset($date_select_option)?implode('',$date_select_option):"",
	"interval_option" => isset($interval_option)?implode('',$interval_option):"",
	"link_general" => $link_general,
	"link_fleet" => $link_fleet,
	"link_research" => $link_research,
));
$tpl->parse();

require_once("views/page_tail.php");

?>