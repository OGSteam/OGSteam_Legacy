<?php
/***************************************************************************
*	filename	: statistic.php
*	desc.		:
*	Author		: Kyser - http://www.ogsteam.fr/
*	created		: 08/12/2005
*	modified	: 22/11/2006 21:44:50

***************************************************************************/


if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}
$step = 25;
$user_statistic = user_statistic();

$galaxy_statistic = galaxy_statistic($step);
$galaxy_statistic = $galaxy_statistic["map"];

require_once("views/page_header.php");
?>

<table>
<tr>
<td class="c" colspan="20" align="center"><?php echo $LANG["stats_DBState"];?></td>
</tr>
<tr>
	<td class="c" width="45">&nbsp;</td>
<?php
for($i=1 ; $i <= $server_config["nb_galaxy"] ; $i++)
{
	echo"<td class='c' width='60' colspan='2'>";
	echo sprintf($LANG["cartography_GalaxyShortcut"], $i);
	echo"</td>";
}
?>
	<td class="c" width="45">&nbsp;</td>
</tr>
<?php
for ($system=1 ; $system<=$server_config["nb_system"] ; $system=$system+$step) {
	$up = $system+$step-1;
	if ($up > $server_config["nb_system"]) $up = $server_config["nb_system"];

	echo "<tr>"."\n";
	echo "\t"."<td class='c' align='center'>".$system." - ".$up."</td>";
	for ($galaxy=1 ; $galaxy<=$server_config["nb_galaxy"] ; $galaxy++) {
		$link_colonized = "";
		$colonized = "-";
		$link_free = "";
		$free = "-";
		if ($galaxy_statistic[$galaxy][$system]["planet"] > 0) {
			$link_colonized = "onclick=\"window.location = 'index.php?action=galaxy_sector&";
			$link_colonized .= "galaxy=".$galaxy."&";
			$link_colonized .= "system_down=".$system."&system_up=".$up;
			$link_colonized .= "';\"";
			$days = datediff("d",$galaxy_statistic[$galaxy][$system]["last_update"], time(), true);
				if ($days > 30) $days = 30;
					($days > 15) ? $red_days = 15 : $red_days = $days;
					($days < 15) ? $green_days = 15 : $green_days = 30 - $days;
					$color_red_chanel = dechex((int)(17 * $red_days));
				if (strlen($color_red_chanel) < 2) $color_red_chanel = "0" . $color_red_chanel;
					$color_green_chanel = dechex((int)(17 * $green_days));
				if (strlen($color_green_chanel) < 2) $color_green_chanel = "0" . $color_green_chanel;
					$color_blue_chanel = dechex(0);
				if (strlen($color_blue_chanel) < 2) $color_blue_chanel = "0" . $color_blue_chanel;
					$color = "#" . $color_red_chanel . $color_green_chanel . $color_blue_chanel;
				if ($galaxy_statistic[$galaxy][$system]["new"])
					$colonized = "<a style='cursor:pointer'><font color='" . $color . "'><blink>".$galaxy_statistic[$galaxy][$system]["planet"]."</blink></font></a>";
				else
					$colonized = "<a style='cursor:pointer'><font color='" . $color . "'>".$galaxy_statistic[$galaxy][$system]["planet"]."</font></a>";
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
?>
<tr>
	<td class="c" width="45">&nbsp;</td>
<?php
for($i=1 ; $i <= $server_config["nb_galaxy"] ; $i++)
{
	echo"<td class='c' width='60' colspan='2'>";
	echo sprintf($LANG["cartography_GalaxyShortcut"], $i);
	echo"</td>";
}
?>
	<td class="c" width="45">&nbsp;</td>
</tr>
<?php
$legend = "<table width=\"225\">";
$legend .= "<tr><td class=\"c\" colspan=\"2\" align=\"center\" width=\"150\">".$LANG["search_Legend"]."</td></tr>";
$legend .= "<tr><td class=\"c\">".$LANG["stats_KnownPlanets"]."</td><th><font color=\"Lime\">xx</font></th></tr>";
$legend .= "<tr><td class=\"c\">".$LANG["stats_FreePlanets"]."</td><th><font color=\"orange\"><b>xx</b></font></th></tr>";
$legend .= "<tr><td class=\"c\">".$LANG["stats_UpdatedRecentlyPlanets"]."</td><th><font color=\"Lime\"><blink><b>xx</blink></th></tr>";
$legend .= "</table>";
$legend = addslashes(htmlentities($legend));
?>
<tr>
<td class="c" colspan="20" align="center"><a style='cursor:pointer' onmouseover="this.T_WIDTH=210;this.T_TEMP=0;return escape('<?php echo $legend;?>')"><?php echo $LANG["search_Legend"];?></a></td>
</tr>
</table>
<br />
<table>
<tr align="center">
	<td class="c" width="100" rowspan="2"><?php echo $LANG["stats_Nicknames"];?></td>
	<td class="c" colspan="3"><?php echo $LANG["univers_Planets"];?></td>
	<td class="c" colspan="3"><?php echo $LANG["univers_SpyReports"];?></td>
	<td class="c" colspan="3"><?php echo $LANG["stats_RankingLines"];?></td>
	<td class="c" colspan="1" rowspan="2"><?php echo $LANG["stats_ResearchMade"];?></td>
	<td class="c" colspan="1" rowspan="2"><?php echo $LANG["stats_Ratio"];?></td>

<?php if ($user_data["user_admin"] == 1 || $user_data["user_coadmin"] == 1 || $user_data["management_user"] == 1) { echo("<td class=\"c\" colspan=\"2\" rowspan=\"2\">Admin</td>"); } ?>
</tr>
<tr align="center">
		<td class="c" width="50"><a title="<?php echo $LANG["stats_LoadedFromBrowser"];?>">Web&nbsp;<img src='images/desc.png'></a></td>
	<td class="c" width="50"><a title="<?php echo $LANG["stats_LoadedFromOGS"];?>">OGS&nbsp;<img src='images/desc.png'></a></td>
	<td class="c" width="50"><a title="<?php echo $LANG["stats_SendedToOGS"];?>">OGS&nbsp;<img src='images/asc.png'></a></td>
	<td class="c" width="50"><a title="<?php echo $LANG["stats_LoadedFromBrowser"];?>">Web&nbsp;<img src='images/desc.png'></a></td>
	<td class="c" width="50"><a title="<?php echo $LANG["stats_LoadedFromOGS"];?>">OGS&nbsp;<img src='images/desc.png'></a></td>
	<td class="c" width="50"><a title="<?php echo $LANG["stats_SendedToOGS"];?>">OGS&nbsp;<img src='images/asc.png'></a></td>
	<td class="c" width="50"><a title="<?php echo $LANG["stats_LoadedFromBrowser"];?>">Web&nbsp;<img src='images/desc.png'></a></td>
	<td class="c" width="50"><a title="<?php echo $LANG["stats_LoadedFromOGS"];?>">OGS&nbsp;<img src='images/desc.png'></a></td>
	<td class="c" width="50"><a title="<?php echo $LANG["stats_SendedToOGS"];?>">OGS&nbsp;<img src='images/asc.png'></a></td>
</tr>
<?php
//Statistiques participation des membres actifs
foreach ($user_statistic as $v) {
	$player = $v["user_id"];
	$array = ratio_calc($player);
	$result = $array[0];
	
	$couleur = $result[3] > 0 ? "lime" : "red";
	if ($result < 0) $color = "red";
	elseif ($result == 0) $color = "white";
	elseif ($result < 100) $color = "orange";
	else $color = "lime";
	
	echo "<tr>"."\n";
	echo "\t"."<th><font color='".$color."'>".$v["user_name"]." ".$v["here"]."</font></th>";
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
	if ($user_data["user_admin"] == 1 || $user_data["user_coadmin"] == 1 || $user_data["management_user"] == 1) { echo("<th><input type=\"button\" value=\"Reset\" onclick=\"window.location = 'index.php?action=admin_ratio&what=reset&j0ueur=".$v["user_id"]."'\"></th>"); }
	if ($user_data["user_admin"] == 1 || $user_data["user_coadmin"] == 1 || $user_data["management_user"] == 1) { echo("<th><input type=\"button\" value=\"Boost\" onclick=\"window.location = 'index.php?action=admin_ratio&what=boost&j0ueur=".$v["user_id"]."'\"></th>"); }
	echo "</tr>"."\n";
}
if (sizeof($user_statistic) > 10) {
?>
<tr align="center">
	<td class="c" width="100" rowspan="2"><?php echo $LANG["stats_Nicknames"];?></td>
	<td class="c" width="50"><a title="<?php echo $LANG["stats_LoadedFromBrowser"];?>">Web</a></td>
	<td class="c" width="50"><a title="<?php echo $LANG["stats_LoadedFromOGS"];?>">OGS&nbsp;<img src='images/asc.png'></a></td>
	<td class="c" width="50"><a title="<?php echo $LANG["stats_SendedToOGS"];?>">OGS&nbsp;<img src='images/desc.png'></a></td>
	<td class="c" width="50"><a title="<?php echo $LANG["stats_LoadedFromBrowser"];?>">Web</a></td>
	<td class="c" width="50"><a title="<?php echo $LANG["stats_LoadedFromOGS"];?>">OGS&nbsp;<img src='images/asc.png'></a></td>
	<td class="c" width="50"><a title="<?php echo $LANG["stats_SendedToOGS"];?>">OGS&nbsp;<img src='images/desc.png'></a></td>
	<td class="c" width="50"><a title="<?php echo $LANG["stats_LoadedFromBrowser"];?>">Web</a></td>
	<td class="c" width="50"><a title="<?php echo $LANG["stats_LoadedFromOGS"];?>">OGS&nbsp;<img src='images/asc.png'></a></td>
	<td class="c" width="50"><a title="<?php echo $LANG["stats_SendedToOGS"];?>">OGS&nbsp;<img src='images/desc.png'></a></td>
	<td class="c" colspan="1" rowspan="2"><?php echo $LANG["stats_ResearchMade"];?></td>
	<td class="c" colspan="1" rowspan="2"><?php echo $LANG["stats_Ratio"];?></td>
	<?php if ($user_data["user_admin"] == 1 || $user_data["user_coadmin"] == 1 || $user_data["management_user"] == 1) { echo("<td class=\"c\" colspan=\"2\" rowspan=\"2\">Admin</td>"); } ?>
</tr>
<tr align="center">
	<td class="c" colspan="3"><?php echo $LANG["univers_Planets"];?></td>
	<td class="c" colspan="3"><?php echo $LANG["univers_SpyReports"];?></td>
	<td class="c" colspan="3"><?php echo $LANG["stats_RankingLines"];?></td>
</tr>
<?php
}?>
<tr>
	<td colspan="12"><?php echo $LANG["stats_ConnectedLegend"];?></td>
</tr>
</table>
<?php
require_once("views/page_tail.php");
?>
