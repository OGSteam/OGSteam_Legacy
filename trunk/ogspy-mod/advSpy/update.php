<?php
//includes ogspy
define("IN_SPYOGAME", true);
require_once("common.php");
global $db;

//includes advspy (environement de base)
define("IN_MOD_ADVSPY",TRUE);
$AdvSpyConfig['Settings']['AdvSpy_BasePath']="./mod/AdvSpy/";
include $AdvSpyConfig['Settings']['AdvSpy_BasePath']."Adv_config.php";

//verification pas indispensable mais on sais jamais commen une install peut se retrouver apres une mauvaise manip'...
$query = 'SELECT `action` FROM `'.TABLE_MOD.'` WHERE `action`=\'AdvSpy\' LIMIT 1';
if (!$db->sql_numrows($db->sql_query($query))) {
	$query = "INSERT INTO ".TABLE_MOD." (id, title, menu, action, root, link, version, active)
	VALUES ('','AdvSpy','- AdvSpy -','AdvSpy','AdvSpy','AdvSpy.php','".$AdvSpyConfig['version']['advspy']."','1')";
	$db->sql_query($query);
}

//mise à jour de la version du mod
$query = "UPDATE ".TABLE_MOD." SET version='".$AdvSpyConfig['version']['advspy']."' WHERE action='AdvSpy'";
$db->sql_query($query);

//creation de la table des raids (si besoin)
$query = "CREATE TABLE IF NOT EXISTS `".$AdvSpyConfig['Settings']['AdvSpy_TableName_RaidAlert']."` (
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

//creation de la table des sauvegardes (si besoin)
$query = "CREATE TABLE IF NOT EXISTS `".$AdvSpyConfig['Settings']['AdvSpy_TableName_SaveLoad']."` (
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


//verification de rétro-compatibilité pour Galaxy sur 2 chiffres et non 1 seul (compatibilité uni 50 fr, galaxy = 50)
$query = "SHOW COLUMNS FROM `".$AdvSpyConfig['Settings']['AdvSpy_TableName_RaidAlert']."`";
$result=$db->sql_query($query);
$query = "";
while ($Columns=@mysql_fetch_assoc($result)) {
	//$Columns[' Field  	 Type  	 Null  	 Key  	 Default  	 Extra']
	if ($Columns['Field'] == "RaidGalaxy") {
		if ($Columns['Type'] == "int(1)") {
			$query = "ALTER TABLE `".$AdvSpyConfig['Settings']['AdvSpy_TableName_RaidAlert']."` CHANGE `RaidGalaxy` `RaidGalaxy` INT( 2 ) NOT NULL DEFAULT '0'";
			$db->sql_query($query);
		}
	}
}

//verification: si aucune sauvegarde existe, on remet celles par défaut.
$query = 'SELECT `SaveId` FROM `'.$AdvSpyConfig['Settings']['AdvSpy_TableName_SaveLoad'].'` WHERE 1 LIMIT 1';
if (!$db->sql_numrows($db->sql_query($query))) {
	include $AdvSpyConfig['Settings']['AdvSpy_BasePath']."Adv_DefaultSaves.php";
	$db->sql_query(AdvSpy_Config_GetSqlOfDefaultSaves($AdvSpyConfig['Settings']['AdvSpy_TableName_SaveLoad']));
}


?>
