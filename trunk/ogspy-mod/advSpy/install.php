<?php
//includes ogspy
//if (!defined("IN_SPYOGAME")) { define("IN_SPYOGAME", true); }
if (!defined('IN_SPYOGAME')) die("install > IN_SPYOGAME = 0");
require_once("common.php");
global $db;

//includes advspy (environement de base)
define("IN_MOD_ADVSPY",TRUE);
$AdvSpyConfig['Settings']['AdvSpy_BasePath']="./mod/AdvSpy/";
include $AdvSpyConfig['Settings']['AdvSpy_BasePath']."Adv_config.php";

//ajout de advspy à la liste des mods actifs.
$query = "INSERT INTO ".TABLE_MOD." ( title, menu, action, root, link, version, active)
VALUES ('AdvSpy','- AdvSpy -','AdvSpy','AdvSpy','AdvSpy.php','".$AdvSpyConfig['version']['advspy']."','1')";
$db->sql_query($query);

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

//sauvegardes crées par défaut
include $AdvSpyConfig['Settings']['AdvSpy_BasePath']."Adv_DefaultSaves.php";
$db->sql_query(AdvSpy_Config_GetSqlOfDefaultSaves($AdvSpyConfig['Settings']['AdvSpy_TableName_SaveLoad']));


?>
