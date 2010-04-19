<?php
/** $Id$ **/
/**
* Page d'administration des groupes
* @package OGSpy
* @subpackage main
* @author Kyser
* @copyright Copyright &copy; 2007, http://ogsteam.fr/
* @version 4.00 ($Rev$)
* @modified $Date$
* @link $HeadURL$
*/
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

user_check_auth("usergroup_manage");

$usergroup_list = usergroup_list();

foreach ($usergroup_list as $value) {
	$group_list[] = '"'.$value['group_name'].'"';
	$group_id[] = '"'.$value['group_id'].'"';
}

$group_list = implode(',', $group_list);
$group_id = implode(',', $group_id);

$mods_list = mod_list();
$mod_list = Array();
$mod_id = Array();

$cats_list = cat_list();
$mod_to_skip = Array();
foreach($cats_list["actived"] as $value){
	if($value['title']!="Admin"){
		$mod_list[] = '"'.$value['title'].'"';
		$mod_id[] = '"-'.$value['id'].'"';
	}
}

foreach ($mods_list['actived'] as $value) {
	$mod_list[] = '"'.$value['title'].'"';
	$mod_id[] = '"'.$value['id'].'"';
}
foreach ($mods_list['disabled'] as $value) {
	$mod_list[] = '"'.$value['title'].'"';
	$mod_id[] = '"'.$value['id'].'"';
}
$mod_list = implode(',',$mod_list);
$mod_id = implode(',',$mod_id);


$user_list = user_get();
$user_names = array();
$user_id = array();

foreach($user_list as $key => $value) {
	$user_id[] = '"'.$value['user_id'].'"';
	$user_names[] = '"'.$value['user_name'].'"';
}

$user_id = implode(',', $user_id);
$user_names = implode(',', $user_names);

if (file_exists($user_data['user_skin'].'\templates\admin_members_group.tpl'))
{
    $tpl = new template($user_data['user_skin'].'\templates\admin_members_group.tpl');
}
elseif (file_exists($server_config['default_skin'].'\templates\admin_members_group.tpl'))
{
    $tpl = new template($server_config['default_skin'].'\templates\admin_members_group.tpl');
}
else
{
    $tpl = new template('admin_members_group.tpl');
}
$tpl->SimpleVar(Array(
	'java_group_list' => $group_list,
	'java_group_id' => $group_id,
	'java_mod_list' => $mod_list,
	'java_mod_id' => $mod_id,
	'java_user_names' => $user_names,
	'java_user_id' => $user_id,
	'admingroup_Informations' => addslashes(L_("admingroup_Informations")),
	'admingroup_GroupCreate' => addslashes(L_("admingroup_GroupCreate")),
	'admingroup_GroupName' => addslashes(L_("admingroup_GroupName")),
	'admingroup_Create' => addslashes(L_("admingroup_Create")),
	'admingroup_Cancel' => addslashes(L_("admingroup_Cancel")),
	'admingroup_Group' => addslashes(L_("admingroup_Group")),
	'admingroup_GroupCreate' => addslashes(L_("admingroup_GroupCreate")),
	'admingroup_MemberList' => addslashes(L_("admingroup_MemberList")),
	'admingroup_AddToGroup' => addslashes(L_("admingroup_AddToGroup")),
	'admingroup_NoMemberToAdd' => addslashes(L_("admingroup_NoMemberToAdd")),
	'admingroup_ModsList' => addslashes(L_("admingroup_ModsList")),
	'admingroup_RestrictGroup' => addslashes(L_("admingroup_RestrictGroup")),
	'admingroup_NoModsToRestrict' => addslashes(L_("admingroup_NoModsToRestrict")),
	'admingroup_GroupSelected' => addslashes(L_("admingroup_GroupSelected")),
	'admingroup_GroupRename' => addslashes(L_("admingroup_GroupRename")),
	'admingroup_Rename' => addslashes(L_("admingroup_Rename")),
	'admingroup_DeleteGroup' => addslashes(L_("admingroup_DeleteGroup")),
	'admingroup_DeleteGroupConf' => addslashes(L_("admingroup_DeleteGroupConf")),
	'admingroup_Permissions' => addslashes(L_("admingroup_Permissions")),
	'admin_ServerRights' => addslashes(L_("admin_ServerRights")),
	'admin_AddSolarSystem' => addslashes(L_("admin_AddSolarSystem")),
	'admin_AddSpyReport' => addslashes(L_("admin_AddSpyReport")),
	'admin_AddCombatReport' => addslashes(L_("admin_AddCombatReport")),
	'admin_AddRanking' => addslashes(L_("admin_AddRanking")),
	'admin_ViewHiddenPosition' => addslashes(L_("admin_ViewHiddenPosition")),
	'admin_ExternalClientRights' => addslashes(L_("admin_ExternalClientRights")),
	'admin_ServerConnection' => addslashes(L_("admin_ServerConnection")),
	'admin_ImportSolarSystem' => addslashes(L_("admin_ImportSolarSystem")),
	'admin_ExportSolarSystem' => addslashes(L_("admin_ExportSolarSystem")),
	'admin_ImportSpyReport' => addslashes(L_("admin_ImportSpyReport")),
	'admin_ExportSpyReport' => addslashes(L_("admin_ExportSpyReport")),
	'admin_ImportRanking' => addslashes(L_("admin_ImportRanking")),
	'admin_ExportRanking' => addslashes(L_("admin_ExportRanking")),
	'admingroup_ValidatePermissions' => addslashes(L_("admingroup_ValidatePermissions")),
	'admingroup_NoMembers' => addslashes(L_('admingroup_NoMembers')),
	'admingroup_GroupNameChanged' => addslashes(L_('admingroup_GroupNameChanged')),
	'admingroup_GroupDeleted' => addslashes(L_('admingroup_GroupDeleted')),
	'admingroup_GroupCreated' => addslashes(L_('admingroup_GroupCreated')),
	'admingroup_MemberAdded' => addslashes(L_('admingroup_MemberAdded')),
	'admingroup_MemberRemoved' => addslashes(L_('admingroup_MemberRemoved')),
	'admingroup_PermsChanged' => addslashes(L_('admingroup_PermsChanged')),
	'admingroup_Error' => addslashes(L_('admingroup_Error')),
	'admingroup_GroupAlreadyExist' => addslashes(L_('admingroup_GroupAlreadyExist')),
	'admingroup_FatalError' => addslashes(L_('admingroup_FatalError')),
	'admingroup_InvaldGroupName' => addslashes(L_('admingroup_InvaldGroupName')),
	'admingroup_CanDeleteThisGroup' => addslashes(L_('admingroup_CanDeleteThisGroup')),
	'admingroup_ModAdded' => addslashes(L_('admingroup_ModAdded')),
	'admingroup_ModRemoved' => addslashes(L_('admingroup_ModRemoved')),
	'admingroup_NoMods' => addslashes(L_('admingroup_NoMods'))
));

//make_ajax_script(false,'info','retour');

$tpl->parse();

?>
