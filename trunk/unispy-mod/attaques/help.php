<?php
/**
* help.php 
 * @package Attaques
 * @author Verité
 * @link http://www.ogsteam.fr
 * @version : 0.8e
 */

//L'appel direct est interdit
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

//On vérifie que le mod est activé
$query = "SELECT `active` FROM `".TABLE_MOD."` WHERE `action`='attaques' AND `active`='1' LIMIT 1";
if (!$db->sql_numrows($db->sql_query($query))) die("Hacking attempt");

$help["bbcode"] = "Pour insérer vos résultats sur un forum, selectionner le texte ci-dessous, copier le, puis coller le dans votre post.";
$help["ajouter_attaque"] = "Pour ajouter une nouvelle attaque copiez le rapport de combat dans le formulaire ci-dessous, puis cliquez sur envoyer.";
$help["changer_affichage"] = "Ici vous pouvez choisir la période d'affichage en cliquant sur les liens ou en entrant les dates manuellement.";
$help["resultats"] = "Ici vous pouvez consulter les résultats en fonction de l'affichage choisi, et les graphiques correspondants.";
$help["liste_attaques"] = "Ici vous pouvez voir la liste de vos attaques en fonction de l'affichage choisi.";
$help["ajouter_recy"] = "Pour ajouter un nouveau recyclage copiez le rapport de recyclage dans le formulaire ci-dessous, puis cliquer sur envoyer.";
$help["liste_recy"] = "Ici vous pouvez voir la liste de vos recyclages en fonction de l'affichage choisi.";


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