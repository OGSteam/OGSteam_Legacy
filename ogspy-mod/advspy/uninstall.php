<?php
//includes ogspy
define("IN_SPYOGAME", true);
require_once("common.php");
global $db;

//includes advspy (environement de base)
define("IN_MOD_ADVSPY",TRUE);
$AdvSpyConfig['Settings']['AdvSpy_BasePath']="./mod/AdvSpy/";
include $AdvSpyConfig['Settings']['AdvSpy_BasePath']."Adv_config.php";

//table des raids
$query = "DROP TABLE `".$AdvSpyConfig['Settings']['AdvSpy_TableName_RaidAlert']."`;";
$db->sql_query($query);

//table des sauvegardes
$query = "DROP TABLE `".$AdvSpyConfig['Settings']['AdvSpy_TableName_SaveLoad']."`;";
$db->sql_query($query);

?>