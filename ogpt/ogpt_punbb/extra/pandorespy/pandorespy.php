<?php



if (!defined('IN_SPYOGAME')) die("Hacking attempt");



require_once("views/page_header.php");

$query = "SELECT `active` FROM `".TABLE_MOD."` WHERE `action`='pandorespy' AND `active`='1' LIMIT 1";
if (!$db->sql_numrows($db->sql_query($query))) die("Hacking attempt");





echo'
<br><br><font color="green"><b>Module correctement installé et fonctionnel</b></font>
<br><br><br><br>
Module de visualisation des presences des joueurs pour pun_ogpt <br> par <b>Machine</b> <br> portail pun_OGPT
Version 1.0';


?>