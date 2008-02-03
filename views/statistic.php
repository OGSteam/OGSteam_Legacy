<?php
/***************************************************************************
*	filename	: statistic.php
*	desc.		:
*	Author		: Kyser - http://ogsteam.fr/
*	created		: 08/12/2005
*	modified	: 13/04/2007 03:40:00

***************************************************************************/

if (!defined('IN_SPACSPY')) {
	die("Hacking attempt");
}
$galaxy_step=$server_config['galaxy_by_line_stat'];
$galaxy_down=1;
$galaxy=1;
$step = $server_config['system_by_line_stat'];

$enable_stat_view = $server_config['enable_stat_view'];
$enable_members_view = $server_config['enable_members_view'];

$user_statistic = user_statistic();

$galaxy_statistic = galaxy_statistic($step);
$galaxy_statistic = $galaxy_statistic["map"];

require_once("views/page_header.php");
?>

<table>
<tr>
	<td class="c" colspan="<?php echo $galaxy_step*2+2;?>" align="center">Etat de la cartographie</td>
</tr>
<?php

do{
	$galaxy_up = $galaxy_down + $galaxy_step;
?>
<tr>
	<td class="c" width="45">&nbsp;</td>
<?php
	if ($galaxy > intval($server_config['num_of_galaxies']))
		$galaxy_up = intval($server_config['num_of_galaxies']);
	for ($i=$galaxy_down ; $i<$galaxy_up ; $i++){
		echo "<td class=\"c\" width=\"60\" colspan=\"2\">";
		if ($i<=intval($server_config['num_of_galaxies']))
			echo "G$i";
			echo "</td>";
	}
?>
	<td class="c" width="45">&nbsp;</td>
</tr>
<?php
	for ($system=1 ; $system<=intval($server_config['num_of_systems']) ; $system=$system+$step) {
		$up = $system+$step-1;
		if ($up > intval($server_config['num_of_systems'])) $up = intval($server_config['num_of_systems']);
		echo "<tr>"."\n";
		echo "\t"."<td class='c' align='center'>".$system." - ".$up."</td>";
		for ($galaxy=$galaxy_down ; $galaxy<$galaxy_up ; $galaxy++) {
			$link_colonized = "";
			$colonized = "-";
			$link_free = "";
			$free = "-";
			if ($galaxy>intval($server_config['num_of_galaxies'])) {
				echo "<th> </th><th> </th>";
				continue;
			}
			if ($galaxy_statistic[$galaxy][$system]["planet"] > 0) {
				$link_colonized = "onclick=\"window.location = 'index.php?action=galaxy_sector&";
				$link_colonized .= "galaxy=".$galaxy."&";
				$link_colonized .= "system_down=".$system."&system_up=".$up;
				$link_colonized .= "';\"";
				if ($galaxy_statistic[$galaxy][$system]["new"])
				$colonized = "<a style='cursor:pointer'><font color='lime'><blink>".$galaxy_statistic[$galaxy][$system]["planet"]."</blink></font></a>";
				else
				$colonized = "<a style='cursor:pointer'><font color='lime'>".$galaxy_statistic[$galaxy][$system]["planet"]."</font></a>";
			}
			if ($galaxy_statistic[$galaxy][$system]["free"] > 0) {
				$link_free = "onclick=\"window.location = 'index.php?action=search&type_search=colonization&";
				$link_free .= "galaxy_down=".$galaxy."&galaxy_up=".$galaxy."&";
				$link_free .= "system_down=".$system."&system_up=".$up."&";
				$link_free .= "row_down&row_up";
				$link_free .= "';\"";
				$free = "<a style='cursor:pointer'><font color='orange'>".$galaxy_statistic[$galaxy][$system]["free"]."</font></a>";
			}
			echo "<th width='30' ".$link_colonized.">".$colonized."</th>";
			echo "<th width='30' ".$link_free.">".$free."</th>"."\n";
		}
		echo "\t"."<td class='c' align='center'>".$system." - ".$up."</td>";
		echo "</tr>"."\n";
	}
	$galaxy_down = $galaxy_up;
}while($galaxy_up<intval($server_config['num_of_galaxies']));
$legend = "<table width=\"225\">";
$legend .= "<tr><td class=\"c\" colspan=\"2\" align=\"center\" width=\"150\">Légende</td></tr>";
$legend .= "<tr><td class=\"c\">Planètes répertoriées</td><th><font color=\"Lime\">xx</font></th></tr>";
$legend .= "<tr><td class=\"c\">Planètes colonisables</td><th><font color=\"orange\"><b>xx</b></font></th></tr>";
$legend .= "<tr><td class=\"c\">Planètes mises à jour récemment</td><th><font color=\"Lime\"><blink><b>xx</blink></th></tr>";
$legend .= "</table>";
$legend = htmlentities($legend);
?>
<tr>
	<td class="c" colspan="<?php echo $galaxy_step*2+2;?>" align="center"><a style='cursor:pointer' onmouseover="this.T_WIDTH=210;this.T_TEMP=0;return escape('<?php echo $legend;?>')">Légende</a></td>
