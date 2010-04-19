<?php
/***************************************************************************
*	filename	: viewtrade.php
*	desc.		:
*	Author		: ericalens - http://ogs.servebbs.net/
*	modified	: dimanche 11 juin 2006, 14:57:14 (UTC+0200)
***************************************************************************/

if (!defined('IN_OGSMARKET')) {
	die("Hacking attempt");
}

require_once("views/page_header.php");
require_once("includes/ogamecalc.php");
function affiche_icone($ouinon) {
	if ($ouinon=="1")
	{
		echo "<img src=\"images/graphic_ok.gif\" width=\"20\"/>";
	} else {
		echo "<img src=\"images/graphic_cancel.gif\" width=\"20\"/>";
	}
}
$trade=$Trades->get_trade($ogs_tradeid);
if ($trade) {
?><table><tr>
			<td class="c" rowspan="2"><a href="index.php?sortby=date">Date</a></td>
			<th colspan="3">Offres</th>
			<th colspan="3">Demandes</th>
			<th colspan="2">Informations</th>
		</tr>
		<tr>
			<td class="k"><a href="index.php?sortby=offermetal">Metal</a></th>
			<td class="k"><a href="index.php?sortby=offercrystal">Crystal</a></th>
			<td class="k"><a href="index.php?sortby=offerdeut">Deuterium</a></th>
			<td class="k"><a href="index.php?sortby=wantmetal">Métal</a></th>
			<td class="k"><a href="index.php?sortby=wantcrystal">Crystal</a></th>
			<td class="k"><a href="index.php?sortby=wantdeut">Deuterium</a></th>
			<td class="k"><a href="index.php?sortby=player">Joueur</a></th>
			<td class="k"><a href="index.php?sortby=expiration">Expiration</a></th>
		</tr>
<?php
		echo "<tr>\n";
		echo "\t<th>".strftime("%a %d %b %H:%M:%S",$trade["creation_date"])."</th>\n";
		echo "\t<td class='c'>".number_format($trade["offer_metal"])."</td>\n";
		echo "\t<td class='c'>".number_format($trade["offer_crystal"])."</td>\n";
		echo "\t<td class='c'>".number_format($trade["offer_deuterium"])."</td>\n";
		echo "\t<td class='c'>".number_format($trade["want_metal"])."</td>\n";
		echo "\t<td class='c'>".number_format($trade["want_crystal"])."</td>\n";
		echo "\t<td class='c'>".number_format($trade["want_deuterium"])."</td>\n";
		echo "\t<th><a href='index.php?action=profile&amp;id=".$trade["traderid"]."'>".$trade["username"]."</a></th>\n";
		echo "\t<th>".strftime("%a %d %b %H:%M:%S",$trade["expiration_date"])."</th>\n";
		echo "\t<tr><th>Note</th><td>".taux_echange($trade["offer_metal"],$trade["offer_crystal"],$trade["offer_deuterium"],$trade["want_metal"],$trade["want_crystal"],$trade["want_deuterium"])."</td><td colspan='8' class='k'>&nbsp;".stripslashes($trade["note"])."</td></tr>\n";
		if ($trade["pos_user"]<>0)
		{
			$user2=$Users->get_user($trade["pos_user"]);
			if(!$user2) {echo "<div>Profil non trouvé</div>";}
			else
			echo "\t<tr><th>Offre réservé par :</th><td class=\"c\" colspan=\"4\">".$user2["name"]."</td>";
			echo "<th class=\"c\" colspan=\"2\"> le :</th><td class=\"c\" colspan=\"5\">".strftime("%a %d %b %H:%M:%S",$trade["pos_date"])."</td>";
		}
		echo "\t<tr><th>Livrable en:</th><td class=\"c\" colspan=\"9\">";
			echo "G1";affiche_icone($trade["deliver_g1"]);
			echo "G2";affiche_icone($trade["deliver_g2"]);
			echo "G3";affiche_icone($trade["deliver_g3"]);
			echo "G4";affiche_icone($trade["deliver_g4"]);
			echo "G5";affiche_icone($trade["deliver_g5"]);
			echo "G6";affiche_icone($trade["deliver_g6"]);
			echo "G7";affiche_icone($trade["deliver_g7"]);
			echo "G8";affiche_icone($trade["deliver_g8"]);
			echo "G9";affiche_icone($trade["deliver_g9"]);
		echo "</td></tr>";
		echo "\t<tr><th>Payable en:</th><td class=\"c\" colspan=\"9\">";
			echo "G1";affiche_icone($trade["refunding_g1"]);
						echo "G2";affiche_icone($trade["refunding_g2"]);
						echo "G3";affiche_icone($trade["refunding_g3"]);
						echo "G4";affiche_icone($trade["refunding_g4"]);
						echo "G5";affiche_icone($trade["refunding_g5"]);
						echo "G6";affiche_icone($trade["refunding_g6"]);
						echo "G7";affiche_icone($trade["refunding_g7"]);
						echo "G8";affiche_icone($trade["refunding_g8"]);
						echo "G9";affiche_icone($trade["refunding_g9"]);
		echo "</td></tr>";
		echo "</table>\n";
} 
echo "<br>";
$dont_include_header=true;
$ogs_id=$trade["traderid"];
$now=time();

