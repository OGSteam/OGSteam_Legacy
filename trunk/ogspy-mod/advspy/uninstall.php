<?php
//includes ogspy
define("IN_SPYOGAME", true);

$mod_folder= "advspy";
//includes advspy (environement de base)
define("IN_MOD_ADVSPY",TRUE);
$AdvSpyConfig['Settings']['AdvSpy_BasePath']="./mod/".$mod_folder."/";
require_once($AdvSpyConfig['Settings']['AdvSpy_BasePath']."Adv_config.php");

$mod_uninstall_name = "advspy";
$mod_uninstall_table = $AdvSpyConfig['Settings']['AdvSpy_TableName_RaidAlert'].', '.$AdvSpyConfig['Settings']['AdvSpy_TableName_SaveLoad'];
uninstall_mod($mod_unistall_name,$mod_uninstall_table);

?>