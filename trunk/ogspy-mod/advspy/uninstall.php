<?php
//includes ogspy
define("IN_SPYOGAME", true);
require_once("common.php");
global $db;
$mod_folder= "advspy";
//includes advspy (environement de base)
define("IN_MOD_ADVSPY",TRUE);
$AdvSpyConfig['Settings']['AdvSpy_BasePath']="./mod/".$mod_folder."/";
include $AdvSpyConfig['Settings']['AdvSpy_BasePath']."Adv_config.php";

global $table_prefix;
$mod_uninstall_name = "advspy";
$mod_uninstall_table = $AdvSpyConfig['Settings']['AdvSpy_TableName_RaidAlert'].', '.$AdvSpyConfig['Settings']['AdvSpy_TableName_SaveLoad'];
uninstall_mod($mod_unistall_name,$mod_uninstall_table);


?>