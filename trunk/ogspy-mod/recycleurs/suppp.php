
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
define("TABLE_PHALANGES", $table_prefix."phalanges");



// On commence par récupérer les champs
if(isset($pub_id)) $id=$pub_id;
else $id="";


// on écrit la requête sql
    $query = "DELETE from " .TABLE_PHALANGES. " where id=$id";
   
    //insertion formulaire table
 $db->sql_query($query);
 
 redirection("index.php?action=recycleurs&sub_action=phalanges");


?>