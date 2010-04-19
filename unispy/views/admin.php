<?php
/***************************************************************************
*	filename	: admin.php
*	desc.		:
*	Author		: Kyser - http://www.ogsteam.fr/
*	created		: 16/12/2005
*	modified	: 21/11/2006 18:00:00 by Naqdazar
***************************************************************************/

if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}

if ($user_data["user_admin"] != 1 && $user_data["user_coadmin"] != 1 && $user_data["management_user"] != 1) {
	redirection("index.php?action=message&id_message=forbidden&info");
}

require_once("views/page_header.php");
?>

<table width="100%">
<tr>
	<td>
		<table border="1">
		<tr align="center">
<?php
if (!isset($pub_subaction)) {
	if ($user_data["user_admin"] == 1 || $user_data["user_coadmin"] == 1) $pub_subaction = "infoserver";
	else $pub_subaction = "member";
}

if ($user_data["user_admin"] == 1 || $user_data["user_coadmin"] == 1) {
	if ($pub_subaction != "infoserver") {
		echo "\t\t\t"."<td class='c' width='150' onclick=\"window.location = 'index.php?action=administration&subaction=infoserver';\">";
		echo "<a style='cursor:pointer'><font color='lime'>".$LANG["admin_GeneralInfo"]."</font></a>";
		echo "</td>"."\n";
	}
	else {
		echo "\t\t\t"."<th width='150'>";
		echo "<a>".$LANG["admin_GeneralInfo"]."</a>";
		echo "</th>"."\n";
	}
}

if ($user_data["user_admin"] == 1 || $user_data["user_coadmin"] == 1) {
	if ($pub_subaction != "parameter") {
		echo "\t\t\t"."<td class='c' width='150' onclick=\"window.location = 'index.php?action=administration&subaction=parameter';\">";
		echo "<a style='cursor:pointer'><font color='lime'>".$LANG["admin_ServerParameters"]."</font></a>";
		echo "</td>"."\n";
	}
	else {
		echo "\t\t\t"."<th width='150'>";
		echo "<a>".$LANG["admin_ServerParameters"]."</a>";
		echo "</th>"."\n";
	}
}

if ($user_data["user_admin"] == 1 || $user_data["user_coadmin"] == 1 || $user_data["management_user"] == 1) {
	if ($pub_subaction != "member") {
		echo "\t\t\t"."<td class='c' width='150' onclick=\"window.location = 'index.php?action=administration&subaction=member';\">";
		echo "<a style='cursor:pointer'><font color='lime'>".$LANG["admin_UserManagement"]."</font></a>";
		echo "</td>"."\n";
	}
	else {
		echo "\t\t\t"."<th width='150'>";
		echo "<a>".$LANG["admin_UserManagement"]."<a>";
		echo "</th>"."\n";
	}
}

if ($user_data["user_admin"] == 1 || $user_data["user_coadmin"] == 1 || $user_data["management_user"] == 1) {
	if ($pub_subaction != "group") {
		echo "\t\t\t"."<td class='c' width='150' onclick=\"window.location = 'index.php?action=administration&subaction=group';\">";
		echo "<a style='cursor:pointer'><font color='lime'>".$LANG["admin_GroupManagement"]."</font></a>";
		echo "</td>"."\n";
	}
	else {
		echo "\t\t\t"."<th width='150'>";
		echo "<a>".$LANG["admin_GroupManagement"]."<a>";
		echo "</th>"."\n";
	}
}

if ($user_data["user_admin"] == 1 || $user_data["user_coadmin"] == 1) {
	if ($pub_subaction != "viewer") {
		echo "\t\t\t"."<td class='c' width='150' onclick=\"window.location = 'index.php?action=administration&subaction=viewer';\">";
		echo "<a style='cursor:pointer'><font color='lime'>".$LANG["admin_Journal"]."</font></a>";
		echo "</td>"."\n";
	}
	else {
		echo "\t\t\t"."<th width='150'>";
		echo "<a>".$LANG["admin_Journal"]."</a>";
		echo "</th>"."\n";
	}
}

if ($user_data["user_admin"] == 1 || $user_data["user_coadmin"] == 1) {
	if ($pub_subaction != "mod") {
		echo "\t\t\t"."<td class='c' width='150' onclick=\"window.location = 'index.php?action=administration&subaction=mod';\">";
		echo "<a style='cursor:pointer'><font color='lime'>".$LANG["admin_Mods"]."</font></a>";
		echo "</td>"."\n";
	}
	else {
		echo "\t\t\t"."<th width='150'>";
		echo "<a>".$LANG["admin_Mods"]."</a>";
		echo "</th>"."\n";
	}
}

//<!-- Emplacement mod / position admin /-->
if ($user_data["user_admin"] == 1 || $user_data["user_coadmin"] == 1 || $user_data["management_user"] == 1) {
   $request = "select action, menu, tooltip, dateinstall, noticeifnew from ".TABLE_MOD." where active = 1 and menupos=5 ORDER BY position asc";
   $result = $db->sql_query($request);
   if ($db->sql_numrows($result)) {


	   while ($val = $db->sql_fetch_assoc($result)) {
           if ($pub_subaction != $val['action']) {

                $menuitem = "\t\t\t"."<td class='c' width='150' onclick=\"window.location = 'index.php?action=administration&subaction=".$val['action']."';\"";
                $menutooltip = addslashes(htmlentities($val['tooltip']));
                if ($val['tooltip']!="") $menuitem .= ' onmouseover="this.T_WIDTH=210;this.T_STICKY=true;this.T_TEMP=0;return escape(\''.$menutooltip.'\');";';
                $menuitem .= ">";
                echo $menuitem."\n";

                echo "<a style='cursor:pointer'><font color='lime'>".$val['menu']."</font></a>";
                echo "</td>"."\n";
                }

        else {
		echo "\t\t\t"."<th width='150'>";
		echo "<a>".$val['menu']."</a>";
		echo "</th>"."\n";
        }
        }

   }
}


//<!-- Fin des mods /-->

?>
		</tr>
		</table>
	</td>
</tr>
<tr>
	<td>
<?php
	// ajout Naqdazar / code gestion mods pos 5
	if ($pub_subaction <> '') {
           $query = "SELECT root, link FROM ".TABLE_MOD." WHERE active = '1' AND menupos=5 AND action = '".$pub_subaction."'";
           $result = $db->sql_query($query);
           if ($db->sql_numrows($result)) {
              $val = $db->sql_fetch_assoc($result);
              require_once("mod/".$val['root']."/".$val['link']);
              exit();
           }
        }

switch ($pub_subaction) {
	case "member" :
	require_once("admin_members.php");
	break;

	case "group" :
	require_once("admin_members_group.php");
	break;

	case "infoserver" :
	require_once("admin_infoserver.php");
	break;

	case "parameter" :
	require_once("admin_parameters.php");
	break;

	case "viewer" :
	require_once("admin_viewer.php");
	break;

	case "mod" :
	require_once("admin_mod.php");
	break;

	default:
	require_once("admin_infoserver.php");
	break;
}
?>
	</td>
</tr>
</table>

<?php
require_once("views/page_tail.php");
?>
