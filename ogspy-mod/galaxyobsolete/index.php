<?php
/** $Id: galaxy_obsolete.php 4417 2008-11-16 15:37:51Z Sylar $ **/
/**
* Affichage des galaxies obsoletes
* @package OGSpy
* @subpackage main
* @author Kyser
* @copyright Copyright &copy; 2007, http://ogsteam.fr/
* @version 4.00 ($Rev: 4417 $)
* @modified $Date: 2008-11-16 16:37:51 +0100 (dim. 16 nov. 2008) $
* @link $HeadURL: http://svn.ogsteam.fr/OGSpy/trunk/views/galaxy_obsolete.php $
*/
if (!defined('IN_SPYOGAME')) die("Hacking attempt");
require_once("mod/{$val['root']}/common.php");
lang_init_module($mod_name);

$obsolete_listing = galaxy_obsolete();
if (!isset($pub_since)) $pub_since = 0;
if (!isset($pub_perimeter)) $pub_perimeter = 1;
if (!isset($pub_typesearch)) $pub_typesearch = "P";

$since = $pub_since;
$perimeter = $pub_perimeter;
$typesearch = $pub_typesearch;

require_once("views/page_header.php");
?>

<table border="1">
<form method="POST" action="index.php?action=galaxy_obsolete">
<tr>
	<td class="c" colspan="2"><?php echo T_("galaxyobsolete_HeadTitle");?></td>
</tr>
<tr>
	<th colspan="2">
		<select name="perimeter">
			<?php 
				for ($i=1; $i<=intval($server_config['num_of_galaxies']) ; $i++)
					print "<option value=\"$i\"". ($perimeter == $i ? '"selected"' : '') .">".L_('common_Galaxy')." $i</option>"; 
			?>
			<option value="0" <?php if ($perimeter == 0) echo "selected";?>><?php echo T_("galaxyobsolete_AllUniverse");?></option>
		</select>
		&nbsp;&nbsp;
		<?php echo T_("galaxyobsolete_since");?>
		&nbsp;&nbsp;
		<select name="since">
			<option value="56" <?php echo ($since==56?"selected>":">").T_("galaxyobsolete_Week", 8);?></option>
			<option value="42" <?php echo ($since==42?"selected>":">").T_("galaxyobsolete_Week", 6);?></option>
			<option value="28" <?php echo ($since==28?"selected>":">").T_("galaxyobsolete_Week", 4);?></option>
			<option value="21" <?php echo ($since==21?"selected>":">").T_("galaxyobsolete_Week", 3);?></option>
			<option value="14" <?php echo ($since==14?"selected>":">").T_("galaxyobsolete_Week", 2);?></option>
			<option value="7" <?php echo ($since==7?"selected>":">").T_("galaxyobsolete_Week", 1);?></option>
		</select>
		&nbsp;&nbsp;
	</th>
</tr>
<tr>
	<th width="50%"><input type="radio" name="typesearch" value="P" <?php if ($typesearch == "P") echo "checked";?>> <?php echo T_("galaxyobsolete_ShowPlanets");?></th>
	<th width="50%"><input type="radio" name="typesearch" value="M" <?php if ($typesearch == "M") echo "checked";?>> <?php echo T_("galaxyobsolete_ShowMoons");?></th>
