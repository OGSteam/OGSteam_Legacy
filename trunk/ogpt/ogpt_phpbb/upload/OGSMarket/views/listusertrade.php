<?php
/***************************************************************************
*	filename	: listusertrade.php
*	desc.		:
*	Author		: Digiduck - http://ogs.servebbs.net/
*	created		: 11/02/2007
***************************************************************************/

if (!defined('IN_OGSMARKET')) {
	die("Hacking attempt");
}
function affiche_icone($ouinon) {
	if ($ouinon=="1")
	{
		echo "<img src=\"images/graphic_ok.gif\" width=\"20\"/>";
	} else {
		echo "<img src=\"images/graphic_cancel.gif\" width=\"20\"/>";
	}
}
require_once("views/page_header.php");
$now = time();
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
<tr>
	<td>
		<table width="100%">
		<tr>
			<th colspan=12>Liste de vos Offres, <?php echo $user_data["name"]; ?> - Marché : <?php echo $current_uni["name"]; ?></th>
		</tr>
		<tr>
			<td class="c" rowspan="2"><a href="index.php?action=listtrade&amp;sortby=date">Date d'insertion</a></td>
			<th colspan="3">Offres en Milliers</th>
			<th colspan="3">Demandes en Milliers</th>
			<th colspan="4">Informations</th>
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
			<td class="k"><a href="index.php?action=listtrade&amp;sortby=posuser">Reservé par</a></th>
			<td class="k"><a href="index.php?action=listtrade&amp;sortby=posdate">Reservé le</a></th>
		</tr>
<?php
	if(!isset($ogs_sortby)) $ogs_sortby = "";
	
	switch ($ogs_sortby){
		case "offermetal":
			$orderby="offer_metal desc";
			break;
		case "offercrystal":
			$orderby="offer_crystal desc";
			break;
		case "offerdeut":
			$orderby="offer_deuterium desc";
			break;
		case "wantmetal":
			$orderby="want_metal desc";
			break;
		case "wantcrystal":
			$orderby="want_crystal desc";
			break;
		case "wantdeut":
			$orderby="want_deuterium desc";
			break;
		case "player":
			$orderby="username desc";
			break;
		case "posuser":
			$orderby="pos_user desc";
			break;
		case "posdate":
			$orderby="pos_date desc";
			break;
		default:
		$orderby="creation_date desc";
			break;
	}
	foreach($Trades->tradesuser_array($user_data["id"]) as $trade) {
		echo "<tr>\n";
		echo "\t<th rowspan='2'>".strftime("%a %d %b",$trade["creation_date"])."<br/>".strftime("%H:%M:%S",$trade["creation_date"])."<br><br>\n";
		if ($trade["expiration_date"] < $now) { ?>
			<form action='index.php' methode='post'>
			<input type='hidden' name='action' value='reactive_trade'>
			<input type='hidden' name='id' value='<?php echo $trade["id"]; ?>'>
			<input type="submit" value="Réactiver Offre">
			</th></form>
		<?php }
		echo "\t<td class='c'>".number_format($trade["offer_metal"])."</td>\n";
		echo "\t<td class='c'>".number_format($trade["offer_crystal"])."</td>\n";
		echo "\t<td class='c'>".number_format($trade["offer_deuterium"])."</td>\n";
		echo "\t<td class='c'>".number_format($trade["want_metal"])."</td>\n";
		echo "\t<td class='c'>".number_format($trade["want_crystal"])."</td>\n";
		echo "\t<td class='c'>".number_format($trade["want_deuterium"])."</td>\n";
		echo "\t<th><a href='index.php?action=profile&amp;id=".$trade["traderid"]."'>".$trade["username"]."</a></th>\n";
		if ($trade["expiration_date"] < $now) { echo "\t<th><font color=\"red\">Offre Expirée</font></th>\n";}
		else {echo "\t<th><font color=\"green\">".strftime("%a %d %b %H:%M:%S",$trade["expiration_date"])."</font></th>\n";
		}
		if ($trade["pos_user"]<>0)
		{
			$user2=$Users->get_user($trade["pos_user"]);
			if(!$user2) {echo "\t<th>Membre Inconnu</th>\n";}
			else
			echo "\t<th><a href='index.php?action=profile&amp;id=".$trade["pos_user"]."'>".$user2["name"]."</a></th>\n";
		}
		else echo "\t<th></th>\n";
		if (!$trade["pos_date"]){echo "\t<th></th>\n";}
		else {echo "\t<th>".strftime("%a %d %b %H:%M:%S",$trade["pos_date"])."</th>\n";	}
		echo "<tr><th colspan='6'>&nbsp;".stripslashes($trade["note"])."</th>";
		echo "<td class='k'>";
			echo "<a href='index.php?action=viewtrade&amp;tradeid=".$trade["id"]."'><font color=\"yellow\">Infos</font></a>";

			$ogs_id=$trade["traderid"];
			$now=time();
		if (isset($user_data) ){ 
			if (($user_data["id"]==$ogs_id || $user_data["is_admin"]) AND $trade["pos_user"]==0 AND $trade["expiration_date"]>$now) {
				echo "<div align='center'>";		
				if($user_data["id"]!=$ogs_id) echo "[a]";
					echo "<a href='index.php?action=modifytrade&amp;tradeid=".$trade["id"]."'>Modifier</a></div>";
			}
			if ($user_data["id"]==$ogs_id || $user_data["is_admin"]==1){
				echo "<div align='center'>";
				if($user_data["id"]!=$ogs_id) echo "[a]";
					echo "<a href='index.php?action=deletetrade&amp;tradeid=".$trade["id"]."'>Effacer</a></div>";
			}
			if ($user_data["id"]!=$ogs_id AND $trade["pos_user"]==0) {
				echo "<div align='center'>";
				echo "<a href='index.php?action=betontrade&amp;tradeid=".$trade["id"]."'>Réserver</a></div>";
			}
			if (($user_data["id"]==$trade["pos_user"] || $user_data["is_admin"]==1) AND $trade["pos_user"]!=0)	{
				echo "<div align='center'>";
				if($user_data["id"]!=$ogs_id AND $user_data["is_admin"]==1) echo "[a]";
					echo "<a href='index.php?action=unbetontrade&amp;tradeid=".$trade["id"]."'>Libérer</a></div>";
			}
		}
		echo "</td>";		
		echo "<td class='c' colspan='4'>";
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
		</td>
		<?php
		
		
		echo "</tr>";
	}

?>
		</table>
	</td>
</tr>
</table>

<?php
require_once("views/page_tail.php");
?>
