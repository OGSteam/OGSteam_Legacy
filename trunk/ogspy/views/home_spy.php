<?php
/** $Id$ **/
/**
* 
* @package OGSpy
* @subpackage main
* @author Ben.12
* @copyright Copyright &copy; 2007, http://ogsteam.fr/
* @version 4.00 ($Rev$)
* @modified $Date$
* @link $HeadURL$
*/
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

//$nb_del_spy = user_del_old_favorite_spy();
$favorites = user_getfavorites_spy();

if (!isset($sort2)) $sort2 = 0;
else $sort2 = $sort2 != 0 ? 0 : 1;

if (file_exists($user_data['user_skin'].'\templates\home_spy.tpl'))
{
    $tpl = new template($user_data['user_skin'].'\templates\home_spy.tpl');
}
elseif (file_exists($server_config['default_skin'].'\templates\home_spy.tpl'))
{
    $tpl = new template($server_config['default_skin'].'\templates\home_spy.tpl');
}
else
{
    $tpl = new template('home_spy.tpl');
}

foreach ($favorites as $v) {
	$spy_id = $v["spy_id"];
	$galaxy = $v["spy_galaxy"];
	$system = $v["spy_system"];
	$row = $v["spy_row"];
	$player = $v["player"];
	$ally = $v["ally"];
	$moon = $v["moon"];
	$status = $v["status"];
	$timestamp = $v["datadate"];

	if ($timestamp != 0) {
		$timestamp = strftime("%d %b %Y %H:%M", $timestamp);
		$poster = $timestamp." - ".$v["poster"];
	}
	
	$coordinates = "<a href='?action=galaxy&amp;galaxy={$galaxy}&amp;system={$system}'>{$galaxy}:{$system}:{$row}</a>";

	if ($ally == "") $ally = "&nbsp;";
	else $ally = "<a href='?action=search&amp;type_search=ally&amp;string_search=".urlencode($ally)."&amp;strict=on'>{$ally}</a>";

	if ($player == "") $player = "&nbsp;";
	else $player = "<a href='?action=search&amp;type_search=player&amp;string_search=".urlencode($player)."&amp;strict=on'>{$player}</a>";

	if ($status == "") $status = " &nbsp;";

	if ($moon == 1) $moon = " M";
	else $moon = "&nbsp;";

	$fs_array[] = Array(
		"coordinates" => $coordinates,
		"ally" => $ally,
		"player" => $player,
		"moon" => $moon,
		"status" => $status,
		"poster" => $poster,
		"homespy_Look" => L_("homespy_Look"),
		"show_report_link" => "?action=show_reportspy&amp;galaxy={$galaxy}&amp;system={$system}&amp;row={$row}&amp;spy_id={$spy_id}",
		"homespy_Delete" => L_("homespy_Delete"),
		"delete_link" => "?action=del_favorite_spy&amp;spy_id={$spy_id}&amp;info=1",
	);
}

if(isset($fs_array)){
	$tpl->CheckIf('is_fs',true);
	foreach($fs_array as $fav)
		$tpl->loopVar('fs',$fav);
}

$tpl->SimpleVar(Array(
	"homespy_pos_link" => "?action=home&amp;subaction=spy&amp;sort=1&amp;sort2={$sort2}",
	"homespy_pos" => L_("homespy_pos"),
	"homespy_Allys_link" => "?action=home&amp;subaction=spy&amp;sort=2&amp;sort2={$sort2}",
	"homespy_Allys" => L_("homespy_Allys"),
	"homespy_Players_link" => "?action=home&amp;subaction=spy&amp;sort=3&amp;sort2={$sort2}",
	"homespy_Players" => L_("homespy_Players"),
	"homespy_Moon_link" => "?action=home&amp;subaction=spy&amp;sort=4&amp;sort2={$sort2}",
	"homespy_Moon" => L_("homespy_Moon"),
	"homespy_Updated_link" => "?action=home&amp;subaction=spy&amp;sort=5&amp;sort2={$sort2}",
	"homespy_Updated" => L_("homespy_Updated"),
));

$tpl->parse();
