<?php
/***************************************************************************
*	filename	: ranking_ally.php
*	desc.		:
*	Author		: Kyser - http://ogsteam.fr/
*	created		: 06/05/2006
*	modified	: 22/08/2006 00:00:00
***************************************************************************/

if (!defined('IN_SPACSPY')) {
	die("Hacking attempt");
}

list($order, $ranking, $ranking_available, $maxrank) = galaxy_show_ranking_ally();

$order_by = $pub_order_by;
$interval = $pub_interval;
if (!empty($pub_suborder)) $suborder = $pub_suborder; else $suborder = "rank"; 

$tooltip = "<table width=\"120\">";
$tooltip .= "<tr><td class=\"c\"><a href=\"index.php?action=ranking&subaction=ally&order_by=type\">Tri global</a></td></tr>";
$tooltip .= "<tr><td class=\"c\"><a href=\"index.php?action=ranking&subaction=ally&order_by=type&suborder=member\">Tri par membre</a></td></tr>";
$tooltip .= "</table>";
$tooltip = htmlentities($tooltip);

$link_general = "<a href=\"index.php?action=ranking&subaction=ally&order_by=general\" onmouseover=\"this.T_WIDTH=120;return escape('".str_replace("type", "general", $tooltip)."')\">Pts Général</a>";
$link_fleet = "<a href=\"index.php?action=ranking&subaction=ally&order_by=fleet\" onmouseover=\"this.T_WIDTH=120;return escape('".str_replace("type", "fleet", $tooltip)."')\">Pts Flotte</a>";
$link_research = "<a href=\"index.php?action=ranking&subaction=ally&order_by=research\" onmouseover=\"this.T_WIDTH=120;return escape('".str_replace("type", "research", $tooltip)."')\">Pts Recherche</a>";
$link_research = "<a href=\"index.php?action=ranking&subaction=ally&order_by=mines\" onmouseover=\"this.T_WIDTH=120;return escape('".str_replace("type", "mines", $tooltip)."')\">Pts Mines</a>";
$link_research = "<a href=\"index.php?action=ranking&subaction=ally&order_by=defenses\" onmouseover=\"this.T_WIDTH=120;return escape('".str_replace("type", "mines", $tooltip)."')\">Pts Défenses</a>";

switch ($order_by) {
	case "general": $link_general = str_replace("Pts Général", "<img src='images/asc.png'>&nbsp;Pts Général&nbsp;<img src='images/asc.png'>", $link_general);break;
	case "fleet": $link_fleet = str_replace("Pts Flotte", "<img src='images/asc.png'>&nbsp;Pts Flotte&nbsp;<img src='images/asc.png'>", $link_fleet);break;
	case "research": $link_research = str_replace("Pts Recherche", "<img src='images/asc.png'>&nbsp;Pts Recherche&nbsp;<img src='images/asc.png'>", $link_research);break;
	case "mines": $link_mines = str_replace("Pts Mines", "<img src='images/asc.png'>&nbsp;Pts Mines&nbsp;<img src='images/asc.png'>", $link_mines);break;
	case "defenses": $link_defenses = str_replace("Pts Défenses", "<img src='images/asc.png'>&nbsp;Pts Défenses&nbsp;<img src='images/asc.png'>", $link_defenses);break;
}

?>

<table>
<tr>
	<form method="POST" action="index.php">
	<input type="hidden" name="action" value="ranking">
	<input type="hidden" name="subaction" value="ally">
	<input type="hidden" name="order_by" value="<?php echo $order_by;?>">
	<input type="hidden" name="suborder" value="<?php echo $suborder;?>">
	<td align="right">
		<select name="date" onchange="this.form.submit();">
<?php
foreach ($ranking_available as $v) {
	$selected = "";
	if (!isset($pub_date_selected) && !isset($datadate)) {
		$datadate = $v;
		$date_selected = strftime("%d %b %Y %Hh", $v);
	}
	if ($pub_date == $v) {
		$selected = "selected";
		$datadate = $v;
		$date_selected = strftime("%d %b %Y %Hh", $v);
	}
	$string_date = strftime("%d %b %Y %Hh", $v);
	echo "\t\t\t"."<option value='".$v."' ".$selected.">".$string_date."</option>"."\n";
}
?>
		</select>
		&nbsp;
		<select name="interval" onchange="this.form.submit();">
