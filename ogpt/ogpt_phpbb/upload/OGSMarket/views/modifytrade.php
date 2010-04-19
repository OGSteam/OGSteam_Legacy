<?php
/***************************************************************************
*	filename	: newtrade.php
*	desc.		:
*	Author		: ericalens - http://ogs.servebbs.net/
*	created		: mardi 6 Juin 2006, 14:36:42 (UTC+0200)
***************************************************************************/

if (!defined('IN_OGSMARKET')) {
	die("Hacking attempt");
}

require_once("views/page_header.php");
require_once("includes/trade.php");

$trade=$Trades->get_trade($ogs_tradeid);
?>

<table width="100%">
<tr>
	<td>
		<table width="100%">
		<tr align="center">
			<td align="center"><a href='http://ogs.servebbs.net'>OGSMarket</a>: Le commerce Ogamien par l'<b>OGSTeam</b></td>
		</tr>
		</table>
	</td>
</tr>
<tr >
	<td align="center">
		<table class='style'>
			<tr>
			<th colspan="3">Modifier mon offre pour <?php echo $current_uni["name"]; ?></th>
			</tr>
			<tr><td colspan="3">
			Attention les offres sont en K c'est à dire en milliers de ressources ( 10k Metal = 10.000 Métal)<br>
			N'oubliez pas de mettre à jour votre profil afin d'y laisser les informations pour vous contacter.<br>
			Vous pouvez modifier votre offre aussi souvent que vous le souhaitez. La prolongation est soumise à une limitation.
			</td></tr>
		</table><br>
		<table class="style">
			<tr>
			<th width="110">&nbsp;</th><th width="80">Offres (Ko)</th><th width="80">Demandes (Ko)</th>
			</tr>
			<form action="index.php" method="post">
			<input type='hidden' name='action' value='upd_trade'>
			<input type='hidden' name='tradeid' value='<?php echo $ogs_tradeid; ?>'/>
			<input type='hidden' name='expiration_date' value='<?php echo $trade["expiration_date"]; ?>'/>
			<input type='hidden' name='creation_date' value='<?php echo $trade["creation_date"]; ?>'/>
			<tr>
			<td class='c'>Metal</td><td width="80" align="center"><input type='text' size="8" name='offer_metal' value='<?php echo $trade["offer_metal"]; ?>'></td>
				      <td align="center"><input type='text' size="8"  name='want_metal' value='<?php echo $trade["want_metal"]; ?>'></td>
			</tr>
			<tr>
			<td class='c'>Crystal</td><td align="center"><input type='text' size="8"  name='offer_crystal' value='<?php echo $trade["offer_crystal"]; ?>'></td>
				      <td align="center"><input type='text' size="8"  name='want_crystal' value='<?php echo $trade["want_crystal"]; ?>'></td>
			</tr>
			<tr>
			<td class='c'>Deuterium</td><td align="center"><input type='text' size="8"  name='offer_deuterium' value='<?php echo $trade["offer_deuterium"]; ?>'></td>
				      <td align="center"><input type='text' size="8"  name='want_deuterium' value='<?php echo $trade["want_deuterium"]; ?>'></td>
			</tr>
			<tr>
			<td class='c'>&nbsp;</td>
			<td colspan='2'><hr width='50%' /></td>
			</tr>
			<tr>
			<td class='c'>Création</td><td align="center" colspan='2'><?php echo(strftime("%a %d %b %H:%M:%S",$trade["creation_date"])); ?></td>				   
			</tr>
			<td class='c'>Expiration</td><td align="center" colspan='2'><?php echo(strftime("%a %d %b %H:%M:%S",$trade["expiration_date"])); ?></td>
			</tr>
<?php
// Autorisation de prolonger l'offre
	$quartemps = (intval($trade["expiration_date"]) - intval($trade["creation_date"]))/4;
	$now = time();
		if ($now < intval($trade["expiration_date"]) - $quartemps)	{				
			echo "\t<td class=\"c\">Prolonger</td>\n";
			echo "\t<td class=\"l\" colspan=\"2\"><center><font color=\"lime\">A partir de ".strftime("%a %d %b %H:%M:%S",($trade["expiration_date"] - $quartemps))."</font></centrer></td>\n";
		 } else {
			echo "\t<td class=\"c\">Prolonger</td><td align=\"center\"><input type='text' size='5' name='expiration_hours' value='0'></td>\n";
			echo "\t<td>(en heures) MAXI ".intval($server_config["max_trade_delay_seco"]/(60*60))." heures</td>\n";
		}
