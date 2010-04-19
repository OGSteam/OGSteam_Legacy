<?php
/**
*  Post/envoi d'un message - post.php
* @package Messagerie
* @author ericalens <ericalens@ogsteam.fr> 
* @link http://www.ogsteam.fr http://doc.ogsteam.fr/modules_ogspy/classtrees_Messagerie.html
* @version 1.0
* @since 1.0 - 21 sept. 07
*/

echo "<table width=90%>\n";

include(MODMSGDIR."fckeditor/fckeditor.php");
if (isset($pub_boardid)) { // C'est un nouveau message dans un board
	$board=new cBoard(intval($pub_boardid));
	if (!$board->user_can_write() and !$board->user_can_admin()) die("Vous n'êtes pas autoriser à poster dans ce board.");
	if ($board) {
		echo "<tr><td class=k>Nouveau Message</td> <td class=b>".$board->URL()."</td><td class=c>".$board->description."</td></tr>";
	}else {echo "<tr><td>Erreur: Identificateur de board incorrect</td></tr>";}
}
else {//C'est un message privé
	
}
echo "</table>\n";

echo "<table width=90%>\n";
echo "<form action='?action=Messagerie' method='post'>\n";
echo "<input type='hidden' name='subaction' value='post'>\n";
if (isset($pub_boardid)) echo "<input type='hidden' name='boardid' value='".intval($pub_boardid)."'>\n";
echo "<tr><td width=30px class=from>Sujet:</td><td><input size=100 type='text' name='subject'  value='".htmlentities($pub_subject)."'></td></tr>\n";
echo "<tr><td colspan=2>";

$oFCKeditor = new FCKeditor('FCKeditorMessagerie') ;
$oFCKeditor->Height = '250';
$oFCKeditor->BasePath	= "./".MODMSGDIR."/fckeditor/" ;
$oFCKeditor->Value		= isset($pub_FCKeditorMessagerie)? $pub_FCKeditorMessagerie:'' ;
$oFCKeditor->Create() ;
echo "<tr><td colspan=2 class=b><input type=submit value='Envoyer le message'></td></tr>";
echo "</form>";

echo "</td></tr></table>";

?>
