<?php
/***************************************************************************
*	filename	: updtrade.php
*	desc.		: 
*	Author		: ericalens - http://ogs.servebbs.net/
*	created		: mardi 6 Juin 2006, 14:36:42 (UTC+0200)
***************************************************************************/

if (!defined('IN_OGSMARKET')) {
die("Hacking attempt");
}

require_once("views/page_header.php");

if ($user_data["is_active"]!=1) die ("Impossible de modifer cette offre, l'utilisateur est inactif.");

if (((intval($ogs_offer_metal)<0) or intval($ogs_offer_crystal)<0 or intval($ogs_offer_deuterium)<0) or
	(intval($ogs_want_metal)<0 or intval($ogs_want_crystal)<0 or intval($ogs_want_deuterium)<0)
){

	echo "Vos offres et demandes en ressources ne peuvent etre négatives :";
	
	require_once("views/page_tail.php");
	exit;
}

$totalressources=intval($ogs_offer_metal)+intval($ogs_offer_crystal)+intval($ogs_offer_deuterium);

if ($totalressources<=0){
	echo "Le total des ressources offertes est égal à 0.<br>Vous devez fournir une valeur valide >0 pour , au moins, une de vos ressources offertes.";

	require_once("views/page_tail.php");
	exit;
}


$totalressources=intval($ogs_want_metal)+intval($ogs_want_crystal)+intval($ogs_want_deuterium);

if ($totalressources<=0){
	echo "Le total des ressources demandés est égal à 0.<br>Vous devez fournir une valeur valide >0 pour , au moins, une de vos ressources demandés";

	require_once("views/page_tail.php");
	exit;
}

if (intval($ogs_expiration_hours)*60*60>$server_config["max_trade_delay_seco"]){

	echo "Le delai de prolongation ne doit dépasser ";
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

//$expiration= ($ogs_expiration_hours == '0') ? $ogs_expiration_date : $ogs_expiration_date+intval($ogs_expiration_hours)*60*60;

// Calcul de la prolongation
$maxi = $server_config["max_trade_delay_seco"]*2;

if ($ogs_expiration_hours == '0') 
	$expiration = $ogs_expiration_date;
else if (intval($ogs_expiration_date)-intval($ogs_creation_date) + (intval($ogs_expiration_hours)*60*60) < $maxi)
	$expiration = intval($ogs_expiration_date)+(intval($ogs_expiration_hours)*60*60);
else
	$expiration = intval($ogs_creation_date)+$maxi;

//Update de l'offre
$Trades->upd_trade( $ogs_tradeid,$user_data["id"],$current_uni["id"],
			intval($ogs_offer_metal),
			intval($ogs_offer_crystal),
			intval($ogs_offer_deuterium),
			intval($ogs_want_metal),
			intval($ogs_want_crystal),
			intval($ogs_want_deuterium),
			intval($expiration),
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
echo "Offre modifiée sur l'univers ".$current_uni["name"];

require_once("views/page_tail.php");
redirection("index.php?action=listusertrade");
?>
