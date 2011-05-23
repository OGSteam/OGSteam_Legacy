<?php
/**
* uninstall.php 
 * @package QuiMobserve
 * @author Santory
 * @link http://www.ogsteam.fr
 * @version : 0.1d
 */

if (!defined('IN_SPYOGAME')) {
    die("Hacking attempt");
}

global $db;
define("TABLE_QUIMOBSERVE", $table_prefix."MOD_quimobserve");
define("TABLE_QUIMOBSERVE_ARCHIVE", $table_prefix."MOD_quimobserve_archive");

//Suppression de la table MOD_quimobserve
$query = "DROP TABLE IF EXISTS ".TABLE_QUIMOBSERVE.";";
$db->sql_query($query);

//Suppression de la table MOD_quimobserve_archive
$query = "DROP TABLE IF EXISTS ".TABLE_QUIMOBSERVE_ARCHIVE.";";
$db->sql_query($query);

$query = "DELETE FROM ".TABLE_MOD." WHERE title='QuiMobserve'";

$db->sql_query($query);
?>