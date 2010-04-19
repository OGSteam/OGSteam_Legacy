<?php
/** $Id:$ **/
/**
* Fonctions d'administrations 
* @package SpacSpy
* @version 0.1b ($Rev:$)
* @subpackage admin
* @author Kyser
* @created 16/12/2005
* @copyright Copyright &copy; 2007, http://spacsteam.fr/
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
* @modified $Date$
* @link $HeadURL$
*/

if (!defined('IN_SPACSPY')) {
	die("Hacking attempt");
}
// Verification des droits admins
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
		echo "<a style='cursor:pointer'><font color='lime'>Informations générales</font></a>";
		echo "</td>"."\n";
	}
	else {
		echo "\t\t\t"."<th width='150'>";
		echo "<a>Informations générales</a>";
		echo "</th>"."\n";
	}
}

if ($user_data["user_admin"] == 1 || $user_data["user_coadmin"] == 1) {
	if ($pub_subaction != "parameter") {
		echo "\t\t\t"."<td class='c' width='150' onclick=\"window.location = 'index.php?action=administration&subaction=parameter';\">";
		echo "<a style='cursor:pointer'><font color='lime'>Paramètres du serveur</font></a>";
		echo "</td>"."\n";
	}
	else {
		echo "\t\t\t"."<th width='150'>";
		echo "<a>Paramètres du serveur</a>";
		echo "</th>"."\n";
	}
}

if ($user_data["user_admin"] == 1 || $user_data["user_coadmin"] == 1) {
	if ($pub_subaction != "affichage") {
		echo "\t\t\t"."<td class='c' width='150' onclick=\"window.location = 'index.php?action=administration&subaction=affichage';\">";
		echo "<a style='cursor:pointer'><font color='lime'>Paramètres d'affichage</font></a>";
		echo "</td>"."\n";
	}
	else {
		echo "\t\t\t"."<th width='150'>";
		echo "<a>Paramètres d'affichage</a>";
		echo "</th>"."\n";
	}
}

if ($user_data["user_admin"] == 1 || $user_data["user_coadmin"] == 1 || $user_data["management_user"] == 1) {
	if ($pub_subaction != "member") {
		echo "\t\t\t"."<td class='c' width='150' onclick=\"window.location = 'index.php?action=administration&subaction=member';\">";
		echo "<a style='cursor:pointer'><font color='lime'>Gestion des membres</font></a>";
		echo "</td>"."\n";
	}
	else {
		echo "\t\t\t"."<th width='150'>";
		echo "<a>Gestion des membres<a>";
		echo "</th>"."\n";
	}
}

if ($user_data["user_admin"] == 1 || $user_data["user_coadmin"] == 1 || $user_data["management_user"] == 1) {
	if ($pub_subaction != "group") {
		echo "\t\t\t"."<td class='c' width='150' onclick=\"window.location = 'index.php?action=administration&subaction=group';\">";
		echo "<a style='cursor:pointer'><font color='lime'>Gestion des groupes</font></a>";
		echo "</td>"."\n";
	}
	else {
		echo "\t\t\t"."<th width='150'>";
		echo "<a>Gestion des groupes<a>";
		echo "</th>"."\n";
	}
}

if ($user_data["user_admin"] == 1 || $user_data["user_coadmin"] == 1) {
	if ($pub_subaction != "viewer") {
		echo "\t\t\t"."<td class='c' width='150' onclick=\"window.location = 'index.php?action=administration&subaction=viewer';\">";
		echo "<a style='cursor:pointer'><font color='lime'>Journal</font></a>";
		echo "</td>"."\n";
	}
	else {
		echo "\t\t\t"."<th width='150'>";
		echo "<a>Journal</a>";
		echo "</th>"."\n";
	}
}

if ($user_data["user_admin"] == 1 || $user_data["user_coadmin"] == 1) {
	if ($pub_subaction != "mod") {
		echo "\t\t\t"."<td class='c' width='150' onclick=\"window.location = 'index.php?action=administration&subaction=mod';\">";
		echo "<a style='cursor:pointer'><font color='lime'>Mods</font></a>";
		echo "</td>"."\n";
	}
	else {
		echo "\t\t\t"."<th width='150'>";
		echo "<a>Mods</a>";
		echo "</th>"."\n";
	}
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
	case "member" :
	require_once("admin_members.php");
	break;

	case "group" :
	require_once("admin_members_group.php");
	break;

	case "parameter" :
	require_once("admin_parameters.php");
	break;

	case "affichage" :
	require_once("admin_affichage.php");
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
