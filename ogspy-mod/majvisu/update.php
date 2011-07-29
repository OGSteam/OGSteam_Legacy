<?php
/**
* update.php 
* @package majvisu
* @author 
* @update ianouf
* @link http://www.ogsteam.fr
*/

if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}

global $db;

$mod_folder = "majvisu";
$mod_name = "majvisu";
update_mod($mod_folder,$mod_name);
?>