</tr>
</table>
<br />
<table>
<?php
	if ($user_data["user_admin"] == 1 || $user_data["user_coadmin"] == 1 || $user_data["management_user"] == 1)
		{
		echo "<tr align=\"right\">
			<td colspan=12><a href=\"index.php?action=raz_ratio\">Remise à zero</a></td>";
		}
?>
<tr align="center">
	<td class="c" width="100">Pseudos</td>
	<td class="c" colspan="3">Planètes</td>
	<td class="c" colspan="3">Rapports d'espionnage</td>
	<td class="c" colspan="3">Classement (lignes)</td>
	<td class="c" colspan="1">Recherches<br />effectuées</td>
	<td class="c" colspan="1">Ratio</td>
</tr>
<tr align="center">
	<td class="c" width="100" colspan="1">&nbsp;</td>
	<td class="c" width="50"><a title="Chargées via le navigateur">Web&nbsp;<img src='images/desc.png'></a></td>
	<td class="c" width="50"><a title="Chargées via spacs et les toolbars">spacs&nbsp;<img src='images/desc.png'></a></td>
	<td class="c" width="50"><a title="Envoyées vers spacs">spacs&nbsp;<img src='images/asc.png'></a></td>
	<td class="c" width="50"><a title="Chargés via le navigateur">Web&nbsp;<img src='images/desc.png'></a></td>
	<td class="c" width="50"><a title="Chargés via spacs et les toolbars">spacs&nbsp;<img src='images/desc.png'></a></td>
	<td class="c" width="50"><a title="Envoyés vers spacs">spacs&nbsp;<img src='images/asc.png'></a></td>
	<td class="c" width="50"><a title="Chargées via le navigateur">Web&nbsp;<img src='images/desc.png'></a></td>
	<td class="c" width="50"><a title="Chargées via spacs et les toolbars">spacs&nbsp;<img src='images/desc.png'></a></td>
	<td class="c" width="50"><a title="Envoyées vers spacs">spacs&nbsp;<img src='images/asc.png'></a></td>
	<td class="c" width="100" colspan="1">&nbsp;</td>
	<td class="c" width="100" colspan="1">&nbsp;</td>
</tr>
<?php
//Statistiques participation des membres actifs
$request = "select sum(planet_added_web + planet_added_ogs), ";
$request .= "sum(spy_added_web + spy_added_ogs), ";
$request .= "sum(rank_added_web + rank_added_ogs), ";
$request .= "sum(search) ";
$request .= "from ".TABLE_USER;
$result = $db->sql_query($request);
list($planetimport, $spyimport, $rankimport, $search) = $db->sql_fetch_row($result);

if ($planetimport == 0) $planetimport = 1;
if ($spyimport == 0) $spyimport = 1;
if ($rankimport == 0) $rankimport = 1;
if ($search == 0) $search = 1;


