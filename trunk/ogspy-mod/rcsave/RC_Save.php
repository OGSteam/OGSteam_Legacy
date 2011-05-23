<?php
/***************************************************************************
*	filename	: RC_Save.php
*	Author	: ben.12
*         Mod OGSpy: RC Save
***************************************************************************/

/**************************************************************************
*	Ce mod gère les permission d'acces grace aux groupe d'ogpy.
*	Pour cela créé un groupe nomé "RC_Save" et ajoutez y les utilisateur devants avoir acces a ce mod.
*	SI AUCUN GROUPE N'EST CREE, TOUS LES MEMBRES ONT ACCES.
***************************************************************************/

if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}

$query = "SELECT `active` FROM `".TABLE_MOD."` WHERE `action`='rc_save' AND `active`='1' LIMIT 1";
if (!$db->sql_numrows($db->sql_query($query))) die("Hacking attempt");

if($user_data["user_admin"] != 1 && $user_data["user_coadmin"] != 1) {
	$request = "SELECT group_id FROM ".TABLE_GROUP." WHERE group_name='RC_Save'";
	$result = $db->sql_query($request);
	
	if(list($group_id) = $db->sql_fetch_row($result)) {
		$request = "SELECT COUNT(*) FROM ".TABLE_USER_GROUP." WHERE group_id=".$group_id." AND user_id=".$user_data['user_id'];
		$result = $db->sql_query($request);
		list($row) = $db->sql_fetch_row($result);
		if($row == 0) redirection("index.php?action=message&id_message=forbidden&info");
	}
}

define("TABLE_RC_SAVE", $table_prefix."rc_save");

$help["RC_save_view"] = "Les <font color='lime'>50 derniers RC</font> partagés.";

require_once("views/page_header.php");
?>

<table width="100%">
<tr>
	<td>
		<table width="100%">
		<tr align="center">
<?php
if (!isset($pub_subaction)) $pub_subaction = "add";

if ($pub_subaction != "add") {
	echo "\t\t\t"."<td class='c' width='150' onclick=\"window.location = 'index.php?action=rc_save&subaction=add';\">";
	echo "<a style='cursor:pointer'><font color='lime'>Ajout/Modification/Suppression de RC</font></a>";
	echo "</td>";
}
else {
	echo "\t\t\t"."<th width='150'>";
	echo "<a>Ajout/Modification/Suppression de RC</a>";
	echo "</th>";
}

if ($pub_subaction != "view") {
	echo "\t\t\t"."<td class='c' width='150' onclick=\"window.location = 'index.php?action=rc_save&subaction=view';\">";
	echo "<a style='cursor:pointer'><font color='lime'>Voir les RC partagés&nbsp;".help("RC_save_view")."</font></a>";
	echo "</td>";
}
else {
	echo "\t\t\t"."<th width='150'>";
	echo "<a>Voir les RC partagés&nbsp;".help("RC_save_view")."</a>";
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
	switch ($pub_subaction) {
		case "add" :
		require_once("mod/RC_save/RC_Save_Add.php");
		break;

		case "view" :
		require_once("mod/RC_save/RC_Save_View.php");
		break;

		default:
		require_once("mod/RC_save/RC_Save_Add.php");
		break;
	}
?>
	</td>
</tr>
</table>

<?php
require_once("views/page_tail.php");
?>