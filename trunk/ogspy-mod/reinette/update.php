<?php
/**
 * @package Xtense 2
 * @author Unibozu
 * @version 1.0
 * @licence GNU
 */

if (!defined('IN_SPYOGAME')) die("Hacking Attemp!");
global $db;

$mod_folder = "reinette";
$mod_name = "reinette";
update_mod($mod_folder, $mod_name);

   list($root, $active) = $db->sql_fetch_row($db->sql_query("SELECT root, active FROM " .
    TABLE_MOD . " WHERE action = 'reinette'"));

require_once ("mod/{$root}/includes/functions.php");


	   	$query = "CREATE TABLE IF NOT EXISTS `".TABLE_TMP."` (
					`galaxy` enum('1','2','3','4','5','6','7','8','9') NOT NULL DEFAULT '1',
					`system` smallint(3) NOT NULL default '0',
					`row` enum('1','2','3','4','5','6','7','8','9','10','11','12','13','14','15') NOT NULL default '1',
                    `moon` enum('0','1') NOT NULL default '0',
                    `name` varchar(20) NOT NULL default '',
                      `ally` varchar(20) default NULL,
                      `player` varchar(20) default NULL,
                      `status` varchar(5) NOT NULL,
                      `last_update` int(11) NOT NULL default '0',
                    `last_update_user_id` int(11) NOT NULL default '0',
                      UNIQUE KEY univers (galaxy,system,`row`),
                      KEY player (player))";
				$db->sql_query($query);
                
                
                	 	$query = "CREATE TABLE IF NOT EXISTS `".TABLE_CFG."` (
					config_name varchar(255) NOT NULL default '',
                    config_value varchar(255) NOT NULL default '',
				  PRIMARY KEY  (config_name))";
				$db->sql_query($query);

// on injecte les valeurs
insert_config("nb_maj_uni","0");
insert_config("nb_maj_stat","0");
insert_config("last_maj_uni","1");
insert_config("last_maj_stat","1");
insert_config("version_pommedapi","0.0.0.3"); // version minimum pomme d api
insert_config("nb_ss_par_envoi","50"); // version minimum pomme d api
                
                
generate_config_cache();


?>