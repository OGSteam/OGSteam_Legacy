<?php
/**
 * update.php 
 * @package Guerres
 * @author Verité
 * @link http://www.ogsteam.fr
 * @version 0.2f
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/

//L'appel direct est interdit
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

//il y a juste à mettre à jour le version du mod
$query  = "UPDATE ".TABLE_MOD." SET version='0.2f' WHERE action='guerres' LIMIT 1";
$db->sql_query($query);


?>
