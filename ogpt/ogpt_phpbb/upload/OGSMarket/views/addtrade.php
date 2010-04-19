<?php
/***************************************************************************
*	filename	: addtrade.php
*	desc.		: 
*	Author		: ericalens - http://ogs.servebbs.net/
*	created		: mardi 6 Juin 2006, 14:36:42 (UTC+0200)
***************************************************************************/

if (!defined('IN_OGSMARKET')) {
die("Hacking attempt");
}

require_once("views/page_header.php");

if ($user_data["is_active"]!=1) die ("Impossible d'ajouter une nouvelle offre, l'utilisateur est inactif.");

if (((intval($ogs_offer_metal)<0) or intval($ogs_offer_crystal)<0 or intval($ogs_offer_deuterium)<0) or
	(intval($ogs_want_metal)<0 or intval($ogs_want_crystal)<0 or intval($ogs_want_deuterium)<0)
){

	echo "Vos offres et demandes en ressources ne peuvent etre n�gatives :";
	
	require_once("views/page_tail.php");
	exit;
}

$totalressources=intval($ogs_offer_metal)+intval($ogs_offer_crystal)+intval($ogs_offer_deuterium);

if ($totalressources<=0){
	echo "Le total des ressources offertes est �gal � 0.<br>Vous devez fournir une valeur valide >0 pour , au moins, une de vos ressources offertes.";

	require_once("views/page_tail.php");
	exit;
}


$totalressources=intval($ogs_want_metal)+intval($ogs_want_crystal)+intval($ogs_want_deuterium);

if ($totalressources<=0){
	echo "Le total des ressources demand�s est �gal � 0.<br>Vous devez fournir une valeur valide >0 pour , au moins, une de vos ressources demand�s";

	require_once("views/page_tail.php");
	exit;
}

if (intval($ogs_expiration_hours)<1 || intval($ogs_expiration_hours)*60*60>$server_config["max_trade_delay_seco"]){

	echo "Le delai de validit� doit etre compris entre 1 heure et ";
	echo intval($server_config["max_trade_delay_seco"]/(60*60))." heures ";

	echo " (".text_datediff(time()+$server_config["max_trade_delay_seco"]).")";
	require_once("views/page_tail.php");
	exit;
}
if (!(isset($ogs_deliver_g1))) $ogs_deliver_g1="0";
if (!(isset($ogs_deliver_g2))) $ogs_deliver_g2="0";
if (!(isset($ogs_deliver_g3))) $ogs_deliver_g3="0";
if (!(isset($ogs_deliver_g4))) $ogs_deliver_g4="0";
if (!(isset($ogs_deliver_g5))) $ogs_deliver_g5="0";
if (!(isset($ogs_deliver_g6))) $ogs_deliver_g6="0";
if (!(isset($ogs_deliver_g7))) $ogs_deliver_g7="0";
if (!(isset($ogs_deliver_g8))) $ogs_deliver_g8="0";
if (!(isset($ogs_deliver_g9))) $ogs_deliver_g9="0";
if (!(isset($ogs_refunding_g1))) $ogs_refunding_g1="0";
if (!(isset($ogs_refunding_g2))) $ogs_refunding_g2="0";
if (!(isset($ogs_refunding_g3))) $ogs_refunding_g3="0";
if (!(isset($ogs_refunding_g4))) $ogs_refunding_g4="0";
if (!(isset($ogs_refunding_g5))) $ogs_refunding_g5="0";
if (!(isset($ogs_refunding_g6))) $ogs_refunding_g6="0";
if (!(isset($ogs_refunding_g7))) $ogs_refunding_g7="0";
if (!(isset($ogs_refunding_g8))) $ogs_refunding_g8="0";
if (!(isset($ogs_refunding_g9))) $ogs_refunding_g9="0";


$Trades->insert_new( $user_data["id"],$current_uni["id"],
			intval($ogs_offer_metal),
			intval($ogs_offer_crystal),
			intval($ogs_offer_deuterium),
			intval($ogs_want_metal),
			intval($ogs_want_crystal),
			intval($ogs_want_deuterium),
			intval($ogs_expiration_hours)*60*60,
			get_htmlspecialchars($ogs_note),
			$ogs_deliver_g1,
			$ogs_deliver_g2,
			$ogs_deliver_g3,
			$ogs_deliver_g4,
			$ogs_deliver_g5,
			$ogs_deliver_g6,
			$ogs_deliver_g7,
			$ogs_deliver_g8,
			$ogs_deliver_g9,
			$ogs_refunding_g1,
			$ogs_refunding_g2,
			$ogs_refunding_g3,
			$ogs_refunding_g4,
			$ogs_refunding_g5,
			$ogs_refunding_g6,
			$ogs_refunding_g7,
			$ogs_refunding_g8,
			$ogs_refunding_g9);
echo "Offre ajout�e sur l'univers ".$current_uni["name"];

require_once("views/page_tail.php");
redirection("index.php?action=listusertrade");
?>
