<?php
/**
 * help.php 
 * @package QuiMobserve
 * @author Santory
 * @link http://www.ogsteam.fr
 * @version : 0.1d
 */


//L'appel direct est interdit
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

//On vérifie que le mod est activé
$query = "SELECT `active` FROM `".TABLE_MOD."` WHERE `action`='Quimobserve' AND `active`='1' LIMIT 1";
if (!$db->sql_numrows($db->sql_query($query))) die("Hacking attempt");

$help["ajouter_espionage"] = "Pour ajouter un nouvelle espionnage, copiez le rapport d'espionnage dans le formulaire ci-dessous, puis cliquez sur envoyer.";
$help["parametre_annalise_planette"] = "Permet de choisir les options de recherche.";
$help["changer_affichage"] = "Ici vous pouvez choisir la période d'affichage en cliquant sur les liens ou en entrant les dates manuellement.";

	global $help;

	if (!isset($help[$key]) && !(is_null($key) && $value <> "")) {
		return;
	}

	if (isset($help[$key])) {
		$value = $help[$key];
	}
	
	$text = "<table width=\"200\">";
	$text .= "<tr><td align=\"center\" class=\"c\">Aide</td></tr>";
	$text .= "<tr><th align=\"center\">".addslashes($value)."</th></tr>";
	$text .= "</table>";

	$text = htmlentities($text);
	$text = "this.T_WIDTH=210;this.T_TEMP=0;return escape('".$text."')";

	return "<img style=\"cursor:pointer\" src=\"".$prefixe."images/help_2.png\" onmouseover=\"".$text."\">";
?>