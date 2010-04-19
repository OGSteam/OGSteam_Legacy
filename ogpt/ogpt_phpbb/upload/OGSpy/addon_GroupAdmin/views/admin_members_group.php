<?php
/***************************************************************************
*	filename	: admin_members_group.php
*	desc.		:
*	Author		: Kyser - http://www.ogsteam.fr/
*	created		: 16/12/2005
*	modified	: 23/11/2006 00:00:00
***************************************************************************/

if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}

if ($user_data["user_admin"] != 1 && $user_data["user_coadmin"] != 1 && $user_data["management_user"] != 1) {
	redirection("index.php?action=message&id_message=forbidden&info");
}

$usergroup_list = usergroup_list();

foreach ($usergroup_list as $value) {
	$group_list[] = '"'.$value['group_name'].'"';
	$group_id[] = '"'.$value['group_id'].'"';
}

$group_list = implode(',', $group_list);
$group_id = implode(',', $group_id);

$user_list = user_get();
$user_names = array();
$user_id = array();

foreach($user_list as $key => $value) {
	$user_id[] = '"'.$value['user_id'].'"';
	$user_names[] = '"'.$value['username'].'"';
}

$user_id = implode(',', $user_id);
$user_names = implode(',', $user_names);

?>


<script language="javascript" type="text/javascript" src="js/admin_group.js"></script>
<script language="javascript" type="text/javascript">
var group_list = new Array(<?php echo $group_list; ?>);
var group_id = new Array(<?php echo $group_id; ?>);
var user_names = new Array(<?php echo $user_names; ?>);
var user_id = new Array(<?php echo $user_id; ?>);
</script>
<table width="100%">
	<tr>
		<td width="450">
		
		<form method="POST" name="form" onsubmit="create_group(); return false;" style="margin:0px;">
			<table width="450">
				<tr>
					<td class="c" colspan="3">Création d'un groupe</td>
				</tr>
				<tr>
					<th width="33%" height="25">Nom du groupe</th>
					<th width="33%"><input name="group_name" type="text" maxlength="15" size="20"></th>
					<th><input type="button" onclick="create_group();" value="Creer"></th>
				</tr>
			</table>
			</form>
			
		</td>
		<td valign="top">
		
			<table width="100%" align="left">
				<tr>
					<td class="c" colspan="3">Informations</td>
				</tr>
				<tr>
					<th height="25"><span id="info" style="display:block; text-align:left; pargin:0px; padding:0px; font-weight:bold;">&nbsp;</span></th>
				</tr>
			</table>
			
		</td>
	</tr>
	<tr>
		<td valign="top">
		
			<table width="450">
				<tr>
					<td class="c">Groupes</td>
				</tr>
				<tr>
					<th style="text-align:left;"><span id="group_list"></span></th>
				</tr>
			</table>
			<script language="javascript" type="text/javascript">parse_groups();</script>
			
			<span id="group_infos_block" style="display:none;">
			<table width="450">
				<tr>
					<td class="c">Groupe selectionne: <span id="group_name3"></span></td>
				</tr>
				<tr>
					<th>Renommer le groupe: <input type="text" id="new_name" size="20" maxlength="15" value="" /> <input type="button" value="Valider" onclick="group_rename();" /></th>
				</tr>
				<tr>
					<th>
					<span id="del_group1"><a href="javascript:void(0);" onclick="hide('del_group1'); display('del_group2');">Supprimer le groupe</a></span>
					<span id="del_group2" style="display:none;"><a href="javascript:void(0);" onclick="group_delete();" style="color:#FF9900;">Cliquez ici pour supprimer definitivement le groupe</span>
					</th>
				</tr>
			</table>
			</span>
			
		</td>
		<td valign="top">
			
			<span id="group_auth_block" style="display:none;">
			<table width="100%">
				<tr>
					<td class="c" colspan="2">Permission du groupe <span id="group_name1"></span></td>
				</tr>
				<tr>
					<th width="50%" valign="top">
						<!-- Table des droits du server -->
						<table width="100%">
							<tr>
								<td class="c">Droits sur le serveur</td>
								<td class="c">-</td>
							</tr>
							<tr>
								<th>Ajout/Mise à jour système solaire</th>
								<th><input id="server_set_system" type="checkbox" value="1"></th>
							</tr>
							<tr>
								<th>Ajout rapport espionnage</th>
								<th><input id="server_set_spy" type="checkbox" value="1"></th>
							</tr>
							<tr>
								<th>Ajout classement</th>
								<th><input id="server_set_ranking" type="checkbox" value="1"></th>
							</tr>
							<tr>
								<th>Visualiser coordonnées alliances protégées  	</th>
								<th><input id="server_show_positionhided" type="checkbox" value="1"></th>
							</tr>
						</table>
						<!-- END -->
					</th>
					<th width="50%" valign="top">
						<!-- Table des droits OGS -->
						<table width="100%">
							<tr>
								<td class="c">Droit clients externes (OGame Stratège)</td>
								<td class="c">-</td>
							</tr>
							<tr>
								<th>Connexion serveur</th>
								<th><input id="ogs_connection" type="checkbox" value="1"></th>
							</tr>
							<tr>
								<th>Importation système solaire</th>
								<th><input id="ogs_set_system" type="checkbox" value="1"></th>
							</tr>
							<tr>
								<th>Exportation système solaire</th>
								<th><input id="ogs_get_system" type="checkbox" value="1"></th>
							</tr>
							<tr>
								<th>Importation rapport espionnage</th>
								<th><input id="ogs_set_spy" type="checkbox" value="1"></th>
							</tr>
							<tr>
								<th>Exportation rapport espionnage</th>
								<th><input id="ogs_get_spy" type="checkbox" value="1"></th>
							</tr>
							<tr>
								<th>Importation classement</th>
								<th><input id="ogs_set_ranking" type="checkbox" value="1"></th>
							</tr>
							<tr>
								<th>Exportation classement</th>
								<th><input id="ogs_get_ranking" type="checkbox" value="1"></th>
							</tr>
						</table>
						<!-- END -->
					</th>
				</tr>
				<tr>
					<th colspan="2"><input type="button" onclick="set_auth();" value="Valider" /></th>
				</tr>
			</table>
			</span>
			
			<span id="group_members_block" style="display:none;">
			<table width="100%">
				<tr>
					<td class="c">Membres du groupe <span id="group_name2"><span></td>
				</tr>
				<tr>
					<th id="group_members"></th>
				</tr>
				<tr>
					<th>Ajouter un membre: <select id="user" style="width:130px;"></select> <input type="button" value="Valider" onclick="add_member();" /></th>
				</tr>
			</table>
			</span>
			
		</td>
	</tr>
	<tr>
		<td align="center"><strong>Addon GroupAdmin créé par Unibozu - Version 0.1</strong></td>
	</tr>
</table>