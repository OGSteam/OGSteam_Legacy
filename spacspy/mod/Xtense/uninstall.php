<?php
/**
* xtense_unistall.php
* @package Xtense
*  @author Naqdazar, then modified by OGSteam
*  @link http://www.ogsteam.fr
*  @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/
if (!defined('IN_SPACSPY')) die("Hacking attempt");
global $db;


if (file_exists("xtense_plugin.php")) @unlink("xtense_plugin.php");

$request = "DELETE FROM ".TABLE_CONFIG." where config_name = 'xtense_debug'";
$db->sql_query($request);

$request = "DELETE FROM ".TABLE_CONFIG." where config_name = 'xtense_maintenance'";
$db->sql_query($request);

$request = "DELETE FROM ".TABLE_CONFIG." where config_name = 'xtense_logogslogon'";
$db->sql_query($request);

//
$request = "DELETE FROM ".TABLE_CONFIG." where config_name = 'xtense_logogsspyadd'";
$db->sql_query($request);

//
$request = "DELETE FROM ".TABLE_CONFIG." where config_name = 'xtense_logogsgalview'";
$db->sql_query($request);

//
$request = "DELETE FROM ".TABLE_CONFIG." where config_name = 'xtense_logogsplayerstats'";
$db->sql_query($request);

//
$request = "DELETE FROM ".TABLE_CONFIG." where config_name = 'xtense_logogsallystats'";
$db->sql_query($request);

//
$request = "DELETE FROM ".TABLE_CONFIG." where config_name = 'xtense_logogsallyhistory'";
$db->sql_query($request);

//logogsuserbuildings
$request = "DELETE FROM ".TABLE_CONFIG." where config_name = 'xtense_logogsuserbuildings'";
$db->sql_query($request);  

//logogsusertechnos
$request = "DELETE FROM ".TABLE_CONFIG." where config_name = 'xtense_logogsusertechnos'";
$db->sql_query($request);  

//logogsuserdefence
$request = "DELETE FROM ".TABLE_CONFIG." where config_name = 'xtense_logogsuserdefence'";
$db->sql_query($request);  	
	
//logogsuserplanetempire
$request = "DELETE FROM ".TABLE_CONFIG." where config_name = 'xtense_logogsuserplanetempire'";
$db->sql_query($request);
	
//logogsuserplanetmoon
$request = "DELETE FROM ".TABLE_CONFIG." where config_name = 'xtense_logogsusermoonempire'";
$db->sql_query($request);
	
//logunallowconnattempt
$request = "DELETE FROM ".TABLE_CONFIG." where config_name = 'xtense_logunallowedconnattempt'";
$db->sql_query($request);
	
$request = "DELETE FROM ".TABLE_CONFIG." where config_name = 'xtense_handlegalaxyviews'";
$db->sql_query($request);
	
$request = "DELETE FROM ".TABLE_CONFIG." where config_name = 'xtense_handleplayerstats'";
$db->sql_query($request);
	
$request = "DELETE FROM ".TABLE_CONFIG." where config_name = 'xtense_handleallystats'";
$db->sql_query($request);
	
$request = "DELETE FROM ".TABLE_CONFIG." where config_name = 'xtense_handleespioreports'";
$db->sql_query($request);
	
// forcestricnameuniv - bloquer les données provenant de serveur ogame non associé
$request = "DELETE FROM ".TABLE_CONFIG." where config_name = 'xtense_forcestricnameuniv'";
$db->sql_query($request);

//
$request = "DELETE FROM ".TABLE_CONFIG." where config_name = 'xtense_logogssqlfailure'";
$db->sql_query($request);
	
//
$request = "DELETE FROM ".TABLE_CONFIG." where config_name = 'xtense_ogsplugin_numuniv'";
$db->sql_query($request);

//
$request = "DELETE FROM ".TABLE_CONFIG." where config_name = 'xtense_ogsplugin_nameuniv'";
$db->sql_query($request);
?>
