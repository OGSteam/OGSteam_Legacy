<?php
/**
* simu.php Simulation de MIP et recherche d'information sur le joueur
* @package [MOD] Tout sur les MIP
* @author Bartheleway <contactbarthe@g.q-le-site.webou.net>
* @version 0.4
* created	: 21/08/2006
* modified	: 07/02/2007
*/

if (!defined('IN_SPYOGAME')) die("Hacking attempt");

$query = "SELECT `active` FROM `".TABLE_MOD."` WHERE `action`='lesmip' AND `active`='1' LIMIT 1";
if (!$db->sql_numrows($db->sql_query($query))) die("Hacking attempt");

/**
*Page qui permet de faire tout les calculs et recherches de données
*/
require_once("mod/lesmip/calcul.php");
?>

<script src="mod/lesmip/simulation_mip.js" type="text/javascript"></script>

<script type="text/javascript">
<!--
function clear_text_missil() {
	if (document.Eingaben.Bericht.value == "<?php echo $lang['lesmip_simu_REpaste']; ?>") {
		document.Eingaben.Bericht.value = "";
	}
}

function r() {
	for(var i=0;i<11;i++) {
		document.getElementById("v"+i).innerHTML = "-";
		document.getElementById("k"+i).innerHTML = "-";
		document.getElementById("m"+i).innerHTML = "-";
		document.getElementById("c"+i).innerHTML = "-";
		document.getElementById("d"+i).innerHTML = "-";
		document.getElementById("temps_vol").innerHTML = "-";
	};
	for(i=0;i<11;i++) {
		document.Eingaben.a[i].value = "";
	};
	document.Eingaben.dep.value = "";
	document.Eingaben.arriv.value = "";
	document.coord.galaxie.value = "";
	document.coord.solaire.value = "";
	document.coord.position.value = "";
	document.Eingaben.priz.selectedIndex = 8;
	document.Eingaben.Bericht.value="<?php echo $lang['lesmip_simu_REpaste']; ?>";
};
//-->
</script>