foreach ($user_statistic as $v) {
	$ratio_planet = ($v["planet_added_web"] + $v["planet_added_ogs"]) / $planetimport;
	$ratio_spy = ($v["spy_added_web"] + $v["spy_added_ogs"]) / $spyimport;
	$ratio_rank = ($v["rank_added_web"] + $v["rank_added_ogs"]) / $rankimport;	
	$ratio = ($ratio_planet * 4 + $ratio_spy * 2 + $ratio_rank) / (3 + 2 + 1);	
	
	$ratio_planet_penality = ($v["planet_added_web"] + $v["planet_added_ogs"] - $v["planet_exported"]) / $planetimport;
	$ratio_spy_penality = (($v["spy_added_web"] + $v["spy_added_ogs"]) - $v["spy_exported"]) / $spyimport;
	$ratio_rank_penality = (($v["rank_added_web"] + $v["rank_added_ogs"]) - $v["rank_exported"]) / $rankimport;
	$ratio_penality = ($ratio_planet_penality * 4 + $ratio_spy_penality * 2 + $ratio_rank_penality) / (3 + 2 + 1);	
		
	$ratio_search = $v["search"] / $search;
	$ratio_searchpenality = ($ratio - $ratio_search);	
	
	$couleur = $ratio_penality > 0 ? "lime" : "red";
	
	$result = ($ratio + $ratio_penality + $ratio_searchpenality) * 1000;
	if ($result < 0) $color = "red";
	elseif ($result == 0) $color = "white";
	elseif ($result < 100) $color = "orange";
	else $color = "lime";

	if ($enable_stat_view || ($v["user_name"] == $user_data["user_name"]) || $user_data["user_admin"] || $user_data["user_coadmin"]){
		echo "<tr>"."\n";
		echo "\t"."<th><font color='".$color."'>".$v["user_name"]." ";
		if ($enable_members_view || $user_data["user_admin"] || $user_data["user_coadmin"])
			echo $v["here"];
		echo "</font></th>";
		echo "<th>".formate_number($v["planet_added_web"])."</th>";
		echo "<th>".formate_number($v["planet_added_ogs"])."</th>";
		echo "<th>".formate_number($v["planet_exported"])."</th>";
		echo "<th>".formate_number($v["spy_added_web"])."</th>";
		echo "<th>".formate_number($v["spy_added_ogs"])."</th>";
		echo "<th>".formate_number($v["spy_exported"])."</th>";
		echo "<th>".formate_number($v["rank_added_web"])."</th>";
		echo "<th>".formate_number($v["rank_added_ogs"])."</th>";
		echo "<th>".formate_number($v["rank_exported"])."</th>";
		echo "<th>".formate_number($v["search"])."</th>"."\n";
		echo "<th><font color='".$color."'>".formate_number($result)."</font></th>"."\n";
		echo "</tr>"."\n";
	}
}
if (sizeof($user_statistic) > 10) {
?>
<tr align="center">
	<td class="c" width="100" colspan="1">&nbsp;</td>
	<td class="c" width="50"><a title="Chargées via le navigateur">Web</a></td>
	<td class="c" width="50"><a title="Chargées via spacs">spacs&nbsp;<img src='images/asc.png'></a></td>
	<td class="c" width="50"><a title="Envoyées vers spacs">spacs&nbsp;<img src='images/desc.png'></a></td>
	<td class="c" width="50"><a title="Chargés via le navigateur">Web</a></td>
	<td class="c" width="50"><a title="Chargés via spacs">spacs&nbsp;<img src='images/asc.png'></a></td>
	<td class="c" width="50"><a title="Envoyés vers spacs">spacs&nbsp;<img src='images/desc.png'></a></td>
	<td class="c" width="50"><a title="Chargées via le navigateur">Web</a></td>
	<td class="c" width="50"><a title="Chargées via spacs">spacs&nbsp;<img src='images/asc.png'></a></td>
	<td class="c" width="50"><a title="Envoyées vers spacs">spacs&nbsp;<img src='images/desc.png'></a></td>
	<td class="c" width="100" colspan="1">&nbsp;</td>
	<td class="c" width="100" colspan="1">&nbsp;</td>
</tr>
<tr align="center">
	<td class="c" width="100">Pseudos</td>
	<td class="c" colspan="3">Planètes</td>
	<td class="c" colspan="3">Rapports d'espionnage</td>
	<td class="c" colspan="3">Classement (lignes)</td>
	<td class="c" colspan="1">Recherches effectuées</td>
	<td class="c" colspan="1">Ratio</td>
</tr>
<?php
}
if ($enable_members_view || $user_data["user_admin"] || $user_data["user_coadmin"]){
?>
<tr>
	<td colspan="12">(*) connecté sur le serveur<br />(**) connecté avec spacs ou les toolbars</td>
</tr>
<?php
}
echo "</table>";
require_once("views/page_tail.php");
?>