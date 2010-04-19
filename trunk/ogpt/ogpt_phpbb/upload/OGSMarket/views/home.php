<?php
/***************************************************************************
*	filename	: home.php
*	desc.		:
*	Author		: ericalens - http://ogs.servebbs.net/
*	created		: 17/12/2005
*	modified	: 28/12/2005 23:56:40
*	modified	: dimanche 11 juin 2006, 01:05:08 (UTC+0200)
***************************************************************************/

if (!defined('IN_OGSMARKET')) {
	die("Hacking attempt");
}

require_once("views/page_header.php");
require_once("includes/ogamecalc.php");

function counter_ligne($sql){
		global $db;
		$db->sql_query($sql);
		list($counter)=$db->sql_fetch_row();
		return $counter;
}

$servername = $server_config["servername"];
$home = $infos_config["home"];
if (isset($user_data)) {
	$new_users = counter_ligne( "SELECT COUNT(*) FROM ".TABLE_USER." WHERE is_active = '0'" );
	$current_trade = counter_ligne( "SELECT COUNT(*) FROM ".TABLE_TRADE." WHERE traderid = ".$user_data["id"]."  AND expiration_date >= ".time() );
	$trade_pos_user = counter_ligne( "SELECT COUNT(*) FROM ".TABLE_TRADE." WHERE traderid = ".$user_data["id"]." AND pos_user <> '0' AND expiration_date >= ".time() );
}
?>
<table width="90%">
<tr><th>
Bienvenue sur le: <font color="red"><?php echo $servername;?></font><br><br>
<?php
if (isset($user_data) && $user_data["is_admin"]==1 && $new_users !=0) echo "Il y a <a href=\"index.php?action=admin_members\"><font color=\"red\">".$new_users."</font> nouveau(x)</a> membre(s) en attente d'activation";
if ($current_trade !=0) {
	echo "<br>Vous avez <a href=\"index.php?action=listusertrade\"><font color=\"red\">".$current_trade."</font> offre(s)</a> en cours<br>";
	if ($trade_pos_user !=0) echo "Il y a <a href=\"index.php?action=listusertrade\"><font color=\"red\">".$trade_pos_user."</font> réservation(s)</a>";
}
?>
</tr></th>
<tr><td class="l">
<?php echo $home;?>
<br>
</table>
<br>
<table width="90%">
<tr><th colspan="6">Statistiques et Dernières entrées sur le serveur</th></tr>
<?php

	$pair=1;
	foreach ($Universes->universes_array() as $uni) {
	       if($pair)echo "<tr>\n";
		echo "\t<th width='100'><a href='index.php?action=listtrade&amp;uni=".$uni["id"]."'>".$uni["name"]."</a></th>\n";
		$LastTrade=$Trades->last($uni["id"]);
		if ($LastTrade){
	        echo "<td class='c'>".$Trades->count($uni["id"])." offres.</td>";
	        	if ($server_config["view_trade"] == "1" AND empty($user_data)) {
					echo "<td class='c' align='center'><font size =\"2\" color = \"yellow\">Serveur Privé</font><br>Visualisation des offres limitée aux membres<br>Veuillez vous identifier.</td>";
				} else {
		echo "<td class='c' align='center'><a href='index.php?action=viewtrade&amp;tradeid=".$LastTrade["id"]."'>&nbsp;";
		if ($LastTrade["offer_metal"]>0) echo " ".number_format($LastTrade["offer_metal"])." k Métal ";
		if ($LastTrade["offer_crystal"]>0) echo " ".number_format($LastTrade["offer_crystal"])." k Crystal ";
		if ($LastTrade["offer_deuterium"]>0) echo " ".number_format($LastTrade["offer_deuterium"])." k Deut ";
		echo " contre " ;

		if ($LastTrade["want_metal"]>0) echo " ".number_format($LastTrade["want_metal"])." k Métal ";
		if ($LastTrade["want_crystal"]>0) echo " ".number_format($LastTrade["want_crystal"])." k Crystal ";
		if ($LastTrade["want_deuterium"]>0) echo " ".number_format($LastTrade["want_deuterium"])." k Deut ";
		echo "</a> par <a href='index.php?action=profile&amp;id=".$LastTrade["traderid"]."'>".$LastTrade["username"]."</a>";
	//	$secssincepost=time()-$LastTrade["creation_date"];
	
		echo "<br>(".taux_echange($LastTrade["offer_metal"],$LastTrade["offer_crystal"],$LastTrade["offer_deuterium"],$LastTrade["want_metal"],$LastTrade["want_crystal"],$LastTrade["want_deuterium"]).")";
		echo "(Fini dans ".text_datediff($LastTrade["expiration_date"]).")";
//		if ($secssincepost>0) echo " (Il y a $secssincepost secondes)";
		echo "</td>";
				}
		}else
		{
		echo "<td colspan='2' valign='center' class='l'><em>Pas d'offre disponible dans cet univers</em></td>\n";
		}
		
		if ($pair==0) {
		 echo "</tr>\n";
		 $pair=1;
		}else $pair=0;
	}
		
		if ($pair==0)echo "<td colspan='3'>&nbsp;</td></tr>";

?>
</table>
<?php
require_once("views/page_tail.php");
?>
