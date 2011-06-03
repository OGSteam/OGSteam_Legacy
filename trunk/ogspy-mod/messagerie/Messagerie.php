<?php
/**
* Module de Messagerie pour OGSpy - Fichier principal du module
* @package Messagerie
* @author ericalens <ericalens@ogsteam.fr> 
* @link http://www.ogsteam.fr http://doc.ogsteam.fr/modules_ogspy/classtrees_Messagerie.html
* @version 1.0
*/
// L'appel direct est interdit....
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

// Est-ce que le mod est actif et recup de version
$query = "SELECT `version` FROM `".TABLE_MOD."` WHERE `action`='Messagerie' AND `active`='1' LIMIT 1";
$result = $db->sql_query($query);

if (!$db->sql_numrows($result)) die("Hacking attempt");

$mod_version = 0;
list($mod_version) = $db->sql_fetch_row($result);

define ("MODMSGDIR","mod/messagerie/");
// Includes
require_once(MODMSGDIR."functions.php");



//Affichage
require_once("views/page_header.php");
echo "<link rel='stylesheet' type='text/css' href='".MODMSGDIR."messagerie.css'>" ;
echo "<div class='messagerie'>\n";
if (empty($pub_subaction)) {
	include_once(MODMSGDIR."default.php");
}else {
switch ($pub_subaction) {
	case "show":
		if (isset($pub_boardid)) {
			include_once(MODMSGDIR."showboard.php");
		}
		break;
	case "showthread":
		if (isset($pub_threadid)) {
			include_once(MODMSGDIR."showthread.php");
		}
		break;
	case "post":
		include_once(MODMSGDIR."post.php");
		break;
}
}
echo "\n</div>\n";
?>

<p align='center'>Mod Messagerie | Version <?php echo $mod_version ?> | <a href='http://www.ogsteam.fr/forums/misc.php?email=2'>ericalens</a> |© 2007</p>
<?php
require_once("views/page_tail.php");
?>
