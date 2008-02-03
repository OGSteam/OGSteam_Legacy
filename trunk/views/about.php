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
if (!isset($pub_subaction)) $subaction = "spacsteam";
else $subaction = $pub_subaction;

if ($subaction != "ogsteam") {
	echo "\t\t\t"."<td class='c' width='150' onclick=\"window.location = 'index.php?action=about&subaction=ogsteam';\">";
	echo "<a style='cursor:pointer'><font color='lime'>OGS Team</font></a>";
	echo "</td>";
}
else {
	echo "\t\t\t"."<th width='150'>";
	echo "<a>OGS Team</a>";
	echo "</th>";
}

if ($subaction != "changelog") {
	echo "\t\t\t"."<td class='c' width='150' onclick=\"window.location = 'index.php?action=about&subaction=changelog';\">";
	echo "<a style='cursor:pointer'><font color='lime'>Changelog</font></a>";
	echo "</td>";
}
else {
	echo "\t\t\t"."<th width='150'>";
	echo "<a>Changelog</a>";
	echo "</th>";
}
?>
		</tr>
		</table>
	</td>
</tr>
<tr>
	<td>
<?php
switch ($subaction) {
	case "ogsteam" :
	require_once("about_ogsteam.php");
	break;
	
	case "changelog" :
	require_once("about_changelog.php");
	break;
}
?>
	</td>
</tr>
</table>
<?php
require_once("views/page_tail.php");
?>
