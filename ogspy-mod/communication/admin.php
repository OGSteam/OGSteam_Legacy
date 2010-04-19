<?php
/**
* admin.php  : Panneau d'adminisrration
* @author ericalens <ericalens@ogsteam.fr> http://www.ogsteam.fr
* @copyright OGSteam 2006 
* @version 0.2
* @package Communication
*/

if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}

/**
* Affichage du panneau d'administration de Communication
*/
function AffichagePanneauAdmistration(){
	global $server_config;
	echo "<br>\n"
		."<table width='500'>\n"
		."<tr><td class='c' align='center' colspan='3'>Administration du module Communication</td></tr>\n"
		."<form action='index.php' method='post'>\n"
		."<input type='hidden' name='action' value='Communication'>\n";

	echo "<tr><th>Config</th><th>Valeur</th><th>Description</th></tr>\n";
	echo "<tr><th>Communication_IRCServer</th><td><input type='text' name='Communication_IRCServer' value='".$server_config["Communication_IRCServer"]."'></td>\n"
		."<td>Serveur IRC:<br><i>irc.sorcery.net</i></td></tr>\n";

	echo "<tr><th>Communication_UniChan</th><td><input type='text' name='Communication_UniChan' value='".$server_config["Communication_UniChan"]."'></td>"
		."<td>Canal Univers:(#OGSTeam par defaut)<br><i>#ogamefr.xx</i> ou xx est le num de l'univers</td></tr>\n";

	echo "<tr><th>Communication_MarketChan</th><td><input type='text' name='Communication_MarketChan' value='".$server_config["Communication_MarketChan"]."'></td>"
		."<td>Canal OGSMarket:<br><i>#OGSMarket</i></td></tr>\n";

	echo "<tr><th>Communication_AllyChan</th><td><input type='text' name='Communication_AllyChan' value='";
	if (isset ($server_config["Communication_AllyChan"])) { echo $server_config["Communication_AllyChan"];}

	echo "'></td>"
		."<td>Canal de votre alliance:<br>#votrealliance</td></tr>\n";
	echo "<tr><td colspan='3' align='center'><input type='submit'></td></tr>\n";    
	echo "</table>";	
}

if($user_data["user_admin"] == 1 ) {
	AffichagePanneauAdmistration();
} else
{
	echo "<br>Et la marmotte , elle a mis le chocolat dans le papier alu...";
}
?>
