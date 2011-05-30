<?php
/***************************************************************************
*	Filename	: install.php
*	desc.		: Page d'installation du module "Présentation Alliance"
*	Authors	: Sylar - sylar@ogsteam.fr
*	created	: 23/02/2008
*	modified	: 18/05/2011
*	version	: 1.0
***************************************************************************/
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

// Ajout du module dans la table des mod de OGSpy
global $db,$table_prefix;
$is_ok = false;
$mod_folder = "presentationalliance";
$is_ok = install_mod($mod_folder);
if ($is_ok == true)
	{
		define("TABLE_P_ALLY_PIC", $table_prefix."pres_alliance_pic");
		define("TABLE_P_ALLY_DATA", $table_prefix."pres_alliance_data");

		// Création de la table qui va accueillir les infos générales des images
		$db->sql_query("CREATE TABLE IF NOT EXISTS `".TABLE_P_ALLY_PIC."` (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`name` varchar(64) collate latin1_general_ci NOT NULL,
			`tag_alliance` varchar(24) collate latin1_general_ci NOT NULL,
			`background` varchar(64) collate latin1_general_ci NOT NULL,
			`output` varchar(64) collate latin1_general_ci NOT NULL,
			`user_id` int(11) collate latin1_general_ci NOT NULL,
			KEY `id` (`id`) ) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;");

		// Création de la table qui va stocker les différents champs pour toutes les images
		$db->sql_query("CREATE TABLE IF NOT EXISTS `".TABLE_P_ALLY_DATA."` (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`id_pic` int(11) NOT NULL,
			`type`  enum('image','text','stat') NOT NULL,
			`nom_champ` varchar(64) collate latin1_general_ci NOT NULL,
			`text` varchar(64) collate latin1_general_ci NOT NULL,
			`pos_x` int(4) NOT NULL,
			`pos_y` int(4) NOT NULL,
			`pos_ang` int(4) NOT NULL,
			`font_name` text collate latin1_general_ci NOT NULL,
			`font_size` int(4) NOT NULL,
			`font_color` varchar(64) collate latin1_general_ci NOT NULL,
			`actif` tinyint(1) NOT NULL,
			KEY `id` (`id`) ) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;");

		// Ajout de l'image d'exemple
		$db->sql_query("INSERT INTO `".TABLE_P_ALLY_PIC."` (`name`,`tag_alliance`,`background`,`output`,`user_id`) 
			VALUES ('Exemple','Tag','fond0.jpg','exemple.jpg',0);");

		// Quel est l'id donné ?
		$id = $db->sql_insertid();

		// Ajout des champs images, text, et stat de l'image d'exemples.
		$query = "INSERT INTO `".TABLE_P_ALLY_DATA."` ";
		$query .= "(`id_pic`,`type`,`nom_champ`,`text`,`pos_x`,`pos_y`,`pos_ang`,`font_name`,`font_size`,`font_color`,`actif`) ";
		$query .= "VALUES ";
		$query .= "( $id, 'image', 'Recrutement', 'ouvert.png', 680, 179, 0, '', 0, '',1 ),";
		$query .= "( $id, 'image', 'Recrutement', 'ferme.png', 680, 179, 0, '', 0, '',0 ),";
		$query .= "( $id, 'text', 'Tag', 'LNA', 290, 90, 0, 'verdanab.ttf', 60, 'F76541',1 ), ";
		$query .= "( $id, 'text', 'Nom Alliance', 'Le Nom Alliance', 70, 90, 0, 'CloisterBlack.ttf', 20, 'F76541',1 ), ";
		$query .= "( $id, 'text', 'Texte', 'Bonjour^n                  à vous tous!', 170, 220, 0, 'xenippa1.ttf', 18, 'F76541',1 ), ";
		$query .= "( $id, 'text', 'Pactes', 'Pactes', 150, 415, 0, 'verdanab.ttf', 10, 'F76541',1 ), ";
		$query .= "( $id, 'text', 'infoPactes', '- Aucun -', 200, 415, 0, 'verdanab.ttf', 10, '78EE12',1 ), ";
		$query .= "( $id, 'text', 'Divers', 'Divers', 150, 430, 0, 'verdanab.ttf', 10, 'F76541',1 ), ";
		$query .= "( $id, 'text', 'infoDivers', '- Néant -', 200, 430, 0, 'verdanab.ttf', 10, '4852DD',1 ), ";
		$query .= "( $id, 'text', 'Recrutement', 'Recrutement :', 600, 200, 0, 'CloisterBlack.ttf', 10, 'FFFFFF',1 ), ";
		$query .= "( $id, 'stat', 'general', '{rank} ème en points', 600, 520, 0, 'verdanab.ttf', 10, 'F76541',1 ), ";
		$query .= "( $id, 'stat', 'fleet', '{rank} ème en flotte', 600, 530, 0, 'verdanab.ttf', 10, 'F76541',1 ), ";
		$query .= "( $id, 'stat', 'research', '{rank} ème en recherche', 600, 540, 0, 'verdanab.ttf', 10, 'F76541',1 ); ";
		$db->sql_query($query);
	}
else
	{	
		echo  "<script>alert('Désolé, un problème a eu lieu pendant l'installation, corrigez les problèmes survenue et réessayez.');</script>";
	}
?>