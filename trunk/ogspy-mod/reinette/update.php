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
generate_config_cache();


?>