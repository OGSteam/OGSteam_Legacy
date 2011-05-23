<?php
/***************************************************************************
*	filename	: changelog.php
*   package     : Copy_local
*	desc.		: liste des modifications des versions du module
*	Author		: ericc - http://www.ogsteam.fr/
*	created		: 10/03/2008
*	modified	: 05/04/2008
***************************************************************************/
if (!defined('IN_SPYOGAME')) die("Hacking attempt");
//Définitions
global $db;
//On vérifie que le mod est activé
$query = "SELECT `active` FROM `".TABLE_MOD."` WHERE `action`='attaques' AND `active`='1' LIMIT 1";
if (!$db->sql_numrows($db->sql_query($query))) die("Hacking attempt");

echo"<fieldset><legend><b><font color='#0080FF'><u>Version 0.2a :</u></font></b></legend>";
echo"<p align='left'><font size='2'><ul>";
echo"<li>Correction d'erreur dans les pages 'restore' et 'compare'</li>";
echo"<li>Gros bug dans la page 'update'</li>";
echo"</ul></font></p>";
echo"</fieldset>";
echo"<br>";

echo"<fieldset><legend><b><font color='#0080FF'><u>Version 0.2 :</u></font></b></legend>";
echo"<p align='left'><font size='2'><ul>";
echo"<li>Ajout page 'compare' pour comparer le contenu des tables locales et distantes</li>";
echo"<li>Ajout page 'restore' pour restorer les donnees locales vers le serveur distant</li>";
echo"<li>Création des script d'update et de désinstallation</li>";
echo"</ul></font></p>";
echo"</fieldset>";
echo"<br>";

echo"<fieldset><legend><b><font color='#0080FF'><u>Version 0.1 :</u></font></b></legend>";
echo"<p align='left'><font size='2'><ul>";
echo"<li>Création du mod</li>";
echo"</ul></font></p>";
echo"</fieldset>";
echo"<br>";
echo"<br>";

?>