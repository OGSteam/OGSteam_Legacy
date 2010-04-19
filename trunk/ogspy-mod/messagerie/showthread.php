<?php
/**
* Module de Messagerie pour OGSpy - Fichier de visualisation du contenu d'un board
* @package Messagerie
* @author ericalens <ericalens@ogsteam.fr> 
* @link http://www.ogsteam.fr http://doc.ogsteam.fr/modules_ogspy/classtrees_Messagerie.html
* @version 1.0
*/
// L'appel direct est interdit....
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

$thread=new cMessageThread();

if (!$thread->read($pub_threadid)) exit();

$board= new cBoard($thread->boardid);
echo "<table  width='95%'>
	<tr><th colspan=3>".$Messagerie->URL()." > ".$board->URL()." > ".$thread->URL()."</th>";

echo "</tr>\n";
if ($board->user_can_read()) {
	echo "<tr><td class='menubar' colspan=3>[ ";
	if ($board->user_can_write() or $board->user_can_admin()) {echo " -<a href='?action=Messagerie&amp;subaction=post&amp;threadid=".$pub_threadid."'>Répondre</a>&nbsp;";} ;
	if ($board->user_can_admin()) {echo "-<a href='?action=Messagerie&amp;subaction=deletethread&amp;threadid=".$pub_threadid."'>Supprimer</a>&nbsp;";} ;
	echo "]</td></tr>\n";
	$messages=$thread->GetMessages();
	if (count($messages)) {
		foreach($messages as $message) {
			echo "\t<tr><td width=100 class='from'>".$message->fromname."</td><td colspan=2 class='post'>".$message->message."</td></tr>\n";
		}
	}
} else {
	echo "<tr><td colspan=3>Vous n'êtes pas autorisé à la lecture de ces informations</td></tr>";
}

echo "</table>\n";
?>
