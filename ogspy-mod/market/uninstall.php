<?php
/** uninstall.php Script de désinstallation du Mod Market
* @package MOD_Market
* @author Jey2k <jey2k.ogsteam@gmail.com>
* @version 1.0
*/
define("IN_SPYOGAME", true);
require_once("common.php");

define("TABLE_MARKET", substr(TABLE_USER, 0, strlen(TABLE_USER)-4)."market");
define("TABLE_MARKET_PROFIL", substr(TABLE_USER, 0, strlen(TABLE_USER)-4)."market_profile");

$query = "DELETE FROM ".TABLE_CONFIG." WHERE config_name='Market_universe'";
$db->sql_query($query);
$query = "DROP TABLE IF EXISTS ".TABLE_MARKET;
$db->sql_query($query);
$query = "DROP TABLE IF EXISTS ".TABLE_MARKET_PROFIL;
$db->sql_query($query);
?>