<?php
/***************************************************************************
*	filename	: ranking.php
*	desc.		:
*	Author		: Kyser - http://www.ogsteam.fr/
*	created		: 06/05/2006
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
if (!isset($pub_subaction)) $subaction = "player";
else $subaction = $pub_subaction;

if ($subaction != "player") {
	echo "\t\t\t"."<td class='c' width='150' onclick=\"window.location = 'index.php?action=ranking&subaction=player';\">";
	echo "<a style='cursor:pointer'><font color='lime'>".$LANG["univers_Players"]."</font></a>";
	echo "</td>";
}
else {
	echo "\t\t\t"."<th width='150'>";
	echo "<a>".$LANG["univers_Players"]."</a>";
	echo "</th>";
}

if ($subaction != "ally") {
	echo "\t\t\t"."<td class='c' width='150' onclick=\"window.location = 'index.php?action=ranking&subaction=ally';\">";
	echo "<a style='cursor:pointer'><font color='lime'>".$LANG["univers_Allys"]."</font></a>";
	echo "</td>";
}
else {
	echo "\t\t\t"."<th width='150'>";
	echo "<a>".$LANG["univers_Allys"]."</a>";
	echo "</th>";
}
?>
		</tr>
		</table>
	</td>
</tr>
<tr>
	<td align="center">
<?php
switch ($subaction) {
	case "player" :
	require_once("ranking_player.php");
	break;

	case "ally" :
	require_once("ranking_ally.php");
	break;
}
?>
	</td>
</tr>
</table>

<?php
require_once("views/page_tail.php");
?>