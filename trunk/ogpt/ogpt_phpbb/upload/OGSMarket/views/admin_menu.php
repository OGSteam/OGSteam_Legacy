<?php
/***************************************************************************
*	filename	: admin_menu.php
*	desc.		: 
*	Author		: Kyser - http://ogs.servebbs.net/
*	created		: 16/12/2005
*	modified	: 30/07/2006 00:00:00
***************************************************************************/

if (!defined('IN_OGSMARKET')) {
	die("Hacking attempt");
}

if ($user_data["is_admin"] != 1) {
	redirection("index.php?action=message&id_message=forbidden&info");
}

require_once("views/page_header.php");
?>

<table width="90%">
<th>Administration</th>
<tr>
	<td>
		<table align="center" border="1">
		<tr align="center">
<?php
if ($user_data["is_admin"] == 1) {
	if ($pub_subaction != "admin") {
		echo "\t\t\t"."<td class='c' width='150' onclick=\"window.location = 'index.php?action=admin';\">";
		echo "<a style='cursor:pointer'><font color='lime'>Administration Générale</font></a>";
		echo "</td>"."\n";
	}
	else {
		echo "\t\t\t"."<th width='150'>";
		echo "<a>Administration Générale</a>";
		echo "</th>"."\n";
	}
}

if ($user_data["is_admin"] == 1) {
	if ($pub_subaction != "admin_trade") {
		echo "\t\t\t"."<td class='c' width='150' onclick=\"window.location = 'index.php?action=admin_trade';\">";
		echo "<a style='cursor:pointer'><font color='lime'>Administration Commerciale</font></a>";
		echo "</td>"."\n";
	}
	else {
		echo "\t\t\t"."<th width='150'>";
		echo "<a>Administration commerciale</a>";
		echo "</th>"."\n";
	}
}

if ($user_data["is_admin"] == 1) {
	if ($pub_subaction != "admin_uni") {
		echo "\t\t\t"."<td class='c' width='150' onclick=\"window.location = 'index.php?action=admin_uni';\">";
		echo "<a style='cursor:pointer'><font color='lime'>Administration des univers</font></a>";
		echo "</td>"."\n";
	}
	else {
		echo "\t\t\t"."<th width='150'>";
		echo "<a>Administration des univers</a>";
		echo "</th>"."\n";
	}
}

if ($user_data["is_admin"] == 1) {
	if ($pub_subaction != "admin_members") {
		echo "\t\t\t"."<td class='c' width='150' onclick=\"window.location = 'index.php?action=admin_members';\">";
		echo "<a style='cursor:pointer'><font color='lime'>Administration des Membres</font></a>";
		echo "</td>"."\n";
	}
	else {
		echo "\t\t\t"."<th width='150'>";
		echo "<a>Administration des Membres</a>";
		echo "</th>"."\n";
	}
}

if ($user_data["is_admin"] == 1) {
	if ($pub_subaction != "debug") {
		echo "\t\t\t"."<td class='c' width='150' onclick=\"window.location = 'index.php?action=debug';\">";
		echo "<a style='cursor:pointer'><font color='lime'>Débug</font></a>";
		echo "</td>"."\n";
	}
	else {
		echo "\t\t\t"."<th width='150'>";
		echo "<a>Débug</a>";
		echo "</th>"."\n";
	}
}

?>
		</tr>
		</table>
	</td>
</tr>
</tr>