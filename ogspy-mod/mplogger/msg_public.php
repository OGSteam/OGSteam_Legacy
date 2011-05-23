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
echo"<table><tr><td class='c' align='center' width = '120'>";
echo"d M y H:i:s";
echo"</td>	<td class='c' align='center' width = '80'>";
echo'expediteur';
echo"</td><td class='c' align='center' width = '180'>";
echo'titre';
echo"</td></tr><tr><th colspan='3'><p align='left'>";
echo'contenu';
echo"</p></td></tr><tr><td class='d' align='center' colspan='3'>&nbsp</tr>";
echo "</table>\n";
?>