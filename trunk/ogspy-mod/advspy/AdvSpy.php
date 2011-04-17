<?php
/***************************************************************************
*	filename	: AdvSpy.php
*	desc.		: AdvSpy, mod for OGSpy.
*	Author		: kilops - http://ogs.servebbs.net/
*	created		: 16/08/2006
***************************************************************************/
error_reporting(E_ALL ^ E_NOTICE);

try {
	@ini_set('max_execution_time',60);
	@ini_set("memory_limit",'32M');
	@set_time_limit(60);
	@ob_end_clean();
} catch (Exception $e) {
    //echo "init error: $e";
}


function return_bytes($val) {
    $val = trim($val);
    $last = strtolower($val{strlen($val)-1});
    switch($last) {
        case 'g': $val *= 1024*1024*1024;
        case 'm': $val *= 1024*1024;
        case 'k': $val *= 1024;
    }
    return $val;
}


// Déclarations OgSpy
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

$query = 'SELECT `active` FROM `'.TABLE_MOD.'` WHERE `action`=\''.$pub_action.'\' AND `active`=\'1\' LIMIT 1';
if (!$db->sql_numrows($db->sql_query($query))) die('Hacking attempt (ou alors mod installé n\'importe commen)');

define("IN_MOD_ADVSPY",TRUE);


// dossier dans lequel est installé AdvSpy (avec un / a la fin) defaut : "./mod/AdvSpy/" )
$AdvSpyConfig['Settings']['AdvSpy_BasePath']="./mod/AdvSpy/";

include $AdvSpyConfig['Settings']['AdvSpy_BasePath']."Adv_config.php";
include $AdvSpyConfig['Settings']['AdvSpy_BasePath']."Adv_menu.php";
include $AdvSpyConfig['Settings']['AdvSpy_BasePath']."Adv_html.php";
include $AdvSpyConfig['Settings']['AdvSpy_BasePath']."Adv_sim.php";
include $AdvSpyConfig['Settings']['AdvSpy_BasePath']."Adv_functions.php";

//ancien fichier lang_fr
//include $AdvSpyConfig['Settings']['AdvSpy_BasePath']."AdvSpy_Lang_fra.php";
// Récupération des chaines de langue
require_once("mod/AdvSpy/lang/lang_FR/AdvSpy.php");
if (file_exists("mod/AdvSpy/lang/lang_".$server_config['language']."/AdvSpy.php")) require_once("mod/AdvSpy/lang/lang_".$server_config['language']."/AdvSpy.php");
if (file_exists("mod/AdvSpy/lang/lang_".$user_data['user_language']."/AdvSpy.php")) require("mod/AdvSpy/lang/lang_".$server_config['language']."/AdvSpy.php");

//versions concomitantes
$AdvSpyConfig['version']['ogspy']='4.0';
$AdvSpyConfig['version']['ogame']='[FR]0.83';

if(isset($pub_RaidAlert_Row) && isset($pub_RaidAlert_System) && isset($pub_RaidAlert_Galaxy))
{
	if ( ($AdvSpy_RaidAlert_Galaxy = $pub_RaidAlert_Galaxy) 
		&& ($AdvSpy_RaidAlert_System = $pub_RaidAlert_System) 
		&& ($AdvSpy_RaidAlert_Row = $pub_RaidAlert_Row)) 
	{
		if (isset($pub_RaidAlert_Lune)) $AdvSpy_RaidAlert_Lune = $pub_RaidAlert_Lune;
		else $AdvSpy_RaidAlert_Lune='';
		AdvSpy_RaidAlert_START($AdvSpy_RaidAlert_Galaxy,$AdvSpy_RaidAlert_System,$AdvSpy_RaidAlert_Row,$AdvSpy_RaidAlert_Lune);
	}
} 
else 
{
	require_once("views/page_header.php");
	AdvSpy_START();
	require_once("views/page_tail.php");
}
?>