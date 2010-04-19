<?php
/***************************************************************************
*	filename	: deletetrade.php
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
?>
<table >
<tr>
	<td>
<?php
	$tradeid=intval($ogs_tradeid);
	if (isset($user_data) && isset($tradeid)) {

	echo "Demande de suppression d'offre</td><td>";

	$trade=$Trades->get_trade($tradeid);
	if ($trade){
		if ($trade["traderid"]==$user_data["id"] || $user_data["is_admin"]){
			$Trades->delete_trade($tradeid);
			echo "L'offre a été effacé";
			$trade_efface_success=true;
		}else
		{
			echo "Cette offre ($tradeid) ne vous appartient pas, vous ne pouvez donc pas l'effacer";
		}
	}else
	{
		echo "Je ne trouve pas d'offre correspondant au numero $tradeid";

	}

	}else
	{
		echo "Vous devez etre inscrit, connecté et utilisez les liens sur le serveur pour effacer une offre";
	}

?>
	</td>
</tr>
</table>

<?php
require_once("views/page_tail.php");
if ($trade_efface_success){
	redirection("index.php?action=listtrade");
}

?>