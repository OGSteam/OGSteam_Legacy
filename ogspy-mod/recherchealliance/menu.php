<?php
/**
* @Page principale du module
* @package rechercheAlly
* @Créateur du script Aeris
* @link http://www.ogsteam.fr
*
* @Modifier par Kazylax
* @Site internet www.kazylax.net
* @Contact kazylax-fr@hotmail.fr
*
 */
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

require_once("views/page_header.php");

echo "<table width='%100'>";
echo "<tr><td colspan=5 align=center class=c><a href='index.php?action=alliance'><font color='#FFFFCC'>Recherche Alliance</font></a><font color='#FFFFFF'> - </font><a href='index.php?action=alliance&page=coord'><font color='#FFFFCC'>Recherche Coordonnées</font></a><font color='#FFFFFF'> - </font><a href='index.php?action=alliance&page=joueur'><font color='#FFFFCC'>Recherche Joueur</font></a><font color='#FFFFFF'> - </font><a href='index.php?action=alliance&page=changelog'><font color='#FFFFCC'>Changelog</font></a></td></tr>";
echo "</table>";
?>