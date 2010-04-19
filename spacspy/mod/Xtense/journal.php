<?php
/**
* journal.php
* @package Xtense
*  @author Naqdazar, then modified by OGSteam
*  @link http://www.ogsteam.fr
*  @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/

if (!defined('IN_SPACSPY')) die("Hacking attempt");

//Définitions
global $db;

//On vérifie que le mod est activé
$query = "SELECT `active` FROM `".TABLE_MOD."` WHERE `action`='xtense' AND `active`='1' LIMIT 1";
if (!$db->sql_numrows($db->sql_query($query))) die("Hacking attempt");

if ($user_data["user_admin"] == 1  || $user_data["user_coadmin"] == 1)
{
	$file = "Xtense_debug/xtense_plugin.txt";
	if (file_exists($file)) $log = file($file);
	
	echo"<br><br>";
	echo"<table width='100%'>";
	echo"<tr>";
	echo"<td class='l' colspan='3'><font color='red'>Journal de debug Xtense</b></font></i><br>";
	
	if( (isset($log)) && ($log != "") )
	{
		while ($line = current($log)) 
		{
			$line = trim(nl2br(htmlspecialchars($line)));
			$line = preg_replace("#/\*(.*)\*/#", "<font color='orange'>$1 : </font>", $line);
			
			echo $line;
			next($log);
		}
	}
	else echo"Aucun journal de debug n'est disponible";

	echo"</td>";
	echo"</tr>";
	echo"</table>";
}
?>