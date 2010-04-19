<?php
/** $Id$ **/
/**
* Page d'administration des mods : Index et fonctions usuelles
* @package OGSpy
* @subpackage main
* @author Kyser
* @copyright Copyright &copy; 2007, http://ogsteam.fr/
* @version 4.00 ($Rev$)
* @modified $Date$
* @link $HeadURL$
*/
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

$valid_pub_show = Array('mod_list','new_modules','new_updates');
if(!isset($pub_show) || !in_array($pub_show,$valid_pub_show))
	$pub_show = 'mod_list';
if(isset($pub_make)){
	switch($pub_make){
		case 'new_install':
			if(import_module($pub_mod_root,$pub_mod_version)){
				$msg_return = L_('adminmod_NewInstall_Ok');
				$pub_directory = $pub_mod_root;
				if(mod_install())
					$msg_return .= L_('adminmod_Install_ok');
				else
					$msg_return .= L_('adminmod_Error');
			} else
				$msg_return = L_('adminmod_NewInstall_NotOk');
			break;
			
		case 'mod_install':
			if(mod_install())
				$msg_return = L_('adminmod_Install_ok');
			else
				$msg_return = L_('adminmod_Error');
			break;
			
		case 'new_update':
			if(import_module($pub_root,$pub_version)){
				$msg_return = L_('adminmod_NewUpdate_ok');
				if(mod_update())
					$msg_return .= L_('adminmod_Update_ok');
				else
					$msg_return .= L_('adminmod_Error');
			} else
				$msg_return = L_('adminmod_Error');
			break;
			
		case 'mod_update':
			if(mod_update())
				$msg_return = L_('adminmod_Update_ok');
			else
				$msg_return = L_('adminmod_Error');
			break;
			
		case 'mod_uninstall':
			mod_uninstall();
			$msg_return = L_('adminmod_Uninstall_ok');
			break;
			
		case 'mod_active':
			mod_active();
			$msg_return = L_('adminmod_Enable_ok');
			break;
			
		case 'mod_disable':
			mod_disable();
			$msg_return = L_('adminmod_Disable_ok');
			break;
			
		case 'mod_up':
			mod_sort("up");
			$msg_return = L_('adminmod_ModUp_ok');
			break;
			
		case 'mod_down':
			mod_sort("down");
			$msg_return = L_('adminmod_ModDown_ok');
			break;
			
		case 'mod_rename':
			mod_rename();
			$msg_return = L_('adminmod_ModRename_ok');
			break;
			
		case 'mod_admin_link':
			mod_change_admin_link();
			$msg_return = L_('adminmod_ModAdminLink_ok');
			break;
			
		case 'cat_rem_mod':
			cat_add_mod(0);
			$msg_return = L_('adminmod_CatRemMod_ok');
			break;

		case 'cat_up':
			cat_sort("up");
			$msg_return = L_('adminmod_CatUp_ok');
			break;

		case 'cat_down':
			cat_sort("down");
			$msg_return = L_('adminmod_CatDown_ok');
			break;

		case 'cat_remove':
			cat_remove();
			$msg_return = L_('adminmod_CatRemove_ok');
			break;

		case 'cat_add_mod':
			cat_add_mod();
			$msg_return = L_('adminmod_CatAddMod_ok');
			break;

		case 'cat_rename':
			cat_rename();
			$msg_return = L_('adminmod_CatRename_ok');
			break;

		case 'cat_create':
			cat_create();
			$msg_return = L_('adminmod_CatCreate_ok');
			break;
	}
}

// On créé le template basique
if (file_exists($user_data['user_skin'].'\templates\admin_mod.tpl'))
{
    $tpl = new template($user_data['user_skin'].'\templates\admin_mod.tpl');
}
elseif (file_exists($server_config['default_skin'].'\templates\admin_mod.tpl'))
{
    $tpl = new template($server_config['default_skin'].'\templates\admin_mod.tpl');
}
else
{
    $tpl = new template('admin_mod.tpl');
}
$tpl->SimpleVar(Array(
	'msg_return' => isset($msg_return)?$msg_return:'&nbsp;',
	'adminmod_Manage_Modules'=>L_('adminmod_Manage_Modules'),
	'modules_list'=>L_('adminmod_Modules_List'),
	'Search_new_module'=>L_('adminmod_Search_new_module'),
));

// Affichage du Template
$tpl->parse();

switch($pub_show){
	case 'mod_list' : require 'views/admin_mod_list.php'; break;
	case 'new_modules' : require 'views/admin_mod_new.php'; break;
}
?>
