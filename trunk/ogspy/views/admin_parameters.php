<?php
/** $Id$ **/
/**
* Panneau d'administration des options du serveur
* @package OGSpy
* @subpackage main
* @author Kyser
* @copyright Copyright &copy; 2007, http://ogsteam.fr/
* @version 4.00 ($Rev$)
* @modified $Date$
* @link $HeadURL$
*/
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

if ($user_data["user_admin"] != 1 && $user_data["user_coadmin"] != 1) {
	redirection("?action=message&amp;id_message=forbidden&info");
}

$max_battlereport = $server_config['max_battlereport'];
$max_favorites = $server_config['max_favorites'];
$max_spyreport = $server_config['max_spyreport'];
$server_active = $server_config['server_active'] == 1 ? "checked='checked'" : "";
$session_time = $server_config['session_time'];
$max_keeplog = $server_config['max_keeplog'];
$default_skin = $server_config['default_skin'];
$debug_log = $server_config['debug_log'] == 1 ? "checked='checked'" : "";
$log_phperror = $server_config['log_phperror'] == 1 ? "checked='checked'" : "";
$log_langerror = $server_config['log_langerror'] == 1 ? "checked='checked'" : "";
$reason = $server_config['reason'];
$ally_protection = $server_config['ally_protection'];
$ally_protection_color = $server_config['ally_protection_color'];
$url_forum = $server_config['url_forum'];
$max_keeprank = $server_config['max_keeprank'];
$keeprank_criterion = $server_config['keeprank_criterion'];
$max_keepspyreport = $server_config['max_keepspyreport'];
$servername = $server_config['servername'];
$max_favorites_spy = $server_config['max_favorites_spy'];
$disable_ip_check = $server_config['disable_ip_check'] == 1 ? "checked='checked'" : "";
$num_of_galaxies = ( isset ( $pub_num_of_galaxies ) ) ? $pub_num_of_galaxies:$server_config['num_of_galaxies'];
$num_of_systems = ( isset ( $pub_num_of_systems ) ) ? $pub_num_of_systems:$server_config['num_of_systems'];
$block_ratio = $server_config['block_ratio'] == 1 ? "checked='checked'" : "";
$ratio_limit = $server_config['ratio_limit'];
$speed_uni = $server_config['speed_uni'];
$ddr = $server_config['ddr'];

// Creation du template
if (file_exists($user_data['user_skin'].'\templates\admin_parameters.tpl'))
{
    $tpl = new template($user_data['user_skin'].'\templates\admin_parameters.tpl');
}
elseif (file_exists($server_config['default_skin'].'\templates\admin_parameters.tpl'))
{
    $tpl = new template($server_config['default_skin'].'\templates\admin_parameters.tpl');
}
else
{
    $tpl = new template('admin_parameters.tpl');
}

