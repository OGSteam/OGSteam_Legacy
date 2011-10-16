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
define("TABLE_PHALANGES", $table_prefix."phalanges");

// On commence par récupérer les champs
if(isset($pub_galaxie)) $galaxie=$pub_galaxie;
else $galaxie="";

if(isset($pub_systeme)) $systeme=$pub_systeme;
else $systeme="";


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

if(isset($pub_niv)) $niv=$pub_niv;
else $niv="";

$nivp = $niv * $niv - 1;
$systemea = $systeme + $nivp;
$systemep = $systeme - $nivp;

if ($systemea <1)
{
$systemea = "1";
}
if ($systemea >$nb_systems)
{
$systemea = $nb_systems;
}

if ($systemep <1)
{
$systemep = "1";
}
if ($systemep >$nb_systems)
{
$systemep = $nb_systems;
}


// on écrit la requête sql
$query = "INSERT INTO " . TABLE_PHALANGES . "(`id` , `user_name` , `galaxie` , `systeme` , `position` , `systemea` , `systemep` , `time`) VALUES ('', '" . $user_data['user_name'] . "', '$galaxie', '$systeme', '$position', '$systemea', '$systemep', " . time() . ")";
 $db->sql_query($query);
 	
redirection("index.php?action=recycleurs&sub_action=phalanges");

?> 