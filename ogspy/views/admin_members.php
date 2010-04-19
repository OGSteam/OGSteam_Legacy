<?php
/** $Id$ **/
/**
* Page d'administration des membres
* @package OGSpy
* @subpackage main
* @author Kyser
* @copyright Copyright &copy; 2007, http://ogsteam.fr/
* @version 4.00 ($Rev$)
* @modified $Date$
* @link $HeadURL$
*/
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

if ($user_data["user_admin"] != 1 && $user_data["user_coadmin"] != 1 && $user_data["management_user"] != 1) {
	redirection("?action=message&amp;id_message=forbidden&info");
}
// Si c'est un appel AJAX, alors il faut afficher la liste ---> renvoi vers la fonction
if(isset($pub_postaction)&&($pub_postaction == 'admin_modify_member')) admin_user_set();

// Ce n'est pas un appel Ajax, donc on créé le template de la page admin/members
if (file_exists($user_data['user_skin'].'\templates\admin_members.tpl'))
{
    $tpl = new template($user_data['user_skin'].'\templates\admin_members.tpl');
}
elseif (file_exists($server_config['default_skin'].'\templates\admin_members.tpl'))
{
    $tpl = new template($server_config['default_skin'].'\templates\admin_members.tpl');
}
else
{
    $tpl = new template('admin_members.tpl');
}

// récupération de la liste des groupes (pour créer le formulaire de création d'un nouveau compte)
$usergroup_list = usergroup_get();
foreach ($usergroup_list as $value)
	$tpl->loopVar('group_list',Array(
		'value' => $value["group_id"],
		'text' => $value["group_name"]
	));

// Traitement des conditions (l'affichge différe selon que l'utilisateur est admin, coadmin, ou simlpe gestionnaire de membres
$tpl->CheckIf('is_admin',($user_data["user_admin"] == 1));
$tpl->CheckIf('is_admin_or_co',($user_data["user_admin"] == 1 || $user_data["user_coadmin"] == 1));

// Affichage de la liste des joueurs
global $user_data,$pub_asc,$pub_desc,$db,$tpl_global_defined,$tpl;
	
// Définition de l'ordre de tri
$order = 'user_name';
if(isset($pub_asc)) $order = $pub_asc;
if(isset($pub_desc)) $order = $pub_desc." desc";
	
// Définition des icones des accès (avec tooltip) et des images Oui - Non
$blank_pic = '<img src="images/action_blank.png" alt="" />';
$admin_pic = '<img src="images/medal_gold_1.png" alt="'.L_('admin_InfoAccessAdmin').'" />';
$coadmin_pic = '<img src="images/medal_silver_1.png" alt="'.L_('admin_InfoAccessCoAdmin').'" />';
$ranking_man_pic = '<img src="images/shape_align_bottom.png" alt="'.L_('admin_InfoAccessRankingMan').'" />';
$members_man_pic = '<img src="images/group_edit.png" alt="'.L_('admin_InfoAccessMembersMan').'" />';
$active_pic = '<img src="images/b.gif" alt="'.L_('admin_ActiveAccount').'" />';
$inactive_pic = '<img src="images/c.gif" alt="'.L_('admin_InActiveAccount').'" />';
$YesNo = array("<font color=\"red\">".L_("basic_No")."</font>", "<font color=\"lime\">".L_("basic_Yes")."</font>");

//Statistiques participation des membres actifs (utilisé pour calculer le ratio)
$request = "select sum(planet_added_web + planet_added_ogs), sum(spy_added_web + spy_added_ogs), sum(rank_added_web + rank_added_ogs), sum(search) from ".TABLE_USER;
$result = $db->sql_query($request);
list($planetimport, $spyimport, $rankimport, $search) = $db->sql_fetch_row($result);
if ($planetimport == 0) $planetimport = 1;
if ($spyimport == 0) $spyimport = 1;
if ($rankimport == 0) $rankimport = 1;
if ($search == 0) $search = 1;

// Récupération des informations des membres
$user_info = user_get(false, $order);
	
