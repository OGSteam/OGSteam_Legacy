<?php
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

$filename = 'mod/Pandore/version.txt';
if (file_exists($filename)) $file = file($filename);

global $table_prefix;

// Créer la table d'enregistrements si besoin
$query = 'CREATE TABLE IF NOT EXISTS `'.$table_prefix.'mod_pandore` (
	`id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	`joueur` VARCHAR(20) NOT NULL ,
	`classement_general` INT(11) NOT NULL ,
	`points_general` INT(11) NOT NULL ,
	`classement_flotte` INT(11) NOT NULL ,
	`points_flotte` INT(11) NOT NULL ,
	`classement_recherche` INT(11) NOT NULL ,
	`points_recherches` INT(11) NOT NULL ,
	`PT` INT(11) NOT NULL ,
	`GT` INT(11) NOT NULL ,
	`CLE` INT(11) NOT NULL ,
	`CLO` INT(11) NOT NULL ,
	`CR` INT(11) NOT NULL ,
	`VB` INT(11) NOT NULL ,
	`VC` INT(11) NOT NULL ,
	`REC` INT(11) NOT NULL ,
	`SE` INT(11) NOT NULL ,
	`BMD` INT(11) NOT NULL ,
	`SAT` INT(11) NOT NULL ,
	`DST` INT(11) NOT NULL ,
	`EDLM` INT(11) NOT NULL ,
	`TRA` INT(11) NOT NULL ,
	`points` INT(11) NOT NULL ,
	`points_manquants` INT(11) NOT NULL ,
	`flottes` INT(11) NOT NULL ,
	`flottes_manquantes` INT(11) NOT NULL ,
	`user_name` VARCHAR(20) NOT NULL ,
	`date` VARCHAR(19) NOT NULL ,
	INDEX ( `date` ) 
)';
$db->sql_query($query);

$query = "INSERT INTO ".TABLE_MOD." (title, menu, action, root, link, version, active) VALUES ('Pandore','Pandore','pandore','Pandore','pandore.php','".trim($file[1])."','1')";
$db->sql_query($query);
?>
