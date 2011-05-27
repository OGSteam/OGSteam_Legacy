<?php
/**
* Desinstallation du module
* @package varAlly
* @author Aeris
* @link http://ogsteam.fr
 */
if (!defined('IN_SPYOGAME')) die('Hacking attempt'); 
include('./parameters/id.php');
global $db,$table_prefix;

$mod_uninstall_name = "nom du mode";
$mod_uninstall_table = $table_prefix.'varAlly';
uninstall_mod($mod_uninstall_name,$mod_uninstall_table);


$queries = array();
$queries[] = 'DELETE FROM `'.TABLE_CONFIG.'` WHERE `config_name`=\'nbrjoueur\'';
$queries[] = 'DELETE FROM `'.TABLE_CONFIG.'` WHERE `config_name`=\'tagAlly\'';
$queries[] = 'DELETE FROM `'.TABLE_CONFIG.'` WHERE `config_name`=\'tagAllySpy\'';
$queries[] = 'DELETE FROM `'.TABLE_CONFIG.'` WHERE `config_name`=\'bilAlly\'';
$queries[] = 'DELETE FROM `'.TABLE_CONFIG.'` WHERE `config_name`=\'tblAlly\'';

$queries[] = 'DELETE FROM `'.TABLE_MOD.'` WHERE  `title`=  \'varAlly\'';
$queries[] = 'DELETE FROM `'.TABLE_CONFIG.'` WHERE `config_name`=\'tagAlly\' 
											 OR `config_name`=\'tagAllySpy\' 
											 OR `config_name`=\'tblAlly\'
											 OR `config_name`=\'bilAlly\'';
foreach ($queries as $query) {
	$db->sql_query($query);
}
?>
