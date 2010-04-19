<?php
/***************************************************************************
*	filename	: admin_members.php
*	desc.		:
*	Author		: Kyser - http://ogs.servebbs.net/
*	created		: 16/12/2005
*	modified	: 30/07/2006 00:00:00
***************************************************************************/

if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}

if ($user_data["user_admin"] != 1 && $user_data["user_coadmin"] != 1 && $user_data["management_user"] != 1) {
	redirection("index.php?action=message&id_message=forbidden&info");
}

$user_info = user_get();
?>
<table>
<tr>
	<td class="c" width="120">Joueur</td>
	<td class="c" width="120">Inscrit le</td>
	<td class="c" width="120">Compte actif</td>
<?php
if ($user_data["user_admin"] == 1) {?>
	<td class="c" width="120">Co-administrateur</td></td>
<?php }
if ($user_data["user_admin"] == 1 || $user_data["user_coadmin"] == 1) {?>
	<td class="c" width="120">Gestion des membres&nbsp;<?php echo help("admin_member_manager");?></td>
<?php }?>
	<td class="c" width="120">Gestion des classements&nbsp;<?php echo help("admin_ranking_manager");?></td>
	<td class="c" width="120">Dernière connexion</td>
	<td class="c" colspan="3">&nbsp;</td>
</tr>
<?php
foreach ($user_info as $v) {
	$user_id = $v["user_id"];
	if (($v["user_admin"] == 1) ||
	($user_data["user_coadmin"] == 1 && $v["user_coadmin"] == 1) ||
	(($user_data["user_coadmin"] != 1 && $user_data["management_user"] == 1) && ($v["user_coadmin"] == 1 || $v["management_user"] == 1))) {
		continue;
	}

	$YesNo = array("<font color=\"red\">Non</font>", "<font color=\"lime\">Oui</font>");
	$user_auth = user_get_auth($user_id);

	$auth = "<table>";
	$auth .= "<tr><td class=\"c\" colspan=\"2\">Droits sur le serveur</td></tr>";
	$auth .= "<tr><th>Ajout de systèmes solaires</th><th>".$YesNo[$user_auth["server_set_system"]]."</th></tr>";
	$auth .= "<tr><th>Ajout de rapports d\'espionnages</th><th>".$YesNo[$user_auth["server_set_spy"]]."</th></tr>";
	$auth .= "<tr><th>Ajout de classements</th><th>".$YesNo[$user_auth["server_set_ranking"]]."</th></tr>";
	$auth .= "<tr><th>Affichage des positions protégées</th><th>".$YesNo[$user_auth["server_show_positionhided"]]."</th></tr>";
	$auth .= "<tr><td colspan=\"2\">&nbsp;</th></tr>";

	$auth .= "<tr><td class=\"c\" colspan=\"2\">Droits clients externes</td></tr>";
	$auth .= "<tr><th>Connexion au serveur</th><th>".$YesNo[$user_auth["ogs_connection"]]."</th></tr>";
	$auth .= "<tr><th>Importation de systèmes solaires</th><th>".$YesNo[$user_auth["ogs_set_system"]]."</th></tr>";
	$auth .= "<tr><th>Exportation de systèmes solaires</th><th>".$YesNo[$user_auth["ogs_get_system"]]."</th></tr>";
	$auth .= "<tr><th>Importation de rapports d\'espionnages</th><th>".$YesNo[$user_auth["ogs_set_spy"]]."</th></tr>";
	$auth .= "<tr><th>Exportation de rapports d\'espionnages</th><th>".$YesNo[$user_auth["ogs_get_spy"]]."</th></tr>";
	$auth .= "<tr><th>Importation de classements</th><th>".$YesNo[$user_auth["ogs_set_ranking"]]."</th></tr>";
	$auth .= "<tr><th>Exportation de classements</th><th>".$YesNo[$user_auth["ogs_get_ranking"]]."</th></tr>";
	$auth .= "</table>";

	$auth = htmlentities($auth);

	$name = $v["username"];

	$reg_date =  strftime("%d %b %Y %H:%M", $v["user_regdate"]);

	$active_off = !$v["user_active"] ? " selected" : "";
	$user_coadmin_off = !$v["user_coadmin"] ? " selected" : "";
	$management_user_off = !$v["management_user"] ? " selected" : "";
	$management_ranking_off = !$v["management_ranking"] ? " selected" : "";
	
	if ($v["user_lastvisit"] != 0) {
		$last_visit =  strftime("%d %b %Y %H:%M", $v["user_lastvisit"]);
	}
	else {
		$last_visit = "--";
	}

	echo "<tr>"."\n";

	echo "<form method='POST' action='index.php?action=admin_modify_member&user_id=".$user_id."'>"."\n";
	echo "\t"."<th><a onmouseover=\"this.T_WIDTH=260;this.T_TEMP=15000;return escape('".$auth."')\">".$name."</a></th>"."\n";
	echo "\t"."<th>".$reg_date."</th>"."\n";
	echo "\t"."<th><select name='active'><option value='1'>Oui</option><option value='0'$active_off>Non</option></select></th>"."\n";
	if ($user_data["user_admin"] == 1) {
		echo "\t"."<th><select name='user_coadmin'><option value='1'>Oui</option><option value='0'$user_coadmin_off>Non</option></select></th>"."\n";
	}
	if ($user_data["user_admin"] == 1 || $user_data["user_coadmin"] == 1) {
		echo "\t"."<th><select name='management_user'><option value='1'>Oui</option><option value='0'$management_user_off>Non</option></select></th>"."\n";
	}
		echo "\t"."<th><select name='management_ranking'><option value='1'>Oui</option><option value='0'$management_ranking_off>Non</option></select></th>"."\n";
		echo "\t"."<th>".$last_visit."</th>"."\n";
	echo "\t"."<th><input type='image' src='images/usercheck.png' title='Valider les paramètres de ".$name."'></th>"."\n";
	echo "</form>"."\n";

	echo "</tr>"."\n";
}
?>
</table>