<?php
/***************************************************************************
*	filename	: listtradexml.php
*	desc.		:
*	Author		: jey2k - http://ogs.servebbs.net/
*	created		: 23/08/2006
*	modified	: 25/08/2006 Ajout authentification
***************************************************************************/

if (!defined('IN_OGSMARKET')) {
	die("Hacking attempt");
}
require_once("views/page_header_xml.php");
if(!isset($ogs_sortby)) $ogs_sortby = "";
echo "<market>";
switch ($server_config["market_read_access"])
{
	case "0":
		echo "<access><TYPE>Public</TYPE><RESULT>OK</RESULT></access>";
		affiche_liste($ogs_sortby,$current_uni);
		break;
	case "1":
		if(!isset($ogs_marketpwd)) $ogs_marketpwd = "";
		if (cModMarket::checkMD5Password($ogs_marketpwd)) {
			echo "<access><TYPE>Password</TYPE><RESULT>OK</RESULT></access>";
			affiche_liste($ogs_sortby,$current_uni);
		} else {
			echo "<access><TYPE>Password</TYPE><RESULT>NOK</RESULT></access>";
		}
		break;
	case "2":
		if(!isset($ogs_ogspyurl)) $ogs_ogspyurl = "";
		if (cModMarket::checkURLAuth($ogs_ogspyurl,'read')){
			echo "<access><TYPE>URI</TYPE><RESULT>OK</RESULT></access>";
			affiche_liste($ogs_sortby,$current_uni);
		} else {
			echo "<access><TYPE>URI</TYPE><RESULT>NOK:".$ogs_ogspyurl."</RESULT></access>";
		}
		break;
	case "3":
		if(!isset($ogs_marketpwd)) $ogs_marketpwd = "";
		if(!isset($ogs_ogspyurl)) $ogs_ogspyurl = "";
		if ((cModMarket::checkURLAuth($ogs_ogspyurl,'read'))&&(cModMarket::checkMD5Password($ogs_marketpwd))) {
			echo "<access><TYPE>URI</TYPE><RESULT>OK</RESULT></access>";
			affiche_liste($ogs_sortby,$current_uni);
		} else {
			echo "<access><TYPE>URI</TYPE><RESULT>NOK</RESULT></access>";
		}
		break;
	default:
		echo "<ERROR>Mauvais type identification</ERROR>";
}

function affiche_liste($ogs_sortby,$current_uni)
{
	global $Trades;
	echo "<offers_list>";
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
		default:
		$orderby="creation_date desc";
			break;
	}
	echo $Trades->trades_array_xml($current_uni["id"],$orderby,false);
	echo "</offers_list>";
}
?>
</market>