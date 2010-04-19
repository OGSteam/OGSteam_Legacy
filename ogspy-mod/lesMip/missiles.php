<?php
/**
* missiles.php Affiche la portée des missiles interplanétaires
* @package [MOD] Tout sur les MIP
* @author Bartheleway <contactbarthe@g.q-le-site.webou.net>
* @version 0.4d
* created	: 03/02/2007
* modified	: 16/04/2008
*/

if (!defined('IN_SPYOGAME')) die("Hacking attempt");

require_once("./views/page_header.php");

$query = "SELECT `active` FROM `".TABLE_MOD."` WHERE `action`='lesmip' AND `active`='1' LIMIT 1";
if (!$db->sql_numrows($db->sql_query($query))) die("Hacking attempt");

$step = 1;
$nb_colonnes_ally = 3;

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

$galaxy_num = 0;
for ($i = 1; $i <= 9; $i++) {
	if (!empty($pub_num[$i]) AND $pub_num[$i] == 1) {
		$galaxy_num = $galaxy_num + 1;
		$dernier = $i;
	}
}
if ($galaxy_num == 1) {
	for ($i = 1; $i <= 9; $i++) {
		if (!empty($pub_num[$i]) AND $pub_num[$i] == 1) {
			$galaxy = $i;
		}
	}
}
?>
<script language="JavaScript" src="js/autocomplete.js"></script>
<table>
<form method="post" action="?action=lesmip&sub=porte">
<tr>
	<td class="c" align="center" colspan="2" width="300"><font color='Magenta'><?php echo $lang['lesmip_missiles_ally1']; ?></font></td>
	<td class="c" align="center" colspan="2" width="300"><font color='Yellow'><?php echo $lang['lesmip_missiles_ally2']; ?></font></td>
	<td class="c" align="center" colspan="2" width="300"><font color='Red'><?php echo $lang['lesmip_missiles_ally3']; ?></font></td>
</tr>
<tr>
	<th width="125"><input type="text" name="select_ally_[1]" onkeyup="autoComplete(this,this.form.elements['ally_[1]'],'text',false)"></th>
	<th width="175"><select name="ally_[1]"><?php echo $options_1;?></select></th>
	<th width="125"><input type="text" name="select_ally_[2]" onkeyup="autoComplete(this,this.form.elements['ally_[2]'],'text',false)"></th>
	<th width="175"><select name="ally_[2]"><?php echo $options_2;?></select></th>
	<th width="125"><input type="text" name="select_ally_[3]" onkeyup="autoComplete(this,this.form.elements['ally_[3]'],'text',false)"></th>
	<th width="175"><select name="ally_[3]"><?php echo $options_3;?></select></th>
