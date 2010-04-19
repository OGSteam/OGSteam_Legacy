<?php
/**
* info.php Information complémentaire sur le joueur
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
require_once("mod/lesmip/calcul.php");	?>
<table width="75%">
			<tr>
				<td colspan="6" class="c" align="center"><?php echo $lang['lesmip_info_info']." : ".$name; ?></td>
			</tr>
			<tr>
				<td class="c"><?php echo $lang['lesmip_info_planet']; ?></td>
				<td class="c"><?php echo $lang['lesmip_info_phalange']; ?></td>
				<td class="c"><?php echo $lang['lesmip_info_ally']; ?></td>
				<td class="c"><?php echo $lang['lesmip_info_lastupdate']; ?></td>
				<td class="c"><?php echo $lang['lesmip_info_updateby']; ?></td>
			</tr>
			<?php if (isset($bon) AND $bon = "oui") {
			while ($cherche2 = $db->sql_fetch_assoc($cherche1)) {
			$coord = "<a href=\"index.php?action=galaxy&galaxy=".$cherche2['galaxy']."&system=".$cherche2['system']."\">";
			$coord .= $cherche2['galaxy'].":".$cherche2['system'].":".$cherche2['row']."</a>";
			$moon = $cherche2['moon'];
			$phalanx = $cherche2['phalanx'];
			if (isset($moon) AND $moon != '0') {
			$coord .= " + Lune";
			}
			$ally = $cherche2['ally'];
			$phalan = "Niveau ".$phalanx;
			$timestamp = $cherche2['last_update'];
			$maj = date('d/m/Y', $timestamp);
			$maj .= " - ".date('H\h i\m\i\n', $timestamp);
			$jmaj = $cherche6['user_name'];
			?>
			<tr>
				<td><?php echo $coord; ?></td>
				<td align="center"><?php echo $phalan; ?></td>
				<td><?php echo $ally; ?></td>
				<td><?php echo $maj; ?></td>
				<td align="center"><?php echo $jmaj; ?></td>
			</tr><?php } } ?>
			<tr>
				<td colspan="6"><br /></td>
			</tr>
			<tr>
				<td class="c" colspan="6" align="center"><?php echo $lang['lesmip_info_stat']; ?></td>
			</tr>
			<tr>
				<td class="c" colspan="3" align="center" width="50%"><?php echo $lang['lesmip_info_player']; ?></td>
				<td class="c" colspan="3" align="center"><?php echo $lang['lesmip_info_ally']; ?></td>
			</tr>
			<tr>
				<td class="c" width="17%"><?php echo $lang['lesmip_info_general']; ?></td>
				<td class="c" width="17%"><?php echo $lang['lesmip_info_fleet']; ?></td>
				<td class="c"><?php echo $lang['lesmip_info_research']; ?></td>
				<td class="c" width="17%"><?php echo $lang['lesmip_info_general']; ?></td>
				<td class="c" width="17%"><?php echo $lang['lesmip_info_fleet']; ?></td>
				<td class="c"><?php echo $lang['lesmip_info_research']; ?></td>
			</tr>
			<?php if (isset($bon) AND $bon = "oui") {
				$jpoint = $classp2['rank'];
				$jflotte = $classf2['rank'];
				$jrecherche = $classr2['rank'];
				$apoint = $classap2['rank'];
				$aflotte = $classaf2['rank'];
				$arecherche = $classar2['rank'];
				?>
			<tr>
				<td><?php echo $jpoint; ?></td>
				<td><?php echo $jflotte; ?></td>
				<td><?php echo $jrecherche; ?></td>
				<td><?php echo $apoint; ?></td>
				<td><?php echo $aflotte; ?></td>
				<td><?php echo $arecherche; ?></td>
			</tr><?php } ?>
		</table>
<br />
[MOD] Tout sur les MIP <?php echo $lang['lesmip_simu_version'];
	$ver = "SELECT version FROM ".TABLE_MOD." where action = 'lesmip'";
	$ver1 = $db->sql_query($ver);
	$donne = $db->sql_fetch_assoc($ver1);
	echo $donne['version']; ?><br />
<?php echo $lang['lesmip_createdby']; ?> Christ24, Zildal1 <?php echo $lang['lesmip_and']; ?> Bartheleway</div>