<?php
/***************************************************************************
*	Filename	: police.php
*	desc.		: Script de gestion des Polices d'�criture du module "Pr�sentation Alliance"
*	Authors	: Lose - http://ogs.servebbs.net/; Edit� par Sylar - sylar@ogsteam.fr
*	created	: 30/11/2007
*	modified	: 25/02/2008
*	version	: 0.1
***************************************************************************/
if (!defined('IN_SPYOGAME')) 	die("Hacking attempt");

// Listage du dossier des polices d'�criture
$police = array(); 
$dossier = @opendir (FOLDER_FONT); 
while ($fichier = readdir ($dossier))
	if (substr($fichier, -4) == ".ttf" )
		$police[] = $fichier;
?>