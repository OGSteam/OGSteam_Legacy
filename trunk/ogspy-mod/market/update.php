<?php
/** update.php Script de mise à jour du module
* @package MOD_Market
* @author Jey2k <jey2k.ogsteam@gmail.com>
* @version 1.0
*/
//define("IN_SPYOGAME", true);
require_once("common.php");

define("TABLE_MARKET", substr(TABLE_USER, 0, strlen(TABLE_USER)-4)."market");
define("TABLE_MARKET_PROFILE", substr(TABLE_USER, 0, strlen(TABLE_USER)-4)."market_profile");
define("TABLE_MARKET_USER_SERVER_PROFILE", substr(TABLE_USER, 0, strlen(TABLE_USER)-4)."market_server_user_profile");


$request = "SELECT version FROM ".TABLE_MOD." WHERE title='Market' LIMIT 1";
$result = $db->sql_query($request);
$val = $db->sql_fetch_assoc($result);
$version = $val['version'];

$requests = array();
switch ($version) {
	case "0.1" :
	case "0.1b" :
		$requests[] = "DROP TABLE IF EXISTS ".TABLE_MARKET;
		$requests[] = 'CREATE TABLE IF NOT EXISTS `'.TABLE_MARKET.'` ('
		        . ' `server_id` int(11) NOT NULL auto_increment,'
		        . ' `server_url` varchar(255) NOT NULL default  \'\','
		        . ' `server_name` varchar(255) NOT NULL default \'\','
		        . ' `server_password` varchar(255) default NULL,'
		        . ' `server_active` enum(\'0\',\'1\') NOT NULL default \'0\','
		        . ' `universes_list` blob,'
		        . ' `universes_list_timestamp` int(11) default NULL,'
		        . ' `trades_list` blob,'
		        . ' `trades_list_timestamp` int(11) default NULL,'
		        . ' `server_refresh` int(11) NOT NULL default \'60\','
		        . ' `active_universe` int(11) default NULL,'
		        . ' `trades_count` int(11) NOT NULL default \'0\','
		        . ' PRIMARY KEY (`server_id`)'
		        . ' );';
		$requests[] = "INSERT INTO `".TABLE_MARKET."` (`server_id`, `server_url`, `server_name`, `server_password`, `server_active`, `universes_list`, `universes_list_timestamp`, `trades_list`, `trades_list_timestamp`, `server_refresh`, `active_universe`, `trades_count`) VALUES ('', 'http://market.ogsteam.fr/', 'Serveur OGSMarket Officiel', NULL, '1', '', '0', '', '0', '60', '', '0')";
		$version = "0.2";
		break;
	case "0.2" :
		$version = "0.2a";
		break;
	case "0.2a":
		$requests[] = "CREATE TABLE IF NOT EXISTS `".TABLE_MARKET_PROFILE."` ("
					  ."`user_id` int(11) NOT NULL primary key COMMENT 'Identificateur utilisateur',"
					  ."`email` varchar(250) NOT NULL default '' COMMENT 'Email',"
					  ."`msn` varchar(100) NOT NULL default '' COMMENT 'Email MSN',"
					  ."`pm_link` varchar(30) NOT NULL default '' COMMENT 'Lien Message Privé',"
					  ."`irc_nick` varchar(30) NOT NULL default '' COMMENT 'Nick IRC',"
					  ."`note` varchar(250) NOT NULL default '' COMMENT 'Description User')";
		$requests[] = "CREATE TABLE IF NOT EXISTS `".TABLE_MARKET_USER_SERVER_PROFILE."` ("
        . " `user_id` INT NOT NULL, "
        . " `server_id` INT NOT NULL, "
        . " `password` VARCHAR(255), "
        . " `last_check` DATETIME,"
        . " PRIMARY KEY (`user_id`, `server_id`)"
        . " )";
		$version = "0.2b";
		break;
	default:
		die("Aucune mise à jour est disponible");
}

$requests[] = "UPDATE ".TABLE_MOD." SET version='".$version."' WHERE title='Market' LIMIT 1";
foreach ($requests as $request) {
	$db->sql_query($request);
	//echo $request."<br>\n";
}
?>
	<h3 align='center'><font color='yellow'>Mise à jour du serveur OGSpy vers la version <?php echo $version;?> effectuée avec succès</font></h3>
