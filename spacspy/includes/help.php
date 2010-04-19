<?php
/** $Id$ **/
/**
* Fonctions d'aides SpacSpy
* @package SpacSpy
* @subpackage main
* @author Kyser
* @copyright Copyright &copy; 2007, http://ogsteam.fr/
* @version 0.1b ($Rev$)
* @modified $Date$
* @link $HeadURL$
*/

if (!defined('IN_SPACSPY')) {
	die("Hacking attempt");
}

$help["admin_server_status"] = "Lorsque le serveur est désactivé, seul les membres avec le statut d'administrateur ont accès aux fonctionnalités du serveur";
$help["admin_server_status_message"] = "Le message sera affiché aux membres \"de base\" lorsque le serveur sera désactivé";
$help["admin_save_transaction"] = "Les transactions correspondent aux :<br />- Systèmes solaires<br />- Rapports d'espionnage<br />- Classements joueurs et alliances";
$help["admin_member_manager"] = "Autorise la création, la mise à jour et la suppression des utilisateurs";
$help["admin_ranking_manager"] = "Autorise la suppression des classements joueurs et alliances";
$help["admin_check_ip"] = "Certains utilisateurs subissent des déconnexions intempestives (AOL, Proxy, etc).<br />Activez cette option afin qu'ils puissent désactiver la vérification dans leur profil";
$help["admin_session_infini"] = "Si vous choisissez des sessions indéfinies dans le temps, plusieurs individus ne pourront plus utiliser le même compte en même temps";

$help["search_strict"] = "<font color=orange>Joueur recherché :</font><br /><i>Liquid snake</i><br /><font color=orange>Critère de recherche :</font><br /><i>snake</i><br /><br />=> <font color=lime>Résultat positif</font> si l'option \"strict\" est désactivée<br />=> <font color=red>Résultat négatif</font> si l'option \"strict\" est activée";

$help["home_commandant"] = "Page empire du compte commandant";

$help["profile_skin"] = "SpacSpy utilise les mêmes skins qu'spacecon";
$help["profile_main_planet"] = "La vue Galaxie sera ouverte directement sur ce système solaire";
$help["profile_login"] = "Doit contenir entre 3 et 15 caractères (les caractères spéciaux ne sont pas acceptés)";
$help["profile_password"] = "Doit contenir entre 6 et 15 caractères (les caractères spéciaux ne sont pas acceptés)";
$help["profile_galaxy"] = "Doit contenir un nombre<br /> de 1 à 999";
$help["profile_disable_ip_check"] = "La vérification de l'adresse IP permet de vous protéger contre le vol de session.<br /><br />";
$help["profile_disable_ip_check"] .= "Si vous êtes déconnecté régulièrement (AOL, Proxy, etc), désactivez la vérification.<br /><br />";
$help["profile_disable_ip_check"] .= "<i>L'option est disponible uniquement si l'administrateur l'a activée</i>";

$help["galaxy_phalanx"] = "Chargez des rapports d'espionnage pour afficher les phalanges hostiles";

/**
* Création d'un lien d'aide en popup sur image
* @param string $key Identifiant de l'aide
* @param string $value Texte optionnel d'aide , lorsque $key n'est pas fourni
* @param string $prefixe Chemin optionnel vers le root SpacSpy
* @return string le lien à insérer
*/
function help($key, $value = "", $prefixe = "") {
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
}
?>
