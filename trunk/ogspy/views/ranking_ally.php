<?php/****************************************************************************	filename	: ranking_ally.php*	desc.		:*	Author		: Kyser - http://ogsteam.fr/*	created		: 06/05/2006*	modified	: 22/08/2006 00:00:00***************************************************************************/if (!defined('IN_SPYOGAME')) {	die("Hacking attempt");}list($order, $ranking, $ranking_available, $maxrank) = galaxy_show_ranking_ally();$order_by = $pub_order_by;$interval = $pub_interval;if (!empty($pub_suborder)) $suborder = $pub_suborder; else $suborder = "rank"; $tooltip = "<table width=\"120\">";$tooltip .= "<tr><td class=\"c\"><a href=\"index.php?action=ranking&subaction=ally&order_by=type\">Tri global</a></td></tr>";$tooltip .= "<tr><td class=\"c\"><a href=\"index.php?action=ranking&subaction=ally&order_by=type&suborder=member\">Tri par membre</a></td></tr>";$tooltip .= "</table>";$tooltip = htmlentities($tooltip);      $link_general = "<a href=\"index.php?action=ranking&subaction=ally&order_by=general\" onmouseover=\"this.T_WIDTH=120;return escape('".str_replace("type", "general", $tooltip)."')\">G�n�ral</a>";    $link_eco = "<a href=\"index.php?action=ranking&subaction=ally&order_by=eco\" onmouseover=\"this.T_WIDTH=120;return escape('".str_replace("type", "eco", $tooltip)."')\">Economique</a>";    $link_techno = "<a href=\"index.php?action=ranking&subaction=ally&order_by=techno\" onmouseover=\"this.T_WIDTH=120;return escape('".str_replace("type", "techno", $tooltip)."')\">Recherche</a>";      $link_military = "<a href=\"index.php?action=ranking&subaction=ally&order_by=military\" onmouseover=\"this.T_WIDTH=120;return escape('".str_replace("type", "military", $tooltip)."')\">Militaire</a>";    $link_military_l = "<a href=\"index.php?action=ranking&subaction=ally&order_by=military_l\" onmouseover=\"this.T_WIDTH=120;return escape('".str_replace("type", "military_l", $tooltip)."')\">Perte militaire</a>";  $link_military_d = "<a href=\"index.php?action=ranking&subaction=ally&order_by=military_d\" onmouseover=\"this.T_WIDTH=120;return escape('".str_replace("type", "military_d", $tooltip)."')\">destruction</a>";    $link_honnor = "<a href=\"index.php?action=ranking&subaction=ally&order_by=honnor\" onmouseover=\"this.T_WIDTH=120;return escape('".str_replace("type", "honnor", $tooltip)."')\">honorifique</a>";switch ($order_by) {	case "general": $link_general = str_replace("G�n�ral", "<img src='images/asc.png'>&nbsp;G�n�ral&nbsp;<img src='images/asc.png'>", $link_general);break;    case "eco": $link_eco = str_replace("Economique", "<img src='images/asc.png'>&nbsp;Economique&nbsp;<img src='images/asc.png'>", $link_eco);break;   	case "techno": $link_techno = str_replace("Recherche", "<img src='images/asc.png'>&nbsp;Recherche&nbsp;<img src='images/asc.png'>", $link_techno);break;  case "military": $link_military = str_replace("Militaire", "<img src='images/asc.png'>&nbsp;Militaire&nbsp;<img src='images/asc.png'>", $link_military);break;	case "military_l": $link_military_l = str_replace("Perte militaire", "<img src='images/asc.png'>&nbsp;Perte militaire&nbsp;<img src='images/asc.png'>", $link_military_l);break;   case "military_d": $link_military_d = str_replace("destruction", "<img src='images/asc.png'>&nbsp;destruction&nbsp;<img src='images/asc.png'>", $link_military_d);break;    case "honnor": $link_honnor = str_replace("honorifique", "<img src='images/asc.png'>&nbsp;honorifique&nbsp;<img src='images/asc.png'>", $link_honnor);break;}          ////   le formulaire si dessous avec les trois traitements php empeche la page de s afficher   \\\\\///     easy php mal parametrer ????????????????????????????????????????????????????????????,   \\\///   d�sactivation tmporaire pour traiter les classements                                       \\\\          ?><!--<table><tr>	<form method="POST" action="index.php">	<input type="hidden" name="action" value="ranking">	<input type="hidden" name="subaction" value="ally">	<input type="hidden" name="order_by" value="<?php echo $order_by;?>">	<input type="hidden" name="suborder" value="<?php echo $suborder;?>">	<td align="right">		<select name="date" onchange="this.form.submit();">--><?php////foreach ($ranking_available as $v) {//	$selected = "";//	if (!isset($pub_date_selected) && !isset($datadate)) {//		$datadate = $v;//		$date_selected = strftime("%d %b %Y %Hh", $v);//	}//	if ($pub_date == $v) {//		$selected = "selected";//		$datadate = $v;//		$date_selected = strftime("%d %b %Y %Hh", $v);//	}//	$string_date = strftime("%d %b %Y %Hh", $v);//	echo "\t\t\t"."<option value='".$v."' ".$selected.">".$string_date."</option>"."\n";//}// ?>	<!--	</select>		&nbsp;		<select name="interval" onchange="this.form.submit();">  --><?php //if (sizeof($ranking_available) > 0) {//	for ($i=1 ; $i<=$maxrank ; $i=$i+100) {//		$selected = "";//		if ($i == $interval) $selected = "selected";//		echo "\t\t\t"."<option value='".$i."' ".$selected.">".$i." - ".($i+99)."</option>"."\n";//	}//}//?><!--		</select>	</td>	</form>--><?php  //if ($user_data["user_admin"] == 1 || $user_data["user_coadmin"] == 1 || $user_data["management_ranking"] == 1) {?><!--	<form method="POST" action="index.php" onsubmit="return confirm('Etes-vous s�r de vouloir supprimer ce classement ?');">	<input type="hidden" name="action" value="drop_ranking">	<input type="hidden" name="subaction" value="ally">	<input type="hidden" name="datadate" value="<?php echo $datadate;?>">	<td align="right"><input type="image" src="images/drop.png" title="Supprimer le classement du <?php echo $date_selected;?>"></td>	</form>--><?php //}?><!--</tr></table>--><?php////////////////////////////////////////////////////////////////////////////////////////////////////////                                                fin desactivation temporaire                \\\\\////////////////////////////////////////////////////////////////////////////////////////////////////?><table width="1200"><tr>	<td class="c" width="30">Place</td>	<td class="c">Alliance</td>	<td class="c">Memb.</td>	<td class="c_classement_points" colspan="2"><?php echo $link_general;?></td>	<td class="c" colspan="2"><?php echo $link_eco;?></td>	<td class="c_classement_recherche" colspan="2"><?php echo $link_techno;?></td>    <td class="c_classement_flotte" colspan="2"><?php echo $link_military;?></td>	<td class="c_classement_flotte" colspan="2"><?php echo $link_military_l;?></td>	<td class="c_classement_flotte" colspan="2"><?php echo $link_military_d;?></td>    <td class="c" colspan="2"><?php echo $link_honnor;?></td></tr><?php$index = $interval;while ($value = current($order)) {	$ally = "<a href='index.php?action=search&type_search=ally&string_search=".$value."&strict=on'>";	$ally .= $value;	$ally .= "</a>";	$member = formate_number($ranking[$value]["number_member"]);  	$general_pts = "&nbsp;";	$general_pts_per_member = "&nbsp;";	$general_rank = "&nbsp;";	$techno_pts = "&nbsp;";	$techno_pts_per_member = "&nbsp;";	$techno_rank = "&nbsp;";	$eco_pts = "&nbsp;";	$eco_pts_per_member = "&nbsp;";	$eco_rank = "&nbsp;";    $military_pts = "&nbsp;";	$military_pts_per_member = "&nbsp;";	$military_rank = "&nbsp;";	$military_l_pts = "&nbsp;";	$military_l_pts_per_member = "&nbsp;";	$military_l_rank = "&nbsp;";	$military_d_pts = "&nbsp;";	$military_d_pts_per_member = "&nbsp;";	$military_d_rank = "&nbsp;";    $honnor_pts = "&nbsp;";	$honnor_pts_per_member = "&nbsp;";	$honnor_rank = "&nbsp;";	if (isset($ranking[$value]["general"]["points"])) {		$general_pts = formate_number($ranking[$value]["general"]["points"]);		$general_pts_per_member = formate_number($ranking[$value]["general"]["points_per_member"]);		$general_rank = formate_number($ranking[$value]["general"]["rank"]);	}	if (isset($ranking[$value]["eco"]["points"])) {		$eco_pts = formate_number($ranking[$value]["eco"]["points"]);		$eco_pts_per_member = formate_number($ranking[$value]["eco"]["points_per_member"]);		$eco_rank = formate_number($ranking[$value]["eco"]["rank"]);	}	if (isset($ranking[$value]["techno"]["points"])) {		$techno_pts = formate_number($ranking[$value]["techno"]["points"]);		$techno_pts_per_member = formate_number($ranking[$value]["techno"]["points_per_member"]);		$techno_rank = formate_number($ranking[$value]["techno"]["rank"]);	}	if (isset($ranking[$value]["military"]["points"])) {		$military_pts = formate_number($ranking[$value]["military"]["points"]);		$military_pts_per_member = formate_number($ranking[$value]["military"]["points_per_member"]);		$military_rank = formate_number($ranking[$value]["military"]["rank"]);	}	if (isset($ranking[$value]["military_l"]["points"])) {		$military_l_pts = formate_number($ranking[$value]["military_l"]["points"]);		$military_l_pts_per_member = formate_number($ranking[$value]["military_l"]["points_per_member"]);		$military_l_rank = formate_number($ranking[$value]["military_l"]["rank"]);	}	if (isset($ranking[$value]["military_d"]["points"])) {		$military_d_pts = formate_number($ranking[$value]["military_d"]["points"]);		$military_d_pts_per_member = formate_number($ranking[$value]["military_d"]["points_per_member"]);		$military_d_rank = formate_number($ranking[$value]["military_d"]["rank"]);	}        if (isset($ranking[$value]["honnor"]["points"])) {		$honnor_pts = formate_number($ranking[$value]["honnor"]["points"]);		$honnor_pts_per_member = formate_number($ranking[$value]["honnor"]["points_per_member"]);		$honnor_rank = formate_number($ranking[$value]["honnor"]["rank"]);	}	echo "<tr>";	echo "\t"."<th>".formate_number($index)."</th>";	echo "\t"."<th>".$ally."</th>";	echo "\t"."<th>".$member."</th>";	echo "\t"."<th width='100'>".$general_pts."<br />(<font color='yellow'><i>".$general_pts_per_member."</i></font>)</th>";	echo "\t"."<th width='40'><font color='lime'><i>".$general_rank."</i></font></th>";    echo "\t"."<th width='100'>".$eco_pts."<br />(<font color='yellow'><i>".$eco_pts_per_member."</i></font>)</th>";	echo "\t"."<th width='40'><font color='lime'><i>".$eco_rank."</i></font></th>";    echo "\t"."<th width='100'>".$techno_pts."<br />(<font color='yellow'><i>".$techno_pts_per_member."</i></font>)</th>";	echo "\t"."<th width='40'><font color='lime'><i>".$techno_rank."</i></font></th>";    echo "\t"."<th width='100'>".$military_pts."<br />(<font color='yellow'><i>".$military_pts_per_member."</i></font>)</th>";	echo "\t"."<th width='40'><font color='lime'><i>".$military_rank."</i></font></th>";    echo "\t"."<th width='100'>".$military_l_pts."<br />(<font color='yellow'><i>".$military_l_pts_per_member."</i></font>)</th>";	echo "\t"."<th width='40'><font color='lime'><i>".$military_l_rank."</i></font></th>";    echo "\t"."<th width='100'>".$military_d_pts."<br />(<font color='yellow'><i>".$military_d_pts_per_member."</i></font>)</th>";	echo "\t"."<th width='40'><font color='lime'><i>".$military_d_rank."</i></font></th>";    echo "\t"."<th width='100'>".$honnor_pts."<br />(<font color='yellow'><i>".$honnor_pts_per_member."</i></font>)</th>";	echo "\t"."<th width='40'><font color='lime'><i>".$honnor_rank."</i></font></th>";	echo "</tr>";	$index++;	next($order);}?></table>