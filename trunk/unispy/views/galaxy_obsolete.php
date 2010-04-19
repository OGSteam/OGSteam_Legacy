<?php
/***************************************************************************
*	filename	: galaxy_obsolete.php
*	desc.		:
*	Author		: Kyser - http://www.ogsteam.fr/
*	created		: 03/02/2006
*	modified	: 30/07/2006 00:00:00
***************************************************************************/

if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}

$obsolete_listing = galaxy_obsolete();
if (!isset($pub_since)) $pub_since = 0;
if (!isset($pub_perimeter)) $pub_perimeter = 1;
if (!isset($pub_typesearch)) $pub_typesearch = "P";

$since = $pub_since;
$perimeter = $pub_perimeter;
$typesearch = $pub_typesearch;

require_once("views/page_header.php");
?>

<table border="1" width="400">
<form method="POST" action="index.php?action=galaxy_obsolete">
<tr>
	<td class="c" colspan="2"><?php echo $LANG["galaxyobsolete_HeadTitle"];?></td>
</tr>
<tr>
	<th colspan="2">
		<select name="perimeter">
		<?php
for($i=1 ; $i <= $server_config["nb_galaxy"] ; $i++)
{
	?>
	<option value="<?php echo $i; ?>" <?php if ($perimeter == $i) echo "selected";?>><?php echo $LANG["univers_Galaxy"]." ".$i;?></option>
	<?php
}
?>
			<option value="0" <?php if ($perimeter == 0) echo "selected";?>><?php echo $LANG["galaxyobsolete_AllUniverse"];?></option>
		</select>
		&nbsp;&nbsp;
		depuis
		&nbsp;&nbsp;
		<select name="since">
			<option value="56" <?php if ($since == 56) echo "selected";?>>8 <?php echo $LANG["galaxyobsolete_Week"];?></option>
			<option value="42" <?php if ($since == 42) echo "selected";?>>6 <?php echo $LANG["galaxyobsolete_Week"];?></option>
			<option value="28" <?php if ($since == 28) echo "selected";?>>4 <?php echo $LANG["galaxyobsolete_Week"];?></option>
			<option value="21" <?php if ($since == 21) echo "selected";?>>3 <?php echo $LANG["galaxyobsolete_Week"];?></option>
			<option value="14" <?php if ($since == 14) echo "selected";?>>2 <?php echo $LANG["galaxyobsolete_Week"];?></option>
			<option value="7" <?php if ($since == 7) echo "selected";?>>1 <?php echo $LANG["galaxyobsolete_Week"];?></option>
		</select>
		&nbsp;&nbsp;
	</th>
</tr>
<tr><th colspan="2"><input type="submit" value="Rechercher"></th></tr>
</form>
</table>
<br><br>
<?php
if ($since >= 56) {
?>
<table>
<tr><td class="c" colspan="8"><?php echo sprintf($LANG["galaxyobsolete_IntervalMax"], 8);?></td></tr>
<tr>
	<td class="c" width="110"><?php echo $LANG["galaxyobsolete_SolarSystem"];?></td><td class="c" width="110"><?php echo $LANG["galaxyobsolete_UpdateDate"];?></td>
	<td class="c" width="110"><?php echo $LANG["galaxyobsolete_SolarSystem"];?></td><td class="c" width="110"><?php echo $LANG["galaxyobsolete_UpdateDate"];?></td>
	<td class="c" width="110"><?php echo $LANG["galaxyobsolete_SolarSystem"];?></td><td class="c" width="110"><?php echo $LANG["galaxyobsolete_UpdateDate"];?></td>
	<td class="c" width="110"><?php echo $LANG["galaxyobsolete_SolarSystem"];?></td><td class="c" width="110"><?php echo $LANG["galaxyobsolete_UpdateDate"];?></td>
</tr>
<?php
if (isset($obsolete_listing[56])) {
	$obsolete = $obsolete_listing[56];
	$i = $index = 0;
	foreach ($obsolete as $value) {
		$index++;
		if ($i==4) {
			$i=0;
			echo "</tr>"."\n";
			echo "<tr>";
		}
		if ($value["last_update"] != 0) $date = strftime("%d %b %Y %H:%M", $value["last_update"]);
		else $date = "-";
		$color = $i&1 ? "magenta" : "lime";

		$coordinates = $value["galaxy"].":".$value["system"];
		if ($typesearch == "M") $coordinates .= ":".$value["row"];
		echo "<th><font color='".$color."'>".$coordinates."</font></th><th><font color='".$color."'>".$date."</font></th>";
		$i++;

		if ($index == 50) {
			echo "<th colspan='4'><font color='orange'><i>Liste limitée à 50 systèmes</i></font></th>";
			$i=4;
			break;
		}
	}
	for ($i ; $i<4 ; $i++) {
		echo "<th>&nbsp;</th><th>&nbsp;</th>";
	}
}
?>
</table>
<br>
<?php
}

