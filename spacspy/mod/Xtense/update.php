<?php
/**
* xtense_update.php
* @package Xtense
*  @author Naqdazar, then modified by OGSteam
*  @link http://www.ogsteam.fr
*  @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/

//On récupère la version actuel du mod   
$query = "SELECT version FROM ".TABLE_MOD." WHERE action='xtense'";
$result = $db->sql_query($query);

list($version) = $db->sql_fetch_row($result);

if ($version == "1.0.0")
{
	//On change la version
	$query  = "UPDATE ".TABLE_MOD." SET version='1.0.1' WHERE action='xtense' LIMIT 1";
	$db->sql_query($query);
	
	$version = "1.0.1";
}

if ($version == "1.0.1")
{
	//Paramètre du debug du plugin
	$query = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('xtense_debug', '0')";
	$db->sql_query($query);

	//Paramètre de la maintenance du plugin
	$query = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('xtense_maintenance', '0')";
	$db->sql_query($query);
	
	//Puis on change la version
	$query  = "UPDATE ".TABLE_MOD." SET version='1.0.2' WHERE action='xtense' LIMIT 1";
	$db->sql_query($query);
	
	$version = "1.0.2";
}

if ($version == "1.0.2")
{	
	//Copie du fichier xtense_plugin.php à la racine d'OGSpy
    if (defined("OGSPY_INSTALLED") || defined("INSTALL_IN_PROGRESS") || defined("UPGRADE_IN_PROGRESS")) {
	    copy ("../mod/Xtense/xtense_plugin.php", "../xtense_plugin.php" );
    } else { 
	    copy ("mod/Xtense/xtense_plugin.php", "xtense_plugin.php" );
    }
	
	//Puis on change le nom dans le menu
	$query  = "UPDATE ".TABLE_MOD." SET menu='Xtense Plugin' WHERE action='xtense' LIMIT 1";
	$db->sql_query($query);
	
	//Puis on change la version
	$query  = "UPDATE ".TABLE_MOD." SET version='1.0.3' WHERE action='xtense' LIMIT 1";
	$db->sql_query($query);
	
	$version = "1.0.3";
}
if ($version == '1.0.3') {
    if (defined("OGSPY_INSTALLED") || defined("INSTALL_IN_PROGRESS") || defined("UPGRADE_IN_PROGRESS")) {
	    copy ("../mod/Xtense/xtense_plugin.php", "../xtense_plugin.php" );
    } else { 
	    copy ("mod/Xtense/xtense_plugin.php", "xtense_plugin.php" );
    }

	//Puis on change la version
	$db->sql_query("UPDATE ".TABLE_MOD." SET version='1.0.4' WHERE action='xtense' LIMIT 1");
	$version = "1.0.4";
}
if ($version == '1.0.4') {
    if (defined("OGSPY_INSTALLED") || defined("INSTALL_IN_PROGRESS") || defined("UPGRADE_IN_PROGRESS")) {
	    copy ("../mod/Xtense/xtense_plugin.php", "../xtense_plugin.php" );
    } else { 
	    copy ("mod/Xtense/xtense_plugin.php", "xtense_plugin.php" );
    }

	//Puis on change la version
	$db->sql_query("UPDATE ".TABLE_MOD." SET version='1.0.5' WHERE action='xtense' LIMIT 1");
	$version = "1.0.5";
}

if ($version == '1.0.5') {
    if (defined("OGSPY_INSTALLED") || defined("INSTALL_IN_PROGRESS") || defined("UPGRADE_IN_PROGRESS")) {
	    copy ("../mod/Xtense/xtense_plugin_inc.php", "../xtense_plugin.php" );
    } else { 
	    copy ("mod/Xtense/xtense_plugin.php", "xtense_plugin.php" );
    }

	//Puis on change la version
	$db->sql_query("UPDATE ".TABLE_MOD." SET version='1.0.6' WHERE action='xtense' LIMIT 1");
	$version = "1.0.6";
}

if ($version == '1.0.6') {
    if (defined("OGSPY_INSTALLED") || defined("INSTALL_IN_PROGRESS") || defined("UPGRADE_IN_PROGRESS")) {
	    copy ("../mod/Xtense/xtense_plugin.php", "../xtense_plugin.php" );
    } else { 
	    copy ("mod/Xtense/xtense_plugin.php", "xtense_plugin.php" );
    }

	//Puis on change la version
	$db->sql_query("UPDATE ".TABLE_MOD." SET version='1.0.7' WHERE action='xtense' LIMIT 1");
	$version = "1.0.7";
}

if ($version == '1.0.7') {
    if (defined("OGSPY_INSTALLED") || defined("INSTALL_IN_PROGRESS") || defined("UPGRADE_IN_PROGRESS")) {
	    copy ("../mod/Xtense/xtense_plugin.php", "../xtense_plugin.php" );
    } else { 
	    copy ("mod/Xtense/xtense_plugin.php", "xtense_plugin.php" );
    }

	//Puis on change la version
	$db->sql_query("UPDATE ".TABLE_MOD." SET version='1.0.8' WHERE action='xtense' LIMIT 1");
	$version = "1.0.8";
}
if ($version == '1.0.8') {
    if (defined("OGSPY_INSTALLED") || defined("INSTALL_IN_PROGRESS") || defined("UPGRADE_IN_PROGRESS")) {
	    copy ("../mod/Xtense/xtense_plugin.php", "../xtense_plugin.php" );
    } else { 
	    copy ("mod/Xtense/xtense_plugin.php", "xtense_plugin.php" );
    }

	//Puis on change la version
	$db->sql_query("UPDATE ".TABLE_MOD." SET version='1.0.9' WHERE action='xtense' LIMIT 1");
	$version = "1.0.9";
}
if ($version == '1.0.9') {
    if (defined("OGSPY_INSTALLED") || defined("INSTALL_IN_PROGRESS") || defined("UPGRADE_IN_PROGRESS")) {
	    copy ("../mod/Xtense/xtense_plugin.php", "../xtense_plugin.php" );
    } else { 
	    copy ("mod/Xtense/xtense_plugin.php", "xtense_plugin.php" );
    }

	//Puis on change la version
	$db->sql_query("UPDATE ".TABLE_MOD." SET version='1.1.0' WHERE action='xtense' LIMIT 1");
	$version = "1.1.0";
}
?>
