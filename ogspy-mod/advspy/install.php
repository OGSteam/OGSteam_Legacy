<?php

if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}

define("IN_MOD_ADVSPY",TRUE);

//ajout de advspy à la liste des mods actifs.

$is_ok = false;
$mod_folder= "advspy";
$is_ok=install_mod($mod_folder);
if ($is_ok == true)
{
	$AdvSpyConfig['Settings']['AdvSpy_BasePath']="mod/advspy/";
	require_once($AdvSpyConfig['Settings']['AdvSpy_BasePath']."Adv_config.php");

	//creation de la table des raids
	$query = "CREATE TABLE `".$AdvSpyConfig['Settings']['AdvSpy_TableName_RaidAlert']."` (
	  `RaidId` int(11) NOT NULL auto_increment,
	  `RaidOwner` int(11) NOT NULL default '0',
	  `RaidGalaxy` int(2) NOT NULL default '0',
	  `RaidSystem` int(3) NOT NULL default '0',
	  `RaidRow` int(2) NOT NULL default '0',
	  `RaidDate` varchar(11) NOT NULL default '0',
	  `RaidLune` int(1) NOT NULL default '0',
	  PRIMARY KEY  (`RaidId`),
	  KEY `RaidOwner` (`RaidOwner`),
	  KEY `RaidDate` (`RaidDate`),
	  KEY `RaidGalaxy` (`RaidGalaxy`),
	  KEY `RaidRow` (`RaidRow`),
	  KEY `RaidSystem` (`RaidSystem`),
	  KEY `RaidLune` (`RaidLune`)
	);";
	$db->sql_query($query);

	//creation de la table des sauvegardes
	$query = "CREATE TABLE `".$AdvSpyConfig['Settings']['AdvSpy_TableName_SaveLoad']."` (
	  `SaveId` int(11) NOT NULL auto_increment,
	  `SaveOwner` int(11) NOT NULL default '0',
	  `SaveType` int(1) NOT NULL default '0',
	  `SaveData` text NOT NULL,
	  `SaveName` varchar(255) NOT NULL default 'x',
	  PRIMARY KEY  (`SaveId`),
	  KEY `SaveName` (`SaveName`),
	  KEY `SaveOwner` (`SaveOwner`),
	  KEY `SaveType` (`SaveType`)
	);";
	$db->sql_query($query);

	//sauvegardes defaut
	include $AdvSpyConfig['Settings']['AdvSpy_BasePath']."Adv_DefaultSaves.php";
	$db->sql_query(AdvSpy_Config_GetSqlOfDefaultSaves($AdvSpyConfig['Settings']['AdvSpy_TableName_SaveLoad']));
	echo	"<script>alert('Pour éviter les erreurs dans le journal, vous devez configurez vos préférences administrateur et utlisateur. De plus chaque utilisateur doit configurer ces préférences utilisateurs.');</script>";

}
else
{
	echo  "<script>alert('Désolé, un problème a eu lieu pendant l'installation, corrigez les problèmes survenue et réessayez.');</script>";
}

?>
