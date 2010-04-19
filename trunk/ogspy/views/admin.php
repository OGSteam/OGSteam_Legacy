<?php
/** $Id$ **/
/**
* Page générale de l'administration
* @package OGSpy
* @subpackage main
* @author Kyser
* @copyright Copyright &copy; 2007, http://ogsteam.fr/
* @version 4.00 ($Rev$)
* @modified $Date$
* @link $HeadURL$
*/
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

// Verification des droits admins
if ($user_data["user_admin"] != 1 && $user_data["user_coadmin"] != 1 && $user_data["management_user"] != 1) {
	redirection("?action=message&amp;id_message=forbidden&info");
}

if(!isset($pub_ajax)) require_once("views/page_header.php");
require_once("includes/admin.php");

// Creation des templates
if (file_exists($user_data['user_skin'].'\templates\admin_header.tpl'))
{
    $tpl_header = new template($user_data['user_skin'].'\templates\admin_header.tpl');
}
elseif (file_exists($server_config['default_skin'].'\templates\admin_header.tpl'))
{
    $tpl_header = new template($server_config['default_skin'].'\templates\admin_header.tpl');
}
else
{
    $tpl_header = new template('admin_header.tpl');
}

if (file_exists($user_data['user_skin'].'\templates\admin_footer.tpl'))
{
    $tpl_footer = new template($user_data['user_skin'].'\templates\admin_footer.tpl');
}
elseif (file_exists($server_config['default_skin'].'\templates\admin_footer.tpl'))
{
    $tpl_footer = new template($server_config['default_skin'].'\templates\admin_footer.tpl');
}
else
{
    $tpl_footer = new template('admin_footer.tpl');
}

// Verifications des droits
$tpl_header->checkIf('not_admin', ($user_data["user_admin"] != 1 && $user_data["user_coadmin"] != 1));

// Options des menus
$menu_item = Array(
	'infoserver' => L_("admin_GeneralInfo"),
	'parameters' => L_("admin_ServerParameters"),
	'affichage' => L_("admin_ViewParameters"),
	'members' => L_("admin_UserManagement"),
	'members_group' => L_("admin_GroupManagement"),
	'mod' => L_("admin_Mods"),
	'viewer' => L_("admin_Journal")
);

// Test de la validité de subaction
$pub_subaction = (isset($pub_subaction)&&in_array($pub_subaction,array_keys($menu_item)))?$pub_subaction:(($user_data["user_admin"] == 1 || $user_data["user_coadmin"] == 1) ? "infoserver" : "members");

// Listing des menus
foreach($menu_item as $menu_action => $menu_title)
	$tpl_header->loopVar('MENU', Array(
				'title' => $menu_title,
				'subaction' => $menu_action,
				'this_one' => ($pub_subaction==$menu_action),
				'user_manage' => (($menu_title == 'members' || $menu_title == 'group'))
	));

// Affiche de l'en-tête de la page
if(!isset($pub_ajax)) $tpl_header->parse();

// Affichage du contenu de la page en fonction de l'onglet sélectionné
require_once(translated("admin_{$pub_subaction}.php"));

// Affichage du footer de la page Home.
if(!isset($pub_ajax)) $tpl_footer->parse();

// Footer OGSpy
if(!isset($pub_ajax)) require_once("views/page_tail.php");
?>