</tr>
<tr>
	<th><?php echo $lang['lesmip_missiles_galaxynumber']; ?></th>
	<th><input type="checkbox" id="num[1]" name="num[1]" <?php echo(isset($pub_num['1']) AND $pub_num['1'] == 1) ? "checked" : ""; ?> value="1"/><label for="num[1]">-> 1</label>&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" id="num[2]" name="num[2]" <?php echo(isset($pub_num['2']) AND $pub_num['2'] == 1) ? "checked" : ""; ?> value="1"/><label for="num[2]">-> 2</label>&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" id="num[3]" name="num[3]" <?php echo(isset($pub_num['3']) AND $pub_num['3'] == 1) ? "checked" : ""; ?> value="1"/><label for="num[3]">-> 3</label><br />
		<input type="checkbox" id="num[4]" name="num[4]" <?php echo(isset($pub_num['4']) AND $pub_num['4'] == 1) ? "checked" : ""; ?> value="1"/><label for="num[4]">-> 4</label>&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" id="num[5]" name="num[5]" <?php echo(isset($pub_num['5']) AND $pub_num['5'] == 1) ? "checked" : ""; ?> value="1"/><label for="num[5]">-> 5</label>&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" id="num[6]" name="num[6]" <?php echo(isset($pub_num['6']) AND $pub_num['6'] == 1) ? "checked" : ""; ?> value="1"/><label for="num[6]">-> 6</label><br />
		<input type="checkbox" id="num[7]" name="num[7]" <?php echo(isset($pub_num['7']) AND $pub_num['7'] == 1) ? "checked" : ""; ?> value="1"/><label for="num[7]">-> 7</label>&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" id="num[8]" name="num[8]" <?php echo(isset($pub_num['8']) AND $pub_num['8'] == 1) ? "checked" : ""; ?> value="1"/><label for="num[8]">-> 8</label>&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" id="num[9]" name="num[9]" <?php echo(isset($pub_num['9']) AND $pub_num['9'] == 1) ? "checked" : ""; ?> value="1"/><label for="num[9]">-> 9</label>

	</th>
	<th><?php echo $lang['lesmip_missiles_systemnumber']; ?></th>
	<th><select name="number_system">
			<?php $i = 50; while($i <= 500) {
				$z = $i - 1;
				if(!empty($pub_number_system) AND $pub_number_system == $i) {
					$select = " selected";
				} else if (!empty($pub_number_system) AND $pub_number_system == $z) {
					$select = " selected";
				} else {
					$select = "";
				}
				if ($i != 50) $a = "\t\t\t"; else $a = "";
				if ($i == 500) $y = 1; else $y = 0;
				echo $a."<option".$select." value=\"".($i - $y)."\">-> ".$i."</option>\n";
				$i = $i + 50;
			} ?>
		</select>
	</th>
	<th><?php echo $lang['lesmip_missiles_tosystem']; ?></th>
	<th><select name="to_system">
			<?php $i = 0; while($i <= 450) {
				if(!empty($pub_to_system) AND $pub_to_system == $i) {
					$select = " selected";
				} else {
					$select = "";
				}
				if ($i != 0) $a = "\t\t\t"; else $a = "";
				if ($i == 0) $i++;
				echo $a."<option".$select." value=\"".$i."\">-> ".$i."</option>\n";
				if($i == 1) $i = $i - 1;
				$i = $i + 50;
			} ?>
		</select>
	</th>
</tr>
<tr>
	<td class="c" colspan="6" align="center"><input type="submit" name="valid" value="<?php echo $lang['lesmip_missiles_affpos']; ?>"></td>
</tr>
</form>
</table>
<br />
<div id="affbox"></div>
<table border=\'1\'>
<tr>
<?php if (!empty($galaxy_num) AND $galaxy_num == 9) {
	echo "\t".'<td class="c" width="45">&nbsp;</td>'."\n";
	echo "\t".'<td class="c" width="60" colspan="4" align="center">'.$lang['lesmip_missiles_G'].'1</td>'."\n";
	echo "\t".'<td class="c" width="60" colspan="4" align="center">'.$lang['lesmip_missiles_G'].'2</td>'."\n";
	echo "\t".'<td class="c" width="60" colspan="4" align="center">'.$lang['lesmip_missiles_G'].'3</td>'."\n";
	echo "\t".'<td class="c" width="60" colspan="4" align="center">'.$lang['lesmip_missiles_G'].'4</td>'."\n";
	echo "\t".'<td class="c" width="60" colspan="4" align="center">'.$lang['lesmip_missiles_G'].'5</td>'."\n";
	echo "\t".'<td class="c" width="60" colspan="4" align="center">'.$lang['lesmip_missiles_G'].'6</td>'."\n";
	echo "\t".'<td class="c" width="60" colspan="4" align="center">'.$lang['lesmip_missiles_G'].'7</td>'."\n";
	echo "\t".'<td class="c" width="60" colspan="4" align="center">'.$lang['lesmip_missiles_G'].'8</td>'."\n";
	echo "\t".'<td class="c" width="60" colspan="4" align="center">'.$lang['lesmip_missiles_G'].'9</td>'."\n";
	echo "\t".'<td class="c" width="45">&nbsp;</td>'."\n";
	echo '</tr>';
}