<form name="Eingaben" action="">
<table width="100%">
	<tr>
		<td class="c"><?php echo $lang['lesmip_simu_simuMI']; ?></td>
		<td class="c"><?php echo $lang['lesmip_simu_data']; ?></td>
		<td class="c" colspan="5"><?php echo $lang['lesmip_simu_result']; ?></td>
	</tr>
	<tr>
		<td class="c"><?php echo $lang['lesmip_simu_type']; ?></td>
		<td class="c"><?php echo $lang['lesmip_simu_number']; ?></td>
		<td class="c"><?php echo $lang['lesmip_simu_unitsurvive']; ?></td>
		<td class="c"><?php echo $lang['lesmip_simu_unitdestroy']; ?></td>
		<td class="c"><?php echo $lang['lesmip_simu_metal']; ?></td>
		<td class="c"><?php echo $lang['lesmip_simu_cristal']; ?></td>
		<td class="c"><?php echo $lang['lesmip_simu_deut']; ?></td>
	</tr>
	<tr>
		<td><?php echo $lang['lesmip_simu_lm']; ?></td>
		<td><input type="text" name="a" size="8"></td>
		<td id="v0" class="a">-</td>
		<td id="k0" class="a">-</td>
		<td id="m0" class="a">-</td>
		<td id="c0" class="a">-</td>
		<td id="d0" class="a">-</td>
	</tr>
	<tr>
		<td><?php echo $lang['lesmip_simu_al']; ?></td>
		<td><input type="text" name="a" size="8"></td>
		<td id="v1" class="a">-</td>
		<td id="k1" class="a">-</td>
		<td id="m1" class="a">-</td>
		<td id="c1" class="a">-</td>
		<td id="d1" class="a">-</td>
	</tr>
	<tr>
		<td><?php echo $lang['lesmip_simu_aL']; ?></td>
		<td><input type="text" name="a" size="8"></td>
		<td id="v2" class="a">-</td>
		<td id="k2" class="a">-</td>
		<td id="m2" class="a">-</td>
		<td id="c2" class="a">-</td>
		<td id="d2" class="a">-</td>
	</tr>
	<tr>
		<td><?php echo $lang['lesmip_simu_gauss']; ?></td>
		<td><input type="text" name="a" size="8"></td>
		<td id="v3" class="a">-</td>
		<td id="k3" class="a">-</td>
		<td id="m3" class="a">-</td>
		<td id="c3" class="a">-</td>
		<td id="d3" class="a">-</td>
	</tr>
	<tr>
		<td><?php echo $lang['lesmip_simu_ions']; ?></td>
		<td><input type="text" name="a" size="8"></td>
		<td id="v4" class="a">-</td>
		<td id="k4" class="a">-</td>
		<td id="m4" class="a">-</td>
		<td id="c4" class="a">-</td>
		<td id="d4" class="a">-</td>
	</tr>
	<tr>
		<td><?php echo $lang['lesmip_simu_plasma']; ?></td>
		<td><input type="text" name="a" size="8"></td>
		<td id="v5" class="a">-</td>
		<td id="k5" class="a">-</td>
		<td id="m5" class="a">-</td>
		<td id="c5" class="a">-</td>
		<td id="d5" class="a">-</td>
	</tr>
	<tr>
		<td><?php echo $lang['lesmip_simu_pb']; ?></td>
		<td><input type="text" name="a" size="8"></td>
		<td id="v6" class="a">-</td>
		<td id="k6" class="a">-</td>
		<td id="m6" class="a">-</td>
		<td id="c6" class="a">-</td>
		<td id="d6" class="a">-</td>
	</tr>
	<tr>
		<td><?php echo $lang['lesmip_simu_gb']; ?></td>
		<td><input type="text" name="a" size="8"></td>
		<td id="v7" class="a">-</td>
		<td id="k7" class="a">-</td>
		<td id="m7" class="a">-</td>
		<td id="c7" class="a">-</td>
		<td id="d7" class="a">-</td>
	</tr>
	<tr>
		<td style="height:21px"><?php echo $lang['lesmip_simu_totaux']; ?></td>
		<td></td>
		<td id="v8" class="a">-</td>
		<td id="k8" class="a">-</td>
		<td id="m8" class="a">-</td>
		<td id="c8" class="a">-</td>
		<td id="d8" class="a">-</td>
	</tr>
	<tr>
		<td colspan="2" class="c"><?php echo $lang['lesmip_simu_objectif']; ?></td>
		<td colspan="5"  class="c"></td>
	</tr>
	<tr>
		<td><?php echo $lang['lesmip_simu_mi']; ?></td>
		<td><input type="text" id="a" size="8"></td>
		<td id="v9" class="a">-</td>
		<td id="k9" class="a">-</td>
		<td id="m9" class="a">-</td>
		<td id="c9" class="a">-</td>
		<td id="d9" class="a">-</td>
	</tr>
	<tr>
		<td><?php echo $lang['lesmip_simu_techprotection']; ?></td>
		<td><input type="text" name="a" size="8"></td>
		<td></td>
		<td></td>
		<td></td> 
		<td></td>
		<td></td>
	</tr>
	<tr>
		<td colspan="2"  class="c"><?php echo $lang['lesmip_simu_you']; ?></td>
		<td colspan="5"  class="c"></td>
	</tr>
	<tr>
		<td><?php echo $lang['lesmip_simu_haveMI']; ?></td>
		<td><input type="text" name="a" size="8"></td>
		<td class="a" id="v10">-</td>
		<td class="a" id="k10">-</td>
		<td class="a" id="m10">-</td>
		<td class="a" id="c10">-</td>
		<td class="a" id="d10">-</td>
	</tr>
	<tr>
		<td><?php echo $lang['lesmip_simu_techarme']; ?></td>
		<td><input type="text" name="a" size="8" value="<?php echo $Armes; ?>"></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<td><?php echo $lang['lesmip_simu_priority']; ?></td>
		<td><select name="priz">
			<option><?php echo $lang['lesmip_simu_olm']; ?></option>
			<option><?php echo $lang['lesmip_simu_oal']; ?></option>
			<option><?php echo $lang['lesmip_simu_oaL']; ?></option>
			<option><?php echo $lang['lesmip_simu_ogauss']; ?></option>
			<option><?php echo $lang['lesmip_simu_oions']; ?></option>
			<option><?php echo $lang['lesmip_simu_oplasma']; ?></option>
			<option><?php echo $lang['lesmip_simu_opb']; ?></option>
			<option><?php echo $lang['lesmip_simu_ogb']; ?></option>
			<option selected><?php echo $lang['lesmip_simu_none']; ?></option>
		</select></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<td colspan="2"  class="c"><?php echo $lang['lesmip_simu_options']; ?></td>
		<td colspan="5"  class="c"></td>
	</tr>
	<tr>
		<td><input name="spio" type="button" onClick="lesen()" value="<?php echo $lang['lesmip_simu_read']; ?>"></td>
		<!-- appel de la function points créé par Christ24 -->
		<td><textarea name="Bericht" cols="10" rows="2" onFocus="clear_text_missil()"><?php echo $donne['rawdata']; ?></textarea></td>
	</tr>
