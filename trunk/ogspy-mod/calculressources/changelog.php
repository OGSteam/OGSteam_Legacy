<?php
/**
* changelog.php
* @package CalculRessources
* @author varius9
* @version 1.0c
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
* @description Fichier de suivi d'évolution du mod
*/

//Définitions
global $db;

//On vérifie que le mod est activé
$query = "SELECT `active` FROM `".TABLE_MOD."` WHERE `action`='CalculRessources' AND `active`='1' LIMIT 1";
if (!$db->sql_numrows($db->sql_query($query))) die("Hacking attempt");

require_once("views/page_header.php");

echo"<table>";
echo"<tr><th><a href='index.php?action=CalculRessources'>Retour</a></th></tr>";
echo"</table>";

echo"<fieldset><legend><b><font color='#0080FF'><u>Version 1.0</u></font></b></legend>";
echo"<p align='left'><font color='white'>";
echo"- première révision du mod CalculRessources par varius9<br>";
echo"- récupération des infos de chaque planètes/lunes selon empire<br>";
echo"- copier/coller des ressources à quai pour chaque planètes/lunes<br>";
echo"- calcul de la somme des ressources selon sélection via case à cocher pour chaque planètes/lunes<br>";
echo"- définition de l'objectif à construire<br>";
echo"- Grand merci à Sylar pour son aide et capi pour l'accès svn (tags 1.0 raté dans svn)<br>";
echo"</p></FONT></fieldset>";

echo"<br>";
echo"<fieldset><legend><b><font color='#0080FF'><u>Version 1.0a</u></font></b></legend>";
echo"<p align='left'><font color='white'>";
echo"- ajout de la date/heure de mise à jour des ressources<br>";
echo"- création de 2 mémoires appelées 0 et 1 => le copier/coller envois les ressources à quai en mémoire 0<br>";
echo"- Possibilité de lire / écrire chaque mémoire (addition ressources en vol ou ajuster les ressources pour objectif)<br>";
echo"(modification de la structure de la BD pour les mémoires)<br>";
echo"</p></FONT></fieldset>";

echo"<br>";
echo"<fieldset><legend><b><font color='#0080FF'><u>Version 1.0b</u></font></b></legend>";
echo"<p align='left'><font color='white'>";
echo"- correction update.php et install.php pour lire le fichier version.txt<br>";
echo"- amélioration de la gestion des mémoires appelées 0 et 1 + boutons<br>";
echo"-----> bouton pour afficher la totalité de chaque mémoire<br>";
echo"-----> bouton pour effacer la totalité de chaque mémoire<br>";
echo"- création changelog<br>";
echo"- Grand merci à scaler pour son aide<br>";
echo"</p></FONT></fieldset>";

echo"<br>";
echo"<fieldset><legend><b><font color='#0080FF'><u>Version 1.0c</u></font></b></legend>";
echo"<p align='left'><font color='white'>";
echo"Suite à la nouvelle barre Xtense2.1 => Maj pour intégration du nouveau callback d'envoi automatique des ressources à quai<br>";
echo"Adieu le copier/coller des versions précédentes ^^<br>";
echo"</p></FONT></fieldset>";

require_once("./mod/CalculRessources/pied_CalculR.php");
require_once("views/page_tail.php");

?>