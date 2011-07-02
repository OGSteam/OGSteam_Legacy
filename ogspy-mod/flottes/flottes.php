<?php
/***************************************************************************
*    filename    : flottes.php
*    desc.       : 1.0.3
*    Link        : http://www.ogsteam.fr 
*    Author      :  Conrad des Dragons
*    created     : 
*    modified    : AirBAT
***************************************************************************/

//secu
if (!defined('IN_SPYOGAME')) die("Hacking attempt");
require_once("./views/page_header.php");
$query = "SELECT `active` FROM `".TABLE_MOD."` WHERE `action`='flottes' AND `active`='1' LIMIT 1";
if (!$db->sql_numrows($db->sql_query($query))) die("Hacking attempt");
// fin de secu

if (!isset($pub_subaction)) $pub_subaction = "flottes";
switch($pub_subaction)
{
	case "flottes" : 
		require_once("./mod/flottes/flottes_general.php");
	break;

	case "admin" :
		require_once("./mod/flottes/flottes_admin.php");
	break;

	case "insert" :
		require_once("./mod/flottes/flottes_ajout.php");
	break;

	case "bbcode" :
		require_once("./mod/flottes/flottes_bbcode.php");
 	break;
 
	case "bbcode2" :
		require_once("./mod/flottes/flottes_bbcode2.php");
	break;

    case "mybb" :
        require_once("./mod/flottes/flottes_mybb.php");
    break;

	case "graphe" :
		require_once("./mod/flottes/flottes_graphe.php");
	break;

    case "xtense2" :
        require_once("./mod/flottes/flottes_xtense2.php");
    break;
 
	default :
		require_once("./mod/flottes/flottes_general.php");
	break;
 }

require_once("./mod/flottes/pied_flottes.php");
require_once("./views/page_tail.php");
?>