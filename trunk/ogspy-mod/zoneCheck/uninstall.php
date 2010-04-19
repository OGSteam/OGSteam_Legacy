<?php
/*
* uninstall.php
* @mod ZoneCheck
* @author Gorn
* @fileversion 2.4
*
* 0 = pas de changement
* 1 = status
* 2 = lune
* 4 = alliance
* 8 = nom
* 16 = planète
* 32 = colonisation
*/

if ( !defined ( 'IN_SPYOGAME' ) )
    die ( 'Hacking attempt' );

global $db, $table_prefix;
define ( 'TABLE_MOD_ZONECHECK', $table_prefix . 'ZoneCheck' );
define ( 'TABLE_MOD_ZONECHECK_CFG', $table_prefix . 'ZoneCheck_config' );
define ( 'TABLE_MOD_ZONECHECK_HST', $table_prefix . 'ZoneCheck_histo' );

$query = 'DROP TABLE IF EXISTS `' . TABLE_MOD_ZONECHECK . '`';
$db->sql_query ( $query );

$query = 'DROP TABLE IF EXISTS `' . TABLE_MOD_ZONECHECK_CFG . '`';
$db->sql_query ( $query );

$query = 'DROP TABLE IF EXISTS `' . TABLE_MOD_ZONECHECK_HST . '`';
$db->sql_query ( $query );

$query = 'DELETE FROM ' . TABLE_MOD . ' WHERE action = \'ZoneCheck\'';
$db->sql_query($query);
?>
