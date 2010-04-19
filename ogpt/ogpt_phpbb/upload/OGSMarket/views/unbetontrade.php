<?php
/***************************************************************************
*	filename	: betontrade.php
*	desc.		:
*	Author		: ericalens - http://ogs.servebbs.net/
*	modified	: samedi 17 juin 2006, 17:31:26 (UTC+0200)
***************************************************************************/
if (!defined('IN_OGSMARKET')) {
	die("Hacking attempt");
}

require_once("views/page_header.php");

echo "<table><tr><td>";
if (!empty($ogs_tradeid)){
	$Trade=$Trades->get_trade($ogs_tradeid);

	if ($Trade) {
		if ($Trade["expiration_date"]<time()) {
			echo "Cette offre n'est plus valide, sa date d'expiration est atteinte";
		}else
		{
			if ($Trade["pos_user"]<>0)
			{
				$out=$Trades->unpos_new($Trade["id"]);
				
				echo "<b>La déréservation de l'offre n° ".$ogs_tradeid." par l'utilisateur ".$user_data["name"]." a donnée : ".$out."</b>";
			}
		}

	}
}

echo "</td></tr></table>";
redirection("index.php?action=listtrade");
require_once("views/page_tail.php");
?>
