<?php
/***********************************************************************
 * filename	:	index.php
 * desc.	:	Fichier principal
 * created	: 	05/06/2006 ericalens
 *
 * *********************************************************************/

define("IN_OGSMARKET", true);

require_once("config.php");

$php_start = benchmark();
$sql_timing = 0;

if (MODE_DEBUG) {
	require_once("views/debug.php");
}

if (is_dir("install") && $ogs_action != "message") {
	redirection("index.php?action=message");
}

if (!isset($ogs_action)) {
	$ogs_action = "";
}

switch ($ogs_action) {

	case "pris_sur_le_fait":
		require_once("views/pris_sur_le_fait.php");
		break;
		
	case "en_dev":
		require_once("views/en_dev.php");
		break;
	
	case "message":
		require_once("views/message.php");
		break;

	case "FAQ":
		require_once("views/FAQ.php");
		break;

	case "addtrade":
		require_once("views/addtrade.php");
		break;

	case "membre":
		require_once("views/membre.php");
		break;

	case "betontrade":
		require_once("views/betontrade.php");
		break;
		
	case "unbetontrade":
		require_once("views/unbetontrade.php");
		break;

	case "contributeur":
		require_once("views/contributeur.php");
		break;

	case "debug":
		require_once("views/debug2.php");
		break;
		
	case "deletetrade":
		require_once("views/deletetrade.php");
		break;
		
	case "editprofile":
		require_once("views/editprofile.php");
		break;
		
	case "inscription":
		require_once("views/inscription.php");
		break;
		
	case "listtrade":
		require_once("views/listtrade.php");
		break;
		
	case "listusertrade":
		require_once("views/listusertrade.php");
		break;
		
	case "listtradexml":
		require_once("views/listtradexml.php");
		break;

	case "listuniversexml":
		require_once("views/listuniversexml.php");
		break;

	case "pingxml":
		require_once("views/pingxml.php");
		break;

	case "admin":
		require_once("views/admin.php");
		break;
		
	case "admin_trade":
		require_once("views/admin_trade.php");
		break;

	case "general":
		require_once("views/general.php");
		break;

	case "rss":
		require_once("views/rss.php");
		break;

	case "login":
		require_once("views/login.php");
		break;

	case "newtrade":
		require_once("views/newtrade.php");
		break;
		
	case "options":
		require_once("views/options.php");
		break;

	case "pjirc":
		require_once("views/pjirc.php");
		break;

	case "profile":
		require_once("views/profile.php");
		break;

	case "setprofile":
		require_once("views/setprofile.php");
		break;

	case "test":
		require_once("views/ajax_test.php");
		break;

	case "viewtrade":
		require_once("views/viewtrade.php");
		break;
		
	case "modifytrade":
		require_once("views/modifytrade.php");
		break;
		
	case "upd_trade":
		require_once("views/updtrade.php");
		break;
		
	case "reactive_trade":
		require_once("views/reactivetrade.php");
		break;

	case "admin_general":
		require_once("views/admin_general.php");
		break;

	case "admin_members":
		require_once("views/admin_members.php");
		break;

	case "admin_uni":
		require_once("views/admin_univers.php");
		break;

	case "admin_new_univers":
		require_once("views/admin_new_univers.php");
		break;

//Convertisseur de ressources

	case "Convertisseur":
		require_once("views/convertisseur.php");
		break;

//Fonction

	case "admin_new_univers_execute":
		$result = $Universes->insert_new( $ogs_url, $ogs_name );
		if($result !== true) redirection("index.php?action=admin_new_univers&info=".$result);
		require_once("views/admin_new_univers.php");
		break;

	case "admin_delete_univers":
		$result = $Universes->delete_universe( $ogs_universeid );
		if($result !== true) redirection("index.php?action=admin_uni&info=".$result);
		require_once("views/admin_univers.php");
		break;

	case "logout":
		unset($_SESSION["username"]);
		unset($_SESSION["userpass"]);
		redirection("index.php");
		break;

	case "newaccount":
		$result = $Users->newaccount($ogs_password, $ogs_name, $ogs_repassword, $ogs_email, $ogs_email_msn, $ogs_pm_link, $ogs_irc_nick, $ogs_note, $ogs_active);
		if($result !== true) redirection("index.php?action=inscription&info=".$result);
		require_once("views/login.php");
		break;

	case "admin_delete_user":
		$result = $Users->delete_account( $ogs_user_id );
		if($result !== true) redirection("index.php?action=admin_members&info=".$result);
		require_once("views/admin_members.php");
		break;

	case "admin_set_active":
		$result = $Users->set_active($ogs_user_id);
		if($result !== true) redirection("index.php?action=admin_members&info=".$result);
		require_once("views/admin_members.php");
		break;

	case "admin_unset_active":
		$result = $Users->unset_active($ogs_user_id);
		if($result !== true) redirection("index.php?action=admin_members&info=".$result);
		require_once("views/admin_members.php");
		break;

	case "admin_set_admin":
		$result = $Users->set_admin($ogs_user_id);
		if($result !== true) redirection("index.php?action=admin_members&info=".$result);
		require_once("views/admin_members.php");
		break;

	case "admin_unset_admin":
		$result = $Users->unset_admin($ogs_user_id);
		if($result !== true) redirection("index.php?action=admin_members&info=".$result);
		require_once("views/admin_members.php");
		break;

	case "admin_set_moderator":
		$result = $Users->set_moderator($ogs_user_id);
		if($result !== true) redirection("index.php?action=admin_members&info=".$result);
		require_once("views/admin_members.php");
		break;

	case "admin_unset_moderator":
		$result = $Users->unset_moderator($ogs_user_id);
		if($result !== true) redirection("index.php?action=admin_members&info=".$result);
		require_once("views/admin_members.php");
		break;

//page en défaut

	default:
		require_once("views/home.php");
		break;

}

?>