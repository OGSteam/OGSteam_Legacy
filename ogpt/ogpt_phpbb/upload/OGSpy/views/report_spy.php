<?php
/***************************************************************************
*	filename	: report_spy.php
*	desc.		:
*	Author		: Kyser - http://ogs.servebbs.net/
*	created		: 02/12/2005
*	modified	: 30/07/2006 00:00:00
***************************************************************************/

if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}

$reports = galaxy_reportspy_show();
$galaxy = $pub_galaxy;
$system = $pub_system;
$row = $pub_row;

if ($reports === false) {
	redirection("index.php?action=message&id_message=errorfatal&info");
}

$favorites = user_getfavorites_spy();

require_once("views/page_header_2.php");

foreach ($reports as $v) {
	$spy_id = $v["spy_id"];
	$sender = $v["sender"];
	$report = nl2br($v["data"]);
	$report = str_replace("Mati�res premi�res", "<>Mati�res premi�res", $report);
	$report = str_replace("Flotte", "<>Flotte", $report);
	$report = str_replace("D�fense", "<>D�fense", $report);
	$report = str_replace("B�timents", "<>B�timents", $report);
	$report = str_replace("Recherche", "<>Recherche", $report);
	$report = str_replace("Probabilit�", "<->Probabilit�", $report);
	$report = explode("<br />", $report);
	
	if (sizeof($favorites) < $server_config['max_favorites_spy'])
	$string_addfavorites = "window.location = 'index.php?action=add_favorite_spy&spy_id=".$spy_id."&galaxy=".$galaxy."&system=".$system."&row=".$row."';";
//echo "\t\t\t"."<td class='c' width='150' onclick=\"window.location = 'index.php?action=about&subaction=ogsteam';\">";
	else
	$string_addfavorites = "alert('Vous avez atteint le nombre maximal de favoris permis (".$server_config['max_favorites_spy'].")')";
	
	$string_delfavorites = "window.location = 'index.php?action=del_favorite_spy&spy_id=".$spy_id."&galaxy=".$galaxy."&system=".$system."&row=".$row."&info=2';";

	echo "<center><b>Rapport d'espionnage envoy� par ".$sender."</b></center>"."\n";
	echo "<table align='center'>"."\n";
	echo "<tr><td align='right'>";
	echo "<input type='button' value='Ajouter aux favoris' onclick=\"".$string_addfavorites."\">";
	if (isset($favorites[$spy_id])) echo "<input type='button' value='Supprimer des favoris' onclick=\"".$string_delfavorites."\">";
	echo "</td></tr>"."\n";

	foreach ($report as $line) {
		if (trim($line) == "") continue;
		if (preg_match("/<>/", $line)) {
			$line = str_replace("<>", "", $line);
			echo "<tr><td class='c'>".$line."</td></tr>"."\n";
		}
		elseif (preg_match("/<->/", $line)) {
			$line = str_replace("<->", "", $line);
			echo "<tr><td class='c'>".$line."</td></tr>\n";
			echo "</table>"."\n";
		}
		else {
			echo "<tr><th><font color='lime'>".$line."</font></th></tr>"."\n";
		}
	}
	echo "</table>";
	echo "<br />";
}

require_once("views/page_tail_2.php");
?>
