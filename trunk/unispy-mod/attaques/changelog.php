<?php
/**
* Changelog.php 
* @package Attaques
* @author Verité
* @link http://www.ogsteam.fr
* @version 0.8e
*/

if (!defined('IN_SPYOGAME')) die("Hacking attempt");

//Définitions
global $db;

//On vérifie que le mod est activé
$query = "SELECT `active` FROM `".TABLE_MOD."` WHERE `action`='attaques' AND `active`='1' LIMIT 1";
if (!$db->sql_numrows($db->sql_query($query))) die("Hacking attempt");

echo"<fieldset><legend><b><font color='#0080FF'><u>Version 0.8e :</u></font></b></legend>";
echo"<p align='left'>";
echo"-beaucoup de modif depuis la 0.5f ;)<br>";
echo"-en gros voir http://ogsteam.fr/viewtopic.php?id=3284 et http://ogsteam.fr/viewtopic.php?id=4443<br>";
echo"<br><br>";
echo"Merci à Draliam pour avoir effectué les modifs nécéssaires";
echo"</p>";
echo"</fieldset>";
echo"<br>";
echo"<br>";

echo"<fieldset><legend><b><font color='#0080FF'><u>Version 0.5f :</u></font></b></legend>";
echo"<p align='left'>";
echo"-Compatibilité avec Ogame au niveau des . dans les attaques<br>";
echo"<br><br>";
echo"Merci à oXid_Fox et à Santory2 pour avoir effectué les modifs nécéssaires";
echo"</p>";
echo"</fieldset>";
echo"<br>";
echo"<br>";

echo"<fieldset><legend><b><font color='#0080FF'><u>Version 0.5e :</u></font></b></legend>";
echo"<p align='left'>";
echo"-Compatibilité avec Ogame version 0.76.<br>";
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
echo"-Compatibilité avec la barre Xtense pour l'envoie des RC.<br>";
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
echo"-Compatibilité avec la barre de Naqdazar.<br>";
echo"</p>";
echo"</fieldset>";
echo"<br>";
echo"<br>";

echo"<fieldset><legend><b><font color='#0080FF'><u>Version 0.4b :</u></font></b></legend>";
echo"<p align='left'>";
echo"-Correction des bugs découvert dans la 0.4.<br>";
echo"-Ajout d'un espace bilan.<br>";
echo"-lorsque l'on clique sur un lien pour changer la date, les données sont rechargées automatiquement. Plus besoin de cliquer en plus sur le bouton afficher.<br>";
echo"</p>";
echo"</fieldset>";
echo"<br>";
echo"<br>";

echo"<fieldset><legend><b><font color='#0080FF'><u>Version 0.4 :</u></font></b></legend>";
echo"<p align='left'>";
echo"-Impossibilité d'enregistrer deux fois la même attaque, ou le même recyclage.<br>";
echo"-Contrôle si la version acuelle est à jour<br>";
echo"-Plus grande liberté au niveau du choix des dates d'affichage.<br>";
echo"-Possibilité de récupérer les résultats et la liste des attaques en BBCode.<br>";
echo"-Séparation des attaques et des recyclages<br>";
echo"-Test de la présence ou non des tables dans les fichiers install et uninstall<br>";
echo"-Ajout de l'aide via les tooltips.<br>";
echo"</p>";
echo"</fieldset>";
echo"<br>";
echo"<br>";

echo"<fieldset><legend><b><font color='#0080FF'><u>Version 0.3 :</u></font></b></legend>";
echo"<p align='left'>";
echo"-Prise en compte des recyclages.<br>";
echo"-Ajout de graphiques sur la page attaques du mois.<br>";
echo"-Pour la mise à jour et la suppression, le mod est appelé par son paramètre GET. Il est donc possible de changer le nom du mod sans problème<br>";
echo"-Amélioration du code.<br>";
echo"</p>";
echo"</fieldset>";
echo"<br>";
echo"<br>";

echo"<fieldset><legend><b><font color='#0080FF'><u>Version 0.2b :</u></font></b></legend>";
echo"<p align='left'>";
echo"-Prise en compte des prefixes des tables.<br>";
echo"-Correction de bugs mineurs.<br>";
echo"-Sécurisation du mod.<br>";
echo"</p>";
echo"</fieldset>";
echo"<br>";
echo"<br>";

echo"<fieldset><legend><b><font color='#0080FF'><u>Version 0.2 :</u></font></b></legend>";
echo"<p align='left'>";
echo"-Prise en compte des pertes attaquant.<br>";
echo"-Les gains des attaques des mois précédent sont sauvegardés.<br>";
echo"-Les chiffres sont affichés avec un séparateur de milliers.<br>";
echo"-Demande une confirmation avant de supprimer une attaque.<br>";
echo"-Amélioration du code.<br>";
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
echo"Merci à calidian pour les tests qu'il a effectués.";

echo"<hr width='325px'>";
echo"<p align='center'>Mod de Gestion des Attaques | Version 0.8e | <a href='mailto:verite@ogsteam.fr'>Vérité</a> |© 2006</p>";

//Insertion du bas de page d'OGSpy
require_once("views/page_tail.php");
?>
