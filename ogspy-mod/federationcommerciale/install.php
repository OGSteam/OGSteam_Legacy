<?php
/**
* install.php 
* @package Attaques
* @author Verité
* @link http://www.ogsteam.fr
*/

if (!defined('IN_SPYOGAME')) die("Hacking Attempt!");
global $db;
//Fichier install
$is_ok = false;
$mod_folder = "federationcommerciale";
$is_ok = install_mod ($mod_folder);
//et si tu as pris la fonction boléenne faut que je rajoute sae
if ($is_ok == true)
	{
		define("TABLE_FEDERATION_COMMERCIAL", substr(TABLE_USER, 0, strlen(TABLE_USER)-4)."federation_commercial");
		define("TABLE_FEDERATION_COMMERCIAL_VENTE", substr(TABLE_USER, 0, strlen(TABLE_USER)-4)."federation_commercial_vente");
		define("TABLE_FEDERATION_COMMERCIAL_PARTICIPANTS", substr(TABLE_USER, 0, strlen(TABLE_USER)-4)."federation_commercial_participants");

		// suppression de la table TABLE_FEDERATION_COMMERCIAL si elle existe
		$query = "DROP TABLE IF EXISTS `".TABLE_FEDERATION_COMMERCIAL."`";
		$db->sql_query($query);

		// création de la table d'enregistrement des settings
		$query = "CREATE TABLE ".TABLE_FEDERATION_COMMERCIAL." (".
			" id int(11) NOT NULL auto_increment,".
			" lastid int(11) NOT NULL default '0' COMMENT 'dernier ID utiliser',".
			" primary key ( id ) )COMMENT='sauvegarde des parametres de federation commercial'";
		$db->sql_query($query);
	
		// suppression de la table TABLE_FEDERATION_COMMERCIALE_VENTE  si elle existe
		$query = 'DROP TABLE IF EXISTS `'.TABLE_FEDERATION_COMMERCIAL_VENTE.'`';
		$db->sql_query($query);

		//creation table pour l'enregistrement des ventes
		$query = "CREATE TABLE ".TABLE_FEDERATION_COMMERCIAL_VENTE." (".
			" id int(11) NOT NULL auto_increment,".
			" nb_vendeur int(11)UNSIGNED NOT NULL default '0' COMMENT 'nombre de vendeur',".
			" nb_acheteur int(11)UNSIGNED NOT NULL default '0' COMMENT 'nombre d\'acheteur',".
			" m_taux int(11)UNSIGNED NOT NULL default '0' COMMENT 'taux du métal',".
			" c_taux int(11)UNSIGNED NOT NULL default '0' COMMENT 'taux du cristal',".
			" d_taux int(11)UNSIGNED NOT NULL default '0' COMMENT 'taux du deuterium',".
			" date int(11)UNSIGNED NOT NULL default '0' COMMENT 'date de la vente',".
			" primary key ( id ) )COMMENT='sauvegarde des vente de federation commercial'";
		$db->sql_query($query);
	
		// suppression de la table FEDERATION_COMMERCIALE_PARTICIPANTS si elle existe
		$query = 'DROP TABLE IF EXISTS `'.TABLE_FEDERATION_COMMERCIAL_PARTICIPANTS.'`';
		$db->sql_query($query);

		//creation table pour l'enregistrement de la contribution de chaque membres
		$query = "CREATE TABLE ".TABLE_FEDERATION_COMMERCIAL_PARTICIPANTS." (".
			" id int(11) NOT NULL auto_increment,".
			" pseudo varchar(40) NOT NULL default '0' COMMENT 'pseudo du participant',".
			" metal int(11)UNSIGNED NOT NULL default '0' COMMENT 'total en métal de la vente',".
			" cristal int(11)UNSIGNED NOT NULL default '0' COMMENT 'total en cristal de la vente',".
			" deuterium int(11)UNSIGNED NOT NULL default '0' COMMENT 'total en deuterium de la vente',".
			" rang int(2)UNSIGNED NOT NULL default '0' COMMENT 'total en cristal de la vente',".
			" groupe int(1)UNSIGNED NOT NULL default '0' COMMENT 'total en deuterium de la vente',".
			" vente_id int(11) NOT NULL default '0' COMMENT 'id de la vente qui lui est rataché',".
			" primary key ( id ) )COMMENT='sauvegarde des vente de federation commercial'";
		$db->sql_query($query);

		//on inicialise les settings
		$query = "INSERT INTO ".TABLE_FEDERATION_COMMERCIAL." (id, lastid) VALUES ('', '')";
		$db->sql_query($query);
	}
else
	{
		echo  "<script>alert('Désolé, un problème a eu lieu pendant l'installation, corrigez les problèmes survenue et réessayez.');</script>";
	}
?>

