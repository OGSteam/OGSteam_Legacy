<?php
/**
 * Changelog.php 
 * @package Guerres
 * @author Verit�
 * @link http://www.ogsteam.fr
 * @version 0.2e
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/

if (!defined('IN_SPYOGAME')) die("Hacking attempt");

//D�finitions
global $db;

//On v�rifie que le mod est activ�
$query = "SELECT `active` FROM `".TABLE_MOD."` WHERE `action`='guerres' AND `active`='1' LIMIT 1";
if (!$db->sql_numrows($db->sql_query($query))) die("Hacking attempt");

//Version 0.2e
echo"<fieldset><legend><b><font color='#0080FF'><u>Version 0.2e :</u></font></b></legend>";
echo"<p align='left'>";
echo"-Suppression de la v�rification de version en bas des pages du mod.<br>";
echo"</p>";
echo"</fieldset>";
echo"<br>";
echo"<br>";

//Version 0.2d
echo"<fieldset><legend><b><font color='#0080FF'><u>Version 0.2d :</u></font></b></legend>";
echo"<p align='left'>";
echo"-Corrige les erreurs que j'ai fait lors du tag de la version.<br>";
echo"</p>";
echo"</fieldset>";
echo"<br>";
echo"<br>";

//Version 0.2c
echo"<fieldset><legend><b><font color='#0080FF'><u>Version 0.2c :</u></font></b></legend>";
echo"<p align='left'>";
echo"-Correction du bug de non cumul des gains.<br>";
echo"-Ajout de la licence.<br>";
echo"</p>";
echo"</fieldset>";
echo"<br>";
echo"<br>";

//Version 0.2b
echo"<fieldset><legend><b><font color='#0080FF'><u>Version 0.2b :</u></font></b></legend>";
echo"<p align='left'>";
echo"-Correction du bug pour les co-admin.<br>";
echo"-Correction du bug au niveau de l'heure des recyclages.<br>";
echo"</p>";
echo"</fieldset>";
echo"<br>";
echo"<br>";

//Version 0.2
echo"<fieldset><legend><b><font color='#0080FF'><u>Version 0.2 :</u></font></b></legend>";
echo"<p align='left'>";
echo"-Lorsqu'il y a une seule guerre celle-ci est automatiquement selectionn�e.<br>";
echo"-Ajout de la possibilit� de modifier les infos d'une guerres.<br>";
echo"-Ajout de la visualisation de la liste des attaques d'une guerre.<br>";
echo"-Ajout de la recuperation de la liste des attaques en BBCode.<br>";
echo"-L'admin et les co-admins peuvent supprimer une attaque d'une guerre.<br>";
echo"-Lorqu'une attaques est ajout�e, un bouton apparait pour transmettre le rc ajout� au mod RCConv dans une nouvelle fen�tre.<br>";
echo"</p>";
echo"</fieldset>";
echo"<br>";
echo"<br>";

//Version 0.1
echo"<fieldset><legend><b><font color='#0080FF'><u>Version 0.1 :</u></font></b></legend>";
echo"<p align='left'>";
echo"-Sortie du mod guerres.<br>";
echo"</p>";
echo"</fieldset>";
echo"<br>";
echo"<br>";

echo"<hr width='325px'>";
echo"<p align='center'>Mod Guerres | Version 0.2e | <a href='mailto:verite@ogsteam.fr'>V�rit�</a> |� 2006</p>";

//Insertion du bas de page d'OGSpy
require_once("views/page_tail.php");
?>