$help["color_picker"] = addslashes("<table border=0 cellspacing=1 cellpadding=0 bgcolor=#000000 style=\"cursor: hand;\" onclick=Set()><tr height=10><td bgcolor=black onMouseOver=View('black') width=10></td><td bgcolor=#000000 onMouseOver=View('#000000') width=10></td><td bgcolor=#001900 onMouseOver=View('#001900') width=10></td><td bgcolor=#003300 onMouseOver=View('#003300') width=10></td><td bgcolor=#006600 onMouseOver=View('#006600') width=10></td><td bgcolor=#009900 onMouseOver=View('#009900') width=10></td><td bgcolor=#00CC00 onMouseOver=View('#00CC00') width=10></td><td bgcolor=#00FF00 onMouseOver=View('#00FF00') width=10></td><td bgcolor=#330000 onMouseOver=View('#330000') width=10></td><td bgcolor=#333300 onMouseOver=View('#333300') width=10></td><td bgcolor=#336600 onMouseOver=View('#336600') width=10></td><td bgcolor=#339900 onMouseOver=View('#339900') width=10></td><td bgcolor=#33CC00 onMouseOver=View('#33CC00') width=10></td><td bgcolor=#33FF00 onMouseOver=View('#33FF00') width=10></td><td bgcolor=#660000 onMouseOver=View('#660000') width=10></td><td bgcolor=#663300 onMouseOver=View('#663300') width=10></td><td bgcolor=#666600 onMouseOver=View('#666600') width=10></td><td bgcolor=#669900 onMouseOver=View('#669900') width=10></td><td bgcolor=#66CC00 onMouseOver=View('#66CC00') width=10></td><td bgcolor=#66FF00 onMouseOver=View('#66FF00') width=10></td></tr><tr height=10><td bgcolor=darkgray onMouseOver=View('darkgray')></td><td bgcolor=#000000 onMouseOver=View('#000000')></td><td bgcolor=#000033 onMouseOver=View('#000033')></td><td bgcolor=#003333 onMouseOver=View('#003333')></td><td bgcolor=#006633 onMouseOver=View('#006633')></td><td bgcolor=#009933 onMouseOver=View('#009933')></td><td bgcolor=#00CC33 onMouseOver=View('#00CC33')></td><td bgcolor=#00FF33 onMouseOver=View('#00FF33')></td><td bgcolor=#330033 onMouseOver=View('#330033')></td><td bgcolor=#333333 onMouseOver=View('#333333')></td><td bgcolor=#336633 onMouseOver=View('#336633')></td><td bgcolor=#339933 onMouseOver=View('#339933')></td><td bgcolor=#33CC33 onMouseOver=View('#33CC33')></td><td bgcolor=#33FF33 onMouseOver=View('#33FF33')></td><td bgcolor=#660033 onMouseOver=View('#660033')></td><td bgcolor=#663333 onMouseOver=View('#663333')></td><td bgcolor=#666633 onMouseOver=View('#666633')></td><td bgcolor=#669933 onMouseOver=View('#669933')></td><td bgcolor=#66CC33 onMouseOver=View('#66CC33')></td><td bgcolor=#66FF33 onMouseOver=View('#66FF33')></td></tr><tr height=10><td bgcolor=gray onMouseOver=View('gray')></td><td bgcolor=#000000 onMouseOver=View('#000000')></td><td bgcolor=#000066 onMouseOver=View('#000066')></td><td bgcolor=#003366 onMouseOver=View('#003366')></td><td bgcolor=#006666 onMouseOver=View('#006666')></td><td bgcolor=#009966 onMouseOver=View('#009966')></td><td bgcolor=#00CC66 onMouseOver=View('#00CC66')></td><td bgcolor=#00FF66 onMouseOver=View('#00FF66')></td><td bgcolor=#330066 onMouseOver=View('#330066')></td><td bgcolor=#333366 onMouseOver=View('#333366')></td><td bgcolor=#336666 onMouseOver=View('#336666')></td><td bgcolor=#339966 onMouseOver=View('#339966')></td><td bgcolor=#33CC66 onMouseOver=View('#33CC66')></td><td bgcolor=#33FF66 onMouseOver=View('#33FF66')></td><td bgcolor=#660066 onMouseOver=View('#660066')></td><td bgcolor=#663366 onMouseOver=View('#663366')></td><td bgcolor=#666666 onMouseOver=View('#666666')></td><td bgcolor=#669966 onMouseOver=View('#669966')></td><td bgcolor=#66CC66 onMouseOver=View('#66CC66')></td><td bgcolor=#66FF66 onMouseOver=View('#66FF66')></td></tr><tr height=10><td bgcolor=#999999 onMouseOver=View('#999999')></td><td bgcolor=#000000 onMouseOver=View('#000000')></td><td bgcolor=#000099 onMouseOver=View('#000099')></td><td bgcolor=#003399 onMouseOver=View('#003399')></td><td bgcolor=#006699 onMouseOver=View('#006699')></td><td bgcolor=#009999 onMouseOver=View('#009999')></td><td bgcolor=#00CC99 onMouseOver=View('#00CC99')></td><td bgcolor=#00FF99 onMouseOver=View('#00FF99')></td><td bgcolor=#330099 onMouseOver=View('#330099')></td><td bgcolor=#333399 onMouseOver=View('#333399')></td><td bgcolor=#336699 onMouseOver=View('#336699')></td><td bgcolor=#339999 onMouseOver=View('#339999')></td><td bgcolor=#33CC99 onMouseOver=View('#33CC99')></td><td bgcolor=#33FF99 onMouseOver=View('#33FF99')></td><td bgcolor=#660099 onMouseOver=View('#660099')></td><td bgcolor=#663399 onMouseOver=View('#663399')></td><td bgcolor=#666699 onMouseOver=View('#666699')></td><td bgcolor=#669999 onMouseOver=View('#669999')></td><td bgcolor=#66CC99 onMouseOver=View('#66CC99')></td><td bgcolor=#66FF99 onMouseOver=View('#66FF99')></td></tr><tr height=10><td bgcolor=#CCCCCC onMouseOver=View('#CCCCCC')></td><td bgcolor=#000000 onMouseOver=View('#000000')></td><td bgcolor=#0000CC onMouseOver=View('#0000CC')></td><td bgcolor=#0033CC onMouseOver=View('#0033CC')></td><td bgcolor=#0066CC onMouseOver=View('#0066CC')></td><td bgcolor=#0099CC onMouseOver=View('#0099CC')></td><td bgcolor=#00CCCC onMouseOver=View('#00CCCC')></td><td bgcolor=#00FFCC onMouseOver=View('#00FFCC')></td><td bgcolor=#3300CC onMouseOver=View('#3300CC')></td><td bgcolor=#3333CC onMouseOver=View('#3333CC')></td><td bgcolor=#3366CC onMouseOver=View('#3366CC')></td><td bgcolor=#3399CC onMouseOver=View('#3399CC')></td><td bgcolor=#33CCCC onMouseOver=View('#33CCCC')></td><td bgcolor=#33FFCC onMouseOver=View('#33FFCC')></td><td bgcolor=#6600CC onMouseOver=View('#6600CC')></td><td bgcolor=#6633CC onMouseOver=View('#6633CC')></td><td bgcolor=#6666CC onMouseOver=View('#6666CC')></td><td bgcolor=#6699CC onMouseOver=View('#6699CC')></td><td bgcolor=#66CCCC onMouseOver=View('#66CCCC')></td><td bgcolor=#66FFCC onMouseOver=View('#66FFCC')></td></tr><tr height=10><td bgcolor=White onMouseOver=View('White')></td><td bgcolor=#000000 onMouseOver=View('#000000')></td><td bgcolor=#0000FF onMouseOver=View('#0000FF')></td><td bgcolor=#0033FF onMouseOver=View('#0033FF')></td><td bgcolor=#0066FF onMouseOver=View('#0066FF')></td><td bgcolor=#0099FF onMouseOver=View('#0099FF')></td><td bgcolor=#00CCFF onMouseOver=View('#00CCFF')></td><td bgcolor=#00FFFF onMouseOver=View('#00FFFF')></td><td bgcolor=#3300FF onMouseOver=View('#3300FF')></td><td bgcolor=#3333FF onMouseOver=View('#3333FF')></td><td bgcolor=#3366FF onMouseOver=View('#3366FF')></td><td bgcolor=#3399FF onMouseOver=View('#3399FF')></td><td bgcolor=#33CCFF onMouseOver=View('#33CCFF')></td><td bgcolor=#33FFFF onMouseOver=View('#33FFFF')></td><td bgcolor=#6600FF onMouseOver=View('#6600FF')></td><td bgcolor=#6633FF onMouseOver=View('#6633FF')></td><td bgcolor=#6666FF onMouseOver=View('#6666FF')></td><td bgcolor=#6699FF onMouseOver=View('#6699FF')></td><td bgcolor=#66CCFF onMouseOver=View('#66CCFF')></td><td bgcolor=#66FFFF onMouseOver=View('#66FFFF')></td></tr><tr height=10><td bgcolor=Red onMouseOver=View('Red')></td><td bgcolor=#000000 onMouseOver=View('#000000')></td><td bgcolor=#990000 onMouseOver=View('#990000')></td><td bgcolor=#993300 onMouseOver=View('#993300')></td><td bgcolor=#996600 onMouseOver=View('#996600')></td><td bgcolor=#999900 onMouseOver=View('#999900')></td><td bgcolor=#99CC00 onMouseOver=View('#99CC00')></td><td bgcolor=#99FF00 onMouseOver=View('#99FF00')></td><td bgcolor=#CC0000 onMouseOver=View('#CC0000')></td><td bgcolor=#CC3300 onMouseOver=View('#CC3300')></td><td bgcolor=#CC6600 onMouseOver=View('#CC6600')></td><td bgcolor=#CC9900 onMouseOver=View('#CC9900')></td><td bgcolor=#CCCC00 onMouseOver=View('#CCCC00')></td><td bgcolor=#CCFF00 onMouseOver=View('#CCFF00')></td><td bgcolor=#FF0000 onMouseOver=View('#FF0000')></td><td bgcolor=#FF3300 onMouseOver=View('#FF3300')></td><td bgcolor=#FF6600 onMouseOver=View('#FF6600')></td><td bgcolor=#FF9900 onMouseOver=View('#FF9900')></td><td bgcolor=#FFCC00 onMouseOver=View('#FFCC00')></td><td bgcolor=#FFFF00 onMouseOver=View('#FFFF00')></td></tr><tr height=10><td bgcolor=#Green onMouseOver=View('Green')></td><td bgcolor=#000000 onMouseOver=View('#000000')></td><td bgcolor=#990033 onMouseOver=View('#990033')></td><td bgcolor=#993333 onMouseOver=View('#993333')></td><td bgcolor=#996633 onMouseOver=View('#996633')></td><td bgcolor=#999933 onMouseOver=View('#999933')></td><td bgcolor=#99CC33 onMouseOver=View('#99CC33')></td><td bgcolor=#99FF33 onMouseOver=View('#99FF33')></td><td bgcolor=#CC0033 onMouseOver=View('#CC0033')></td><td bgcolor=#CC3333 onMouseOver=View('#CC3333')></td><td bgcolor=#CC6633 onMouseOver=View('#CC6633')></td><td bgcolor=#CC9933 onMouseOver=View('#CC9933')></td><td bgcolor=#CCCC33 onMouseOver=View('#CCCC33')></td><td bgcolor=#CCFF33 onMouseOver=View('#CCFF33')></td><td bgcolor=#FF0033 onMouseOver=View('#FF0033')></td><td bgcolor=#FF3333 onMouseOver=View('#FF3333')></td><td bgcolor=#FF6633 onMouseOver=View('#FF6633')></td><td bgcolor=#FF9933 onMouseOver=View('#FF9933')></td><td bgcolor=#FFCC33 onMouseOver=View('#FFCC33')></td><td bgcolor=#FFFF33 onMouseOver=View('#FFFF33')></td></tr><tr height=10><td bgcolor=Blue onMouseOver=View('Blue')></td><td bgcolor=#000000 onMouseOver=View('#000000')></td><td bgcolor=#990066 onMouseOver=View('#990066')></td><td bgcolor=#993366 onMouseOver=View('#993366')></td><td bgcolor=#996666 onMouseOver=View('#996666')></td><td bgcolor=#999966 onMouseOver=View('#999966')></td><td bgcolor=#99CC66 onMouseOver=View('#99CC66')></td><td bgcolor=#99FF66 onMouseOver=View('#99FF66')></td><td bgcolor=#CC0066 onMouseOver=View('#CC0066')></td><td bgcolor=#CC3366 onMouseOver=View('#CC3366')></td><td bgcolor=#CC6666 onMouseOver=View('#CC6666')></td><td bgcolor=#CC9966 onMouseOver=View('#CC9966')></td><td bgcolor=#CCCC66 onMouseOver=View('#CCCC66')></td><td bgcolor=#CCFF66 onMouseOver=View('#CCFF66')></td><td bgcolor=#FF0066 onMouseOver=View('#FF0066')></td><td bgcolor=#FF3366 onMouseOver=View('#FF3366')></td><td bgcolor=#FF6666 onMouseOver=View('#FF6666')></td><td bgcolor=#FF9966 onMouseOver=View('#FF9966')></td><td bgcolor=#FFCC66 onMouseOver=View('#FFCC66')></td><td bgcolor=#FFFF66 onMouseOver=View('#FFFF66')></td></tr><tr height=10><td bgcolor=Yellow onMouseOver=View('Yellow')></td><td bgcolor=#000000 onMouseOver=View('#000000')></td><td bgcolor=#990099 onMouseOver=View('#990099')></td><td bgcolor=#993399 onMouseOver=View('#993399')></td><td bgcolor=#996699 onMouseOver=View('#996699')></td><td bgcolor=#999999 onMouseOver=View('#999999')></td><td bgcolor=#99CC99 onMouseOver=View('#99CC99')></td><td bgcolor=#99FF99 onMouseOver=View('#99FF99')></td><td bgcolor=#CC0099 onMouseOver=View('#CC0099')></td><td bgcolor=#CC3399 onMouseOver=View('#CC3399')></td><td bgcolor=#CC6699 onMouseOver=View('#CC6699')></td><td bgcolor=#CC9999 onMouseOver=View('#CC9999')></td><td bgcolor=#CCCC99 onMouseOver=View('#CCCC99')></td><td bgcolor=#CCFF99 onMouseOver=View('#CCFF99')></td><td bgcolor=#FF0099 onMouseOver=View('#FF0099')></td><td bgcolor=#FF3399 onMouseOver=View('#FF3399')></td><td bgcolor=#FF6699 onMouseOver=View('#FF6699')></td><td bgcolor=#FF9999 onMouseOver=View('#FF9999')></td><td bgcolor=#FFCC99 onMouseOver=View('#FFCC99')></td><td bgcolor=#FFFF99 onMouseOver=View('#FFFF99')></td></tr><tr height=10><td bgcolor=Cyan onMouseOver=View('Cyan')></td><td bgcolor=#000000 onMouseOver=View('#000000')></td><td bgcolor=#9900CC onMouseOver=View('#9900CC')></td><td bgcolor=#9933CC onMouseOver=View('#9933CC')></td><td bgcolor=#9966CC onMouseOver=View('#9966CC')></td><td bgcolor=#9999CC onMouseOver=View('#9999CC')></td><td bgcolor=#99CCCC onMouseOver=View('#99CCCC')></td><td bgcolor=#99FFCC onMouseOver=View('#99FFCC')></td><td bgcolor=#CC00CC onMouseOver=View('#CC00CC')></td><td bgcolor=#CC33CC onMouseOver=View('#CC33CC')></td><td bgcolor=#CC66CC onMouseOver=View('#CC66CC')></td><td bgcolor=#CC99CC onMouseOver=View('#CC99CC')></td><td bgcolor=#CCCCCC onMouseOver=View('#CCCCCC')></td><td bgcolor=#CCFFCC onMouseOver=View('#CCFFCC')></td><td bgcolor=#FF00CC onMouseOver=View('#FF00CC')></td><td bgcolor=#FF33CC onMouseOver=View('#FF33CC')></td><td bgcolor=#FF66CC onMouseOver=View('#FF66CC')></td><td bgcolor=#FF99CC onMouseOver=View('#FF99CC')></td><td bgcolor=#FFCCCC onMouseOver=View('#FFCCCC')></td><td bgcolor=#FFFFCC onMouseOver=View('#FFFFCC')></td></tr><tr height=10><td bgcolor=Magenta onMouseOver=View('Magenta')></td><td bgcolor=#000000 onMouseOver=View('#000000')></td><td bgcolor=#9900FF onMouseOver=View('#9900FF')></td><td bgcolor=#9933FF onMouseOver=View('#9933FF')></td><td bgcolor=#9966FF onMouseOver=View('#9966FF')></td><td bgcolor=#9999FF onMouseOver=View('#9999FF')></td><td bgcolor=#99CCFF onMouseOver=View('#99CCFF')></td><td bgcolor=#99FFFF onMouseOver=View('#99FFFF')></td><td bgcolor=#CC00FF onMouseOver=View('#CC00FF')></td><td bgcolor=#CC33FF onMouseOver=View('#CC33FF')></td><td bgcolor=#CC66FF onMouseOver=View('#CC66FF')></td><td bgcolor=#CC99FF onMouseOver=View('#CC99FF')></td><td bgcolor=#CCCCFF onMouseOver=View('#CCCCFF')></td><td bgcolor=#CCFFFF onMouseOver=View('#CCFFFF')></td><td bgcolor=#FF00FF onMouseOver=View('#FF00FF')></td><td bgcolor=#FF33FF onMouseOver=View('#FF33FF')></td><td bgcolor=#FF66FF onMouseOver=View('#FF66FF')></td><td bgcolor=#FF99FF onMouseOver=View('#FF99FF')></td><td bgcolor=#FFCCFF onMouseOver=View('#FFCCFF')></td><td bgcolor=#FFFFFF onMouseOver=View('#FFFFFF')></td></tr><tr height=10><td colspan=20 height=\"20\"><div id=\"preview\" style=\"height: 100%; width: 100%\"></div></td></tr></table>");

