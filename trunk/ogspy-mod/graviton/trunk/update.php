<?php

/**
* update.php Fichier de mise � jour du MOD Graviton
* @package MOD Graviton
* @author Kal Nightmare
* @link http://www.ogsteam.fr
*/


if (!defined('IN_SPYOGAME')) {
    die("Hacking attempt");
}

global $db;


// mise � jour du num�ro de version
	$query  = 'UPDATE `'.TABLE_MOD.'` SET `version` = \'0.6\' WHERE `title` = \'Graviton\'';
	$db->sql_query($query);
	$query  = 'UPDATE `'.TABLE_MOD.'` SET `root`=\'MODGraviton\'  WHERE `title` = \'Graviton\'';
	$db->sql_query($query);
//renomemr le dossier
if (rename('mod/graviton','mod/MODGraviton')!=TRUE)
	echo '<script type="text/javascript">';
	echo 'alert("Renomer le repertoite graviton en MODGraviton")';
	echo '</script>';

?>