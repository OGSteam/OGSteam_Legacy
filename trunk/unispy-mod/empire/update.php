<?php
/**
* update.php du mod empire
* @package Empire
* @author ben.12
* @link http://www.ogsteam.fr
*/
if (!defined('IN_SPYOGAME')) {
    die("Hacking attempt");
}

global $db;

define("TABLE_MOD_EMPIRE", substr(TABLE_USER, 0, strlen(TABLE_USER)-4)."mod_empire");

?>
