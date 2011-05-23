<?php
/***************************************************************************
*	Filename	: police.php
*	desc.		: Script de gestion des Polices d'écriture du module "Présentation Alliance"
*	Authors	: Lose - http://ogs.servebbs.net/; Edité par Sylar - sylar@ogsteam.fr
*	created	: 30/11/2007
*	modified	: 25/02/2008
*	version	: 0.1
***************************************************************************/
if (!defined('IN_SPYOGAME')) 	die("Hacking attempt");

// Listage du dossier des polices d'écriture
$police = array(); 
$dossier = @opendir (FOLDER_FONT); 
while ($fichier = readdir ($dossier))
	if (substr($fichier, -4) == ".ttf" )
		$police[] = $fichier;
?>