if (!empty($pub_valid)) {
	/* La requete suivante recupere le niveau de la technologie impulsion et en deduit la porte*/
	$req = "SELECT * FROM ".TABLE_USER_TECHNOLOGY;
	$result = $db->sql_query($req);
	while ($data = $db->sql_fetch_assoc($result)) {
		if ($data["RI"]!=NULL){
			$porte[$data['user_id']] = (5*$data["RI"])-1;
		}
	}
	/*La requete suivante extrait le niveau des silo de missile et si le niveau est superieur a 4 liste les systeme pouvant etre touches*/
	$req = "SELECT * FROM ".TABLE_USER_BUILDING;
	$result = $db->sql_query($req);
	while ($data = $db->sql_fetch_assoc($result)) {
	    if ($data["Silo"]!=NULL && $data["Silo"]> 3){
			$coord= explode(":", $data["coordinates"]);
			$gal=$coord[0];
			$sys=$coord[1];
			$sysmini = $sys - $porte[$data['user_id']];
			if ($sysmini<1){
				$sysmini=1;
			}
			$sysmaxi = $sys + $porte[$data['user_id']];
			if ($sysmaxi>499){
				$sysmaxi=499;
			}
			for ($pos = $sysmini; $pos <= $sysmaxi; $pos++){
				$missil[$gal][$pos] = (isset($missil[$gal][$pos]) ? $missil[$gal][$pos]+1 : 1);
			}
		}
	}
}
if ($galaxy_num == "9") {
	$fin = $pub_number_system + $pub_to_system;
	if ($fin > 499) {
		$fin = 499;
	}
	for ($system = $pub_to_system ; $system <= $fin ; $system++) {
		
		echo "<tr>"."\n";
		echo "\t"."<td class='c' align='center' nowrap>".$system."</td>";
		for ($galaxy=1 ; $galaxy<=9 ; $galaxy++) {
			$nb_player = array("&nbsp;", "&nbsp;", "&nbsp;", "&nbsp;");
			$tooltip = array("", "", "");
			$i=0;
			$nb_player[4] = (isset($missil[$galaxy][$system]) ? $missil[$galaxy][$system] : NULL);
			foreach ($position as $ally_name) {
				if ($galaxy_ally_position[$ally_name][$galaxy][$system]["planet"] > 0) {
					$tooltip[$i] = "<table width=\'200\'>";
					$tooltip[$i] .= "<tr><td class=\'c\' colspan=\'2\' align=\'center\'>".$lang['lesmip_missiles_presentplayer']."</td></tr>";
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
			echo "\t"."<th width='20'><font color='green'>".$nb_player[4]."</font></th>"."\n";
			echo "\t"."<th width='20'><a style='cursor:pointer'".$tooltip[0]."><font color='magenta'>".$nb_player[0]."</font></a></th>"."\n";
			echo "\t"."<th width='20'><a style='cursor:pointer'".$tooltip[1]."><font color='yellow'>".$nb_player[1]."</font></a></th>"."\n";
			echo "\t"."<th width='20'><a style='cursor:pointer'".$tooltip[2]."><font color='red'>".$nb_player[2]."</font></a></th>"."\n";
		}
		echo "\t"."<td class='c' align='center' nowrap>".$system."</td>";
		echo "</tr>"."\n";
	}
} else if ($galaxy_num == "1") {
	$fin = $pub_number_system + $pub_to_system;
	if ($galaxy == 9 AND $fin > 499) {
		$fin = 499;
	}
	echo "</tr>";
	echo "\t".'<td class="c" width="45">&nbsp;</td>'."\n";
	echo "\t".'<td class="c" width="60" colspan="4" align="center"><font color="red">'.$lang['lesmip_missiles_G'].$galaxy.'</font></td>'."\n";
	echo "\t".'<td class="c" width="45">&nbsp;</td>'."\n";
	for ($system = $pub_to_system ; $system <= $fin ; $system++) {
		if ($system <= 499 AND $system >= $pub_to_system) {
			echo "<tr>"."\n";
			echo "\t"."<td class='c' align='center' nowrap>".$system."</td>\n";
			$nb_player = array("&nbsp;", "&nbsp;", "&nbsp;", "&nbsp;");
			$tooltip = array("", "", "");
			$i=0;
			$nb_player[4] = (isset($missil[$galaxy][$system]) ? $missil[$galaxy][$system] : NULL);
			foreach ($position as $ally_name) {
				if ($galaxy_ally_position[$ally_name][$galaxy][$system]["planet"] > 0) {
					$tooltip[$i] = "<table width=\'200\'>";
					$tooltip[$i] .= "<tr><td class=\'c\' colspan=\'2\' align=\'center\'>".$lang['lesmip_missiles_presentplayer']."</td></tr>";
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
			echo "\t"."<th width='20'><font color='green'>".$nb_player[4]."</font></th>"."\n";
			echo "\t"."<th width='20'><a style='cursor:pointer'".$tooltip[0]."><font color='magenta'>".$nb_player[0]."</font></a></th>"."\n";
			echo "\t"."<th width='20'><a style='cursor:pointer'".$tooltip[1]."><font color='yellow'>".$nb_player[1]."</font></a></th>"."\n";
			echo "\t"."<th width='20'><a style='cursor:pointer'".$tooltip[2]."><font color='red'>".$nb_player[2]."</font></a></th>"."\n";
			echo "\t"."<td class='c' align='center' nowrap>".$system."</td>";
			echo "</tr>"."\n";
			if ($system == $fin) {
				echo "<tr>"."\n";
				echo "\t".'<td class="c" width="45">&nbsp;</td>'."\n";
				echo "\t".'<td class="c" width="60" colspan="4" align="center"><font color="red">'.$lang['lesmip_missiles_G'].$galaxy.'</font></td>'."\n";
				echo "\t".'<td class="c" width="45">&nbsp;</td>'."\n";
				echo "</tr>";
			}
		} else if ($system == 500) {
			echo "<tr>"."\n";
			echo "\t".'<td class="c" width="45">&nbsp;</td>'."\n";
			echo "\t".'<td class="c" width="60" colspan="4" align="center"><font color="red">'.$lang['lesmip_missiles_G'].$galaxy.'</font></td>'."\n";
			echo "\t".'<td class="c" width="45">&nbsp;</td>'."\n";
			echo "</tr>";
		} else if ($system == 501 AND $galaxy != 9) {
			$galaxy = $galaxy + 1;
			echo "<tr>"."\n";
			echo "\t".'<td class="c" width="45">&nbsp;</td>'."\n";
			echo "\t".'<td class="c" width="60" colspan="4" align="center"><font color="red">'.$lang['lesmip_missiles_G'].$galaxy.'</font></td>'."\n";
			echo "\t".'<td class="c" width="45">&nbsp;</td>'."\n";
			echo "</tr>";
			$fin = $fin - 500;
			$system = 0;
		} else if ($system >= 1 AND $system <= $pub_to_system) {
			echo "<tr>"."\n";
			echo "\t"."<td class='c' align='center' nowrap>".$system."</td>\n";
			$nb_player = array("&nbsp;", "&nbsp;", "&nbsp;", "&nbsp;");
			$tooltip = array("", "", "");
			$i=0;
			$nb_player[4] = $missil[$galaxy][$system];
			foreach ($position as $ally_name) {
				if ($galaxy_ally_position[$ally_name][$galaxy][$system]["planet"] > 0) {
					$tooltip[$i] = "<table width=\'200\'>";
					$tooltip[$i] .= "<tr><td class=\'c\' colspan=\'2\' align=\'center\'>".$lang['lesmip_missiles_presentplayer']."</td></tr>";
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
			echo "\t"."<th width='20'><font color='green'>".$nb_player[4]."</font></th>"."\n";
			echo "\t"."<th width='20'><a style='cursor:pointer'".$tooltip[0]."><font color='magenta'>".$nb_player[0]."</font></a></th>"."\n";
			echo "\t"."<th width='20'><a style='cursor:pointer'".$tooltip[1]."><font color='yellow'>".$nb_player[1]."</font></a></th>"."\n";
			echo "\t"."<th width='20'><a style='cursor:pointer'".$tooltip[2]."><font color='red'>".$nb_player[2]."</font></a></th>"."\n";
			echo "\t"."<td class='c' align='center' nowrap>".$system."</td>";
			echo "</tr>"."\n";
			if ($system == $fin) {
				echo "<tr>"."\n";
				echo "\t".'<td class="c" width="45">&nbsp;</td>'."\n";
				echo "\t".'<td class="c" width="60" colspan="4" align="center"><font color="red">'.$lang['lesmip_missiles_G'].$galaxy.'</font></td>'."\n";
				echo "\t".'<td class="c" width="45">&nbsp;</td>'."\n";
				echo "</tr>";
			}
		}
	}
} else if ($galaxy_num >= 2 AND $galaxy_num <= 8) {
	echo "\t".'<td class="c" width="45">&nbsp;</td>'."\n";
	foreach ($pub_num as $key => $value) {
		$galaxy = $key;
		if ($value == 1) {
			echo "\t".'<td class="c" width="60" colspan="4" align="center"><font color="red">'.$lang['lesmip_missiles_G'].$galaxy.'</font></td>'."\n";
		}
	}
	echo "\t".'<td class="c" width="45">&nbsp;</td>'."\n";
	$fin = $pub_number_system + $pub_to_system;
	for ($system = $pub_to_system ; $system <= $fin ; $system++) {
		if ($system <= 499 AND $system >= $pub_to_system) {
			echo "<tr>"."\n";
			echo "\t"."<td class='c' align='center' nowrap>".$system."</td>\n";
			foreach ($pub_num as $key => $value) {
				$galaxy = $key;
				if ($value == 1) {
					$nb_player = array("&nbsp;", "&nbsp;", "&nbsp;", "&nbsp;");
					$tooltip = array("", "", "");
					$i=0;
					$nb_player[4] = (isset($missil[$galaxy][$system]) ? $missil[$galaxy][$system] : NULL);
					foreach ($position as $ally_name) {
						if ($galaxy_ally_position[$ally_name][$galaxy][$system]["planet"] > 0) {
							$tooltip[$i] = "<table width=\'200\'>";
							$tooltip[$i] .= "<tr><td class=\'c\' colspan=\'2\' align=\'center\'>".$lang['lesmip_missiles_presentplayer']."</td></tr>";
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
					echo "\t"."<th width='20'><font color='green'>".$nb_player[4]."</font></th>"."\n";
					echo "\t"."<th width='20'><a style='cursor:pointer'".$tooltip[0]."><font color='magenta'>".$nb_player[0]."</font></a></th>"."\n";
					echo "\t"."<th width='20'><a style='cursor:pointer'".$tooltip[1]."><font color='yellow'>".$nb_player[1]."</font></a></th>"."\n";
					echo "\t"."<th width='20'><a style='cursor:pointer'".$tooltip[2]."><font color='red'>".$nb_player[2]."</font></a></th>"."\n";
				}
			}
			echo "\t"."<td class='c' align='center' nowrap>".$system."</td>\n";
			echo "</tr>";
			if ($system == $fin) {
				echo "<tr>"."\n";
				echo "\t".'<td class="c" width="45">&nbsp;</td>'."\n";
				foreach ($pub_num as $key => $value) {
					$galaxy = $key;
					if ($value == 1) {
						echo "\t".'<td class="c" width="60" colspan="4" align="center"><font color="red">'.$lang['lesmip_missiles_G'].$galaxy.'</font></td>'."\n";
					}
				}
				echo "\t".'<td class="c" width="45">&nbsp;</td>'."\n";
				echo "</tr>";
			}
		} else if ($system == 500) {
			echo "<tr>"."\n";
			echo "\t".'<td class="c" width="45">&nbsp;</td>'."\n";
			foreach ($pub_num as $key => $value) {
				$galaxy = $key;
				if ($value == 1) {
					echo "\t".'<td class="c" width="60" colspan="4" align="center"><font color="red">'.$lang['lesmip_missiles_G'].$galaxy.'</font></td>'."\n";
				}
			}
			echo "\t".'<td class="c" width="45">&nbsp;</td>'."\n";
			echo "</tr>";
		} else if ($system == 501) {
			echo "<tr>"."\n";
			echo "\t".'<td class="c" width="45">&nbsp;</td>'."\n";
			foreach ($pub_num as $key => $value) {
				$galaxy = $key + 1;
				if ($value == 1) {
					echo "\t".'<td class="c" width="60" colspan="4" align="center"><font color="red">'.$lang['lesmip_missiles_G'].$galaxy.'</font></td>'."\n";
				}
			}
			echo "\t".'<td class="c" width="45">&nbsp;</td>'."\n";
			echo "</tr>";
			$fin = $fin - 500;
			$system = 0;
		} else if ($system >= 1 AND $system <= $pub_to_system) {
			echo "<tr>"."\n";
			echo "\t"."<td class='c' align='center' nowrap>".$system."</td>\n";
			foreach ($pub_num as $key => $value) {
				$galaxy = $key + 1;
				if ($value == 1) {
					$nb_player = array("&nbsp;", "&nbsp;", "&nbsp;", "&nbsp;");
					$tooltip = array("", "", "");
					$i=0;
					$nb_player[4] = $missil[$galaxy][$system];
					foreach ($position as $ally_name) {
						if ($galaxy_ally_position[$ally_name][$galaxy][$system]["planet"] > 0) {
							$tooltip[$i] = "<table width=\'200\'>";
							$tooltip[$i] .= "<tr><td class=\'c\' colspan=\'2\' align=\'center\'>".$lang['lesmip_missiles_presentplayer']."</td></tr>";
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
					echo "\t"."<th width='20'><font color='green'>".$nb_player[4]."</font></th>"."\n";
					echo "\t"."<th width='20'><a style='cursor:pointer'".$tooltip[0]."><font color='magenta'>".$nb_player[0]."</font></a></th>"."\n";
					echo "\t"."<th width='20'><a style='cursor:pointer'".$tooltip[1]."><font color='yellow'>".$nb_player[1]."</font></a></th>"."\n";
					echo "\t"."<th width='20'><a style='cursor:pointer'".$tooltip[2]."><font color='red'>".$nb_player[2]."</font></a></th>"."\n";
				}
			}
			echo "\t"."<td class='c' align='center' nowrap>".$system."</td>\n";
			echo "</tr>";
			if ($system == $fin) {
				echo "<tr>"."\n";
				echo "\t".'<td class="c" width="45">&nbsp;</td>'."\n";
				foreach ($pub_num as $key => $value) {
					$galaxy = $key + 1;
					if ($value == 1) {
						echo "\t".'<td class="c" width="60" colspan="4" align="center"><font color="red">'.$lang['lesmip_missiles_G'].$galaxy.'</font></td>'."\n";
					}
				}
				echo "\t".'<td class="c" width="45">&nbsp;</td>'."\n";
				echo "</tr>";
			}
		}
		
	}
}
?>
<tr>
<?php if (!empty($galaxy_num) AND $galaxy_num == 9) {
	echo "\t".'<td class="c" width="45">&nbsp;</td>'."\n";
	echo "\t".'<td class="c" width="60" colspan="4" align="center">'.$lang['lesmip_missiles_G'].'1</td>'."\n";
	echo "\t".'<td class="c" width="60" colspan="4" align="center">'.$lang['lesmip_missiles_G'].'2</td>'."\n";
	echo "\t".'<td class="c" width="60" colspan="4" align="center">'.$lang['lesmip_missiles_G'].'3</td>'."\n";
	echo "\t".'<td class="c" width="60" colspan="4" align="center">'.$lang['lesmip_missiles_G'].'4</td>'."\n";
	echo "\t".'<td class="c" width="60" colspan="4" align="center">'.$lang['lesmip_missiles_G'].'5</td>'."\n";
	echo "\t".'<td class="c" width="60" colspan="4" align="center">'.$lang['lesmip_missiles_G'].'6</td>'."\n";
	echo "\t".'<td class="c" width="60" colspan="4" align="center">'.$lang['lesmip_missiles_G'].'7</td>'."\n";
	echo "\t".'<td class="c" width="60" colspan="4" align="center">'.$lang['lesmip_missiles_G'].'8</td>'."\n";
	echo "\t".'<td class="c" width="60" colspan="4" align="center">'.$lang['lesmip_missiles_G'].'9</td>'."\n";
	echo "\t".'<td class="c" width="45">&nbsp;</td>'."\n";
}
?>
</tr>
</table>
<br />
[MOD] Tout sur les MIP <?php echo $lang['lesmip_simu_version'];
	$ver = "SELECT version FROM ".TABLE_MOD." where action = 'lesmip'";
	$ver1 = $db->sql_query($ver);
	$donne = $db->sql_fetch_assoc($ver1);
	echo $donne['version']; ?><br />
<?php echo $lang['lesmip_createdby']; ?> Christ24, Zildal1 <?php echo $lang['lesmip_and']; ?> Bartheleway</div>