// Pour tous les membres.....
foreach ($user_info as $v) {
	
	// L'utilisateur peut-il voir cette ligne ?
	if (($user_data["user_admin"] != 1 && $v["user_admin"] == 1) ||
	($user_data["user_admin"] != 1 && $user_data["user_coadmin"] == 1 && $v["user_coadmin"] == 1) ||
	($user_data["user_admin"] != 1 && ($user_data["user_coadmin"] != 1 && $user_data["management_user"] == 1) && ($v["user_coadmin"] == 1 || $v["management_user"] == 1))) {
		// Non, alors on continue et on passe à la ligne suivante (le joueur suivant)
		continue;
	}
	
	// Il y aura au moins une ligne dans le tableau, dans ce cas, on peut valider son affichage (sinon, le tableau n'apparait pas)
	$tpl->CheckIf('show_list',true);

	// Récupération des accès du membre
	$user_auth = user_get_auth($v["user_id"]);
		// Formatage du tableau affichant les accès 
	if ($user_auth["mod_names"]!=""){ 
		// Si des modules sont interdits : on les affiche
		$auth = $tpl_global_defined->GetDefined('admin_user_detail.mod_list',Array(
			'mod_names' => $user_auth["mod_names"]));
	}else $auth = '';
		$auth = TipFormat($tpl_global_defined->GetDefined('admin_user_detail',Array(
			'title' => L_('admin_MembersAccess',"<b>".$v['user_name']."</b>"),
			'mod_list' => $auth,
			'YesNo_server_set_system' => $YesNo[$user_auth["server_set_system"]],
			'YesNo_server_set_spy' =>  $YesNo[$user_auth["server_set_spy"]],
			'YesNo_server_set_ranking' =>  $YesNo[$user_auth["server_set_ranking"]],
			'YesNo_server_show_positionhided' => $YesNo[$user_auth["server_show_positionhided"]],
			'YesNo_ogs_connection' => $YesNo[$user_auth["ogs_connection"]],
			'YesNo_ogs_set_system' => $YesNo[$user_auth["ogs_set_system"]],
			'YesNo_ogs_get_system' => $YesNo[$user_auth["ogs_get_system"]],
			'YesNo_ogs_set_spy' => $YesNo[$user_auth["ogs_set_spy"]],
			'YesNo_ogs_get_spy' => $YesNo[$user_auth["ogs_get_spy"]],
			'YesNo_ogs_set_ranking' => $YesNo[$user_auth["ogs_set_ranking"]],
				'YesNo_ogs_get_ranking' => $YesNo[$user_auth["ogs_get_ranking"]],
		)));
	
	
	// Formatage de la date de dernière visite, si elle est définie ou pas, : il faut obligatoirement afficher une date pour le triage
	$last_visit =  strftime("%d/%m/%Y - %H:%M", $v["user_lastvisit"]);
	
	// Récupération du ratio
	list($ratio,$color) = get_ratio($v,$planetimport,$spyimport,$rankimport,$search);
	
	// Récupération de la liste des groupes dans lequel est le membre
	$request = "select group_name from ".TABLE_GROUP." a,".TABLE_USER_GROUP." b where a.group_id=b.group_id AND b.user_id=".$v['user_id']." order by group_name";
	$result = $db->sql_query($request);
	$group_list = Array();
	while (list($row) = $db->sql_fetch_row($result))
		$group_list[] = $row;
	$groups = implode(', ',$group_list);
	
	// Enregsitrement de la ligne dans le template
	$tpl->loopVar('users',Array(
		'id' => $v["user_id"],
		'auth' => $auth,
		'active_pic' => $v['user_active']?$active_pic:$inactive_pic,
		'admin_pic' => $v['user_admin']?$admin_pic:($v['user_coadmin']?$coadmin_pic:$blank_pic),
		'ranking_man_pic' => $v['management_ranking']?$ranking_man_pic:$blank_pic,
		'members_man_pic' => $v['management_user']?$members_man_pic:$blank_pic,
		'name' => $v["user_name"],
		'reg_date' => strftime("%d/%m/%Y - %H:%M", $v["user_regdate"]), 
		'groups' => $groups,
		'ratio' => round($ratio),
		'last_visit' => $last_visit,
		'last_visit_visibility' => ($v["user_lastvisit"] != 0)?'visible':'hidden',	// Cacher si pas de date
		'admin_ModifParameters' => L_('admin_ModifParameters',$v['user_name']),
		'admin_DeleteUser' => L_('admin_DeleteUser',$v["user_name"]),
		'admin_ConfirmDelete' => L_("admin_ConfirmDelete",$v["user_name"]),
		'admin_PasswordChange' => L_('admin_PasswordChange',$v["user_name"]),
		'admin_ConfirmPasswordChange' => L_('admin_ConfirmPasswordChange',$v["user_name"]),
		'is_active' => $v['user_active']?'1':'0',
		'is_coadmin' => $v['user_coadmin']?'1':'0',
		'is_rankman' => $v['management_ranking']?'1':'0',
		'is_userman' => $v['management_user']?'1':'0',
	));
}
$access_help = '<table>';
$access_help .= '<tr><td>'.$admin_pic.'</td><th>'.L_('admin_InfoAccessAdmin').'</th></tr>';
$access_help .= '<tr><td>'.$coadmin_pic.'</td><th>'.L_('admin_InfoAccessCoAdmin').'</th></tr>';
$access_help .= '<tr><td>'.$members_man_pic.'</td><th>'.L_('admin_InfoAccessMembersMan').'</th></tr>';
$access_help .= '<tr><td>'.$ranking_man_pic.'</td><th>'.L_('admin_InfoAccessRankingMan').'</th></tr>';
$access_help .= '</table>';

// Enregistrement des variables simple
$tpl->SimpleVar(Array(
	'admin_CreateNewAccount' => L_("admin_CreateNewAccount")."&nbsp;".help("admin_member_manager"),
	'admin_MembersManagement' => L_("admin_MembersManagement")."&nbsp;".help('admin_member_manager'),
	'admin_RankingManagement' => L_("admin_RankingManagement")."&nbsp;".help('admin_ranking_manager'),
	'admin_Group' => L_("admin_Group"),
	'admin_Ok' => L_("basic_Ok"),
	'admin_Cancel' => L_("basic_Cancel"),
	'access_Help' => help(NULL, $access_help),
	'active_header' => help(NULL,$active_pic.': '.L_('admin_ActiveAccount').'<br />'.$inactive_pic.': '.L_('admin_InActiveAccount')),
	'order_asc' => isset($pub_asc)?$pub_asc:'',
	'order_desc' => isset($pub_desc)?$pub_desc:'',
	'Player_link' => "sort_list('user_name','".($order=='user_name'?'desc':'asc')."');",
	'RegDate_link' => "sort_list('user_regdate','".($order=='user_regdate'?'desc':'asc')."');",
	'LastCo_link' => "sort_list('user_lastvisit','".($order=='user_lastvisit'?'desc':'asc')."');",
));
	
// Controle des conditions
$tpl->CheckIf('is_admin',($user_data["user_admin"] == 1));
$tpl->CheckIf('is_admin_or_co',($user_data["user_admin"] == 1 || $user_data["user_coadmin"] == 1));

// Envoi du template.
$tpl->parse();

?>
