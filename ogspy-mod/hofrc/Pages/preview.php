<?php

/**
 * preview.php 
 * @package HofRC
 * @author Shad
 * @link http://www.ogsteam.fr
 * @version : 0.0.1
 */


// L'appel direct est interdit....
if (!defined('IN_SPYOGAME')) die("Hacking attempt");
//On vérifie que le mod est activé
$query = "SELECT `active` FROM `".TABLE_MOD."` WHERE `action`='hofrc' AND `active`='1' LIMIT 1";
if (!$db->sql_numrows($db->sql_query($query))) die("Hacking attempt");

//Définitions
global $db, $table_prefix, $prefixe;
require_once("views/page_header_2.php");
$id_rc = $_GET["id"];
$rc= UNparseRC($id_rc);

		echo "<table align='center'>"."\n";
    	echo "<tr><td class='c'>".nl2br($rc)."</td></tr>"."\n";
    	echo "</table>";
	    echo "<br />";
//require_once("views/page_tail_2.php");
?>