<?php
/**
* help.php - Réutilisation de la fonction help() du fichier /includes/help.php . on ne fait que (re)définir des entrées dans le array
 * @package Attaques
 * @author Verité
 * @link http://www.ogsteam.fr
 * @version : 0.8a
 */

//L'appel direct est interdit
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

//On vérifie que le mod est activé
$query = "SELECT `active` FROM `".TABLE_MOD."` WHERE `action`='gameOgame' AND `active`='1' LIMIT 1";
if (!$db->sql_numrows($db->sql_query($query))) die("Hacking attempt");

global $key;
$help["line"] = "Modifie le nombre de ligne affichées dans la page 'Affichage'";
$help["timer"] = "Date et heure de la derni&egrave;re purge.<br /> Si le mode automatique est activ&eacute;, la prochaine purge aura lieu 24h apr&egrave;s !";
$help["soft"] = "Purge l&eacute;g&egrave;re:<br /> Supprime les rapports de combat et de recyclage dont le nombre de point est inf&eacute;rieur ou égal au chiffre que vous entrez dans la cellule.<br />Le nombre de rapport supprim&eacute; et le nombre de points est conserv&eacute;.";
$help["auto"] = "Active la purge automatique pour les purges 'hard' ou 'soft'.<br />Les deux types de purges sont exclusives !<br />La purge automatique n'a lieu qu'une fois toutes les 24 heures !";
$help["hard"] = "Purge profonde:<br /> Ne conserve que les meilleurs rapports de chaque joueur.<br />Le nombre de rapport conserv&eacute; est &agrave; entrer dans la cellule.<br />Le nombre de rapport supprim&eacute; et le nombre de points est conserv&eacute;.";
$help["total"] = "<font color='red'>Purge tout les rapports qui se trouvent dans la base de donn&eacute;es.</font><br />Le nombre de rapport supprim&eacute; et le nombre de points est conserv&eacute;.";
$help["nettoy"] = "Supprime de la base de données les rapports de combat et de recyclage qui n'appartiennent à aucun joueur actif.<br />Supprime aussi les rapports dont les membres actifs ne sont pas les attaquants";
?>