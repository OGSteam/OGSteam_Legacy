<?php
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

global $db;

// Suppression de la ligne, dans la table des mods.
$db->sql_query("DELETE FROM ".TABLE_MOD." WHERE title='OGSCalc'");
?>