$tpl->CheckIf('is_admin',$user_data["user_admin"] == 1);

// Simples variables texte
$tpl->simpleVar(Array(
	'adminparam_GeneralOptions' => L_("adminparam_GeneralOptions"),
	'adminparam_ServerName' => L_("adminparam_ServerName"),
	'servername' => $servername,
	'adminparam_Language' => L_("adminparam_Language")."&nbsp;".help("admin_lang"),
	'language_list' => make_lang_list($server_config['language']),
	'adminparam_Language_parsing' => L_("adminparam_Language_parsing")."&nbsp;".help("admin_lang_parsing"),
	'parsinglang_list' => make_lang_list($server_config['language_parsing']),
	'adminparam_ActivateServer' => L_("adminparam_ActivateServer") ."&nbsp;".help("admin_server_status"),
	'server_active' => $server_active,
	'adminparam_ServerDownReason' => L_("adminparam_ServerDownReason")."&nbsp;".help("admin_server_status_message"),
	'reason' => $reason,
	'adminparam_MembersOptions' => L_("adminparam_MembersOptions"),
	'adminparam_EnableDesactivateIPCheck' => L_("adminparam_EnableDesactivateIPCheck")."&nbsp;".help("admin_check_ip"),
	'disable_ip_check' => $disable_ip_check,
	'adminparam_DefaultSkin' => L_("adminparam_DefaultSkin")."&nbsp;".help("admin_default_skin"),
	'default_skin' => $default_skin,
	'adminparam_MaximumFavorites' => L_("adminparam_MaximumFavorites"),
	'max_favorites' => $max_favorites,
	'adminparam_MaximumSpyReport' => L_("adminparam_MaximumSpyReport"),
	'max_favorites_spy' => $max_favorites_spy,
	'adminparam_SessionsManagement' => L_("adminparam_SessionsManagement"),
	'adminparam_SessionDuration' => L_("adminparam_SessionDuration"),
	'adminparam_Minutes' => L_("adminparam_Minutes"),
	'adminparam_InfiniteSession' => L_("adminparam_InfiniteSession").help("admin_session_infini"),
	'session_time' => $session_time,
	'adminparam_AllianceProtection' => L_("adminparam_AllianceProtection"),
	'adminparam_HidenAllianceList' => L_("adminparam_HidenAllianceList")."&nbsp;".help("admin_hidealliances"),
	'ally_protection' => $ally_protection,
	'ally_protection_color' => $ally_protection_color,
	'adminparam_color_ally_hided' => L_("adminparam_color_ally_hided")."&nbsp;".help("admin_helpcolorallyhide"),
	'ally_protection_color' => $ally_protection_color,
	'color_picker' => help("color_picker","","",true),
	'adminparam_OtherParameters' => L_("adminparam_OtherParameters"),
	'adminparam_AllyBoardLink' => L_("adminparam_AllyBoardLink"),
	'url_forum' => $url_forum,
	'adminparam_LogSQLQuery' => L_("adminparam_LogSQLQuery")."&nbsp;".help("admin_save_transaction"),
	'adminparam_WarnPerformance' => L_("adminparam_WarnPerformance"),
	'debug_log' => $debug_log,
	'adminparam_BanRatioMod' => L_("adminparam_BanRatioMod"),
	'block_ratio' => $block_ratio,
	'adminparam_MaxRatioMod' => L_("adminparam_MaxRatioMod"),
	'ratio_limit' => $ratio_limit,
	'adminparam_Maintenance' => L_("adminparam_Maintenance"),
	'adminparam_KeepRankingDuration' => L_("adminparam_KeepRankingDuration"),
	'max_keeprank' => $max_keeprank,
	'quantity_selected' => $keeprank_criterion == "quantity" ? "selected='selected'" : "",
	'adminparam_Number' => L_("adminparam_Number"),
	'day_selected' => $keeprank_criterion == "day" ? "selected='selected'" : "",
	'adminparam_Days' => L_("adminparam_Days"),
	'adminparam_MaximumSpyReportByPlanets' => L_("adminparam_MaximumSpyReportByPlanets"),
	'max_spyreport' => $max_spyreport,
	'adminparam_KeepSpyReportDuration' => L_("adminparam_KeepSpyReportDuration"),
	'max_keepspyreport' => $max_keepspyreport,
	'adminparam_KeepLogfileDuration' => L_("adminparam_KeepLogfileDuration"),
	'max_keeplog' => $max_keeplog,
	'adminparam_OptionUni' => L_("adminparam_OptionUni"),
	'adminparam_NberGalaxy' => L_("adminparam_NberGalaxy")."&nbsp;".help("profile_galaxy"),
	'num_of_galaxies' => $num_of_galaxies,
	'adminparam_Activate' => L_('adminparam_Activate'),
	'adminparam_NberSysGalaxy' => L_("adminparam_NberSysGalaxy")."&nbsp;".help("profile_galaxy"),
	'num_of_systems' => $num_of_systems,
	'adminparam_SpeedUni' => L_("adminparam_SpeedUni")."&nbsp;".help("profile_speed_uni"),
	'speed_uni' => $speed_uni,
	'adminparam_DepoRav' => L_("adminparam_DepoRav")."&nbsp;".help("profile_ddr"),
	'ddr_checked' => ($ddr==1)? ' checked="checked"':'',
	'adminparam_OptionDebug' => L_("adminparam_OptionDebug"),
	'adminparam_RecError' => L_("adminparam_RecError")."&nbsp;".help("admin_LogPHPError"),
	'log_phperror' => $log_phperror,
	'adminparam_RecLangError' => L_('adminparam_RecLangError')."&nbsp;".help("admin_LogLangError"),
	'log_langerror' => $log_langerror,
	'adminparam_Validate' => L_("adminparam_Validate"),
	'adminparam_Reset' => L_("adminparam_Reset"),
	'adminparam_ConfirmGalaxiesChange' => L_('adminparam_ConfirmGalaxiesChange'),
	'adminparam_ConfirmSystemsChange' => L_('adminparam_ConfirmSystemsChange'),
	'adminparam_ConfirmSpeedChange' => L_('adminparam_ConfirmSpeedChange')
));

// Traitement et affichage du template
$tpl->parse();
