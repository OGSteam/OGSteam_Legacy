<?php
/***************************************************************************
*	filename	: ranking_player.php
*	desc.		:
*	Author		: Kyser - http://ogsteam.fr/
*	created		: 26/12/2005
*	modified	: 06/08/2006 11:40:18
***************************************************************************/

if (!defined('IN_SPACSPY')) {
	die("Hacking attempt");
}

list($order, $ranking, $ranking_available, $maxrank) = galaxy_show_ranking_player();

$order_by = $pub_order_by;
$interval = $pub_interval;

$link_general = "<a href='index.php?action=ranking&subaction=player&order_by=general'>Pts Général</a>";
$link_fleet = "<a href='index.php?action=ranking&subaction=player&order_by=fleet'>Pts Flotte</a>";
$link_research = "<a href='index.php?action=ranking&subaction=player&order_by=research'>Pts Recherche</a>";
$link_mines = "<a href='index.php?action=ranking&subaction=player&order_by=mines'>Pts Mines</a>";
$link_defenses = "<a href='index.php?action=ranking&subaction=player&order_by=defenses'>Pts Défenses</a>";

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
	<input type="hidden" name="subaction" value="player">
	<input type="hidden" name="order_by" value="<?php echo $order_by;?>">
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
	<input type="hidden" name="subaction" value="player">
	<input type="hidden" name="datadate" value="<?php echo $datadate;?>">
	<td align="right"><input type="image" src="images/drop.png" title="Supprimer le classement du <?php echo $date_selected;?>"></td>
	</form>
<?php }?>
</tr>
</table>
<table width="700">
<tr>
	<td class="c" width="30">Place</td>
	<td class="c">Joueur</td>
	<td class="c">Alliance</td>
	<td class="c" colspan="2"><?php echo $link_general;?></td>
	<td class="c" colspan="2"><?php echo $link_fleet;?></td>
	<td class="c" colspan="2"><?php echo $link_research;?></td>
	<td class="c" colspan="2"><?php echo $link_mines;?></td>
	<td class="c" colspan="2"><?php echo $link_defenses;?></td>
	
</tr>
<?php
while ($value = current($order)) {
		 $player = "<a href='index.php?action=search&type_search=player&string_search=".$value."&strict=on'>"; 
	if ($value == $user_data["user_name"]){
	$player .= "<font color='lime'>";
	}
	$player .= $value;
	
	if ($value == $user_data["user_name"]){
	$player .= "</font>";
	}
	$player .= "</a>";

	$ally = "<a href='index.php?action=search&type_search=ally&string_search=".$ranking[$value]["ally"]."&strict=on'>";
	$ally .= $ranking[$value]["ally"];
	$ally .= "</a>";

	$general_pts = "&nbsp;";
	$general_rank = "&nbsp;";
	$fleet_pts = "&nbsp;";
	$fleet_rank = "&nbsp;";
	$research_pts = "&nbsp;";
	$research_rank = "&nbsp;";
	$mines_pts = "&nbsp;";
	$mines_rank = "&nbsp;";
	$defenses_pts = "&nbsp;";
	$defenses_rank = "&nbsp;";

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
	if (isset($ranking[$value]["mines"]["points"])) {
		$mines_pts = formate_number($ranking[$value]["mines"]["points"]);
		$mines_rank = formate_number($ranking[$value]["mines"]["rank"]);
	}
	if (isset($ranking[$value]["defenses"]["points"])) {
		$defenses_pts = formate_number($ranking[$value]["defenses"]["points"]);
		$defenses_rank = formate_number($ranking[$value]["defenses"]["rank"]);
	}
	
	echo "<tr>";
	echo "\t"."<th>".formate_number(key($order))."</th>";
	echo "\t"."<th>".$player."</th>";
	echo "\t"."<th>".$ally."</th>";
	echo "\t"."<th width='70'>".$general_pts."</th>";
	echo "\t"."<th width='40'><font color='lime'><i>".$general_rank."</i></font></th>";
	echo "\t"."<th width='70'>".$fleet_pts."</th>";
	echo "\t"."<th width='40'><font color='lime'><i>".$fleet_rank."</i></font></th>";
	echo "\t"."<th width='70'>".$research_pts."</th>";
	echo "\t"."<th width='40'><font color='lime'><i>".$research_rank."</i></font></th>";
	echo "\t"."<th width='70'>".$mines_pts."</th>";
	echo "\t"."<th width='40'><font color='lime'><i>".$mines_rank."</i></font></th>";
	echo "\t"."<th width='70'>".$defenses_pts."</th>";
	echo "\t"."<th width='40'><font color='lime'><i>".$defenses_rank."</i></font></th>";
	echo "</tr>";
	
	next($order);
}
?>
</table>