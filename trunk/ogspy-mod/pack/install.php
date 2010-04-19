<?php
/**
* install.php
* @package <nom du mod>
* @author <votre pseudo>
* @version 1.0
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
* @description Fichier d'installation du mod
*/
if ( ! defined ( 'IN_SPYOGAME' ) ) die ( 'Hacking attempt' );


if ( isset ( $pub_directory ) )
{
  if ( file_exists ( 'mod/' . $pub_directory . '/version.txt' ) )
    $chemin_du_script = $pub_directory;
    
}
elseif ( isset ( $pub_action ) )
{
  if ( file_exists ( 'mod/' . $pub_action . '/version.txt' ) )
    $chemin_du_script = $pub_action;
}
else
{
  if ( isset ( $_SERVER['PHP_SELF'] ) && file_exists ( 'mod/' . substr ( $_SERVER['PHP_SELF'], 0, strrpos ( '/', $_SERVER['PHP_SELF'] ) ) . '/version.txt' ) )
    $chemin_du_script = substr ( $_SERVER['PHP_SELF'], 0, strrpos ( '/', $_SERVER['PHP_SELF'] ) );
  elseif ( isset ( $PHP_SELF ) && file_exists ( 'mod/' . substr ( $PHP_SELF, 0, strrpos ( '/', $PHP_SELF ) ) . '/version.txt' ) )
    $chemin_du_script = substr ( $PHP_SELF, 0, strrpos ( '/', $PHP_SELF ) );
}
include_once ( 'mod/' . $chemin_du_script . '/include.php' );

$query = 'CREATE TABLE IF NOT EXISTS `' . TABLE_MOD_PCP . '` (
  <ici votre description sql de la table principale du mod>
);';
$db->sql_query ( $query );

$query = 'CREATE TABLE IF NOT EXISTS `' . TABLE_MOD_PARAM . '` (
  <ici votre description sql de la table de configuration du mod>
);';
$db->sql_query ( $query );

$query = 'INSERT INTO ' . TABLE_MOD . ' (id, title, menu, action, root, link, version, active) VALUES (\'\', 
  \'' . NOM_MOD . '\', \'' . NOM_MOD . '\', \'' . $chemin_du_script . '\', \'' . $chemin_du_script . '\', 
  \'index.php\', \'' . VERSION_MOD . '\', \'1\')';
$db->sql_query($query);
?>