if ($since >= 42) {
?>
<table>
<tr><td class="c" colspan="8"><?php echo sprintf($LANG["galaxyobsolete_Interval"], 6, 8);?></td></tr>
<tr>
	<td class="c" width="110"><?php echo $LANG["galaxyobsolete_SolarSystem"];?></td><td class="c" width="110"><?php echo $LANG["galaxyobsolete_UpdateDate"];?></td>
	<td class="c" width="110"><?php echo $LANG["galaxyobsolete_SolarSystem"];?></td><td class="c" width="110"><?php echo $LANG["galaxyobsolete_UpdateDate"];?></td>
	<td class="c" width="110"><?php echo $LANG["galaxyobsolete_SolarSystem"];?></td><td class="c" width="110"><?php echo $LANG["galaxyobsolete_UpdateDate"];?></td>
	<td class="c" width="110"><?php echo $LANG["galaxyobsolete_SolarSystem"];?></td><td class="c" width="110"><?php echo $LANG["galaxyobsolete_UpdateDate"];?></td>
</tr>
<?php
if (isset($obsolete_listing[42])) {
	$obsolete = $obsolete_listing[42];
	$i = $index = 0;
	foreach ($obsolete as $value) {
		$index++;
		if ($i==4) {
			$i=0;
			echo "</tr>"."\n";
			echo "<tr>";
		}
		$date = strftime("%d %b %Y %H:%M", $value["last_update"]);
		$color = $i&1 ? "magenta" : "lime";

		$coordinates = $value["galaxy"].":".$value["system"];
		if ($typesearch == "M") $coordinates .= ":".$value["row"];
		echo "<th><font color='".$color."'>".$coordinates."</font></th><th><font color='".$color."'>".$date."</font></th>";
		$i++;

		if ($index == 50) {
			echo "<th colspan='4'><font color='orange'><i>Liste limitée à 50 systèmes</i></font></th>";
			$i=4;
			break;
		}
	}
	for ($i ; $i<4 ; $i++) {
		echo "<th>&nbsp;</th><th>&nbsp;</th>";
	}
}
?>
</table>
<br>
<?php
}

