<?php
/**
* update.php du mod REFinder
* @package REFinder
* @version 0.4
*/

require_once("common.php");

global $db;

$query="UPDATE ".TABLE_MOD." SET version='0.4' where root='REFinder'";
$db->sql_query($query);
?>
