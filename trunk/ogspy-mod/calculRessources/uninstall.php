<?php
/**
* uninstall.php
* @package CalculRessources
* @author varius9
* @version 1.0c
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
* @description Fichier de désinstallation du mod
*/
if (!defined('IN_SPYOGAME')) die ('Hacking attempt');

global $db, $table_prefix;
define("TABLE_CALCULRESS_USER", $table_prefix."mod_calculress");
define("TABLE_CALCUL_BESOIN", $table_prefix."mod_calculbesoin");
define("TABLE_XTENSE_CALLBACKS", $table_prefix."xtense_callbacks");

if (isset($pub_directory)){
  if (file_exists ('mod/' . $pub_directory . '/version.txt'))
    $chemin_du_script = $pub_directory;}
elseif (isset($pub_action)){
  if ( file_exists ( 'mod/' . $pub_action . '/version.txt' ) )
    $chemin_du_script = $pub_action;}
else {
  if ( isset ( $_SERVER['PHP_SELF'] ) && file_exists ( 'mod/' . substr ( $_SERVER['PHP_SELF'], 0, strrpos ( '/', $_SERVER['PHP_SELF'] ) ) . '/version.txt' ) )
    $chemin_du_script = substr ( $_SERVER['PHP_SELF'], 0, strrpos ( '/', $_SERVER['PHP_SELF'] ) );
  elseif ( isset ( $PHP_SELF ) && file_exists ( 'mod/' . substr ( $PHP_SELF, 0, strrpos ( '/', $PHP_SELF ) ) . '/version.txt' ) )
    $chemin_du_script = substr ( $PHP_SELF, 0, strrpos ( '/', $PHP_SELF ) );}

include_once ( 'mod/' . $chemin_du_script . '/include.php' );

// On récupère l'id du mod pour xtense...
$query = "SELECT id FROM ".TABLE_MOD." WHERE action='CalculRessources'";
$result = $db->sql_query($query);
list($mod_id) = $db->sql_fetch_row($result);

$query="DROP TABLE IF EXISTS ".TABLE_CALCULRESS_USER;
$db->sql_query($query);

$query="DROP TABLE IF EXISTS ".TABLE_CALCUL_BESOIN;
$db->sql_query($query);

$query = 'DELETE FROM ' . TABLE_MOD . ' WHERE action = \'' . $chemin_du_script . '\'';
$db->sql_query($query);

// On regarde si la table xtense_callbacks existe :
$query = 'show tables from '.$db->dbname.' like "'.TABLE_XTENSE_CALLBACKS.'" ';
$result = $db->sql_query($query);
if($db->sql_numrows($result) != 0)
{	//Le mod xtense 2 est installé !
	//Maintenant on regarde s'il est dedans normalement oui mais on est jamais trop prudent...
	$query = 'Select * From '.TABLE_XTENSE_CALLBACKS.' where mod_id = '.$mod_id.' ';
	$result = $db->sql_query($query);
	if($db->sql_numrows($result) != 0)	{ // Il est  dedans alors on l'enlève :
		$query = 'DELETE FROM '.TABLE_XTENSE_CALLBACKS.' where mod_id = '.$mod_id.' ';
		$db->sql_query($query);
		echo("<script> alert('La compatibilité du mod eXchange avec le mod Xtense2 a été désinstallée !') </script>");}
}


?>