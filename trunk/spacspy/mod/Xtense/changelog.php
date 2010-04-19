<?php
/**
* xtense_plugin_mod_changelog.php
* @package Xtense
*  @author Naqdazar, then modified by OGSteam
*  @link http://www.ogsteam.fr
*  @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/

if (!defined('IN_SPACSPY')) die("Hacking attempt");


//Définitions
global $db;

//On vérifie que le mod est activé
$query = "SELECT `active` FROM `".TABLE_MOD."` WHERE `action`='xtense' AND `active`='1' LIMIT 1";
if (!$db->sql_numrows($db->sql_query($query))) die("Hacking attempt");

//Version 1.1.0
echo"<br><br>";
echo"<fieldset><legend><b><font color='#0080FF'><u>Version 1.1.0 :</u></font></b></legend>";
echo"<p align='left'><font color='white'>";
echo"-Patch de compatibilité avec le mod RCSave (ben.12)<br>";
echo"</p>";
echo"</fieldset>";
//Version 1.0.9
echo"<br><br>";
echo"<fieldset><legend><b><font color='#0080FF'><u>Version 1.0.9 :</u></font></b></legend>";
echo"<p align='left'><font color='white'>";
echo"-Compatibilité avec le mod QuiMSonde.<br>";
echo"</p>";
echo"</fieldset>";

//Version 1.0.8
echo"<br><br>";
echo"<fieldset><legend><b><font color='#0080FF'><u>Version 1.0.8 :</u></font></b></legend>";
echo"<p align='left'><font color='white'>";
echo"-Compatibilité avec le mod Flottes.<br>";
echo"</p>";
echo"</fieldset>";

//Version 1.0.7
echo"<br><br>";
echo"<fieldset><legend><b><font color='#0080FF'><u>Version 1.0.7 :</u></font></b></legend>";
echo"<p align='left'><font color='white'>";
echo"-Visualisation du journal de debug.<br>";
echo"-Compatibilité avec le mod Attaques.<br>";
echo"-Corrections de bugs.<br>";
echo"</p>";
echo"</fieldset>";
//Version 1.0.2
echo"<br><br>";
echo"<fieldset><legend><b><font color='#0080FF'><u>Version 1.0.2 :</u></font></b></legend>";
echo"<p align='left'><font color='white'>";
echo"-Le mode debug et le mode maintenance peuvent desormais être activés depuis l'administration du mod.<br>";
echo"-Corrections de bugs.<br>";
echo"</p>";
echo"</fieldset>";
//Version 1.0.1
echo"<br><br>";
echo"<fieldset><legend><b><font color='#0080FF'><u>Version 1.0.1 :</u></font></b></legend>";
echo"<p align='left'><font color='white'>";
echo"-Affichage des informations de configuration de la toolbar pour les non admins.<br>";
echo"</p>";
echo"</fieldset>";
//Version 1.0.0
echo"<br><br>";
echo"<fieldset><legend><b><font color='#0080FF'><u>Version 1.0.0 :</u></font></b></legend>";
echo"<p align='left'><font color='white'>";
echo"-Sortie du plugin Xtense basé sur l'ogsplugin de Naqdazar.<br>";
echo"</p>";
echo"</fieldset>";
echo"<br>";



echo"<br>";
echo"</font></table>";





?>
