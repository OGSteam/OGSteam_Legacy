<?php
/** $Id$ **/
/**
* 
* @package OGSpy
* @subpackage main
* @author Kyser
* @copyright Copyright &copy; 2007, http://ogsteam.fr/
* @version 4.00 ($Rev$)
* @modified $Date$
* @link $HeadURL$
*/
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

$disable_ip_check = ( isset ( $user_data["disable_ip_check"] ) && $user_data["disable_ip_check"] == 1 ) ? "checked" : "";
$off_amiral = ( isset ( $user_data["off_amiral"] ) && $user_data["off_amiral"] == 1 ) ? "checked" : "";
$off_ingenieur = ( isset ( $user_data["off_ingenieur"] ) && $user_data["off_ingenieur"] == 1 ) ? "checked" : "";
$off_geologue = ( isset ( $user_data["off_geologue"] ) && $user_data["off_geologue"] == 1 ) ? "checked" : "";
$off_technocrate = ( isset ( $user_data["off_technocrate"] ) && $user_data["off_technocrate"] == 1 ) ? "checked" : "";

require_once("views/page_header.php");

// Creation du template
if (file_exists($user_data['user_skin'].'\templates\profile.tpl'))
{
    $tpl = new template($user_data['user_skin'].'\templates\profile.tpl');
}
elseif (file_exists($server_config['default_skin'].'\templates\profile.tpl'))
{
    $tpl = new template($server_config['default_skin'].'\templates\profile.tpl');
}
else
{
    $tpl = new template('profile.tpl');
}

// Verifications de l'enregistrement
$tpl->checkIf('is_register', $server_config['enable_register_view'] == 1);

// Creation des galaxys
for($i = 1; $i <= $server_config['num_of_galaxies']; $i++){
	if ($i == $user_data['user_galaxy']) $selected = " selected='selected'";
	else  $selected = "";
	$galaxy[] = Array("galaxy" => $i, "selected" => $selected);
}
foreach ($galaxy as $galaxys)
	$tpl->loopVar('galaxy_list', $galaxys);

//Creation des systems
for($i = 1; $i <= $server_config['num_of_systems']; $i++){
	if ($i == $user_data["user_system"]) $selected = " selected='selected'";
	else  $selected = "";
	$system[] = Array("system" => $i, "selected" => $selected);
}
foreach ($system as $systems)
	$tpl->loopVar('system_list', $systems);

//Creation des planettes
for($i = 1; $i <= 15; $i++){
	if ($i == $user_data["user_row"]) $selected = " selected='selected'";
	else  $selected = "";
	$row[] = Array("row" => $i, "selected" => $selected);
}
foreach ($row as $rows)
	$tpl->loopVar('row_list', $rows);

// Simples variables texte
$tpl->simpleVar(Array(
	'ENTER_NEW_PASSWORD' => L_("profile_EnterNewPass"),
	'ENTER_OLD_PASSWORD' => L_("profile_EnterOldPass"),
	'ERROR_PASSWORD_VERIF' => L_("profile_ErrorPassVerif"),
	'ERROR_PASSWORD_LENGTH' => L_("profile_ErrorLength"),
	'GENERAL_INFO' => L_("profile_GeneralInfo"),
	'USER_NAME' => $user_data["user_name"],
	'LOGIN' => L_("profile_login")."&nbsp;".help("profile_login"),
	'OLD_PASSWORD' => L_("profile_Oldpass"),
	'NEW_PASSWORD' => L_("profile_Newpass")."&nbsp;".help("profile_password"),
	'NEW_PASSWORD_VERIF' => L_("profile_Newpassconf"),
	'LANGUE' => L_("profile_ChooseLang"),
	'LANGUE_LIST' => make_lang_list($user_data['user_language']),
	'GAME_DATA' => L_('profile_GameData'),
	'POSITION_MP' => L_("profile_Positionmp")."&nbsp;".help("profile_main_planet"),
	'NAME_IG' =>  L_("profile_NameIG"),
	'ALLY_IG' =>  L_("profile_AllyIG"),
	'USERNAME_IG' => $user_data['user_stat_name'],
	'ALLYNAME_IG' => $user_data['ally_stat_name'],
	'VARIOUS' => L_("profile_Various"),
	'SKIN' => L_("profile_Linkskin")."&nbsp;".help("profile_skin"),
	'USER_SKIN' => $user_data["user_skin"],
	'IP_CHECK' => L_("profile_Disableipcheck")."&nbsp;".help("profile_disable_ip_check"),
	'USER_IP_CHECK' => $disable_ip_check,
	'OFFICIER' => L_("profile_off"),
	'AMIRAL' => L_("profile_amiral"),
	'USER_AMIRAL' => $off_amiral,
	'INGENIEUR' => L_("profile_inge"),
	'USER_INGENIEUR' => $off_ingenieur,
	'GEOLOGUE' => L_("profile_geo"),
	'USER_GEOLOGUE' => $off_geologue,
	'TECHNOCRATE' => L_("profile_tech"),
	'USER_TECHNOCRATE' => $off_technocrate,
	'VALIDATE' => L_("profile_Validate")
));

// Traitement et affichage du template
$tpl->parse();

require_once("views/page_tail.php");
?>