?> 
			</tr>
			
			<tr>
			<td class='c'>&nbsp;</td>
			<td colspan='2'><hr width='50%' /></td>
			</tr>
			<tr>
			<td class='c'><Note</td>
				<td colspan='2'><textarea name='note'><?php echo stripslashes($trade["note"]); ?></textarea></td>
			</tr>
			
<script language="javascript">
function livrable() {
    for (var i=1; i<=9; i++) {
        var checkbox = "livrable["+i+"]";
        if (document.getElementById(checkbox).checked == true) {
            document.getElementById(checkbox).checked = false
        }
        else document.getElementById(checkbox).checked = true
    }
}
</script>
			
			<tr>
			<td class='c'>Livrable en:</td>
				<td colspan='2'>
					G1<input type="checkbox" value="1" id="livrable[1]" name="deliver_g1" <?php echo(($trade["deliver_g1"]) == 1 ? "checked" : ""); ?>/>
					G2<input type="checkbox" value="1" id="livrable[2]" name="deliver_g2" <?php echo(($trade["deliver_g2"]) == 1 ? "checked" : ""); ?>/>
					G3<input type="checkbox" value="1" id="livrable[3]" name="deliver_g3" <?php echo(($trade["deliver_g3"]) == 1 ? "checked" : ""); ?>/><br/>
					G4<input type="checkbox" value="1" id="livrable[4]" name="deliver_g4" <?php echo(($trade["deliver_g4"]) == 1 ? "checked" : ""); ?>/>
					G5<input type="checkbox" value="1" id="livrable[5]" name="deliver_g5" <?php echo(($trade["deliver_g5"]) == 1 ? "checked" : ""); ?>/>
					G6<input type="checkbox" value="1" id="livrable[6]" name="deliver_g6" <?php echo(($trade["deliver_g6"]) == 1 ? "checked" : ""); ?>/><br/>
					G7<input type="checkbox" value="1" id="livrable[7]" name="deliver_g7" <?php echo(($trade["deliver_g7"]) == 1 ? "checked" : ""); ?>/>
					G8<input type="checkbox" value="1" id="livrable[8]" name="deliver_g8" <?php echo(($trade["deliver_g8"]) == 1 ? "checked" : ""); ?>/>
					G9<input type="checkbox" value="1" id="livrable[9]" name="deliver_g9" <?php echo(($trade["deliver_g9"]) == 1 ? "checked" : ""); ?>/>&nbsp;<input type="button" id="valide" name="valide" value="Inverser la sélection" onClick="livrable();"><br>
				</td>
			</tr>
			<td class='c'>Payable en:</td>
				<td colspan='2'>
					G1<input type="checkbox" value="1" name="refunding_g1" <?php echo(($trade["refunding_g1"]) == 1 ? "checked" : ""); ?>/>
					G2<input type="checkbox" value="1" name="refunding_g2" <?php echo(($trade["refunding_g2"]) == 1 ? "checked" : ""); ?>/>
					G3<input type="checkbox" value="1" name="refunding_g3" <?php echo(($trade["refunding_g3"]) == 1 ? "checked" : ""); ?>/><br/>
					G4<input type="checkbox" value="1" name="refunding_g4" <?php echo(($trade["refunding_g4"]) == 1 ? "checked" : ""); ?>/>
					G5<input type="checkbox" value="1" name="refunding_g5" <?php echo(($trade["refunding_g5"]) == 1 ? "checked" : ""); ?>/>
					G6<input type="checkbox" value="1" name="refunding_g6" <?php echo(($trade["refunding_g6"]) == 1 ? "checked" : ""); ?>/><br/>
					G7<input type="checkbox" value="1" name="refunding_g7" <?php echo(($trade["refunding_g7"]) == 1 ? "checked" : ""); ?>/>
					G8<input type="checkbox" value="1" name="refunding_g8" <?php echo(($trade["refunding_g8"]) == 1 ? "checked" : ""); ?>/>
					G9<input type="checkbox" value="1" name="refunding_g9" <?php echo(($trade["refunding_g9"]) == 1 ? "checked" : ""); ?>/>
				</td>
			</tr>
			<tr>
			<td class='c' align='center' colspan="3"><input type="submit"></td>
			</form>
			<tr>
		</table>
	</td>
</tr>
</table>

<?php
require_once("views/page_tail.php");
?>