</tr>
<tr><th colspan="2"><input type="submit" value="Rechercher"></th></tr>
</form>
</table>
<br><br>
<?php
if ($since >= 56) {
?>
<table>
<tr><td class="c" colspan="8"><?php echo T_("galaxyobsolete_IntervalMax", 8);?></td></tr>
<tr>
	<td class="c" width="110"><?php echo T_("galaxyobsolete_SolarSystem");?></td>
	<td class="c" width="110"><?php echo T_("galaxyobsolete_UpdateDate");?></td>
	<td class="c" width="110"><?php echo T_("galaxyobsolete_SolarSystem");?></td>
	<td class="c" width="110"><?php echo T_("galaxyobsolete_UpdateDate");?></td>
	<td class="c" width="110"><?php echo T_("galaxyobsolete_SolarSystem");?></td>
	<td class="c" width="110"><?php echo T_("galaxyobsolete_UpdateDate");?></td>
	<td class="c" width="110"><?php echo T_("galaxyobsolete_SolarSystem");?></td>
	<td class="c" width="110"><?php echo T_("galaxyobsolete_UpdateDate");?></td>
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
			echo "<th colspan='4'><font color='orange'><i>".T_("galaxyobsolete_limite50sys")."</i></font></th>";
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
<tr><td class="c" colspan="8"><?php echo T_("galaxyobsolete_IntervalMax", 6);?></td></tr>
<tr>
	<td class="c" width="110"><?php echo T_("galaxyobsolete_SolarSystem");?></td>
	<td class="c" width="110"><?php echo T_("galaxyobsolete_UpdateDate");?></td>
	<td class="c" width="110"><?php echo T_("galaxyobsolete_SolarSystem");?></td>
	<td class="c" width="110"><?php echo T_("galaxyobsolete_UpdateDate");?></td>
	<td class="c" width="110"><?php echo T_("galaxyobsolete_SolarSystem");?></td>
	<td class="c" width="110"><?php echo T_("galaxyobsolete_UpdateDate");?></td>
	<td class="c" width="110"><?php echo T_("galaxyobsolete_SolarSystem");?></td>
	<td class="c" width="110"><?php echo T_("galaxyobsolete_UpdateDate");?></td>
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
			echo "<th colspan='4'><font color='orange'><i>".T_("galaxyobsolete_limite50sys")."</i></font></th>";
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
<tr><td class="c" colspan="8"><?php echo T_("galaxyobsolete_IntervalMax", 4);?></td></tr>
<tr>
	<td class="c" width="110"><?php echo T_("galaxyobsolete_SolarSystem");?></td>
	<td class="c" width="110"><?php echo T_("galaxyobsolete_UpdateDate");?></td>
	<td class="c" width="110"><?php echo T_("galaxyobsolete_SolarSystem");?></td>
	<td class="c" width="110"><?php echo T_("galaxyobsolete_UpdateDate");?></td>
	<td class="c" width="110"><?php echo T_("galaxyobsolete_SolarSystem");?></td>
	<td class="c" width="110"><?php echo T_("galaxyobsolete_UpdateDate");?></td>
	<td class="c" width="110"><?php echo T_("galaxyobsolete_SolarSystem");?></td>
	<td class="c" width="110"><?php echo T_("galaxyobsolete_UpdateDate");?></td>
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
			echo "<th colspan='4'><font color='orange'><i>".T_("galaxyobsolete_limite50sys")."</i></font></th>";
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
<tr><td class="c" colspan="8"><?php echo T_("galaxyobsolete_IntervalMax", 3);?></td></tr>
<tr>
	<td class="c" width="110"><?php echo T_("galaxyobsolete_SolarSystem");?></td>
	<td class="c" width="110"><?php echo T_("galaxyobsolete_UpdateDate");?></td>
	<td class="c" width="110"><?php echo T_("galaxyobsolete_SolarSystem");?></td>
	<td class="c" width="110"><?php echo T_("galaxyobsolete_UpdateDate");?></td>
	<td class="c" width="110"><?php echo T_("galaxyobsolete_SolarSystem");?></td>
	<td class="c" width="110"><?php echo T_("galaxyobsolete_UpdateDate");?></td>
	<td class="c" width="110"><?php echo T_("galaxyobsolete_SolarSystem");?></td>
	<td class="c" width="110"><?php echo T_("galaxyobsolete_UpdateDate");?></td>
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
			echo "<th colspan='4'><font color='orange'><font color='orange'><i>".T_("galaxyobsolete_limite50sys")."</i></font></font></th>";
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
<tr><td class="c" colspan="8"><?php echo T_("galaxyobsolete_IntervalMax", 2);?></td></tr>
<tr>
	<td class="c" width="110"><?php echo T_("galaxyobsolete_SolarSystem");?></td>
	<td class="c" width="110"><?php echo T_("galaxyobsolete_UpdateDate");?></td>
	<td class="c" width="110"><?php echo T_("galaxyobsolete_SolarSystem");?></td>
	<td class="c" width="110"><?php echo T_("galaxyobsolete_UpdateDate");?></td>
	<td class="c" width="110"><?php echo T_("galaxyobsolete_SolarSystem");?></td>
	<td class="c" width="110"><?php echo T_("galaxyobsolete_UpdateDate");?></td>
	<td class="c" width="110"><?php echo T_("galaxyobsolete_SolarSystem");?></td>
	<td class="c" width="110"><?php echo T_("galaxyobsolete_UpdateDate");?></td>
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
			echo "<th colspan='4'><font color='orange'><i>".T_("galaxyobsolete_limite50sys")."</i></font></th>";
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
<tr><td class="c" colspan="8"><?php echo T_("galaxyobsolete_IntervalMax", 1);?></td></tr>
<tr>
	<td class="c" width="110"><?php echo T_("galaxyobsolete_SolarSystem");?></td>
	<td class="c" width="110"><?php echo T_("galaxyobsolete_UpdateDate");?></td>
	<td class="c" width="110"><?php echo T_("galaxyobsolete_SolarSystem");?></td>
	<td class="c" width="110"><?php echo T_("galaxyobsolete_UpdateDate");?></td>
	<td class="c" width="110"><?php echo T_("galaxyobsolete_SolarSystem");?></td>
	<td class="c" width="110"><?php echo T_("galaxyobsolete_UpdateDate");?></td>
	<td class="c" width="110"><?php echo T_("galaxyobsolete_SolarSystem");?></td>
	<td class="c" width="110"><?php echo T_("galaxyobsolete_UpdateDate");?></td>
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
			echo "<th colspan='4'><font color='orange'><i>".T_("galaxyobsolete_limite50sys")."</i></font></th>";
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