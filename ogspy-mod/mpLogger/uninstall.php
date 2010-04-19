<?php
/**
 * uninstall.php 

Script de désintallation

 * @package MP_Logger
 * @author Sylar
 * @link http://www.ogsteam.fr
 * @version : 0.1
 * dernière modification : 16.10.07
 * Module de capture des messages entre joueurs
 */
// L'appel direct est interdit
if (!defined('IN_SPYOGAME')) die("Hacking attempt");
include("mpl_includes.php");
global $db;

/*/Suppression de la table...
$query = "DROP TABLE IF EXISTS ".TABLE_MPC.";";
$db->sql_query($query);
$query = "DROP TABLE IF EXISTS ".TABLE_MPC_config.";";
$db->sql_query($query);
*/
$query = "DELETE FROM ".TABLE_MOD." WHERE title='$mod_name'";

$db->sql_query($query);
?>