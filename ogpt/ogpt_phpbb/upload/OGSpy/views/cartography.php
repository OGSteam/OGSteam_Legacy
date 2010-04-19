<?php
/***************************************************************************
*	filename	: cartography.php
*	desc.		:
*	Author		: Kyser - http://ogs.servebbs.net/
*	created		: 17/02/2006
*	modified	: 30/07/2006 00:00:00
***************************************************************************/

if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}

$step = 25;

$galaxy_ally_position = galaxy_ally_position($step);
$position = array_keys($galaxy_ally_position);
@list($ally_1, $ally_2, $ally_3) = array_keys($galaxy_ally_position);

$ally_list = galaxy_ally_listing();
$options_1 = "<option></option>"."\n";
$options_2 = "<option></option>"."\n";
$options_3 = "<option></option>"."\n";
foreach ($ally_list as $ally_name) {
	$selected_1 = $selected_2 = $selected_3 = "";
	if ($ally_name == $ally_1) $selected_1 = "selected";
	if ($ally_name == $ally_2) $selected_2 = "selected";
	if ($ally_name == $ally_3) $selected_3 = "selected";

	$options_1 .= "<option ".$selected_1.">".$ally_name."</option>"."\n";
	$options_2 .= "<option ".$selected_2.">".$ally_name."</option>"."\n";
	$options_3 .= "<option ".$selected_3.">".$ally_name."</option>"."\n";
}

require_once("views/page_header.php");
?>
<script language="JavaScript" src="js/autocomplete.js"></script>

<table>
<form method="POST" action="index.php?action=cartography">
<tr>
	<td class="c" align="center" colspan="2" width="300"><font color='Magenta'>Alliance I</font></td>
	<td class="c" align="center" colspan="2" width="300"><font color='Yellow'>Alliance II</font></td>
	<td class="c" align="center" colspan="2" width="300"><font color='Red'>Alliance III</font></td>
</tr>
<tr>
	<th width="125"><input type="text" name="select_ally_1" onkeyup="autoComplete(this,this.form.elements['ally_1'],'text',false)"></th>
	<th width="175"><select name="ally_1"><?php echo $options_1;?></select></th>
	<th width="125"><input type="text" name="select_ally_2" onkeyup="autoComplete(this,this.form.elements['ally_2'],'text',false)"></th>
	<th width="175"><select name="ally_2"><?php echo $options_2;?></select></th>
	<th width="125"><input type="text" name="select_ally_3" onkeyup="autoComplete(this,this.form.elements['ally_3'],'text',false)"></th>
	<th width="175"><select name="ally_3"><?php echo $options_3;?></select></th>
</tr>
<tr>
	<td class="c" colspan="6" align="center"><input type="submit" value="Afficher les positions"></td>
</tr>
</form>
</table>
<br />
<table border=\'1\'>
<tr>
	<td class="c" width="45">&nbsp;</td>
	<td class="c" width="60" colspan="3">G1</td>
	<td class="c" width="60" colspan="3">G2</td>
	<td class="c" width="60" colspan="3">G3</td>
	<td class="c" width="60" colspan="3">G4</td>
	<td class="c" width="60" colspan="3">G5</td>
	<td class="c" width="60" colspan="3">G6</td>
	<td class="c" width="60" colspan="3">G7</td>
	<td class="c" width="60" colspan="3">G8</td>
	<td class="c" width="60" colspan="3">G9</td>
	<td class="c" width="45">&nbsp;</td>
</tr>
<?php
for ($system=1 ; $system<=499 ; $system=$system+$step) {
	$up = $system+$step-1;
	if ($up > 499) $up = 499;

	echo "<tr>"."\n";
	echo "\t"."<td class='c' align='center' nowrap>".$system." - ".$up."</td>";
	for ($galaxy=1 ; $galaxy<=9 ; $galaxy++) {
		$nb_player = array("&nbsp;", "&nbsp;", "&nbsp;");
		$tooltip = array("", "", "");
		$i=0;
		foreach ($position as $ally_name) {
			if ($galaxy_ally_position[$ally_name][$galaxy][$system]["planet"] > 0) {
				$tooltip[$i] = "<table width=\'200\'>";
				$tooltip[$i] .= "<tr><td class=\'c\' colspan=\'2\' align=\'center\'>Joueur(s) présent(s)</td></tr>";
				$last_player = "";
				foreach ($galaxy_ally_position[$ally_name][$galaxy][$system]["population"] as $value) {
					$player = "";
					if ($last_player != $value["player"]) {
						$player = "<a href=\"index.php?action=search&type_search=player&string_search=".$value["player"]."&strict=on\">".$value["player"]."</a>";
					}
					$row = "<a href=\"index.php?action=galaxy&galaxy=".$value["galaxy"]."&system=".$value["system"]."\">".$value["galaxy"].":".$value["system"].":".$value["row"]."</a>";

					$tooltip[$i] .= "<tr><td class=\'c\' align=\'center\'>".$player."</td><th>".$row."</th></tr>";
					$last_player = $value["player"];
				}
				$tooltip[$i] .= "</table>";
				$tooltip[$i] = " onmouseover=\"this.T_WIDTH=210;this.T_TEMP=15000;return escape('".htmlentities($tooltip[$i])."')\"";

				$nb_player[$i] = $galaxy_ally_position[$ally_name][$galaxy][$system]["planet"];
			}
			$i++;
		}
		echo "\t"."<th width='20'><a style='cursor:pointer'".$tooltip[0]."><font color='magenta'>".$nb_player[0]."</font></a></th>"."\n";
		echo "\t"."<th width='20'><a style='cursor:pointer'".$tooltip[1]."><font color='yellow'>".$nb_player[1]."</font></a></th>"."\n";
		echo "\t"."<th width='20'><a style='cursor:pointer'".$tooltip[2]."><font color='red'>".$nb_player[2]."</font></a></th>"."\n";
	}
	echo "\t"."<td class='c' align='center' nowrap>".$system." - ".$up."</td>";
	echo "</tr>"."\n";
}
?>
<tr>
	<td class="c" width="45">&nbsp;</td>
	<td class="c" width="60" colspan="3">G1</td>
	<td class="c" width="60" colspan="3">G2</td>
	<td class="c" width="60" colspan="3">G3</td>
	<td class="c" width="60" colspan="3">G4</td>
	<td class="c" width="60" colspan="3">G5</td>
	<td class="c" width="60" colspan="3">G6</td>
	<td class="c" width="60" colspan="3">G7</td>
	<td class="c" width="60" colspan="3">G8</td>
	<td class="c" width="60" colspan="3">G9</td>
	<td class="c" width="45">&nbsp;</td>
</tr>
</table>
<?php
require_once("views/page_tail.php");
?>