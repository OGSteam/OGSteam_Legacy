<?php
/**
* @Page principale du module
* @package rechercheAlly
* @Créateur du script Aeris
* @link http://www.ogsteam.fr
*
* @Modifier par Kazylax
* @Site internet www.kazylax.net
* @Contact kazylax-fr@hotmail.fr
*
 */
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

require_once("./views/page_header.php");

$query = "SELECT `active` FROM `".TABLE_MOD."` WHERE `action`='alliance' AND `active`='1' LIMIT 1";
if (!$db->sql_numrows($db->sql_query($query))) die("Hacking attempt");
// fin de secu
if (!isset($pub_page)) $pub_page  = "index";

switch($pub_page)
{

	case "changelog" : 
		require_once("./mod/recherche_alliance/changelog.php");
	break;

	case "coord" :
		require_once("./mod/recherche_alliance/coord.php");
	break;

	case "joueur" :
		require_once("./mod/recherche_alliance/joueur.php");
	break;

	default :
		require_once("./mod/recherche_alliance/alliance.php");
	break;
}

require_once("./views/page_tail.php");
?>