if ($since >= 28) {
?>
<table>
<tr><td class="c" colspan="8"><?php echo sprintf($LANG["galaxyobsolete_Interval"], 4, 6);?></td></tr>
<tr>
	<td class="c" width="110"><?php echo $LANG["galaxyobsolete_SolarSystem"];?></td><td class="c" width="110"><?php echo $LANG["galaxyobsolete_UpdateDate"];?></td>
	<td class="c" width="110"><?php echo $LANG["galaxyobsolete_SolarSystem"];?></td><td class="c" width="110"><?php echo $LANG["galaxyobsolete_UpdateDate"];?></td>
	<td class="c" width="110"><?php echo $LANG["galaxyobsolete_SolarSystem"];?></td><td class="c" width="110"><?php echo $LANG["galaxyobsolete_UpdateDate"];?></td>
	<td class="c" width="110"><?php echo $LANG["galaxyobsolete_SolarSystem"];?></td><td class="c" width="110"><?php echo $LANG["galaxyobsolete_UpdateDate"];?></td>
</tr>
<?php
if (isset($obsolete_listing[28])) {
	$obsolete = $obsolete_listing[28];
	$i = $index = 0;
	foreach ($obsolete as $value) {
		$index++;
		if ($i==4) {
			$i=0;
			echo "</tr>"."\n";
			echo "<tr>";
		}
		$date = strftime("%d %b %Y %H:%M", $value["last_update"]);
		$color = $i&1 ? "magenta" : "lime";

		$coordinates = $value["galaxy"].":".$value["system"];
		if ($typesearch == "M") $coordinates .= ":".$value["row"];
		echo "<th><font color='".$color."'>".$coordinates."</font></th><th><font color='".$color."'>".$date."</font></th>";
		$i++;

		if ($index == 50) {
			echo "<th colspan='4'><font color='orange'><i>Liste limitée à 50 systèmes</i></font></th>";
			$i=4;
			break;
		}
	}
	for ($i ; $i<4 ; $i++) {
		echo "<th>&nbsp;</th><th>&nbsp;</th>";
	}
}
?>
</table>
<br>
<?php
}

if ($since >= 21) {
?>
<table>
<tr><td class="c" colspan="8"><?php echo sprintf($LANG["galaxyobsolete_Interval"], 3, 4);?></td></tr>
<tr>
	<td class="c" width="110"><?php echo $LANG["galaxyobsolete_SolarSystem"];?></td><td class="c" width="110"><?php echo $LANG["galaxyobsolete_UpdateDate"];?></td>
	<td class="c" width="110"><?php echo $LANG["galaxyobsolete_SolarSystem"];?></td><td class="c" width="110"><?php echo $LANG["galaxyobsolete_UpdateDate"];?></td>
	<td class="c" width="110"><?php echo $LANG["galaxyobsolete_SolarSystem"];?></td><td class="c" width="110"><?php echo $LANG["galaxyobsolete_UpdateDate"];?></td>
	<td class="c" width="110"><?php echo $LANG["galaxyobsolete_SolarSystem"];?></td><td class="c" width="110"><?php echo $LANG["galaxyobsolete_UpdateDate"];?></td>
</tr>
<?php
if (isset($obsolete_listing[21])) {
	$obsolete = $obsolete_listing[21];
	$i = $index = 0;
	foreach ($obsolete as $value) {
		$index++;
		if ($i==4) {
			$i=0;
			echo "</tr>"."\n";
			echo "<tr>";
		}
		$date = strftime("%d %b %Y %H:%M", $value["last_update"]);
		$color = $i&1 ? "magenta" : "lime";

		$coordinates = $value["galaxy"].":".$value["system"];
		if ($typesearch == "M") $coordinates .= ":".$value["row"];
		echo "<th><font color='".$color."'>".$coordinates."</font></th><th><font color='".$color."'>".$date."</font></th>";
		$i++;

		if ($index == 50) {
			echo "<th colspan='4'><font color='orange'><font color='orange'><i>Liste limitée à 50 systèmes</i></font></font></th>";
			$i=4;
			break;
		}
	}
	for ($i ; $i<4 ; $i++) {
		echo "<th>&nbsp;</th><th>&nbsp;</th>";
	}
}
?>
</table>
<br>
<?php
}

