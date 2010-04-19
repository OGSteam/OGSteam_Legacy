<?php
/** market_viewtrades.php Affichage de la liste des offres en cours sur les serveurs déclarés
* @package MOD_Market
* @author Jey2k <jey2k.ogsteam@gmail.com>
* @version 1.0
*/
if (!defined('IN_SPYOGAME')) die("Hacking attempt");
// Affichage de l'entête de tableau
?>
<table width="100%" border="1">
	<tr>
		<td>
			<table width="100%">
				<tr align="center">
					<td align="center"><a href='http://www.ogsteam.fr'>OGSMarket</a>: Le commerce Ogamien par l'<b>OGSTeam</b></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>
			<table width="100%">
<?php


foreach($servers as $server){
	// On regarde si les données des offres sont à jour
	if (time()-$server["trades_list_timestamp"] > $server["server_refresh"]){
		$server=update_server_offers($server);
	}
	$offres_array=get_trades_array($server);
	// On affiche la description de l'univers
	?>
	<tr>
		<th colspan="10">
				Marché de <A target="_blank" HREF ="<?php echo $server["server_url"];?>"><?php echo $server["server_name"]." - ".get_active_universe_name($server)."</a> (".count($offres_array);?> offres)
				<form action="index.php">
					<input type="hidden" name="action" value="market"/>
					<input type="hidden" name="subaction" value="serveruserprofile"/>
					<input type="hidden" name="server_id" value="<?php echo $server["server_id"];?>"/>
					<input type="image" src="images/help.png"/>
				</form>
				
		</th>
	</tr>
	<tr>
		<td class="c" rowspan="2"><a href="index.php?action=listtrade&amp;sortby=date">Date d'insertion</a></td>
		<th colspan="3">Offres en Milliers</th>
		<th colspan="3">Demandes en Milliers</th>
		<th colspan="3">Informations</th>
	</tr>
	<tr>
		<td class="k"><a href="index.php?action=listtrade&amp;sortby=offermetal">Metal</a></th>
		<td class="k"><a href="index.php?action=listtrade&amp;sortby=offercrystal">Crystal</a></th>
		<td class="k"><a href="index.php?action=listtrade&amp;sortby=offerdeut">Deuterium</a></th>
		<td class="k"><a href="index.php?action=listtrade&amp;sortby=wantmetal">Métal</a></th>
		<td class="k"><a href="index.php?action=listtrade&amp;sortby=wantcrystal">Crystal</a></th>
		<td class="k"><a href="index.php?action=listtrade&amp;sortby=wantdeut">Deuterium</a></th>
		<td class="k"><a href="index.php?action=listtrade&amp;sortby=player">Joueur</a></th>
		<td class="k"><a href="index.php?action=listtrade&amp;sortby=expiration">Expiration</a></th>
		<td class="k">Action</th>	
	</tr>
	<?php
	// On affiche les offres de l'univers
	foreach($offres_array as $trade){
			echo "<tr>\n";
			echo "\t<th rowspan='2'>".strftime("%a %d %b",$trade["creation_date"])."<br/>".strftime("%H:%M:%S",$trade["creation_date"])."</th>\n";
			echo "\t<td class='c'>".number_format($trade["offer_metal"])."</td>\n";
			echo "\t<td class='c'>".number_format($trade["offer_crystal"])."</td>\n";
			echo "\t<td class='c'>".number_format($trade["offer_deuterium"])."</td>\n";
			echo "\t<td class='c'>".number_format($trade["want_metal"])."</td>\n";
			echo "\t<td class='c'>".number_format($trade["want_crystal"])."</td>\n";
			echo "\t<td class='c'>".number_format($trade["want_deuterium"])."</td>\n";
			echo "\t<th><a target=\"_blank\" href='".$trade["market_server_url"]."index.php?action=profile&amp;id=".$trade["traderid"]."'>".$trade["username"]."</a></th>\n";
			echo "\t<th>".strftime("%a %d %b %H:%M:%S",$trade["expiration_date"])."</th>\n";
			echo "\t<th><a target=\"_blank\" href='".$trade["market_server_url"]."index.php?action=viewtrade&amp;tradeid=".$trade["id"]."'>Info</a></th>";
			echo "\n</tr>";
			echo "<tr><th colspan='6'>&nbsp;".$trade["note"]."</th>";
			echo "<td class='c' colspan='3'>";
			?>
			<table width="100%">
				<tr>
					<td class='c'>Livrable:</td>
					<td class='c'>
						<?php
						echo "G1";affiche_icone($trade["deliver_g1"]);
						echo "G2";affiche_icone($trade["deliver_g2"]);
						echo "G3";affiche_icone($trade["deliver_g3"]);
						echo "G4";affiche_icone($trade["deliver_g4"]);
						echo "G5";affiche_icone($trade["deliver_g5"]);
						echo "G6";affiche_icone($trade["deliver_g6"]);
						echo "G7";affiche_icone($trade["deliver_g7"]);
						echo "G8";affiche_icone($trade["deliver_g8"]);
						echo "G9";affiche_icone($trade["deliver_g9"]);
						?>
					</td>
				</tr>
				<tr>
					<td class='c'>Payable:</td>
					<td class='c'>
						<?php
						echo "G1";affiche_icone($trade["refunding_g1"]);
						echo "G2";affiche_icone($trade["refunding_g2"]);
						echo "G3";affiche_icone($trade["refunding_g3"]);
						echo "G4";affiche_icone($trade["refunding_g4"]);
						echo "G5";affiche_icone($trade["refunding_g5"]);
						echo "G6";affiche_icone($trade["refunding_g6"]);
						echo "G7";affiche_icone($trade["refunding_g7"]);
						echo "G8";affiche_icone($trade["refunding_g8"]);
						echo "G9";affiche_icone($trade["refunding_g9"]);
						?>
					</td>
				</tr>
			</table>
			<?php
			echo "</td></tr>";
		}
		echo "<tr>";
			echo "<td class='c' colspan='10'>&nbsp;</td>";
			echo "</tr>";
	//echo "</table></td></tr></table>";
	
}
echo "</table></td></tr>";
echo "</table>";
?>