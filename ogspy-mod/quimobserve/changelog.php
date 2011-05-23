<?php
/**
 * Archives.php 
 * @package QuiMobserve
 * @author Santory
 * @link http://www.ogsteam.fr
 * @version : 0.1e
 */

 //L'appel direct est interdit
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

//On vérifie que le mod est activé
$query = "SELECT `active` FROM `".TABLE_MOD."` WHERE `action`='QuiMobserve' AND `active`='1' LIMIT 1";
if (!$db->sql_numrows($db->sql_query($query))) die("Hacking attempt");

echo "<fieldset><legend><b><font color='#0080FF'><u>Version 0.2 :</u></font></b></legend>";
echo "<p align='left'><font size=\"2\">";
echo "-Modifcation graphique par Sylar.<br />";
echo "</font></p>";
echo "</fieldset>";
echo "<br>";
echo "<br>";

echo "<fieldset><legend><b><font color='#0080FF'><u>Version 0.1e :</u></font></b></legend>";
echo "<p align='left'><font size=\"2\">";
echo "-Correction d'une faille sécurité.<br />";
echo "-Correction d'un bug dans la partie interpolation si tous les scans sont fait par un joueur inconnu ou une alliance vide.<br />";
echo "-Ajout d'une page pop-up avec les espionnage subit sur une planète dans la partie par planète.<br />";
echo "</font></p>";
echo "</fieldset>";
echo "<br>";
echo "<br>";


echo "<fieldset><legend><b><font color='#0080FF'><u>Version 0.1d :</u></font></b></legend>";
echo "<p align='left'><font size=\"2\">";
echo "-Correction de divers bug.<br />";
echo "-Ajout du pourcentage de destruction des sondes.<br />";
echo "</font></p>";
echo "</fieldset>";
echo "<br>";
echo "<br>";

echo "<fieldset><legend><b><font color='#0080FF'><u>Version 0.1c :</u></font></b></legend>";
echo "<p align='left'><font size=\"2\">";
echo "-Correction du N° de version dans la base.<br />";
echo "</font></p>";
echo "</fieldset>";
echo "<br>";
echo "<br>";

echo "<fieldset><legend><b><font color='#0080FF'><u>Version 0.1a :</u></font></b></legend>";
echo "<p align='left'><font size=\"2\">";
echo "-Correction du bug dans l’interpolation.<br />";
echo "-Ajout d’un lien pour avoir plus d’info sur la planète qui nous a observés.<br />";
echo "</font></p>";
echo "</fieldset>";
echo "<br>";
echo "<br>";

echo "<fieldset><legend><b><font color='#0080FF'><u>Version 0.1 :</u></font></b></legend>";
echo "<p align='left'><font size=\"2\">";
echo "-Sortie du mod QuiMObserve.<br />";
echo "</font></p>";
echo "</fieldset>";
echo "<br>";
echo "<br>";

?>