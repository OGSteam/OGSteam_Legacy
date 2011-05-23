<?php
/*
* update.php
* @mod ZoneCheck
* @author Gorn
* @fileversion 2.5
*
* 0 = pas de changement
* 1 = status
* 2 = lune
* 4 = alliance
* 8 = nom
* 16 = planète
* 32 = colonisation
*/

if ( ! defined ( 'IN_SPYOGAME' ) )
    die ( 'Hacking attempt' );

// Constantes / Variables globales
global $db, $table_prefix;
define ( 'TABLE_MOD_ZONECHECK_HST', $table_prefix . 'ZoneCheck_histo' );
?>
<script language="javascript">alert ( '<?php print mod_version ?>');</script>
<?php
switch ( mod_version() )
{
  case '2.5':
  case '2.5a':
  case '2.5b':
  case '2.5c':
    $query = 'TRUNCATE ' . TABLE_MOD_ZONECHECK_HST;
    $db->sql_query ( $query );
    $query = 'ALTER TABLE ' . TABLE_MOD_ZONECHECK_HST . ' DROP PRIMARY KEY';
    $db->sql_query ( $query );
    $query = 'ALTER TABLE ' . TABLE_MOD_ZONECHECK_HST . ' CHANGE oldname oldname VARCHAR(50)';
    $db->sql_query ( $query );
    $query = 'ALTER TABLE ' . TABLE_MOD_ZONECHECK_HST . ' CHANGE newname newname VARCHAR(50)';
    $db->sql_query ( $query );
    $query = 'ALTER TABLE ' . TABLE_MOD_ZONECHECK_HST . ' ADD coordinates VARCHAR(9) NOT NULL';
    $db->sql_query ( $query );
    $query = 'ALTER TABLE ' . TABLE_MOD_ZONECHECK_HST . ' ADD ally VARCHAR(50) NOT NULL';
    $db->sql_query ( $query );
    $query = 'ALTER TABLE ' . TABLE_MOD_ZONECHECK_HST . ' ADD PRIMARY KEY ( oldname , newname )';
    $db->sql_query ( $query );
    $query = 'ALTER TABLE ' . TABLE_MOD_ZONECHECK_HST . ' ADD INDEX ( coordinates )';
    $db->sql_query ( $query );
    if ( defined ( 'TABLE_MOD_CFG' ) )
    {
      $query = 'INSERT IGNORE INTO ' . TABLE_MOD_CFG ' VALUES ( "ZoneCheck", "nb_system", (SELECT nb_system FROM ' . TABLE_MOD_ZONECHECK_CFG . ') ), 
        ( "ZoneCheck", "block", (SELECT block FROM ' . TABLE_MOD_ZONECHECK_CFG . ') ), 
        ( "ZoneCheck", "moon", (SELECT moon FROM ' . TABLE_MOD_ZONECHECK_CFG . ') ), 
        ( "ZoneCheck", "deco", (SELECT deco FROM ' . TABLE_MOD_ZONECHECK_CFG . ') ), 
        ( "ZoneCheck", "vac", (SELECT vac FROM ' . TABLE_MOD_ZONECHECK_CFG . ') ), 
        ( "ZoneCheck", "inactif", (SELECT inactif FROM ' . TABLE_MOD_ZONECHECK_CFG . ') ), 
        ( "ZoneCheck", "unstatus", (SELECT unstatus FROM ' . TABLE_MOD_ZONECHECK_CFG . ') ), 
        ( "ZoneCheck", "colo", (SELECT colo FROM ' . TABLE_MOD_ZONECHECK_CFG . ') ), 
        ( "ZoneCheck", "less", (SELECT less FROM ' . TABLE_MOD_ZONECHECK_CFG . ') ), 
        ( "ZoneCheck", "middle", (SELECT middle FROM ' . TABLE_MOD_ZONECHECK_CFG . ') ), 
        ( "ZoneCheck", "more", (SELECT more FROM ' . TABLE_MOD_ZONECHECK_CFG . ') ), 
        ( "ZoneCheck", "outofdate", (SELECT outofdate FROM ' . TABLE_MOD_ZONECHECK_CFG . ') ), 
        ( "ZoneCheck", "affichage", (SELECT affichage FROM ' . TABLE_MOD_ZONECHECK_CFG . ') )';
      $db->sql_query ( $query );
      $db->sql_query ( 'DROP TABLE ' . TABLE_MOD_ZONECHECK_CFG );
    }
    break;
  default:
    $query = 'CREATE TABLE IF NOT EXISTS ' . TABLE_MOD_ZONECHECK_HST . ' (
      coordinates varchar(9) NOT NULL default "",
      oldname varchar(50) NOT NULL default "",
      newname varchar(50) NOT NULL default "",
      ally varchar(50) NOT NULL default "",
      type enum("P","A") NOT NULL default "P",
      date int(11) NOT NULL default "0",
      PRIMARY KEY  (oldname,newname),
      KEY coordinates (coordinates))';
    $db->sql_query ( $query );
    break;
}

$query = 'UPDATE ' . TABLE_MOD . ' SET version="2.6" WHERE action="ZoneCheck"';
$db->sql_query ( $query );
?>