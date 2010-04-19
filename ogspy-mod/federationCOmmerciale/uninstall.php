<?php
/**
* uninstall.php 
* @package Attaques
* @author Verité
* @link http://www.ogsteam.fr
*/

define("IN_SPYOGAME", true);
require_once("common.php");

global $db;

define("TABLE_FEDERATION_COMMERCIAL", substr(TABLE_USER, 0, strlen(TABLE_USER)-4)."federation_commercial");
define("TABLE_FEDERATION_COMMERCIAL_VENTE", substr(TABLE_USER, 0, strlen(TABLE_USER)-4)."federation_commercial_vente");
define("TABLE_FEDERATION_COMMERCIAL_PARTICIPANTS", substr(TABLE_USER, 0, strlen(TABLE_USER)-4)."federation_commercial_participants");

// suppression de la table TABLE_FEDERATION_COMMERCIAL si elle existe
$query = "DROP TABLE IF EXISTS `".TABLE_FEDERATION_COMMERCIAL."`";
$db->sql_query($query);

// suppression de la table FEDERATION_COMMERCIALE_PARTICIPANTS si elle existe
$query = 'DROP TABLE IF EXISTS `'.TABLE_FEDERATION_COMMERCIAL_PARTICIPANTS.'`';
$db->sql_query($query);

// suppression de la table TABLE_FEDERATION_COMMERCIALE_VENTE  si elle existe
$query = 'DROP TABLE IF EXISTS `'.TABLE_FEDERATION_COMMERCIAL_VENTE.'`';
$db->sql_query($query);

$query = "DELETE FROM ".TABLE_MOD." WHERE action='federation_commerciale'";
$db->sql_query($query);
?>
