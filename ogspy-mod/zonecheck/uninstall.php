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

$mod_uninstall_name = "zonecheck";
$mod_uninstall_table = TABLE_MOD_ZONECHECK.','.TABLE_MOD_ZONECHECK_CFG.','.TABLE_MOD_ZONECHECK_HST;
uninstall_mod ($mod_uninstall_name, $mod_uninstall_table);
?>
