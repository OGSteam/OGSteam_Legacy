<?php
/** $Id:$ **/
/**
* Panneau d'affichage About
* @package SpacSpy
* @version 0.1b ($Rev:$)
* @subpackage views
* @author Kyser
* @created 17/01/2006
* @copyright Copyright &copy; 2007, http://ogsteam.fr/
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
* @modified $Date$
* @link $HeadURL$
*/

if (!defined('IN_SPACSPY')) {
	die("Hacking attempt");
}

require_once("views/page_header.php");
?>
<table width="100%">
<tr>
	<td>
		<table>
		<tr align="center">
<?php
if (!isset($pub_subaction)) $subaction = "simple";
else $subaction = $pub_subaction;

if ($subaction != "simple") {
	echo "\t\t\t"."<td class='c' width='150' onclick=\"window.location = 'index.php?action=search&subaction=simple';\">";
	echo "<a style='cursor:pointer'><font color='lime'>Simple</font></a>";
	echo "</td>";
}
else {
	echo "\t\t\t"."<th width='150'>";
	echo "<a>Simple</a>";
	echo "</th>";
}

/*
if ($subaction != "advenced") {
	echo "\t\t\t"."<td class='c' width='150' onclick=\"window.location = 'index.php?action=search&subaction=advenced';\">";
	echo "<a style='cursor:pointer'><font color='lime'>Avancé</font></a>";
	echo "</td>";
}
else {
	echo "\t\t\t"."<th width='150'>";
	echo "<a>Avancé</a>";
	echo "</th>";
}
*/
?>
		</tr>
		</table>
<?php
switch ($subaction) {
	case "simple" :
	require_once("search_simple.php");
	break;
	
	/*case "advenced" :
	require_once("search_advenced.php");
	break;
	*/
	
	default:
	require_once("search_simple.php");
	break;
}
?>
	</td>
</tr>
</table>
<?php
require_once("views/page_tail.php");
?>
