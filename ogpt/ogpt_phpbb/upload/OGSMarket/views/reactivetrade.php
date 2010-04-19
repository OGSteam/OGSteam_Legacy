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

$trade=$Trades->get_trade($ogs_id);

// calcul du dŽlais de l'offre en fonction du dŽlais origninal
// et si il y a eu prolongation multiple, reduction au dŽlais maxi
// autorisŽ par l'admin pour une offre
$now = time();
$period = intval($trade["expiration_date"]) - intval($trade["creation_date"]);
$expiration = ($period) > $server_config["max_trade_delay_seco"] ? $server_config["max_trade_delay_seco"] + $now : $period + $now;

//MAJ de l'offre
$Trades->reactive_trade($ogs_id, $now, $expiration);

echo "Offre réactivée - ".$current_uni["name"];

require_once("views/page_tail.php");
redirection("index.php?action=listusertrade");
?>
