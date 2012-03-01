<?php
/**
* install.php : Installation du Module Arcade
* @author ericalens <ericalens@ogsteam.fr> http://www.ogsteam.fr
* @copyright OGSteam 2006 
* @version 2.2
* @package Arcade
*/
if (!defined('IN_SPYOGAME')) die("Hacking Attempt!");
global $db;
if (!isset($table_prefix)) 
	global $table_prefix;
//Fichier install
$is_ok = false;
$mod_folder = "arcade";
$is_ok = install_mod ($mod_folder);
//et si tu as pris la fonction boléenne faut que je rajoute sae
if ($is_ok == true)
{			
	require_once("common.php");
	define('TABLE_ARCADE',$table_prefix.'arcade');
	define('TABLE_ARCADE_BAN',$table_prefix.'arcade_ban');
	define('TABLE_ARCADE_GAME',$table_prefix.'arcade_game');
	define('TABLE_ARCADE_ONLINE',$table_prefix.'arcade_online');
	define('TABLE_ARCADE_TOURGAME',$table_prefix.'arcade_tourgame');
	define('TABLE_ARCADE_TOURNAMENT',$table_prefix.'arcade_tournament');
	define('TABLE_ARCADE_TOURSCORE',$table_prefix.'arcade_tourscore');
	
	/**
	* Création de la table arcade_ogspy avec DROP si neccessaire
	*/
	function CreateTable()
		{
			global $db;
			// Suppresion de la table si elle existe
			$query="DROP TABLE IF EXISTS `".TABLE_ARCADE."`;";
			$db->sql_query($query);
			// Creation de la table proprement dites
			$query="CREATE TABLE `".TABLE_ARCADE."` (
				`id` int(11) NOT NULL auto_increment,
				`playername` varchar(30) NOT NULL default '' COMMENT 'Joueur possedant ce score',
				`score` float NOT NULL COMMENT 'Score soumis',
				`gamename` varchar(30) NOT NULL COMMENT 'Jeu auquel s applique ce score',
				`scoredate` int(11) NOT NULL COMMENT 'Timestamp du score',
				`comment` TEXT NOT NULL COMMENT 'Commentaire du joueur',
				PRIMARY KEY  (`id`)
				) ";
			$db->sql_query($query);		

			// Suppresion de la table si elle existe
			$query="DROP TABLE IF EXISTS `".TABLE_ARCADE_BAN."`";
			$db->sql_query($query);

			// Creation de la table proprement dites
			$query="CREATE TABLE `".TABLE_ARCADE_BAN."` (
				`id` int(11) NOT NULL primary key,
				`playername` varchar(30) NOT NULL COMMENT 'Joueur banni'
				) ";
			$db->sql_query($query);


			// Suppresion de la table si elle existe
			$query="DROP TABLE IF EXISTS `".TABLE_ARCADE_GAME."`";
			$db->sql_query($query);
	

			// Creation de la table proprement dites
			$query="CREATE TABLE `".TABLE_ARCADE_GAME."` (
				`id` int(11) NOT NULL auto_increment COMMENT 'ID du jeu',
				`name` varchar(50) NOT NULL COMMENT 'Nom du jeu',
				`scorename` varchar(50) NOT NULL COMMENT 'Nom du Score du jeu',
				`width` mediumint(9) NOT NULL COMMENT 'Largeur en pixel ',
				`height` mediumint(9) NOT NULL COMMENT 'Hauteur en pixel',
				`swfname` varchar(50) NOT NULL COMMENT 'Nom du fichier SWF',
				`description` varchar(255) NOT NULL COMMENT 'Description du jeu',
				`playcount` int(10) NOT NULL COMMENT 'Nombre de fois ou le jeu a été joué',
				`image` varchar(50) NOT NULL COMMENT 'Image associé',
				`highscore` int(10) NOT NULL COMMENT 'Meilleur score',
				`highscoreplayer` varchar(30) NOT NULL COMMENT 'Nom du Joueur du meilleur score',
				`highscoredate` int(11) NOT NULL COMMENT 'date du highscore',
				`backcolor` varchar(7) NOT NULL default '#000000' COMMENT 'couleur de fond',
				PRIMARY KEY  (`id`)
				) COMMENT='Liste des jeux Installés'  ;";
			$db->sql_query($query);

			// Suppresion de la table si elle existe
			$query="DROP TABLE IF EXISTS `".TABLE_ARCADE_ONLINE."`";
			$db->sql_query($query);
	
			// Creation de la table proprement dites
			$query="CREATE TABLE `".TABLE_ARCADE_ONLINE."` (
				`statustime` int(11) NOT NULL COMMENT 'Timestamp de l''insertion du statut',
				`playername` varchar(50) NOT NULL COMMENT 'Nom Joueur',
				`gameid` int(11) NOT NULL COMMENT 'ID du jeu joué',
				UNIQUE KEY `playername` (`playername`)
				) ";
			$db->sql_query($query);
			
			$query="CREATE TABLE `".TABLE_ARCADE_TOURGAME."` (
				`id` int(11) NOT NULL auto_increment,
				`tournament_id` int(11) NOT NULL,
				`game_id` int(11) NOT NULL,
				PRIMARY KEY  (`id`)
				) ";
			$db->sql_query($query);

			$query="CREATE TABLE `".TABLE_ARCADE_TOURNAMENT."` (
				`id` int(11) NOT NULL auto_increment,
				`name` varchar(150) NOT NULL,
				`starttime` int(11) NOT NULL,
				`endtime` int(11) NOT NULL,
				PRIMARY KEY  (`id`)
				) ";
			$db->sql_query($query);

			$query="CREATE TABLE `".TABLE_ARCADE_TOURSCORE."` (
				`id` int(11) NOT NULL auto_increment,
				`playername` varchar(30) NOT NULL,
				`game_id` int(11) NOT NULL,
				`score` float NOT NULL,
				`scoredate` int(11) NOT NULL,
				PRIMARY KEY  (`id`)
				) ";
			$db->sql_query($query);

		}	

	/**
	* Fonction d'insertion d'une valeur de configuration dans la TABLE_CONFIG
	*/

	function SetConfig($key,$value)
		{
			global $db;

			$query="REPLACE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('$key','$value') ";
		    $db->sql_query($query);
		}

	/**
	* Insertion/Reinitialisation des valeurs de configuration par défaut
	*/

	function CreateConfig()
		{
			global $db;

			SetConfig("arcade_dontforcename","0"); // par defaut, on force le nom du joueur avec son nom OGSPY
			SetConfig("arcade_coadminenable","0"); // par defaut, les coadmins ne peuvent pas gerer le panel admin
			SetConfig("arcade_logdebug","1"); // par defaut, toute insertion de score est journalisé
			SetConfig("arcade_admingamedebug","0"); 
			SetConfig("arcade_announce","Bienvenue sur le mod Arcade"); // par defaut, toute insertion de score est journalisé
			SetConfig("arcade_imagesize","40"); 
			SetConfig("arcade_onlinmins","10"); 
			SetConfig("arcade_fullscreen","1"); 
		}

	// Execution de l'installation

	CreateTable();
	CreateConfig();
	$query="INSERT INTO `".TABLE_ARCADE_GAME."` (`id`, `name`, `scorename`, `width`, `height`, `swfname`, `description`, `playcount`, `image`, `highscore`, `highscoreplayer`, `highscoredate`, `backcolor`) "
      ."VALUES (null, 'Pacman', 'pacman', 350, 400, 'pacman.swf', 'Le classique pacman , par Neaves', 0, 'pacman1.gif', 0, '', 0, '#000000')";
	$db->sql_query($query) ;     
}
else
{
   echo  "<script>alert('Désolé, un problème a eu lieu pendant l'installation, corrigez les problèmes survenue et réessayez.');</script>";
}
?>

