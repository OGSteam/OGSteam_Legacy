<?php
/**
* Module de Messagerie pour OGSpy - Fichier de visualisation du contenu d'un thread
* @package Messagerie
* @author ericalens <ericalens@ogsteam.fr> 
* @link http://www.ogsteam.fr http://doc.ogsteam.fr/modules_ogspy/classtrees_Messagerie.html
* @version 1.0
*/
// L'appel direct est interdit....
if (!defined('IN_SPYOGAME')) die("Hacking attempt");
echo "<table class='style' width=80%>\n";
echo "<tr><th width=150>Messages Re�us</th><th width=150>Messages Envoy�s</th><th>Gestion des messages priv�s</th></tr>\n";
echo "<tr>\n";
echo "<td class='b' >".count($Messagerie->ListMessages($user_data["user_id"],0))." messages re�us</td>\n";
echo "<td class='b'>".count($Messagerie->ListMessages($user_data["user_id"],0))." messages envoy�s</td>\n";
echo "<td class='b'><a href='?action=Messagerie&amp;subaction=post'>Nouveau Message</a></td>\n";

echo "</table>";
echo "<table class='style' width=90%>\n";
foreach($Messagerie->GetBoards() as $board) {
	$Threads=$board->GetThreads();
	echo "<tr><td class=c>".$board->URL()."<br>".$board->description."</td><td class=c> ".count($Threads)." discussions<br>".$board->CountMessages()." messages</td><td class=b>";
	if (count($Threads)) {
		echo $Threads[0]->URL()."</td>";	
	}
	else 	echo "<em>Pas de Messages</em></td></tr>";	

}
echo "</table>";

?>
