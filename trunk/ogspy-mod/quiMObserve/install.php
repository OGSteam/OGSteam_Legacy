<?php
/**
* install.php 
 * @package QuiMObserve
 * @author Santory
 * @link http://www.ogsteam.fr
 * @version : 0.1e
 */
if (!defined('IN_SPYOGAME')) {
    die("Hacking attempt");
}

global $db;
//Définitions
global $db;
global $table_prefix;
define("TABLE_QUIMOBSERVE", $table_prefix."MOD_quimobserve");
define("TABLE_QUIMOBSERVE_ARCHIVE", $table_prefix."MOD_quimobserve_archive");

$query = "CREATE TABLE IF NOT EXISTS  `".TABLE_QUIMOBSERVE."` (
  `spy_id` INT( 11 ) NOT NULL AUTO_INCREMENT ,
  `spy_planetteEspion` VARCHAR( 9 ) DEFAULT '0:0:0' NOT NULL ,
  `spy_maplanette` VARCHAR( 9 ) DEFAULT '0:0:0' NOT NULL ,
  `sender_id` INT( 11 ) DEFAULT '0' NOT NULL ,
  `datadate` INT( 11 ) DEFAULT '0' NOT NULL ,
  `pourcentage` INT( 1 ) DEFAULT '0' NOT NULL,
  INDEX ( `spy_planetteEspion`),
  INDEX (  `spy_maplanette` ),
  INDEX ( `sender_id` ) ,
  UNIQUE (
    `spy_id` 
  )
) TYPE = MYISAM ";
$db->sql_query($query);

$query = "CREATE TABLE IF NOT EXISTS  `".TABLE_QUIMOBSERVE_ARCHIVE."` (
  `spy_id_archive` INT( 11 ) NOT NULL AUTO_INCREMENT ,
  `spy_planetteEspion` VARCHAR( 9 ) DEFAULT '0:0:0' NOT NULL ,
  `spy_maplanette` VARCHAR( 9 ) DEFAULT '0:0:0' NOT NULL ,
  `number` INT( 11 ) DEFAULT '0' NOT NULL ,
  `sender_id` INT( 11 ) DEFAULT '0' NOT NULL ,
  `datadate` int( 6 ) DEFAULT '0' NOT NULL ,

  INDEX ( `spy_planetteEspion`),
  INDEX (  `spy_maplanette` ),
  INDEX ( `sender_id` ) ,
  INDEX ( `datadate` ) ,  
  UNIQUE (
    `spy_id_archive`
  )
) TYPE = MYISAM ";
$db->sql_query($query);

if (file_exists('mod/QuiMObserve/version.txt')) { 
	$file = file('mod/QuiMObserve/version.txt'); 
}

$query = "INSERT INTO ".TABLE_MOD." (id, title, menu, action, root, link, version, active) VALUES ('','QuiMobserve','Qui m\'observe','QuiMobserve','QuiMObserve','QuiMobserve.php','".trim($file[1])."','1')";
$db->sql_query($query);
?>