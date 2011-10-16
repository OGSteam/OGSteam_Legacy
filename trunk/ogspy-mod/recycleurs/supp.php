
<?php
/***************************************************************************
*	filename	: supp.php		
*	desc.		: fichier suppression
*	Author : DeusIrae
*	created : 25/08/07
*	modified	: 03/12/2007 
***************************************************************************/

if (!defined('IN_SPYOGAME')) die("Hacking attempt");

global $db;
global $table_prefix;
define("TABLE_RECYCLEURS", $table_prefix."recycleurs");

$query = "SELECT `active` FROM `".TABLE_MOD."` WHERE `action`='recycleurs' AND `active`='1' LIMIT 1"; //test pour voir si le mod est active
if (!$db->sql_numrows($db->sql_query($query))) die("Hacking attempt");


// On commence par récupérer les champs
if(isset($pub_id)) $id=$pub_id;
else $id="";


// on écrit la requête sql
    $query = "DELETE from " .TABLE_RECYCLEURS. " where id=$id";
   
    //insertion formulaire table
 $db->sql_query($query);
 
 redirection("index.php?action=recycleurs&subaction=recycleurs");


?>

