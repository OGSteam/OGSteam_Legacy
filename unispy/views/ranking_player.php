<?php
/***************************************************************************
*	filename	: ranking_player.php
*	desc.		:
*	Author		: Kyser - http://www.ogsteam.fr/
*	created		: 26/12/2005
*	modified	: 06/08/2006 11:40:18
***************************************************************************/

if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}

list($order, $ranking, $ranking_available) = galaxy_show_ranking_player();

$order_by = $pub_order_by;
$interval = $pub_interval;

$link_general = "<a href='index.php?action=ranking&subaction=player&order_by=general'>".$LANG["rankingplayer_Ptsgeneral"]."</a>";
$link_fleet = "<a href='index.php?action=ranking&subaction=player&order_by=fleet'>".$LANG["rankingplayer_Ptsfloat"]."</a>";
$link_research = "<a href='index.php?action=ranking&subaction=player&order_by=research'>".$LANG["rankingplayer_Ptsresearch"]."</a>";

switch ($order_by) {
	case "general": $link_general = str_replace("Pts G�n�ral", "<img src='images/asc.png'>&nbsp;".$LANG["rankingplayer_Ptsgeneral"]."&nbsp;<img src='images/asc.png'>", $link_general);break;
	case "fleet": $link_fleet = str_replace("Pts Flotte", "<img src='images/asc.png'>&nbsp;".$LANG["rankingplayer_Ptsfloat"]." ?>&nbsp;<img src='images/asc.png'>", $link_fleet);break;
	case "research": $link_research = str_replace("Pts Recherche", "<img src='images/asc.png'>&nbsp;".$LANG["rankingplayer_Ptsresearch"]."&nbsp;<img src='images/asc.png'>", $link_research);break;
}
?>

<table>
<tr>
	<form method="POST" action="index.php">
	<input type="hidden" name="action" value="ranking">
	<input type="hidden" name="subaction" value="player">
	<input type="hidden" name="order_by" value="<?php echo $order_by;?>">
	<td align="right">
		<select name="date" onchange="this.form.submit();">
<?php
foreach ($ranking_available as $v) {
	$selected = "";
	if (!isset($date_selected)) {
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
	for ($i=1 ; $i<=1500 ; $i=$i+100) {
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
	<form method="POST" action="index.php" onsubmit="return confirm('<?php echo $LANG["rankingplayer_Areyousure"]; ?>');">
	<input type="hidden" name="action" value="drop_ranking">
	<input type="hidden" name="subaction" value="player">
	<input type="hidden" name="datadate" value="<?php echo $datadate;?>">
	<td align="right"><input type="image" src="images/drop.png" title="<?php echo $LANG["rankingplayer_Deletefillingof"]; ?> <?php echo $date_selected;?>"></td>
	</form>
<?php }?>
</tr>
</table>
<table width="820">
<tr>
	<td class="c" width="30"><?php echo $LANG["rankingplayer_Place"]; ?></td>	
	<td class="c"><?php echo $LANG["rankingplayer_Member"]; ?></td>
	<td class="c"><?php echo $LANG["univers_Ally"]; ?></td>
	<td class="c" colspan="2"><?php echo $link_general;?></td>
	<td class="c" colspan="2"><?php echo $link_fleet;?></td>
	<td class="c" colspan="2"><?php echo $link_research;?></td>
</tr>
<?php
while ($value = current($order)) {
	$player = "<a href='index.php?action=search&type_search=player&string_search=".urlencode($value)."&strict=on'>";
	$player .= $value;
	$player .= "</a>";

	$ally = "<a href='index.php?action=search&type_search=ally&string_search=".urlencode($ranking[$value]["ally"])."&strict=on'>";
	$ally .= $ranking[$value]["ally"];
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

	echo "<tr>";
	echo "\t"."<th>".formate_number(key($order))."</th>";
	echo "\t"."<th>".$player."</th>";
	echo "\t"."<th>".$ally."</th>";
	echo "\t"."<th width='100'>".$general_pts."</th>";
	echo "\t"."<th width='40'><font color='lime'><i>".$general_rank."</i></font></th>";
	echo "\t"."<th width='100'>".$fleet_pts."</th>";
	echo "\t"."<th width='40'><font color='lime'><i>".$fleet_rank."</i></font></th>";
	echo "\t"."<th width='100'>".$research_pts."</th>";
	echo "\t"."<th width='40'><font color='lime'><i>".$research_rank."</i></font></th>";
	echo "</tr>";

	next($order);
}
?>
</table>