<?php
if (sizeof($ranking_available) > 0) {
	for ($i=1 ; $i<=$maxrank ; $i=$i+100) {
		$selected = "";
		if ($i == $interval) $selected = "selected";
		echo "\t\t\t"."<option value='".$i."' ".$selected.">".$i." - ".($i+99)."</option>"."\n";
	}
}
?>
		</select>
	</td>
	</form>
<?php
if ($user_data["user_admin"] == 1 || $user_data["user_coadmin"] == 1 || $user_data["management_ranking"] == 1) {?>
	<form method="POST" action="index.php" onsubmit="return confirm('Etes-vous sûr de vouloir supprimer ce classement ?');">
	<input type="hidden" name="action" value="drop_ranking">
	<input type="hidden" name="subaction" value="ally">
	<input type="hidden" name="datadate" value="<?php echo $datadate;?>">
	<td align="right"><input type="image" src="images/drop.png" title="Supprimer le classement du <?php echo $date_selected;?>"></td>
	</form>
<?php }?>
</tr>
</table>
<table width="700">
<tr>
	<td class="c" width="30">Place</td>
	<td class="c">Alliance</td>
	<td class="c">Memb.</td>
	<td class="c" colspan="3"><?php echo $link_general;?></td>
	<td class="c" colspan="3"><?php echo $link_fleet;?></td>
	<td class="c" colspan="3"><?php echo $link_research;?></td>
	<td class="c" colspan="3"><?php echo $link_mines;?></td>
	<td class="c" colspan="3"><?php echo $link_defenses;?></td>
</tr>
<?php
$index = $interval;
while ($value = current($order)) {
	$ally = "<a href='index.php?action=search&type_search=ally&string_search=".$value."&strict=on'>";
	$ally .= $value;
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
	$mines_pts = "&nbsp;";
	$mines_pts_per_member = "&nbsp;";
	$mines_rank = "&nbsp;";
	$defenses_pts = "&nbsp;";
	$defenses_pts_per_member = "&nbsp;";
	$defenses_rank = "&nbsp;";

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
	if (isset($ranking[$value]["mines"]["points"])) {
		$mines_pts = formate_number($ranking[$value]["mines"]["points"]);
		$mines_pts_per_member = formate_number($ranking[$value]["mines"]["points_per_member"]);
		$mines_rank = formate_number($ranking[$value]["mines"]["rank"]);
	}
	if (isset($ranking[$value]["mines"]["points"])) {
		$defenses_pts = formate_number($ranking[$value]["defenses"]["points"]);
		$defenses_pts_per_member = formate_number($ranking[$value]["defenses"]["points_per_member"]);
		$defenses_rank = formate_number($ranking[$value]["defenses"]["rank"]);
	}
	
	echo "<tr>";
	echo "\t"."<th>".formate_number($index)."</th>";
	echo "\t"."<th>".$ally."</th>";
	echo "\t"."<th>".$member."</th>";
	echo "\t"."<th width='60'>".$general_pts."</th>";
	echo "\t"."<th width='40'><font color='yellow'><i>".$general_pts_per_member."</i></font></th>";
	echo "\t"."<th width='40'><font color='lime'><i>".$general_rank."</i></font></th>";
	echo "\t"."<th width='60'>".$fleet_pts."</th>";
	echo "\t"."<th width='40'><font color='yellow'><i>".$fleet_pts_per_member."</i></font></th>";
	echo "\t"."<th width='40'><font color='lime'><i>".$fleet_rank."</i></font></th>";
	echo "\t"."<th width='60'>".$research_pts."</th>";
	echo "\t"."<th width='40'><font color='yellow'><i>".$research_pts_per_member."</i></font></th>";
	echo "\t"."<th width='40'><font color='lime'><i>".$research_rank."</i></font></th>";
	echo "\t"."<th width='60'>".$mines_pts."</th>";
	echo "\t"."<th width='40'><font color='yellow'><i>".$mines_pts_per_member."</i></font></th>";
	echo "\t"."<th width='40'><font color='lime'><i>".$mines_rank."</i></font></th>";
	echo "\t"."<th width='60'>".$defenses_pts."</th>";
	echo "\t"."<th width='40'><font color='yellow'><i>".$defenses_pts_per_member."</i></font></th>";
	echo "\t"."<th width='40'><font color='lime'><i>".$defenses_rank."</i></font></th>";
	echo "</tr>";
	
	$index++;
	next($order);
}
?>
</table>