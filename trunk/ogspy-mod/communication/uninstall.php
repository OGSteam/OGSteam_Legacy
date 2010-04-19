<?php
/**
* Desinstallation du Module
* @author ericalens <ericalens@ogsteam.fr> http://www.ogsteam.fr
* @copyright OGSteam 2006 
* @version 0.2
* @package Communication
 */

if (!defined('IN_SPYOGAME')) die('Hacking attempt');

$query = "DELETE FROM ".TABLE_CONFIG." WHERE config_name='Communication'";
$db->sql_query($query);
?>