if ($since >= 14) {
?>
<table>
<tr><td class="c" colspan="8"><?php echo sprintf($LANG["galaxyobsolete_Interval"], 2, 3);?></td></tr>
<tr>
	<td class="c" width="110"><?php echo $LANG["galaxyobsolete_SolarSystem"];?></td><td class="c" width="110"><?php echo $LANG["galaxyobsolete_UpdateDate"];?></td>
	<td class="c" width="110"><?php echo $LANG["galaxyobsolete_SolarSystem"];?></td><td class="c" width="110"><?php echo $LANG["galaxyobsolete_UpdateDate"];?></td>
	<td class="c" width="110"><?php echo $LANG["galaxyobsolete_SolarSystem"];?></td><td class="c" width="110"><?php echo $LANG["galaxyobsolete_UpdateDate"];?></td>
	<td class="c" width="110"><?php echo $LANG["galaxyobsolete_SolarSystem"];?></td><td class="c" width="110"><?php echo $LANG["galaxyobsolete_UpdateDate"];?></td>
</tr>
<?php
if (isset($obsolete_listing[14])) {
	$obsolete = $obsolete_listing[14];
	$i = $index = 0;
	foreach ($obsolete as $value) {
		$index++;
		if ($i==4) {
			$i=0;
			echo "</tr>"."\n";
			echo "<tr>";
		}
		$date = strftime("%d %b %Y %H:%M", $value["last_update"]);
		$color = $i&1 ? "magenta" : "lime";

		$coordinates = $value["galaxy"].":".$value["system"];
		if ($typesearch == "M") $coordinates .= ":".$value["row"];
		echo "<th><font color='".$color."'>".$coordinates."</font></th><th><font color='".$color."'>".$date."</font></th>";
		$i++;

		if ($index == 50) {
			echo "<th colspan='4'><font color='orange'><i>Liste limitée à 50 systèmes</i></font></th>";
			$i=4;
			break;
		}
	}
	for ($i ; $i<4 ; $i++) {
		echo "<th>&nbsp;</th><th>&nbsp;</th>";
	}
}
?>
</table>
<br>
<?php
}

if ($since >= 7) {
?>
<table>
<tr><td class="c" colspan="8"><?php echo sprintf($LANG["galaxyobsolete_Interval"], 1, 2);?></td></tr>
<tr>
	<td class="c" width="110"><?php echo $LANG["galaxyobsolete_SolarSystem"];?></td><td class="c" width="110"><?php echo $LANG["galaxyobsolete_UpdateDate"];?></td>
	<td class="c" width="110"><?php echo $LANG["galaxyobsolete_SolarSystem"];?></td><td class="c" width="110"><?php echo $LANG["galaxyobsolete_UpdateDate"];?></td>
	<td class="c" width="110"><?php echo $LANG["galaxyobsolete_SolarSystem"];?></td><td class="c" width="110"><?php echo $LANG["galaxyobsolete_UpdateDate"];?></td>
	<td class="c" width="110"><?php echo $LANG["galaxyobsolete_SolarSystem"];?></td><td class="c" width="110"><?php echo $LANG["galaxyobsolete_UpdateDate"];?></td>
</tr>
<?php
if (isset($obsolete_listing[7])) {
	$obsolete = $obsolete_listing[7];
	$i = $index = 0;
	foreach ($obsolete as $value) {
		$index++;
		if ($i==4) {
			$i=0;
			echo "</tr>"."\n";
			echo "<tr>";
		}
		$date = strftime("%d %b %Y %H:%M", $value["last_update"]);
		$color = $i&1 ? "magenta" : "lime";

		$coordinates = $value["galaxy"].":".$value["system"];
		if ($typesearch == "M") $coordinates .= ":".$value["row"];
		echo "<th><font color='".$color."'>".$coordinates."</font></th><th><font color='".$color."'>".$date."</font></th>";
		$i++;

		if ($index == 50) {
			echo "<th colspan='4'><font color='orange'><i>Liste limitée à 50 systèmes</i></font></th>";
			$i=4;
			break;
		}
	}
	for ($i ; $i<4 ; $i++) {
		echo "<th>&nbsp;</th><th>&nbsp;</th>";
	}
}
?>
</table>
<?php
}
?>
<?php
require_once("views/page_tail.php");
?>