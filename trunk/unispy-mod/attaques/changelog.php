<?php
/**
* Changelog.php 
* @package Attaques
* @author Verit�
* @link http://www.ogsteam.fr
* @version 0.8e
*/

if (!defined('IN_SPYOGAME')) die("Hacking attempt");

//D�finitions
global $db;

//On v�rifie que le mod est activ�
$query = "SELECT `active` FROM `".TABLE_MOD."` WHERE `action`='attaques' AND `active`='1' LIMIT 1";
if (!$db->sql_numrows($db->sql_query($query))) die("Hacking attempt");

echo"<fieldset><legend><b><font color='#0080FF'><u>Version 0.8e :</u></font></b></legend>";
echo"<p align='left'>";
echo"-beaucoup de modif depuis la 0.5f ;)<br>";
echo"-en gros voir http://ogsteam.fr/viewtopic.php?id=3284 et http://ogsteam.fr/viewtopic.php?id=4443<br>";
echo"<br><br>";
echo"Merci � Draliam pour avoir effectu� les modifs n�c�ssaires";
echo"</p>";
echo"</fieldset>";
echo"<br>";
echo"<br>";

echo"<fieldset><legend><b><font color='#0080FF'><u>Version 0.5f :</u></font></b></legend>";
echo"<p align='left'>";
echo"-Compatibilit� avec Ogame au niveau des . dans les attaques<br>";
echo"<br><br>";
echo"Merci � oXid_Fox et � Santory2 pour avoir effectu� les modifs n�c�ssaires";
echo"</p>";
echo"</fieldset>";
echo"<br>";
echo"<br>";

echo"<fieldset><legend><b><font color='#0080FF'><u>Version 0.5e :</u></font></b></legend>";
echo"<p align='left'>";
echo"-Compatibilit� avec Ogame version 0.76.<br>";
echo"</p>";
echo"</fieldset>";
echo"<br>";
echo"<br>";

echo"<fieldset><legend><b><font color='#0080FF'><u>Version 0.5d :</u></font></b></legend>";
echo"<p align='left'>";
echo"-Correction des bugs de formulaire.<br>";
echo"</p>";
echo"</fieldset>";
echo"<br>";
echo"<br>";

echo"<fieldset><legend><b><font color='#0080FF'><u>Version 0.5c :</u></font></b></legend>";
echo"<p align='left'>";
echo"-Compatibilit� avec la barre Xtense pour l'envoie des RC.<br>";
echo"-Onglets du menu en liens.<br>";
echo"</p>";
echo"</fieldset>";
echo"<br>";
echo"<br>";

echo"<fieldset><legend><b><font color='#0080FF'><u>Version 0.5b :</u></font></b></legend>";
echo"<p align='left'>";
echo"-Correction des erreurs de la 0.5<br>";
echo"</p>";
echo"</fieldset>";
echo"<br>";
echo"<br>";

echo"<fieldset><legend><b><font color='#0080FF'><u>Version 0.5 :</u></font></b></legend>";
echo"<p align='left'>";
echo"-Correction du bug de sauvegarde des resultats<br>";
echo"-Compatibilit� avec la barre de Naqdazar.<br>";
echo"</p>";
echo"</fieldset>";
echo"<br>";
echo"<br>";

echo"<fieldset><legend><b><font color='#0080FF'><u>Version 0.4b :</u></font></b></legend>";
echo"<p align='left'>";
echo"-Correction des bugs d�couvert dans la 0.4.<br>";
echo"-Ajout d'un espace bilan.<br>";
echo"-lorsque l'on clique sur un lien pour changer la date, les donn�es sont recharg�es automatiquement. Plus besoin de cliquer en plus sur le bouton afficher.<br>";
echo"</p>";
echo"</fieldset>";
echo"<br>";
echo"<br>";

echo"<fieldset><legend><b><font color='#0080FF'><u>Version 0.4 :</u></font></b></legend>";
echo"<p align='left'>";
echo"-Impossibilit� d'enregistrer deux fois la m�me attaque, ou le m�me recyclage.<br>";
echo"-Contr�le si la version acuelle est � jour<br>";
echo"-Plus grande libert� au niveau du choix des dates d'affichage.<br>";
echo"-Possibilit� de r�cup�rer les r�sultats et la liste des attaques en BBCode.<br>";
echo"-S�paration des attaques et des recyclages<br>";
echo"-Test de la pr�sence ou non des tables dans les fichiers install et uninstall<br>";
echo"-Ajout de l'aide via les tooltips.<br>";
echo"</p>";
echo"</fieldset>";
echo"<br>";
echo"<br>";

echo"<fieldset><legend><b><font color='#0080FF'><u>Version 0.3 :</u></font></b></legend>";
echo"<p align='left'>";
echo"-Prise en compte des recyclages.<br>";
echo"-Ajout de graphiques sur la page attaques du mois.<br>";
echo"-Pour la mise � jour et la suppression, le mod est appel� par son param�tre GET. Il est donc possible de changer le nom du mod sans probl�me<br>";
echo"-Am�lioration du code.<br>";
echo"</p>";
echo"</fieldset>";
echo"<br>";
echo"<br>";

echo"<fieldset><legend><b><font color='#0080FF'><u>Version 0.2b :</u></font></b></legend>";
echo"<p align='left'>";
echo"-Prise en compte des prefixes des tables.<br>";
echo"-Correction de bugs mineurs.<br>";
echo"-S�curisation du mod.<br>";
echo"</p>";
echo"</fieldset>";
echo"<br>";
echo"<br>";

echo"<fieldset><legend><b><font color='#0080FF'><u>Version 0.2 :</u></font></b></legend>";
echo"<p align='left'>";
echo"-Prise en compte des pertes attaquant.<br>";
echo"-Les gains des attaques des mois pr�c�dent sont sauvegard�s.<br>";
echo"-Les chiffres sont affich�s avec un s�parateur de milliers.<br>";
echo"-Demande une confirmation avant de supprimer une attaque.<br>";
echo"-Am�lioration du code.<br>";
echo"</p>";
echo"</fieldset>";
echo"<br>";
echo"<br>";


echo"<fieldset><legend><b><font color='#0080FF'><u>Version 0.1b :</u></font></b></legend>";
echo"<p align='left'>";
echo"-Correction d'un bug au niveau des formulaires.<br>";
echo"-Correction du code.<br>";
echo"</p>";
echo"</fieldset>";
echo"<br>";
echo"<br>";

echo"<fieldset><legend><b><font color='#0080FF'><u>Version 0.1 :</u></font></b></legend>";
echo"<p align='left'>";
echo"-Sortie du mod gestion des attaques.<br>";
echo"</p>";
echo"</fieldset>";
echo"<br>";
echo"<br>";
echo"Merci � calidian pour les tests qu'il a effectu�s.";

echo"<hr width='325px'>";
echo"<p align='center'>Mod de Gestion des Attaques | Version 0.8e | <a href='mailto:verite@ogsteam.fr'>V�rit�</a> |� 2006</p>";

//Insertion du bas de page d'OGSpy
require_once("views/page_tail.php");
?>