</table>
<table <?php if (isset($pub_stat) AND $pub_stat == true) echo 'width="100%"'; else echo 'width="700px"'; ?>>
	<tr style="text-align : center">
		<td class="c"><?php echo $lang['lesmip_simu_calcul']; ?></td>
		<td class="c"><?php echo $lang['lesmip_simu_loadRE']; ?></td>
		<?php if(isset($pub_stat) AND $pub_stat == true) { echo"\t\t".'<td class="c">'.$lang['lesmip_simu_info'].'</td>'; } ?>
	</tr>
	<tr align="center">
		<td><table>
				<tr style="text-align : center">
					<td class="c"><?php echo $lang['lesmip_simu_dep']; ?></td>
					<td class="c" width="120px"><?php echo $lang['lesmip_simu_flytime']; ?></td>
					<td class="c"><?php echo $lang['lesmip_simu_arr']; ?></b></td>
				</tr>
				<tr align="center">
					<td><input onkeyup="temps_vol()" type="text" name="dep" size="8" maxlength="3" style="text-align : center"></td>
					<td id="temps_vol" style="text-align : center" width="120px">-</td>
					<td><input onkeyup="temps_vol()" type="text" name="arriv" size="8" maxlength="3" style="text-align : center" value="<?php echo $sol; ?>"></td>
				</tr>
				<tr>
					<td><br /><br /></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<?php if (isset($bon) AND $bon = "oui") {
				for ($nombre_de_lignes = 1; $nombre_de_lignes <= 19; $nombre_de_lignes++) { ?>
				<tr>
					<td colspan="4"><br /></td>
				</tr>
				<?php } } ?>
			</table>
		</td>
		</form>
		<form action="index.php?action=lesmip" name="coord" method="post">
		<td><table style="text-align : center">
				<tr>
					<td class="c"><?php echo $lang['lesmip_simu_galaxy']; ?></td>
					<td class="c"><?php echo $lang['lesmip_simu_solarsystem']; ?></td>
					<td class="c"><?php echo $lang['lesmip_simu_position']; ?></td>
					<td></td>
				</tr>
				<tr>
					<td><input size="2" type="text" maxlength="1" value="<?php echo $gala; ?>" style="text-align : center" name="galaxie"/></td>
					<td><input size="4" type="text" maxlength="3" value="<?php echo $sol; ?>" style="text-align : center" name="solaire"/></td>
					<td><input size="3" type="text" maxlength="2" value="<?php echo $pos; ?>" style="text-align : center" name="position"/></td>
					<td><input type="checkbox" id="stat" name="stat" <?php if (isset($pub_stat) AND $pub_stat == true) echo 'checked'; ?> ><label for="stat"><?php echo $lang['lesmip_simu_affinfo']; ?></label></td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td><input type="submit" name="charger" value="<?php echo $lang['lesmip_simu_loadtheRE']; ?>"/></td>
				</tr>
				<?php if (isset($bon) AND $bon = "oui") {
				for ($nombre_de_lignes = 1; $nombre_de_lignes <= 19; $nombre_de_lignes++) { ?>
				<tr>
					<td colspan="4"><br /></td>
				</tr>
				<?php } } ?>				
			</table>
		</td>
		</form>
		<?php if(isset($pub_stat) AND $pub_stat == true) { ?>
		<td><table>
				<tr>
					<td colspan="4" class="c" align="center"><?php echo $lang['lesmip_simu_playername']." : ".$name; ?></td>
				</tr>
				<tr>
					<td class="c"><?php echo $lang['lesmip_simu_planet']; ?></td>
					<td class="c"><?php echo $lang['lesmip_simu_stat']; ?></td>
					<td class="c"><?php echo $lang['lesmip_simu_ally']; ?></td>
					<td class="c"><?php echo $lang['lesmip_simu_pageinfo']; ?></td>
				</tr>
				<?php if (isset($bon) AND $bon = "oui") {
				while ($cherche2 = mysql_fetch_array($cherche1) ) { 
				$coord = "<a href=\"index.php?action=galaxy&galaxy=".$cherche2['galaxy']."&system=".$cherche2['system']."\">";
				$coord .= $cherche2['galaxy'].":".$cherche2['system'].":".$cherche2['row']."</a><br />";
				$ally = $cherche2['ally'];
				$profil = "<a target=\"_blank\" href=\"index.php?action=lesmip&subaction=info&name=".$name."\">".$lang['lesmip_simu_read1']."</a>";
				while ($classp2 = mysql_fetch_array($classp1) ) {
					$stat1 = $lang['lesmip_simu_general']." : ".$classp2['rank']."<br />";
					}
				while ($classf2 = mysql_fetch_array($classf1) ) {
					$stat1 .= $lang['lesmip_simu_flotte']." : ".$classf2['rank']."<br />";
					}
				while ($classr2 = mysql_fetch_array($classr1) ) {
					$stat1 .= $lang['lesmip_simu_research']." : ".$classr2['rank']."<br />";
					}
				 ?>
				<tr>
					<td><?php echo $coord ?></td>
					<td><?php echo $stat1; ?></td>
					<td><?php echo $ally; ?></td>
					<td><?php echo $profil; ?></td>
				</tr>
				<?php } } ?>
			</table>
		</td>
		<?php } ?>
	</tr>
</table>
<input type="button" name="ll" onClick="sim()" value="Simulation">
<input type="button" name="reset" onClick="r()" value="Tout effacer">
<input type="button" name="rak"onClick="sim2()" value="Calcul du nombre de missiles nécessaires"><br /><br />
[MOD] Tout sur les MIP <?php echo $lang['lesmip_simu_version'];
	$ver = "SELECT version FROM ".TABLE_MOD." where action = 'lesmip'";
	$ver1 = $db->sql_query($ver);
	$donne = $db->sql_fetch_assoc($ver1);
	echo $donne['version']; ?><br />
<?php echo $lang['lesmip_createdby']; ?> Christ24, Zildal1 <?php echo $lang['lesmip_and']; ?> Bartheleway</div>