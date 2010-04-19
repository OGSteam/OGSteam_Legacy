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
$board=new cBoard();
if (!$board->read(intval($pub_boardid))) exit();

echo "<table   width='90%'>
	<tr  ><th colspan=3>".$Messagerie->URL()." > ".$board->URL()." :   <em>".$board->description."</em></th>"
	."<tr>";
		echo "<tr><td class='menubar' colspan=3>[ ";
	if ($board->user_can_write() or $board->user_can_admin()) {echo " -<a href='?action=Messagerie&amp;subaction=post&amp;boardid=".$pub_boardid."'>Nouveau Message</a>&nbsp;";} ;
	if ($board->user_can_admin()) {echo "-<a href='?action=Messagerie&amp;subaction=admin&amp;boardid=".$pub_boardid."'>Changer les droits</a>&nbsp;";} ;
	echo "]</td></tr>\n";
$Threads=$board->GetThreads();
if (count($Threads)) {
	foreach($Threads as $thread) {
		echo "\t<tr><td class=c colspan=3>".$thread->URL()."</td></tr>\n";
	}
}else {
	echo "<tr><td colspan=3><em>Pas de messages</em></td></tr>\n";
}
echo "</table>\n";
?>
