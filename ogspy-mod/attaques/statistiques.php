<?php
/**
 * archives.php 
 * @package Attaques
 * @author Verit� modifi� par ericc
 * @link http://www.ogsteam.fr
 * @version : 0.8a
 */

 //L'appel direct est interdit
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

//On v�rifie que le mod est activ�
$query = "SELECT `active` FROM `".TABLE_MOD."` WHERE `action`='attaques' AND `active`='1' LIMIT 1";
if (!$db->sql_numrows($db->sql_query($query))) die("Hacking attempt");

//D�finitions
global $db, $table_prefix, $prefixe;

echo"<fieldset><legend><b><font color='#0080FF'>Rentabilit� Hebdomadaire</font></b></legend>";
echo "<img src='index.php?action=attaques&graphic=week' alt='pas de graphique disponible' />";
echo"</fieldset>";

echo"<br />";

echo"<fieldset><legend><b><font color='#0080FF'>Rentabilit� Mensuelle</font></b></legend>";
echo "<img src='index.php?action=attaques&graphic=mois' alt='pas de graphique disponible' />";
echo"</fieldset>";

?>