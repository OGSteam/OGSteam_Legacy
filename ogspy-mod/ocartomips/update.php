<?php
/**
* install.php 
* @package ocartomips
* @author 
* @update ianouf
* @link http://www.ogsteam.fr
*/

if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}

global $db;

$mod_folder = "ocartomips";
$mod_name = "ocartomips";
update_mod($mod_folder,$mod_name);
?>

