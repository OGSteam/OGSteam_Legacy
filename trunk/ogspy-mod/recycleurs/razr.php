
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
define("TABLE_phalanges", $table_prefix."phalanges");
define("TABLE_recycleurs", $table_prefix."recycleurs");



// On commence par récupérer les champs
if(isset($pub_raz)) $raz=$pub_raz;
else $raz="";

    $query = "DELETE from " .TABLE_phalanges. "";
 $db->sql_query($query);
 
     $query = "DELETE from " .TABLE_recycleurs. "";
 $db->sql_query($query);
 
 redirection("index.php?action=recycleurs&sub_action=admin");


?>