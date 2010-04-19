<?php
/**
* communication.php : Script d'entrée du Module Communication
* @author ericalens <ericalens@ogsteam.fr> http://www.ogsteam.fr
* @copyright OGSteam 2006 
* @version 0.2
* @package Communication
*/

// L'appel direct est interdit....

if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}

// Est-ce que le mod est actif ?

$query = "SELECT `active` FROM `".TABLE_MOD."` WHERE `action`='Communication' AND `active`='1' LIMIT 1";
if (!$db->sql_numrows($db->sql_query($query))) die("Hacking attempt");

// Un petit tableau de toutes les configs concernant notre mod


require_once("views/page_header.php");


// Mise à jour des données de configuration si postés...
if (isset($pub_Communication_IRCServer) && $user_data["user_admin"] == 1) {

	$query="UPDATE ".TABLE_CONFIG." SET config_value='".$pub_Communication_IRCServer."' WHERE config_name='Communication_IRCServer'";
	$db->sql_query($query);

	$query="UPDATE ".TABLE_CONFIG." SET config_value='".$pub_Communication_UniChan."' WHERE config_name='Communication_UniChan'";
	$db->sql_query($query);

	$query="UPDATE ".TABLE_CONFIG." SET config_value='".$pub_Communication_MarketChan."' WHERE config_name='Communication_MarketChan'";
	$db->sql_query($query);

	$query="UPDATE ".TABLE_CONFIG." SET config_value='".$pub_Communication_AllyChan."' WHERE config_name='Communication_AllyChan'";
	$db->sql_query($query);
	echo "\n<table><th>La configuration du module <b>Communication</b> est sauvegardé.</th></table>";
}


if (isset($pub_subaction)) {
	switch ($pub_subaction) {
		case "admin":
			include("./mod/Communication/admin.php");
		break;
		case "irc":
			include("./mod/Communication/irc.php");
		break;
	}
}
else
{

	// Menu Utilisateur

	echo "<table width=90%>\n"
		."<tr><td width=10%>&nbsp;</td><td class='c' align='center'>Communication</td><td width=10%>&nbsp;</td></tr>\n"
		."<tr><td width=10%>&nbsp;</td><td align='center'><a href='index.php?action=Communication&amp;subaction=irc'>Applet JAVA IRC</a></td><td width=10%>&nbsp;</td></tr>\n"
		."<tr><td width=10%>&nbsp;</td><td align='center'><a href='index.php?action=Communication&amp;subaction=listmsn'>Contact MSN des utilisateurs</a></td><td width=10%>&nbsp;</td></tr>\n"
		."<tr><td width=10%>&nbsp;</td><td align='center'><a href='index.php?action=Communication&amp;subaction=preferences'>Mes préférences</a></td><td width=10%>&nbsp;</td></tr>\n";
	if($user_data["user_admin"] == 1 ) {
		echo "<tr><td width=10%>&nbsp;</td><td align='center'><b>[admin]</b> <a href='index.php?action=Communication&amp;subaction=admin'>Configuration du module Communication</a></td><td width=10%>&nbsp;</td></tr>\n";
	}
	echo   "</table>\n";
}
require_once("views/page_tail.php");
?>
