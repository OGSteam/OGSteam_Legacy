<?php
/***************************************************************************
*	filename	: about.php
*	desc.		:
*	Author		: Kyser - http://www.ogsteam.fr/
*	created		: 17/01/2006
*	modified	: 30/07/2006 00:00:00
***************************************************************************/

if (!defined('IN_SPYOGAME')) {
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
if (!isset($pub_subaction)) $subaction = "ogsteam";
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