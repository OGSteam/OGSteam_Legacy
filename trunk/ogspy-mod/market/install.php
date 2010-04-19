<?php
/** install.php Script d'installation du Mod Market
* @package MOD_Market
* @author Jey2k <jey2k.ogsteam@gmail.com>
* @version 1.0
*/
define("IN_SPYOGAME", true);
require_once("common.php");

define("TABLE_MARKET", substr(TABLE_USER, 0, strlen(TABLE_USER)-4)."market");
define("TABLE_MARKET_PROFIL", substr(TABLE_USER, 0, strlen(TABLE_USER)-4)."market_profile");

$query  = "INSERT INTO ".TABLE_MOD." ( title, menu, action, root, link, version, active) VALUES ('Market','Market','Market','market','market.php','0.2b','1');";
$db->sql_query($query);

$query = 'CREATE TABLE IF NOT EXISTS `'.TABLE_MARKET.'` ('
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
$db->sql_query($query);

$query = "INSERT INTO `".TABLE_MARKET."` (`server_id`, `server_url`, `server_name`, `server_password`, `server_active`, `universes_list`, `universes_list_timestamp`, `trades_list`, `trades_list_timestamp`, `server_refresh`, `active_universe`, `trades_count`) VALUES ('', 'http://market.ogsteam.fr/', 'Serveur OGSMarket Officiel', NULL, '1', '', '0', '', '0', '60', '', '0')";
$db->sql_query($query);

$query = "CREATE TABLE IF NOT EXISTS `".TABLE_MARKET_PROFIL."` ("
					  ."`user_id` int(11) NOT NULL primary key COMMENT 'Identificateur utilisateur',"
					  ."`email` varchar(250) NOT NULL default '' COMMENT 'Email',"
					  ."`msn` varchar(100) NOT NULL default '' COMMENT 'Email MSN',"
					  ."`pm_link` varchar(30) NOT NULL default '' COMMENT 'Lien Message Privé',"
					  ."`irc_nick` varchar(30) NOT NULL default '' COMMENT 'Nick IRC',"
					  ."`note` varchar(250) NOT NULL default '' COMMENT 'Description User')";
$db->sql_query($query);

$query = 'CREATE TABLE `ogspy_market_server_user_profile` ('
        . ' `user_id` INT NOT NULL, '
        . ' `server_id` INT NOT NULL, '
        . ' `password` VARCHAR(255), '
        . ' `last_check` DATETIME,'
        . ' PRIMARY KEY (`user_id`, `server_id`)'
        . ' )';
$db->sql_query($query);        
?>