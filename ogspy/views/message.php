<?php
/** $Id$ **/
/**
* Affichage d'un message d'information
* @package OGSpy
* @subpackage main
* @author Kyser
* @copyright Copyright &copy; 2007, http://ogsteam.fr/
* @version 4.00 ($Rev$)
* @modified $Date$
* @link $HeadURL$
*/
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

if(isset($pub_ajax)){
	die(json_encode(Array('message' => $pub_id_message,'info=' => $pub_info)));	
}

if(!isset($pub_id_message) || !isset($pub_info)) redirection("?");

if(!check_var($pub_id_message, "Char") || !check_var($pub_info, "Special", "#^[\sa-zA-Z0-9~€_.\-\:\[\]]+$#")) 
	redirection("?");

$action = "";
$message = "";

switch ($pub_id_message) {
	//
	case "forbidden" :
	$message .= "<font color='red'><b>".L_("message_DontHaveRights")."</b></font>";
	break;

	//
	case "errorfatal" :
	$message .= "<font color='red'><b>".L_("message_ErrorFatal")."</b></font>";
	break;

	//
	case "errordata" :
	$message .= "<font color='red'><b>".L_("message_ErrorData")."</b></font>";
	break;

	//
	case "createuser_success" :
	list($user_id, $password) = explode(":", $pub_info);
	$user_info = user_get($user_id);
	$message .= "<font color='lime'><b>".L_("message_AccountCreation",$user_info[0]["user_name"])."</b></font><br />";
	$message .=L_("message_AccountTransmitInfo")." :<br /><br />";
	$message .= "- ".L_("message_ServerURL")." :<br /><a>http://".$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF']."</a><br /><br />";
	$message .= "- ".L_("message_Password")." :<br /><a>".$password."</a>";
	$action = "action=administration&amp;subaction=members";
	break;

	//
	case "regeneratepwd_success" :
	list($user_id, $password) = explode(":", $pub_info);
	$user_info = user_get($user_id);
	$message .= "<font color='lime'><b>".L_("message_ChangePasswordSuccess",$user_info[0]["user_name"])."</b></font><br />";
	$message .= L_("message_SendPassword")." : <a>".$password."</a>";
	$action = "action=administration&amp;subaction=members";
	break;

	//
	case "regeneratepwd_failed" :
	$message .= "<font color='red'><b>".L_("message_RegeneratePasswordFailed")."</b></font>";
	$action = "action=administration&amp;subaction=members";
	break;

	//
	case "createuser_failed_pseudolocked" :
	$message .= "<font color='red'><b>".L_("message_FailedPseudoLocked",$pub_info)."</b></font><br />";
	$message .= L_("message_NickAlreadyUsed");
	$action = "action=administration&amp;subaction=members";
	break;

	//
	case "createuser_failed_pseudo" :
	$message .= "<font color='red'><b>".L_("message_AccountCreationFailed",$pub_info)."</b></font><br />";
	$message .= L_("message_NickRequierements")."</a>";
	$action = "action=administration&amp;subaction=members";
	break;

	//
	case "createuser_failed_password" :
	$message .= "<font color='red'><b>".L_("message_AccountCreation",$pub_info);
	$message .= L_("message_NickRequierements");
	$action = "action=administration&amp;subaction=members";
	break;	
	
	//
	case "createuser_failed_general" :
	$message .= "<font color='red'><b>".L_("message_AccountCreationFailed")."</b></font><br />";
	$message .= "<i>".L_("message_NickIncorrect")."</i></a>";
	$action = "action=administration&amp;subaction=members";
	break;

	//
	case "admin_modifyuser_success" :
	$user_info = user_get($pub_info);
	$message .= "<font color='lime'><b>".L_("message_ProfileChangedSuccess",$user_info[0]["user_name"])."</b></font>";
	$action = "action=administration&amp;subaction=members";
	break;

	//
	case "admin_modifyuser_failed" :
	$message .= "<font color='red'><b>".L_("message_ProfileChangedFailed")."</b></font>";
	$action = "action=administration&amp;subaction=members";
	break;

	//
	case "member_modifyuser_success" :
	$message .= "<font color='lime'><b>".L_("message_UserProfileChangedSuccess")."</b></font>";
	$action = "action=profile";
	break;

	//
	case "member_modifyuser_failed" :
	$message .= "<font color='red'><b>".L_("message_UserProfileChangedFailed")."</b></font>";
	$action = "action=profile";
	break;

	//
	case "member_modifyuser_failed_passwordcheck" :
	$message .= "<font color='red'><b>".L_("message_UserProfileChangedFailed")."</b></font><br />";
	$message .=  L_("message_UserPasswordCheck");
	$action = "action=profile";
	break;

	//
	case "member_modifyuser_failed_password" :
	$message .= "<font color='red'><b>".L_("message_UserProfileChangedFailed")."</b></font><br />";
	$message .=  L_("message_PasswordRequiert");
	$action = "action=profile";
	break;

	//
	case "member_modifyuser_failed_pseudolocked" :
	$message .= "<font color='red'><b>".L_("message_UserProfileChangedFailed")."</b></font><br />";
	$message .=  L_("message_NickAlreadyUsed");
	$action = "action=profile";
	break;

	//
	case "member_modifyuser_failed_pseudo" :
	$message .= "<font color='red'><b>".L_("message_UserProfileChangedFailed")."</b></font><br />";
	$message .=  L_("message_NickRequierements");
	$action = "action=profile";
	break;

	//
	case "deleteuser_success" :
	$message .= "<font color='lime'><b>".L_("message_DeleteMemberSuccess",$pub_info)."</b></font>";
	$action = "action=administration&amp;subaction=members";
	break;

	//
	case "deleteuser_failed" :
	$message .= "<font color='red'><b>".L_("message_DeleteMemberFailed")."</b></font>";
	$action = "action=administration&amp;subaction=members";
	break;

	//
	case "login_wrong" :
	$message .= "<font color='red'><b>".L_("message_LoginWrong")."</b></font>";
	break;

	//
	case "account_lock" :
	$message .= "<font color='red'><b>".L_("message_AccountLock")."</b></font><br />";
	$message .=  L_("message_ContactAdmin");	
	break;

	//
	case "max_favorites" :
	$message .= "<font color='orange'><b>".L_("message_MaxFavorites",$server_config["max_favorites"])."</b></font>";
	
	break;

	//
	case "setting_serverconfig_failed" :
	$message .= "<font color='red'><b>".L_("message_ServerConfigFailed")."</b></font>";
	$action = "action=administration&amp;subaction=parameters";
	break;

	//
	case "setting_server_view_success" :
	$message .= "<font color='lime'><b>".L_("message_ServerConfigSuccess")."</b></font>";
	$action = "action=administration&amp;subaction=affichage";
	break;

	//
	case "setting_server_view_failed" :
	$message .= "<font color='red'><b>".L_("message_ServerConfigFailed")."</b></font>";
	$action = "action=administration&amp;subaction=affichage";
	break;

	//
	case "setting_serverconfig_success" :
	$message .= "<font color='lime'><b>".L_("message_ServerConfigSuccess")."</b></font>";
	$action = "action=administration&amp;subaction=parameters";
	break;

	//
	case "log_missing" :
	$message .= "<font color='orange'><b>".L_("message_LogMissing")."</b></font>";
	$action = "action=administration&amp;subaction=viewer";
	break;

	//
	case "log_remove" :
	$message .= "<font color='lime'><b>".L_("message_DelLogSucced")."</></font>";
	$action = "action=administration&amp;subaction=viewer";
	break;
	
	//
	case "set_building_failed_planet_id" :
	$message .= "<font color='orange'><b>".L_("message_PlanetIDFailed")."</b></font>";
	$action = "action=home&amp;subaction=empire";
	break;

	//
	case "install_directory" :
	$message .= "<font color='red'><b>".L_("message_DeleteInstall")."</b></font>";	
	break;

	//
	case "install_inprogress" :
	$message .= "<font color='orange'><b>".L_("message_InstallIOnProgress")."</b></font>";	
	break;

	//
	case "spy_added" :
	$reports = explode("€", $pub_info);
	$message .= "<font color='lime'><b>".L_("message_LoadedSpyReport")."</b></font><br />";
	foreach ($reports as $v) {
		list($added, $coordinates, $timestamp) = explode("~", $v);
		list($galaxy, $system, $row) = explode(":", str_replace(array("[", "]"), "", $coordinates));
		$message .= "<br />".L_("message_SpyReportFor"," [<a href='?galaxy=".$galaxy."&amp;system=".$system."'><font color='lime'>".$coordinates."</font></a>]")." : ";
		$message .= $added ? "<font color='lime'>".L_("message_Loaded") : "<font color='orange'>".L_("message_Ignored");
		$message .= "</font>";
	}
	$action = "action=galaxy";
	break;

	//
	case "createusergroup_success" :
	$message .= "<font color='lime'><b>".L_("message_GroupCreationSuccess",$pub_info)."</b></font><br />";
	$action = "action=administration&amp;subaction=group";
	break;

	//
	case "createusergroup_failed_groupnamelocked" :
	$message .= "<font color='red'><b>".L_("message_GroupCreationFailed",$pub_info)."</b></font><br />";
	$message .=  L_("message_NameAlreadyUsed");
	$action = "action=administration&amp;subaction=group";
	break;

	//
	case "createusergroup_failed_groupname" :
	$message .= "<font color='red'><b>".L_("message_GroupCreationFailed",$pub_info)."</b></font><br />";
	$message .=  L_("message_GroupNameRequiert");
	$action = "action=administration&amp;subaction=group";
	break;

	//
	case "createusergroup_failed_general" :
	$message .= "<font color='red'><b>".L_("message_GroupCreationFailed",$pub_info)."</b></font><br />";
	$message .=  L_("message_GroupNameIncorrect");
	$action = "action=administration&amp;subaction=group";
	break;

	//
	case "db_optimize" :
	list($dbSize_before, $dbSize_after) = explode("€", $pub_info);
	$message .= "<font color='lime'><b>".L_("message_DBOptimizeFinished")."</b></font><br />";
	$message .=  L_("message_DBSpaceBeforeOptimize")." : ".$dbSize_before."<br />";
	$message .=  L_("message_DBSpaceAfterOptimize")." : ".$dbSize_after."<br /><br />";
	$action = "action=administration&amp;subaction=infoserver";
	break;

	//
	case "set_empire_failed_data" :
	$message .= "<font color='red'><b>".L_("message_EmpireFailed")."</b></font>";
	$action = "action=home&amp;subaction=empire";
	break;
  
  	//
	case "raz_ratio" :
	$message .= "<font color='lime'><b>".L_("message_ResetOk")."</b></font><br />";
	$action = "action=statistic";
	break;
	
	//
	default:
	redirection("?");
	break;
}

$action = $action != "" ? "?".$action : "?";
$message .="<br /><br /><a href='".$action."'>".L_("message_Return")."</a>";

require_once("views/page_header_2.php");
if (file_exists($user_data['user_skin'].'\templates\message.tpl'))
{
    $tpl = new template($user_data['user_skin'].'\templates\message.tpl');
}
elseif (file_exists($server_config['default_skin'].'\templates\message.tpl'))
{
    $tpl = new template($server_config['default_skin'].'\templates\message.tpl');
}
else
{
    $tpl = new template('message.tpl');
}
$tpl->SimpleVar(Array(
	'message_SystemMessage'=>L_("message_SystemMessage"),
	'message' => $message
));
$tpl->parse();
require_once("views/page_tail_2.php");
?>
