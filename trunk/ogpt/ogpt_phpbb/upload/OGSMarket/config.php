<?php
/***********************************************************************
 * filename	:	config.php
 * desc.	:	Inclusion Générales
 * created	: 	04/06/2006 ericalens
 *
 * *********************************************************************/

if (!defined('IN_OGSMARKET')) {
	die("Hacking attempt");
}
@import_request_variables('GP', "ogs_");

require_once("parameters/id.php");

if (!isset($db_database)) {
	die("OGSMarket n'est pas configuré. Vous devez editer le fichier parameters/id.php avec vos identifiants base de données.");
}

session_start();


// Options 
define("MODE_DEBUG", false);
//

if (!defined("INSTALL_IN_PROGRESS")) {
	//Tables utilisé par les programmes
	define("TABLE_COMMENT", $table_prefix."comment");
	define("TABLE_CONFIG", $table_prefix."config");
	define("TABLE_INFOS", $table_prefix."infos");
	define("TABLE_SESSIONS", $table_prefix."sessions");
	define("TABLE_TRADE", $table_prefix."trade");
	define("TABLE_TRADE_DEALS", $table_prefix."trade_deals");
	define("TABLE_UNIVERS", $table_prefix."univers");
	define("TABLE_USER", $table_prefix."user");
	define("TABLE_OGSPY_AUTH", $table_prefix."ogspy_auth");
	
}

require_once("includes/functions.php");
require_once("includes/mysql.php");
require_once("includes/univers.php");
require_once("includes/trade.php");
require_once("includes/user.php");
require_once("includes/modmarket.php");

//


$db = new sql_db($db_host, $db_user, $db_password, $db_database);

if (!$db->db_connect_id) {
		die("Impossible de se connecter à la base de données");
	}
init_serverconfig();

require_once("includes/cookies.php");

if (empty($link_css)) $link_css=$server_config["skin"];

if (!isset($user_data)){

	$sql="SELECT id FROM ".TABLE_SESSIONS." WHERE ip LIKE '".$_SERVER["REMOTE_ADDR"]."'";
	$result=$db->sql_query($sql);
	if (list($anon_id)=$db->sql_fetch_row($result)){
		$sql="UPDATE ".TABLE_SESSIONS." SET last_connect=".time()." where id=$anon_id";
		$db->sql_query($sql);
	}else{
		$sql="INSERT INTO ".TABLE_SESSIONS." (ip,last_connect) VALUES('".$_SERVER["REMOTE_ADDR"]."',".time().")";
		$db->sql_query($sql);
	}

}
	if (rand(1,10)>8){
		$sql="DELETE FROM ".TABLE_SESSIONS." WHERE last_connect<".(time()-3600);
	}
?>
