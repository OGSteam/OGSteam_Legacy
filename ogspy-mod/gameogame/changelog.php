<?php
/**
* Changelog.php 
* @package gameOgame
* @author Aeris/ericc
* @link http://www.ogsteam.fr
* @version 2.0d
*/

if (!defined('IN_SPYOGAME')) die("Hacking attempt");

//Définitions
global $db;

//On vérifie que le mod est activé
$query = "SELECT `active` FROM `".TABLE_MOD."` WHERE `action`='gameOgame' AND `active`='1' LIMIT 1";
if (!$db->sql_numrows($db->sql_query($query))) die("Hacking attempt");

echo"<fieldset><legend><b><font color='#0080FF'><u>Version 1.0.0 by Shad :</u></font></b></legend>";
echo"<p align='left'><font size='2'><ul>";
echo"<li>Compatibilité numéro de version pour OGSpy 3.0.7</li>";
echo"<li>Mise a jour des functions install, uninstall et update</li>";
echo"<li>Remplacer des noms du répertoire</li>";
echo"</ul></font></p>";
echo"</fieldset>";
echo"<br>";
echo"<br>";

echo"<fieldset><legend><b><font color='#0080FF'><u>Version 2.1b :</u></font></b></legend>";
echo"<p align='left'><font size='2'><ul>";
echo"<li>Compatibilité Xtense2.0b8/2.0.4041</li>";
echo"</ul></font></p>";
echo"</fieldset>";
echo"<br>";
echo"<br>";

echo"<fieldset><legend><b><font color='#0080FF'><u>Version 2.1a :</u></font></b></legend>";
echo"<p align='left'><font size='2'><ul>";
echo"<li>Bug dans la détection des droits des joueurs, les pages Admin et changelog s'affichaient pour tout les joueurs</li>";
echo"<li>Bug dans la détection de la connexion avec Xtense2</li>";
echo"<li>Maintenant les mentions page suivante/précédente s'affiche entre chaque tableau</li>";
echo"<li>A chaque visualisation de la page administration la liste des joueurs du mod est comparé à la liste des joueurs du serveur. Si un joueur a été supprimé alors il est aussi supprimé de gameOgame ainsi que ses RR et RC</li>";
echo"<li>Dans la page 'Affichage' seuls les joueurs actifs sont affichés</li>";
echo"<li>Fixé la taille des flèches dans les colonnes</li>";
echo"</ul></font></p>";
echo"</fieldset>";
echo"<br>";
echo"<br>";

echo"<fieldset><legend><b><font color='#0080FF'><u>Version 2.1 :</u></font></b></legend>";
echo"<p align='left'><font size='2'><ul>";
echo"<li>Ajout d'une page 'Changelog'</li>";
echo"<li>Correction petit problème dans le module de liaison Xtense2 - Merci Sylar </li>";
echo"<li>Remplacement de la fonction 'menu'</li>";
echo"<li>Correction de l'affichage des RC</li>";
echo"<li>Ajout des coordonnées de l'attaquant et du défenseur dans la base de données</li>";
echo"<li>Ajout du nombre de rapports supprimés et du nombre de points des rapports supprimés dans la base de données</li>";
echo"<li>Ajout d'un timestamp dans les rapports de recyclage</li>";
echo"<li>Page Affichage: Création de la liste des joueurs avec des 'checkbox' pour sélectionner</li>";
echo"<li>Page Affichage: Possibilité d'afficher tout les joueurs dans 1 seul tableau</li>";
echo"<li>Page Affichage: Ajout de 'page suivante' / 'page précédente' pour naviguer dans les autres données de la BDD</li>";
echo"<li>Page Affichage: Ajout de flèches dans certaines colonnes pour trier les résultats</li>";
echo"<li>Administration: Transfert des paramètres du mod dans la table mod_config</li>";
echo"<li>Administration: Possibilité de changer le nombre de ligne dans les tableaux de la page 'Affichage'</li>";
echo"<li>Administration: Soft Purge - Supprime les rapports avec un nombre de points inférieurs à une valeur définie</li>";
echo"<li>Administration: Hard Purge - Ne conserve que les X meilleurs rapports de chaque joueur. X étant modifiable</li>";
echo"<li>Administration: Il est possible de mettre une des purges (soft ou hard) en automatique. La purge n'aura lieu qu'une fois par jour</li>";
echo"<li>Administration: Purge Totale - Supprime TOUT les RC et les RR. Comptabilise le nb de RC et les points pour chaque joueur</li>";
echo"<li>Administration: Nettoyage - Suppression des RC orphelins dont le joueur n'est plus actif et des RC défenseur.</li>";
echo"<li>Administration: Ajout de bulles d'aides sur les nouvelles fonctions</li>";
echo"<li>Xtense2: N'accepte plus les rapports défenseurs</li>";
echo"<li>Xtense2: insertion automatique des rapports de recyclages (enfin j'espère)</li>";
echo"<li>Correction page Nouveau RC, même règles que Xtense2</li>";
echo"<li>Stats : Ajout d'un bouton 'individuel' pour afficher les stats de l'utilisateur </li>";
echo"<li>Correction des scripts d'install et de update</li>";
echo"</ul></font></p>";
echo"</fieldset>";
echo"<br>";
echo"<br>";

echo"<fieldset><legend><b><font color='#0080FF'><u>Version 2.0d :</u></font></b></legend>";
echo"<p align='left'><font size='2'><ul>";
echo"<li>Connection avec Xtense2: Rapports de combats</li>";
echo"<li>Page Admin: Détection de Xtense2 et connection</li>";
echo"</ul></font></p>";
echo"</fieldset>";
echo"<br>";
echo"<br>";

echo"<br />";
?>
