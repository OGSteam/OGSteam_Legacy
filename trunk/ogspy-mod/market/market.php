<?php

/** market.php Page principale du module market
* @package MOD_Market
* @author Jey2k <jey2k.ogsteam@gmail.com>
* @version 1.0
*/
if (!defined('IN_SPYOGAME')) die("Hacking attempt");
global $mode_debug;
$mode_debug=false;
require_once("views/page_header.php");


////////////////////////////////////////////////////////////
// variables
$Market_version = "0.2b";
define("TABLE_MARKET", substr(TABLE_USER, 0, strlen(TABLE_USER)-4)."market");
define("TABLE_MARKET_PROFIL", substr(TABLE_USER, 0, strlen(TABLE_USER)-4)."market_profile");
define("TABLE_MARKET_USER_SERVER_PROFILE", substr(TABLE_USER, 0, strlen(TABLE_USER)-4)."market_server_user_profile");
define("OGSPY_URL", "http://".$_SERVER["HTTP_HOST"].substr($_SERVER["PHP_SELF"], 0, -10));

$OGSMarket_trade_url = "/index.php?action=listtradexml&uni=";
$OGSMarket_uni_url = "/index.php?action=listuniversexml";
$OGSMarket_reg_url = "/index.php?action=inscription";
$OGSMarket_credits = '<font size="2"><i><b><a href="http://www.ogsteam.fr" target="_blank">OGSMarket</a></b> is an <b>OGSTeam Software</b> &copy; 2006</i></font>';
$modMarket_path = "mod/market/";
require_once($modMarket_path."market_functions.php");

// Vérification Mod Actif
$query = "SELECT `active` FROM `".TABLE_MOD."` WHERE `action`='Market' AND `active`='1' LIMIT 1";
if (!$db->sql_numrows($db->sql_query($query))) die("Hacking attempt");

// Affichage des onglets
echo "<table><tr>";
if (!(isset($pub_subaction))) $pub_subaction="normal";
if (($pub_subaction != "normal")&&($pub_subaction != "serverupdate")&&($pub_subaction != "insertserver")&&($pub_subaction != "updateuniverselist")&&($pub_subaction != "serverdelete")) {
		echo "\t\t\t"."<td class='c' width='150' onclick=\"window.location = 'index.php?action=market';\">";
		echo "<a style='cursor:pointer'><font color='lime'>Liste des Offres</font></a>";
		echo "</td>"."\n";
	}
	else {
		echo "\t\t\t"."<th width='150'>";
		echo "<a>Liste des Offres</a>";
		echo "</th>"."\n";
	}
if (($pub_subaction != "profil")&&($pub_subaction != "setprofile")) {
		echo "\t\t\t"."<td class='c' width='150' onclick=\"window.location = 'index.php?action=market&subaction=profil';\">";
		echo "<a style='cursor:pointer'><font color='lime'>Profil</font></a>";
		echo "</td>"."\n";
	}
	else {
		echo "\t\t\t"."<th width='150'>";
		echo "<a>Profil</a>";
		echo "</th>"."\n";
	}
echo "</tr></table>";

// On vérifie quelle action exécuter
if (($user_data["user_admin"] == 1) || ($user_data["user_coadmin"] == 1)) {
	if (isset($pub_subaction)){
		switch ($pub_subaction){
			case 'serverupdate':
				if (!(isset($pub_server_active))) $pub_server_active='0';
				update_universe($pub_server_id,$pub_server_url,$pub_server_password	,$pub_server_name,$pub_server_refresh,$pub_active_universe,$pub_server_active);
				update_server_offers(get_server_from_id($pub_server_id));
				break;
			case 'insertserver':
				if (!(isset($pub_server_active))) $pub_server_active='0';
				create_universe($pub_server_url,$pub_server_password	,$pub_server_name,$pub_server_refresh,$pub_server_active);
				break;
			case 'updateuniverselist':
				$query = "SELECT `server_id`,`server_url`, `server_name`, `server_password`, `server_active`, `universes_list`, `universes_list_timestamp`, `trades_list`, `trades_list_timestamp`, `server_refresh`, `active_universe`, `trades_count`, UNIX_TIMESTAMP() as maintenant FROM ".TABLE_MARKET." WHERE `server_id`='".$pub_server_id."'";
				$result = $db->sql_query($query);
				$server = $db->sql_fetch_assoc($result);
				update_server_universes($server);
				break;
			case 'serverdelete':
				delete_server($pub_server_id);
				break;
		}
	}
}

// On récupère tous les serveurs actifs pour vérifier s'il sont à jour
$query = "SELECT `server_id`,`server_url`, `server_name`, `server_password`, `server_active`, `universes_list`, `universes_list_timestamp`, `trades_list`, `trades_list_timestamp`, `server_refresh`, `active_universe`, `trades_count`, UNIX_TIMESTAMP() as maintenant FROM ".TABLE_MARKET." WHERE server_active='1' and `active_universe`!='0'";
$result = $db->sql_query($query);
$servers = array();
while ($server = $db->sql_fetch_assoc($result)) {
   $servers[]=$server;
}

switch ($pub_subaction){
	case "profil":
		require_once($modMarket_path."market_profil.php");
		break;
	case "setprofile":
		require_once($modMarket_path."market_profil.php");
		break;
	case "serveruserprofile":
		require_once($modMarket_path."market_server_profil.php");
		break;
	default:
		require_once($modMarket_path."market_viewtrades.php");
		if (($user_data["user_admin"] == 1) || ($user_data["user_coadmin"] == 1)) {
			require_once($modMarket_path."market_admin.php");
		}
		break;
}

require_once("views/page_tail.php");
?>
