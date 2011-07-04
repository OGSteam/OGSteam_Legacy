<?php
/** $Id$ **/
/**
* admin.php Partie admin du mod
* @package [MOD] AutoUpdate
* @author Bartheleway <contactbarthe@g.q-le-site.webou.net>
* @version 1.0
* created	: 13/11/2006
* modified	: 18/01/2007
*/
if (!defined('IN_SPYOGAME')) {
    die("Hacking attempt");
}

$error = "";
if (isset($pub_valid)) {
	if (!is_writable("mod/autoupdate/parameters.php")) {
		$error .= $lang['autoupdate_admin_isnotwritable']."<br />";
	}
	if ($error <> "") {
		echo "<b><font color='red'>".$lang['autoupdate_admin_define']."</font></b><br />";
		echo $error;
		echo "<br /><br />";
		echo "<i>".$lang['autoupdate_admin_iswritable']."</i>";
		exit();
	}
	if(empty($pub_cycle)) $pub_cycle = 0;
	$generated = generate_parameters($pub_coadmin, $pub_down, $pub_cycle, date("d"), date("H"), 0, $pub_autoMaJ, $pub_banlist);
}

// Récupération des paramètres dans le fichier parameters.php

$arr = get_defined_functions();

foreach($arr as $zeile){
	sort($zeile);$s=0;
	foreach($zeile as $bzeile){
		$s = ($s) ? 0 : 1;
		if($bzeile == 'versionmod' OR $bzeile == 'generate_parameters' OR $bzeile == 'copymodupdate' OR $bzeile == 'json_decode') {
			if($bzeile == 'versionmod') {
				$versionmod = $bzeile;
			}
			if($bzeile == 'generate_parameters') {
				$generate_parameters = $bzeile;
			}
			if($bzeile == 'copymodupdate') {
				$copymodupdate = $bzeile;
			}
			if($bzeile == 'json_decode') {
				$json_on = $bzeile;
			}
		}
	}
}
?>
<table>
	<tr>
		<td class="c" colspan="2"><?php echo $lang['autoupdate_admin_list']; ?></a>
	</tr>
	<tr>
		<td class="c">Versionmod</th>
		<th><?php if(empty($versionmod)) echo $lang['autoupdate_admin_off']; else echo $lang['autoupdate_admin_define']; ?></th>
	</tr>
	<tr>
		<td class="c">Generate_parameters</td>
		<th><?php if(empty($generate_parameters)) echo $lang['autoupdate_admin_off']; else echo $lang['autoupdate_admin_define']; ?></th>
	</tr>
	<tr>
		<td class="c">Copymodupdate</td>
		<th><?php if(empty($copymodupdate)) echo $lang['autoupdate_admin_off']; else echo $lang['autoupdate_admin_define']; ?></th>
	</tr>
	<tr>
		<td class="c">JSON_Decode</td>
		<th><?php if(empty($json_on)) echo $lang['autoupdate_admin_off']; else echo $lang['autoupdate_admin_define']; ?></th>
	</tr>
</table>
<br />
<table>
	<tr>
		<td class="c"><?php echo $lang['autoupdate_admin_option']; ?></td>
		<td class="c" align="center"><?php echo $lang['autoupdate_admin_value']; ?><br /><?php echo $lang['autoupdate_admin_value1']; ?></td>
	</tr>
	<form action="index.php?action=autoupdate&sub=admin" method="post">
	<tr>
		<th><?php echo $lang['autoupdate_admin_MaJ']; ?></th>
		<th><input type="radio" name="coadmin" <?php echo (COADMIN == 1) ? 'checked' : ''; ?> value="1"/> <font size="5">|</font> <input type="radio" name="coadmin" <?php echo (COADMIN == 0) ? 'checked' : ''; ?> value="0"/></th>
	</tr>
	<tr>
		<th><?php echo $lang['autoupdate_admin_AUTOMaJ']; ?></th>
		<th><input type="radio" name="autoMaJ" <?php echo (AUTO_MAJ == 1) ? 'checked' : ''; ?> value="1"/> <font size="5">|</font> <input type="radio" name="autoMaJ" <?php echo (AUTO_MAJ == 0) ? 'checked' : ''; ?> value="0"/></th>
	</tr>
	<tr>
		<th><?php echo $lang['autoupdate_admin_down']; ?><br /><?php echo $lang['autoupdate_admin_down1']; ?></th>
		<th><input type="radio" name="down" <?php echo (DOWNJSON == 1) ? 'checked' : ''; ?> value="1"/> <font size="5">|</font> <input type="radio" name="down" <?php echo (DOWNJSON == 0) ? 'checked' : ''; ?> value="0"/></th>
	</tr>
	<tr>
		<th><?php echo $lang['autoupdate_admin_banlist']; ?><br /><?php echo $lang['autoupdate_admin_banlist1']; ?></th>
		<th><input type="radio" name="banlist" <?php echo (BAN_MODS == 1) ? 'checked' : ''; ?> value="1"/> <font size="5">|</font> <input type="radio" name="banlist" <?php echo (BAN_MODS == 0) ? 'checked' : ''; ?> value="0"/></th>
	</tr>
	<?php if(DOWNJSON == 1) { ?>
	<tr>
		<th><?php echo $lang['autoupdate_admin_frequency']; ?></th>
		<th><select size="1" name="cycle">
				<option value="0" <?php echo (CYCLE == 0) ? 'selected="selected"' : ''; ?> >A chaque visualisation</option>
				<option value="1" <?php echo (CYCLE == 1) ? 'selected="selected"' : ''; ?> >Une fois par jour</option>
				<option value="13" <?php echo (CYCLE == 13) ? 'selected="selected"' : ''; ?> >Toutes les 12 heures</option>
				<option value="9" <?php echo (CYCLE == 9) ? 'selected="selected"' : ''; ?> >Toutes les 8 heures</option>
				<option value="7" <?php echo (CYCLE == 7) ? 'selected="selected"' : ''; ?> >Toutes les 6 heures</option>
				<option value="5" <?php echo (CYCLE == 5) ? 'selected="selected"' : ''; ?> >Toutes les 4 heures</option>
				<option value="4" <?php echo (CYCLE == 4) ? 'selected="selected"' : ''; ?> >Toutes les 3 heures</option>
				<option value="3" <?php echo (CYCLE == 3) ? 'selected="selected"' : ''; ?> >Toutes les 2 heures</option>
				<option value="2" <?php echo (CYCLE == 2) ? 'selected="selected"' : ''; ?> >Toutes les heures</option>
			</select>
		</th>
	</tr>
	<?php } ?>
	<tr>
		<td></td>
		<td><input type="submit" name="valid" value="<?php echo $lang['autoupdate_admin_valid']; ?>"/></td>
	</tr>
	</form>
</table>
<?php
if(!empty($generated)) {
	if($generated == 'yes') {
		echo "<br />\n".$lang['autoupdate_admin_generated']."<br />\n";
	} else {
		echo "<br />\n".$lang['autoupdate_error']."<br />\n";
	}
}
echo "<br />\n";
echo 'AutoUpdate '.$lang['autoupdate_version'].' '.versionmod();
echo '<br />'."\n";
echo $lang['autoupdate_createdby'].' Jibus '.$lang['autoupdate_and'].' Bartheleway.</div>';
require_once("views/page_tail.php");
?>
