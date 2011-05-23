<?php

/**
* update.php Fichier de mise à jour du MOD Gestion MOD
* @package Gestion MOD
* @author Kal Nightmare
* @link http://www.ogsteam.fr
*/


if (!defined('IN_SPYOGAME')) {
    die("Hacking attempt");
}

global $db;


$query  = $db->sql_query("SELECT `version` FROM `".TABLE_MOD."` WHERE `title` = 'Gestion MOD'");

$result = $db->sql_fetch_assoc($query);
$version = $result['version'];


// mise à jour du numéro de version
$filename = 'mod/gestionMod/version.txt';
if (file_exists($filename)) $file = file($filename);

$query  = "UPDATE ".TABLE_MOD." SET version = '".trim($file[1])."' WHERE title = 'gestionMod'";
$db->sql_query($query);

?>
