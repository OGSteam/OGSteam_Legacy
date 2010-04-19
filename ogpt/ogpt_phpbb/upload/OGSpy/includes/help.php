<?php
/***************************************************************************
*	filename	: help.php
*	desc.		:
*	Author		: Kyser - http://www.ogsteam.fr/
*	created		: 04/05/2006
*	modified	: 22/08/2006 00:00:00
***************************************************************************/

if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}

$help["admin_server_status"] = "Lorsque le serveur est d�sactiv�, seul les membres avec le statut d'administrateur ont acc�s aux fonctionnalit�s du serveur";
$help["admin_server_status_message"] = "Le message sera affich� aux membres \"de base\" lorsque le serveur sera d�sactiv�";
$help["admin_save_transaction"] = "Les transactions correspondent aux :<br />- Syst�mes solaires<br />- Rapports d'espionnage<br />- Classements joueurs et alliances";
$help["admin_member_manager"] = "Autorise la cr�ation, la mise � jour et la suppression des utilisateurs";
$help["admin_ranking_manager"] = "Autorise la suppression des classements joueurs et alliances";
$help["admin_check_ip"] = "Certains utilisateurs subissent des d�connexions intempestives (AOL, Proxy, etc).<br />Activez cette option afin qu'ils puissent d�sactiver la v�rification dans leur profil";
$help["admin_session_infini"] = "Si vous choisissez des sessions ind�finies dans le temps, plusieurs individus ne pourront plus utiliser le m�me compte en m�me temps";

$help["search_strict"] = "<font color=orange>Joueur recherch� :</font><br /><i>Liquid snake</i><br /><font color=orange>Crit�re de recherche :</font><br /><i>snake</i><br /><br />=> <font color=lime>R�sultat positif</font> si l'option \"strict\" est d�sactiv�e<br />=> <font color=red>R�sultat n�gatif</font> si l'option \"strict\" est activ�e";

$help["home_commandant"] = "Page empire du compte commandant";

$help["profile_skin"] = "OGSpy utilise les m�me skins qu'OGame";
$help["profile_main_planet"] = "La vue Galaxie sera ouverte directement sur ce syst�me solaire";
$help["profile_login"] = "Doit contenir entre 3 et 15 caract�res (les caract�res sp�ciaux ne sont pas accept�s)";
$help["profile_password"] = "Doit contenir entre 6 et 15 caract�res (les caract�res sp�ciaux ne sont pas accept�s)";
$help["profile_disable_ip_check"] = "La v�rification de l'adresse IP permet de vous prot�ger contre le vol de session.<br /><br />";
$help["profile_disable_ip_check"] .= "Si vous �tes d�connect� r�guli�rement (AOL, Proxy, etc), d�sactivez la v�rification.<br /><br />";
$help["profile_disable_ip_check"] .= "<i>L'option est disponible uniquement si l'administrateur l'a activ�e.</i>";

$help["galaxy_phalanx"] = "Chargez des rapports d'espionnage pour afficher les phalanges hostiles";


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
