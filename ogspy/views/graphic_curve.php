<?php
/***************************************
 * Generate a graphic curve chart with Phplot library (http://phplot.sourceforge.net)
 * @author:		ericc
 * @package:	OGSpy 4.0
 * @copyright:	Copyright © 2010, http://www.ogsteam.fr
 * @version:	1.0
 **************************************/
/*
* This work is hereby released into the Public Domain.
* To view a copy of the public domain dedication,
* visit http://creativecommons.org/licenses/publicdomain/ or send a letter to
* Creative Commons, 559 Nathan Abbott Way, Stanford, California 94305, USA.
*/
/* No direct call */
if (!defined('IN_SPYOGAME')) die("Hacking attempt");
/* Check if we received all variables and in correct format */
if(!isset($pub_player)) exit;
if(!isset($pub_start) || !is_numeric($pub_start)) exit;
if(!isset($pub_end) || !is_numeric($pub_end)) exit;
if(!isset($pub_graph)) exit;
/* Explode variables $graph */
$pub_graph = explode("_", $pub_graph);
/* Check content of $pub_graph and initialise empty variables */
if(sizeof($pub_graph) != 2) exit;
if(!isset($pub_player_comp)) $pub_player_comp="";
if(!isset($pub_titre)) $pub_titre="";
if(!isset($pub_zoom)) $pub_zoom = "true";
/* Check variables content */
if (!check_var($pub_player, "Text") || !check_var($pub_start, "Num") || !check_var($pub_end, "Num") || !check_var($pub_graph[0], "Text") || !check_var($pub_graph[1], "Text") ||
!check_var($pub_player_comp, "Text") || !check_var($pub_titre, "Text") || !check_var($pub_zoom, "Char")) {
	exit;
}
/* Transfert in local variables (useless ?) */
$player = $pub_player;
$start = $pub_start;
$end = $pub_end;
$graph = $pub_graph;
$player_comp = $pub_player_comp;
$titre = $pub_titre;
$zoom = $pub_zoom;
/* Initialise tables names */
$table_player = TABLE_PLAYER;
switch ($graph[0]) {
	case "points":
	$table = TABLE_RANK_PLAYER_POINTS;
	break;
	case "fleet":
	$table = TABLE_RANK_PLAYER_FLEET;
	break;
	case "research":
	$table = TABLE_RANK_PLAYER_RESEARCH;
	break;
}
//on recupère le classement
$ranking_1 = array();
$ranking_2 = array();
$dates = array();
$dates2 = array();
/* Build the SQL query */
$request = "select ".$table_player.".name_player, datadate, ".$graph[1];
$request .= " from ".$table.",".$table_player;
$request .= " where (".$table_player.".name_player = '".mysql_escape_string($player)."' or ".$table_player.".name_player = '".mysql_escape_string($player_comp)."')";
$request .= " and ".$table_player.".id_player = ".$table.".id_player";
$request .= " and datadate between ".$start." and ".$end;
$request .= " order by datadate asc";
$result = $db->sql_query($request, false, false);
/* Retreive data from the database */
while (list($player_name, $datadate, $score) = $db->sql_fetch_row($result)) {
	switch(strtolower($player_name)) {
		case strtolower($player) :
		$ranking_1[$datadate] = $score;
		$dates[] = $datadate;
		break;
		case strtolower($player_comp) :
		$ranking_2[$datadate] = $score;
		$dates2[] = $datadate;
	}
}
// $db->sql_close(); -> Why closing the connection ?
/* define the maximum value of both array */
$divi = 1;
if (!empty($ranking_2))
{
	$max_value =  max(max($ranking_1),max($ranking_2));
}
else
{
	$max_value = max($ranking_1);
}
/* then define a divisor */
if ($max_value>999)
{
	$divi = 1000;
}
elseif ($max_value>999999)
{
	$divi = 1000000;
}

if ($divi != 1)
{
	$titre .= " (x".$divi.")";
	foreach (array_keys($ranking_1) as $key)
	{
		$ranking_1[$key] = $ranking_1[$key] / $divi;
	}
	if (!empty($ranking_2))
	{
		foreach (array_keys($ranking_2) as $key)
		{
			$ranking_2[$key] = $ranking_2[$key] / $divi;
		}
	}
}

/* Merge the 2 lists of dates */
$dates = array_merge($dates,$dates2);
/* Remove duplicate */
$dates = array_unique($dates);
/* reorder dates in array */
array_multisort($dates,SORT_ASC);
/* we have now 1 array containing all the dates for which we have a value for player1 OR player2
  for phplot we need an array of array with values : (date,rank player1, rank player2, ....)*/
$data = array();
foreach($dates as $date)
{
	$rdate = date('d/m',$date);
	$data[] = array($rdate,((isset($ranking_1[$date]))?$ranking_1[$date]:""),((isset($ranking_2[$date]))?$ranking_2[$date]:""));
}

/************ Start Plot ************/
/* Load phplot class */
require_once("./library/phplot/phplot.php");
$plot = new PHPlot(400,200);
/* Define type of plot */
$plot->SetPlotType('lines');
/* Type of data used */
$plot->SetDataType('text-data');

$plot->SetImageBorderType('plain');

/* Define background color and picture */
$plot->SetBackgroundColor('#344566');
$plot->SetBgImage("./images/graphic_background.png",'scale');
/* Define the TTF font to be used. I take the font used by Artichow */
$plot->SetDefaultTTFont('./library/phplot/font/Tuffy.ttf');
/* Color of the Title */
$plot->SetTitleColor('white');
/* Color of the text */
$plot->SetTextColor('white');
/* Main plot title */
$plot->SetTitle($titre);

$plot->SetXLabelAngle(30);

$plot->SetDataColors(array('#1716F9','#1688fa'));
/* color of the axes border */
$plot->SetGridColor('#969696');
/* color of the tick */
$plot->SetTickColor('#969696');
/* to make the tick not going out */
$plot->SetXTickLength(0);
$plot->SetYTickLength(0);
/* precision of Y value -> no decimal */
if ($divi!=1)
{
	$plot->SetPrecisionY(1);
}
else
{
	$plot->SetPrecisionY(0);
}
/* Draw both grid line */
$plot->SetDrawXGrid(True);
$plot->SetDrawYGrid(True);
/* Set the color of the grid */
$plot->SetLightGridColor('#636363');
/* define the style of the dash */
$plot->SetDefaultDashedStyle('1-3');


$plot->SetDataValues($data);
$plot->DrawGraph();
