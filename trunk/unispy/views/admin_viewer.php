<?php
/***************************************************************************
*	filename	: viewer.php
*	desc.		:
*	Author		: Kyser - http://www.ogsteam.fr/
*	created		: 16/12/2005
*	modified	: 06/08/2006 11:40:18
***************************************************************************/

if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}

if ($user_data["user_admin"] != 1 && $user_data["user_coadmin"] != 1) {
	redirection("index.php?action=message&id_message=forbidden&info");
}

//Définition de la date sélectionné
if (!isset($pub_show)) $show = date("y~m~d");
else $show = $pub_show;

if (sizeof(explode("~", $show)) != 3) {
	$show =date("y~m~d");
}
list($show_year, $show_month, $show_day) = explode("~", $show);
if (!checkdate($show_month, $show_day, $show_year)) {
	list($show_year, $show_month, $show_day) = explode("~", date("y~m~d"));
}
$show = $show_year.$show_month.$show_day;

if (!isset($pub_typelog)) {
	$typelog = "log";
}
else {
	if (check_var($pub_typelog, "Char")) $typelog = $pub_typelog;
	else $typelog = "log";
}
if ($typelog != "log" && $typelog != "sql") {
	$typelog = "log";
}
if ($typelog == "log") $file = $typelog."_".$show.".log";
if ($typelog == "sql") $file = $typelog."_".$show.".sql";

//Récupération du log
$dir = $show;
$file = PATH_LOG.$dir."/".$file;

if (file_exists($file)) $log = file($file);
else $log = array($LANG["adminviewer_NoData"]);

echo "<a>".sprintf($LANG["adminviewer_SelectedDate"], strftime("%d %b %Y", mktime(0, 0, 0, $show_month, $show_day, $show_year)))."</a>";
?>

<table width="100%">
<tr>
	<td class="c" colspan="12"><?php echo $LANG["adminviewer_SelectedMonth"];?></th>
</tr>
<?php
$date = mktime(0, 0, 0, date("n"), 1) - 60*60*24*365;
echo "<tr>";
for ($i=0 ; $i<12 ; $i++) {
	$date += 60*60*24*31;
	$show = date("y~m", $date)."~".$show_day;

	if ($show == $show_year."~".$show_month."~".$show_day) {
		echo "\t"."<th width='16%'><a>".strftime("%B %Y", $date)."</a></th>";

		echo "\t"."<th>";
		if (log_check_exist(date("ym", $date))) {
			echo "<input type='image' src='images/save.png' onclick=\"window.location = 'index.php?action=extractor&date=".date("ym", $date)."'\" title='".sprintf($LANG["adminviewer_GetLog"], strftime("%B %Y", $date))."'></font>";
		}
		else echo "&nbsp;";
		echo "</th>"."\n";
	}
	else {
		echo "\t"."<th width='16%' onclick=\"window.location = 'index.php?action=administration&subaction=viewer&show=".$show."&typelog=".$typelog."';\">";
		echo "<a style='cursor:pointer'><font color='lime'>".strftime("%B %Y", $date)."</font></a>";
		echo "</th>"."\n";

		echo "\t"."<th>";
		if (log_check_exist(date("ym", $date))) {
			echo "<input type='image' src='images/save.png' onclick=\"window.location = 'index.php?action=extractor&date=".date("ym", $date)."'\" title='".sprintf($LANG["adminviewer_GetLog"], strftime("%B %Y", $date))."'></font>";
		}
		else echo "&nbsp;";
		echo "</th>"."\n";
	}
	if ($i==5) echo "</tr>"."\n"."<tr>";
}
echo "</tr>";
?>
</table>

<br />
<table width="100%">
<tr>
	<td class="c" colspan="20"><?php echo $LANG["adminviewer_SelectedDay"];?></th>
</tr>
<?php
$max_day = date("d");
if (intval($show_month) != date("m")) $max_day = date("t", mktime(0, 0, 0, $show_month, 1, $show_year));

echo "<tr>";
for ($i=1 ; $i<=$max_day ; $i++) {
	$day = $i;
	if ($i<10) $day = "0".$i;
	$show = $show_year."~".$show_month."~".$day;
	$date = mktime(0, 0, 0, $show_month, $day, $show_year);

	if ($show == $show_year."~".$show_month."~".$show_day) {
		echo "\t"."<th width='10%'><a>".$day."</a></th>";

		echo "\t"."<th>";
		if (log_check_exist($show_year.$show_month.$day)) {
			echo "<input type='image' src='images/save.png' onclick=\"window.location = 'index.php?action=extractor&date=".$show_year.$show_month.$day."'\" title='".sprintf($LANG["adminviewer_GetLog"], strftime("%B %Y", $date))."'>";
		}
		else echo "&nbsp;";
		echo "</th>"."\n";
	}
	else {
		echo "\t"."<th width='10%' onclick=\"window.location='index.php?action=administration&subaction=viewer&show=".$show."&typelog=".$typelog."';\">";
		echo "<a style='cursor:pointer'><font color='lime'>".$day."</font></a>";
		echo "</th>";

		echo "\t"."<th>";
		if (log_check_exist($show_year.$show_month.$day)) {
			echo "<input type='image' src='images/save.png' onclick=\"window.location = 'index.php?action=extractor&date=".$show_year.$show_month.$day."'\" title='".sprintf($LANG["adminviewer_GetLog2"], strftime("%d %B %Y", $date))."'>";
		}
		else echo "&nbsp;";
		echo "</th>"."\n";
	}
	if ($i%10 == 0) echo "</tr>"."\n"."<tr>";
}
$j=1;
while (($i-1)%10 != 0) {
	echo "<th>&nbsp;</th>";
	echo "<th>&nbsp;</th>";
	$i++;
}
echo "</tr>";
?>
</table>

<br />
<table width="100%">
<tr>
	<td class="c" colspan="3"><?php echo $LANG["adminviewer_SelectedLog"];?></td>
</tr>
<?php
$show = $show_year."~".$show_month."~".$show_day;
echo "<tr>";
if ($typelog == "log") {
	echo "\t"."<th width='50%'><a>".$LANG["adminviewer_GeneralLog"]."</a></td>";
	echo "\t"."<th width='50%' onclick=\"window.location = 'index.php?action=administration&subaction=viewer&show=".$show."&typelog=sql';\"><a style='cursor:pointer'><font color='lime'>".$LANG["adminviewer_SQLLog"]."</font></a></td>";
}
else {
	echo "\t"."<th width='50%' onclick=\"window.location = 'index.php?action=administration&subaction=viewer&show=".$show."&typelog=log';\"><a style='cursor:pointer'><font color='lime'>".$LANG["adminviewer_GeneralLog"]."</font></a></td>";
	echo "\t"."<th width='50%'><a>".$LANG["adminviewer_SQLLog"]."</a></td>";
}
echo "</tr>";
?>
<tr>
	<td><font color="Red"><i><?php echo $LANG["adminviewer_Notice"];?></i></font></td>
</tr>
</table>

<br />
<table width="100%">
<tr>
	<td class="l" colspan="3"><b><?php echo $LANG["adminviewer_Viewer"];?></b> <i><font color="red"><b><?php echo $typelog == "log" ? $LANG["adminviewer_GeneralLog"] : $LANG["adminviewer_SQLLog"];?></b></font></i><br>
<?php
end($log);
while ($line = current($log)) {
	$line = trim(nl2br(htmlspecialchars($line)));
	$line = preg_replace("#/\*(.*)\*/#", "<font color='orange'>$1 : </font>", $line);

	echo $line;
	prev($log);
}
?>
	</td>
</tr>
</table>