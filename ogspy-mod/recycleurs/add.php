<?php
/***************************************************************************
*	filename	: supp.php		
*	desc.		: fichier ajout
*	Author : DeusIrae
*	created : 25/08/07
*	modified	: 03/12/2007 
***************************************************************************/
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

global $db;
global $table_prefix;
define("TABLE_RECYCLEURS", $table_prefix."recycleurs");

// On commence par récupérer les champs
if(isset($pub_galaxie)) $galaxie=$pub_galaxie;
else $galaxie="";

if(isset($pub_systeme)) $systeme=$pub_systeme;
else $systeme="";

if ($systeme <1)
{
$systeme = "1";
}
if ($systeme >$nb_systems)
{
$systeme = $nb_systems;
}

if(isset($pub_position)) $position=$pub_position;
else $position="";

if ($position <1)
{
$position = "1";
}
if ($position >15)
{
$position = "15";
}

if(isset($pub_porte)) $porte=$pub_porte;
else $porte="";


if(isset($pub_nombrerecy)) $nombrerecy=$pub_nombrerecy;
else $nombrerecy="";



// on écrit la requête sql
$query = "INSERT INTO " . TABLE_RECYCLEURS . "(`id` , `user_name` , `galaxie` , `systeme` , `position` , `porte` , `nombrerecy` , `time`) VALUES ('', '" . $user_data['user_name'] . "', '$galaxie', '$systeme', '$position', '$porte', '$nombrerecy', " . time() . ")";
log_('mod',$query);
$db->sql_query($query);
 	
redirection("index.php?action=recycleurs&sub_action=recycleurs");

?> 