<?php
/**
* changelog.php
* @package CalculRessources
* @author varius9
* @version 1.0c
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
* @description Fichier de suivi d'�volution du mod
*/

//D�finitions
global $db;

//On v�rifie que le mod est activ�
$query = "SELECT `active` FROM `".TABLE_MOD."` WHERE `action`='CalculRessources' AND `active`='1' LIMIT 1";
if (!$db->sql_numrows($db->sql_query($query))) die("Hacking attempt");

require_once("views/page_header.php");

echo"<table>";
echo"<tr><th><a href='index.php?action=CalculRessources'>Retour</a></th></tr>";
echo"</table>";

echo"<fieldset><legend><b><font color='#0080FF'><u>Version 1.0</u></font></b></legend>";
echo"<p align='left'><font color='white'>";
echo"- premi�re r�vision du mod CalculRessources par varius9<br>";
echo"- r�cup�ration des infos de chaque plan�tes/lunes selon empire<br>";
echo"- copier/coller des ressources � quai pour chaque plan�tes/lunes<br>";
echo"- calcul de la somme des ressources selon s�lection via case � cocher pour chaque plan�tes/lunes<br>";
echo"- d�finition de l'objectif � construire<br>";
echo"- Grand merci � Sylar pour son aide et capi pour l'acc�s svn (tags 1.0 rat� dans svn)<br>";
echo"</p></FONT></fieldset>";

echo"<br>";
echo"<fieldset><legend><b><font color='#0080FF'><u>Version 1.0a</u></font></b></legend>";
echo"<p align='left'><font color='white'>";
echo"- ajout de la date/heure de mise � jour des ressources<br>";
echo"- cr�ation de 2 m�moires appel�es 0 et 1 => le copier/coller envois les ressources � quai en m�moire 0<br>";
echo"- Possibilit� de lire / �crire chaque m�moire (addition ressources en vol ou ajuster les ressources pour objectif)<br>";
echo"(modification de la structure de la BD pour les m�moires)<br>";
echo"</p></FONT></fieldset>";

echo"<br>";
echo"<fieldset><legend><b><font color='#0080FF'><u>Version 1.0b</u></font></b></legend>";
echo"<p align='left'><font color='white'>";
echo"- correction update.php et install.php pour lire le fichier version.txt<br>";
echo"- am�lioration de la gestion des m�moires appel�es 0 et 1 + boutons<br>";
echo"-----> bouton pour afficher la totalit� de chaque m�moire<br>";
echo"-----> bouton pour effacer la totalit� de chaque m�moire<br>";
echo"- cr�ation changelog<br>";
echo"- Grand merci � scaler pour son aide<br>";
echo"</p></FONT></fieldset>";

echo"<br>";
echo"<fieldset><legend><b><font color='#0080FF'><u>Version 1.0c</u></font></b></legend>";
echo"<p align='left'><font color='white'>";
echo"Suite � la nouvelle barre Xtense2.1 => Maj pour int�gration du nouveau callback d'envoi automatique des ressources � quai<br>";
echo"Adieu le copier/coller des versions pr�c�dentes ^^<br>";
echo"</p></FONT></fieldset>";

require_once("./mod/CalculRessources/pied_CalculR.php");
require_once("views/page_tail.php");

?>