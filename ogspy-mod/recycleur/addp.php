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
define("TABLE_phalanges", $table_prefix."phalanges");

// On commence par r�cup�rer les champs
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
if ($systemea >499)
{
$systemea = "499";
}

if ($systemep <1)
{
$systemep = "1";
}
if ($systemep >499)
{
$systemep = "499";
}


// on �crit la requ�te sql
$query = "INSERT INTO " . TABLE_phalanges . "(`id` , `user_name` , `galaxie` , `systeme` , `position` , `systemea` , `systemep` , `time`) VALUES ('', '" . $user_data['user_name'] . "', '$galaxie', '$systeme', '$position', '$systemea', '$systemep', " . time() . ")";
 $db->sql_query($query);
 	
redirection("index.php?action=recycleurs&subaction=phalanges");

?> 