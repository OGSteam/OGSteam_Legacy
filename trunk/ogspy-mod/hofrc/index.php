<?php
/**
 * index.php 
 * @package HofRC
 * @author Shad
 * @link http://www.ogsteam.fr
 * @version : 0.0.1
 */
	
	if (!defined ('IN_SPYOGAME'))		die("Hacking attempt");
	if (!isset ($table_prefix))		global $table_prefix;
	if (!isset ($icon_display))		global $icon_display;
		
	$query = "SELECT `active` FROM `".TABLE_MOD."` WHERE `action`='hofrc' AND `active`='1' LIMIT 1";
	if (!$db->sql_numrows($db->sql_query($query)))
		die("Hacking attempt");
		
	if (!isset($pub_subaction)) $pub_subaction = "convert";
	if ($pub_subaction !== "preview" && $pub_subaction !== "temp")
		{
		require_once("views/page_header.php");
		require_once('mod/hofrc/Pages/include.php');
	?>
	<table width="100%">
<tr  align="center">
	<td>
		<table>
		<tr align="center">
<?php



if ($pub_subaction != "convert") {
	echo "\t\t\t"."<td class='c' width='150' onclick=\"window.location = 'index.php?action=hofrc&subaction=convert';\">";
	echo "<a style='cursor:pointer'><font color='lime'>Conversion d'un HOF</font></a>";
	echo "</td>";
}
else {
	echo "\t\t\t"."<th width='150'>";
	echo "<a>Conversion d'un HOF</a>";
	echo "</th>";
}

if ($pub_subaction != "gestion") {
	echo "\t\t\t"."<td class='c' width='150' onclick=\"window.location = 'index.php?action=hofrc&subaction=gestion';\">";
	echo "<a style='cursor:pointer'><font color='lime'>Gestion des HOF</font></a>";
	echo "</td>";
}
else {
	echo "\t\t\t"."<th width='150'>";
	echo "<a>Gestion des HOF</a>";
	echo "</th>";
}

// if ($pub_subaction != "rp") {
	// echo "\t\t\t"."<td class='c' width='150' onclick=\"window.location = 'index.php?action=hofrc&subaction=rp';\">";
	// echo "<a style='cursor:pointer'><font color='lime'>Rôle Play</font></a>";
	// echo "</td>";
// }
// else {
	// echo "\t\t\t"."<th width='150'>";
	// echo "<a>Rôle Play</a>";
	// echo "</th>";
// }

if ($pub_subaction != "admin") {
	echo "\t\t\t"."<td class='c' width='150' onclick=\"window.location = 'index.php?action=hofrc&subaction=admin';\">";
	echo "<a style='cursor:pointer'><font color='lime'>Administration</font></a>";
	echo "</td>";
}
else {
	echo "\t\t\t"."<th width='150'>";
	echo "<a>Administration</a>";
	echo "</th>";
}

if ($pub_subaction != "changelog") {
	echo "\t\t\t"."<td class='c' width='150' onclick=\"window.location = 'index.php?action=hofrc&subaction=changelog';\">";
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
}
switch ($pub_subaction) {
	case "convert" :
	require_once("Pages/convert.php");
	break;
	
	case "preview" :
	require_once("Pages/preview.php");
	break;

	case "gestion" :
	require_once("Pages/gestion.php");
	break;

	// case "rp" :
	// require_once("Pages/rp.php");
	// break;
	
	case "admin" :
	require_once("Pages/admin.php");
	break;
	
	case "publier" :
	require_once("Pages/publier.php");
	break;
	
	case "changelog" :
	require_once("Pages/changelog.php");
	break;

	default:
	require_once("Pages/convert.php");
	break;
}
?>
	</td>
</tr>
</table>
<br><br><br>
<?php
if (!isset($pub_subaction)) $pub_subaction = "convert";
	if ($pub_subaction !== "preview" && $pub_subaction !== "temp")
		{
		require_once("views/page_header.php");
		require_once('mod/hofrc/Pages/include.php');
		
		page_footer();
		}
require_once("views/page_tail.php");
?>