if (isset($user_data) ){ 
	if ($user_data["id"]==$ogs_id || $user_data["is_admin"]){
		echo "<div align='center'>";
		if($user_data["id"]!=$ogs_id) echo "[admin]";
		echo "<a href='index.php?action=deletetrade&amp;tradeid=".$trade["id"]."'>Effacer cette offre</a></div><br>";
	}
	if ($user_data["id"]!=$ogs_id AND $trade["pos_user"]==0) {
		echo "<div align='center'>";
		echo "<a href='index.php?action=betontrade&amp;tradeid=$ogs_tradeid'>Prendre position sur cette offre</a></div><br>";
	}
	if (($user_data["id"]==$ogs_id || $user_data["is_admin"]) AND $trade["pos_user"]==0 AND $trade["expiration_date"]>$now) {
		echo "<div align='center'>";		
		if($user_data["id"]!=$ogs_id) echo "[admin]";
		echo "<a href='index.php?action=modifytrade&amp;tradeid=$ogs_tradeid'>Modifier cette offre</a></div><br>";
	}
	if (($user_data["id"]==$trade["pos_user"] || $user_data["is_admin"]) AND $trade["pos_user"]!=0) {
		if($user_data["id"]!=$ogs_id AND $user_data["is_admin"]==1) echo "[admin]";
		echo "<a href='index.php?action=unbetontrade&amp;tradeid=$ogs_tradeid'>Annuler position sur cette offre</a>";
	}
}
echo "<br><br>";
	?>
<table>
<tr>
<td>
<table width='100%'>
	<tr>
		<td>
	<?php
		$user=$Users->get_user($trade["traderid"]);
		if(!$user) {echo "<div>Profil non trouvé</div>";}
		else
		{
	?>	<table width="300" align="center">
		<tr><th colspan="2">Profil utilisateur du vendeur : <?php echo $user["name"];?></th></tr>
		<tr><td class="c">Enregistrement :</td><td class="k"><?php echo strftime("%a %d %b %H:%M:%S",$user["regdate"]); ?></td>
		<tr><td class="c">Dern. Connexion:</td><td class="k"><?php echo strftime("%a %d %b %H:%M:%S",$user["lastvisit"]); ?></td>
		<tr><td class="c">Email: </td><td class="k"><?php if (empty($user["email"])) {echo "&lt;Non renseigné&gt;";}
					else {echo "<a href='mailto://".$user["email"]."'>".$user["email"]."</a>";} ?></td>
		<tr><td class="c">MSN: </td><td class="k"><?php if (empty($user["msn"])) {echo "&lt;Non renseigné&gt;";}
					else {echo $user["msn"];} ?></td>
		<tr><td class="c">Pseudo Ingame : </td><td class="k"><?php if (empty($user["pm_link"])) {echo "&lt;Non renseigné&gt;";}
					else {echo $user["pm_link"];} ?></td>
		<tr><td class="c">IRC Nickname: </td><td class="k"><?php if (empty($user["irc_nick"])) {echo "&lt;Non renseigné&gt;";}
					else {echo "<a href='http://ogs.servebbs.net/OGSMarket/index.php?action=pjirc' target='_blank'>".$user["irc_nick"]."</a>";} ?></td>
		</table><?php
		}
	?>
		</td>
	</tr>
	</table>
</td>

<td>
	<?php
if ($trade["pos_user"]!=0)
{
	?>
	<table width='100%'>
	<tr>
		<td>
	<?php
		$user=$Users->get_user($trade["pos_user"]);
		if(!$user) {echo "<div>Profil non trouvé</div>";}
		else
		{
	?>	<table width="300" align="center">
		<tr><th colspan="2">Profil utilisateur de l'acheteur : <?php echo $user["name"];?></th></tr>
		<tr><td class="c">Enregistrement :</td><td class="k"><?php echo strftime("%a %d %b %H:%M:%S",$user["regdate"]); ?></td>
		<tr><td class="c">Dern. Connexion:</td><td class="k"><?php echo strftime("%a %d %b %H:%M:%S",$user["lastvisit"]); ?></td>
		<tr><td class="c">Email: </td><td class="k"><?php if (empty($user["email"])) {echo "&lt;Non renseigné&gt;";}
					else {echo "<a href='mailto://".$user["email"]."'>".$user["email"]."</a>";} ?></td>
		<tr><td class="c">MSN: </td><td class="k"><?php if (empty($user["msn"])) {echo "&lt;Non renseigné&gt;";}
					else {echo $user["msn"];} ?></td>
		<tr><td class="c">Pseudo Ingame : </td><td class="k"><?php if (empty($user["pm_link"])) {echo "&lt;Non renseigné&gt;";}
					else {echo $user["pm_link"];} ?></td>
		<tr><td class="c">IRC Nickname: </td><td class="k"><?php if (empty($user["irc_nick"])) {echo "&lt;Non renseigné&gt;";}
					else {echo "<a href='http://ogs.servebbs.net/OGSMarket/index.php?action=pjirc' target='_blank'>".$user["irc_nick"]."</a>";} ?></td>
		</table><?php
		}

	?>
		</td>
	</tr>
	</table>
	<?php
}
	?>
</td>
</tr>
</table>
	<?php
require_once("views/page_tail.php");
?>
