<?php
/**
 * index.php 

Page principale du mod

 * @package MP_Logger
 * @author Sylar
 * @link http://www.ogsteam.fr
 * @version : 0.1
 * dernière modification : 16.10.07
 * Module de capture des messages entre joueurs
 */
// L'appel direct est interdit
if (!defined('IN_SPYOGAME')) die("Hacking attempt");
global $user_data;
$msg_list = get_messages_by_user($user_data['user_id']);
$msg_per_page = 16;
if(!isset($pub_pagenum)) $pub_pagenum=1;
$start=($pub_pagenum-1)*$msg_per_page;
$stop=$pub_pagenum*$msg_per_page;
if($stop>count($msg_list)) $stop = count($msg_list);
if($msg_list != 0){
	echo"<form action='index.php?action=$mod_name&page=$pub_page' method='POST'>";
	for($i=$start;$i<$stop;$i++){
		$msg = $msg_list[$i];
		echo"<table><tr><td class='d' align='center' width = '2'>";
		echo"$nbsp";
		echo"</td>	<td class='c' align='center' width = '150'>";
		echo get_dateHtml($msg['datadate']);
		echo"</td>	<td class='c' align='center' width = '200'>";
		echo get_txtHtml($msg['expediteur'],true);
		echo"</td><td class='c' align='center' width = '200'>";
		echo get_txtHtml($msg['titre']);
		echo"</td></tr><tr><td class='c' align='center' valign='center'><input name='checkbox".$msg['id']."' type='checkbox'></td><th colspan='3'><p align='left'>";
		echo get_txtHtml($msg['contenu']);
		echo"</p></td></tr><tr><td class='d' align='center' colspan='3'>&nbsp</tr>";
	}
	echo"<tr><td class='c' align='center' colspan='4'><select name='deletemessages'>";
	echo"<option value='deletemarked'>Effacer les messages sélectionnés</option>";
	echo"<option value='deletenonmarked'>Effacer tous les messages non sélectionnés</option>";
	echo"<option value='deleteallshown'>Effacer tous les messages affichés </option>";
	echo"<option value='deleteall'>Effacer tous les messages</option>";
	echo"</select>";
	echo"<input value='ok' type='submit'></form></td></tr><tr>";
	echo"<td class='d'>&nbsp</td>";
	if($pub_pagenum!=1)
		echo"<td class='a' align='center'><a href='index.php?action=$mod_name&page=$pub_page&pagenum=".($pub_pagenum-1)."'>Page Précédente</a></td>";
	else
		echo"<td class='d'>&nbsp</td>";
	echo"<td class='d'>&nbsp</td>";
	if(($pub_pagenum*$msg_per_page)<=count($msg_list))
		echo"<td class='a' align='center'><a href='index.php?action=$mod_name&page=$pub_page&pagenum=".($pub_pagenum+1)."'>Page Suivante</a></td>";
	else
		echo"<td class='d'>&nbsp</td>";
	echo "</tr></table>\n";
} else
	echo "Ici, bientot, vos messages OGame que XTense capture tout seul !";

?>