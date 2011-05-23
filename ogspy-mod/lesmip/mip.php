<?php
/**
* mip.php Choisi quel page on affiche
* @package [MOD] Tout sur les MIP
* @author Bartheleway <contactbarthe@g.q-le-site.webou.net>
* @version 0.4
* created	: 21/08/2006
* modified	: 07/02/2007
*/

if (!defined('IN_SPYOGAME')) die("Hacking attempt");

$query = "SELECT `active` FROM `".TABLE_MOD."` WHERE `action`='lesmip' AND `active`='1' LIMIT 1";
if (!$db->sql_numrows($db->sql_query($query))) die("Hacking attempt");

/**
*Récupère le fichier de langue pour la langue approprié
*/
if (!empty($server_config['language'])) {
	if (is_dir("mod/lesmip/language/".$server_config['language'])) require_once("mod/lesmip/language/".$server_config['language']."/lang_main.php");
	else require_once("mod/lesmip/language/english/lang_main.php");
} else {
	require_once("mod/lesmip/language/french/lang_main.php");
}

if (!isset($pub_sub)) $pub_sub = 'mip'; else $pub_sub = htmlentities($pub_sub);

if ($pub_sub != "mip") {
	$bouton1 = "\t\t"."<td class='c' align='center' width='150' style='cursor:pointer' onclick=\"window.location = 'index.php?action=lesmip&sub=mip';\">";
	$bouton1 .= "<font color='lime'>".$lang['lesmip_mip_simu']."</font>";
	$bouton1 .= "</td>\n";
} else {
	$bouton1 = "\t\t"."<th width='150'>";
	$bouton1 .= "<font color=\"#5CCCE8\">".$lang['lesmip_mip_simu']."</font>";
	$bouton1 .= "</th>\n";
}
if ($pub_sub != "porte") {
	$bouton2 = "\t\t"."<td class='c' align='center' width='150' style='cursor:pointer' onclick=\"window.location = 'index.php?action=lesmip&sub=porte';\">";
	$bouton2 .= "<font color='lime'>".$lang['lesmip_mip_porte']."</font>";
	$bouton2 .= "</td>\n";
} else {
	$bouton2 = "\t\t"."<th width='150'>";
	$bouton2 .= "<font color=\"#5CCCE8\">".$lang['lesmip_mip_porte']."</font>";
	$bouton2 .= "</th>\n";
}

/**
* Chargement du menu et de l'en-tête
*/
require_once("views/page_header.php");

if ($pub_sub != 'info') {
	echo '<table>'."\n";
	echo "\t".'<tr>'."\n";
	echo $bouton1.$bouton2;
	echo "\t".'</tr>'."\n";
	echo '</table>'."\n<br />\n";
}

/**
*Choisi quel page il affiche
*/
switch($pub_sub) {
	case 'mip': include ('simu.php');break;
	case 'info': include ('info.php');break;
	case 'porte': include ('missiles.php');break;
}

/**
* Chargement du pied de page
*/
require_once("views/page_tail.php");
?>