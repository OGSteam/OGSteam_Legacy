<?php
/***************************************************************************
*	filename	: message.php
*	desc.		:
*	Author		: Kyser - http://www.ogsteam.fr/
*	created		: 09/12/2005
*	modified	: 22/06/2006 00:13:20
*	modified	: 30/07/2006 00:00:00
***************************************************************************/

if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}

if(!isset($pub_id_message) || !isset($pub_info)) {
	redirection("index.php");
}

if(!check_var($pub_id_message, "Char") || !check_var($pub_info, "Special", "#^[\sa-zA-Z0-9~¤_.-\[\]]+$#")) {
	redirection("index.php");
}

$action = "";
$message = "<b>".$LANG["message_SystemMessage"]."</b><br /><br />";

switch ($pub_id_message) {
	//
	case "forbidden" :
	$message .= "<font color='red'><b>".$LANG["message_DontHaveRights"]."</b></font>";
	break;

	//
	case "errorfatal" :
	$message .= "<font color='red'><b>".$LANG["message_ErrorFatal"]."</b></font>";
	break;

	//
	case "errordata" :
	$message .= "<font color='red'><b>".$LANG["message_ErrorData"]."</b></font>";
	break;

	//
	case "createuser_success" :
	list($user_id, $password) = explode("n", $pub_info);
	$user_info = user_get($user_id);
	$message .= "<font color='lime'><b>".sprintf($LANG["message_AccountCreation"],$user_info[0]["user_name"])."</b></font><br />";
	$message .=$LANG["message_AccountTransmitInfo"]." :<br /><br />";
	$message .= "- ".$LANG["message_ServerURL"]." :<br /><a>http://".$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF']."</a><br /><br />";
	$message .= "- ".$LANG["message_Password"]." :<br /><a>".$password."</a>";
	$action = "action=administration&subaction=member";
	break;

	//
	case "regeneratepwd_success" :
	list($user_id, $password) = explode("n", $pub_info);
	$user_info = user_get($user_id);
	$message .= "<font color='lime'><b>".sprintf($LANG["message_ChangePasswordSuccess"],$user_info[0]["user_name"])."</b></font><br />";
	$message .= $LANG["message_SendPassword"]." : <a>".$password."</a>";
	$action = "action=administration&subaction=member";
	break;

	//
	case "regeneratepwd_failed" :
	$message .= "<font color='red'><b>".$LANG["message_RegeneratePasswordFailed"]."</b></font>";
	$action = "action=administration&subaction=member";
	break;

	//
	case "createuser_failed_pseudolocked" :
	$message .= "<font color='red'><b>".sprintf($LANG["message_FailedPseudoLocked"],$pub_info)."</b></font><br />";
	$message .= "<i>Le pseudo est déjà utilisé</i>";
	$action = "action=administration&subaction=member";
	break;

	//
	case "createuser_failed_pseudo" :
	$message .= "<font color='red'><b>".sprintf($LANG["message_AccountCreationFailed"],$pub_info)."</b></font><br />";
	$message .= "<i>".$LANG["message_NickRequierements"]."</i></a>";
	$action = "action=administration&subaction=member";
	break;

	//
	case "createuser_failed_general" :
	$message .= "<font color='red'><b>".$LANG["message_AccountCreationFailed"]."</b></font><br />";
	$message .= "<i>".$LANG["message_NickIncorrect"]."</i></a>";
	$action = "action=administration&subaction=member";
	break;

	//
	case "admin_modifyuser_success" :
	$user_info = user_get($pub_info);
	$message .= "<font color='lime'><b>".sprintf($LANG["message_ProfileChangedSuccess"],$user_info[0]["user_name"])."</b></font>";
	$action = "action=administration&subaction=member";
	break;

	//
	case "admin_modifyuser_failed" :
	$message .= "<font color='red'><b>".$LANG["message_ProfileChangedFailed"]."</b></font>";
	$action = "action=administration&subaction=member";
	break;

	//
	case "member_modifyuser_success" :
	$message .= "<font color='lime'><b>".$LANG["message_UserProfileChangedSuccess"]."</b></font>";
	$action = "action=profile";
	break;

	//
	case "member_modifyuser_failed" :
	$message .= "<font color='red'><b>".$LANG["message_UserProfileChangedFailed"]."</b></font>";
	$action = "action=profile";
	break;

	//
	case "member_modifyuser_failed_passwordcheck" :
	$message .= "<font color='red'><b>".$LANG["message_UserProfileChangedFailed"]."</b></font><br />";
	$message .= $LANG["message_UserPasswordCheck"];
	$action = "action=profile";
	break;

	//
	case "member_modifyuser_failed_password" :
	$message .= "<font color='red'><b>".$LANG["message_UserProfileChangedFailed"]."</b></font><br />";
	$message .= $LANG["message_PasswordRequiert"];
	$action = "action=profile";
	break;

	//
	case "member_modifyuser_failed_pseudolocked" :
	$message .= "<font color='red'><b>".$LANG["message_UserProfileChangedFailed"]."</b></font><br />";
	$message .= $LANG["message_NickAlreadyUsed"];
	$action = "action=profile";
	break;

	//
	case "member_modifyuser_failed_pseudo" :
	$message .= "<font color='red'><b>".$LANG["message_UserProfileChangedFailed"]."</b></font><br />";
	$message .= $LANG["message_NickRequierements"];
	$action = "action=profile";
	break;

	//
	case "deleteuser_success" :
	$message .= "<font color='lime'><b>".sprintf($LANG["message_DeleteMemberSuccess"],$pub_info)."</b></font>";
	$action = "action=administration&subaction=member";
	break;

	//
	case "deleteuser_failed" :
	$message .= "<font color='red'><b>".$LANG["message_DeleteMemberFailed"]."</b></font>";
	$action = "action=administration&subaction=member";
	break;

	//
	case "login_wrong" :
	$message .= "<font color='red'><b>".$LANG["message_LoginWrong"]."</b></font>";
	break;

	//
	case "account_lock" :
	$message .= "<font color='red'><b>".$LANG["message_AccountLock"]."</b></font><br />";
	$message .= $LANG["message_ContactAdmin"];	
	break;

	//
	case "max_favorites" :
	$message .= "<font color='orange'><b>".sprintf($LANG["message_MaxFavorites"],$server_config["max_favorites"])."</b></font>";
	
	break;

	//
	case "setting_serverconfig_failed" :
	$message .= "<font color='red'><b>".$LANG["message_ServerConfigFailed"]."</b></font>";
	$action = "action=administration&subaction=parameter";
	break;

	//
	case "setting_serverconfig_success" :
	$message .= "<font color='lime'><b>".$LANG["message_ServerConfigSuccess"]."</b></font>";
	$action = "action=administration&subaction=parameter";
	break;

	//
	case "log_missing" :
	$message .= "<font color='orange'><b>".$LANG["message_LogMissing"]."</b></font>";
	$action = "action=administration&subaction=viewer";
	break;

	//
	case "set_building_failed_planet_id" :
	$message .= "<font color='orange'><b>".$LANG["message_PlanetIDFailed"]."</b></font>";
	$action = "action=home&subaction=empire";
	break;

	//
	case "install_directory" :
	$message .= "<font color='red'><b>".$LANG["message_DeleteInstall"]."</b></font>";	
	break;

	//
	case "spy_added" :
	$reports = explode("¤", $pub_info);
	$message .= "<font color='lime'><b>".$LANG["message_LoadedSpyReport"]."</b></font><br />";
	foreach ($reports as $v) {
		list($added, $coordinates, $timestamp) = explode("~", $v);
		list($galaxy, $system, $row) = explode(":", str_replace(array("[", "]"), "", $coordinates));
		$message .= "<br />".sprintf($LANG["message_SpyReportFor"]," [<a href='index.php?galaxy=".$galaxy."&system=".$system."'><font color='lime'>".$coordinates."</font></a>]")." : ";
		$message .= $added ? "<font color='lime'>".$LANG["message_Loaded"] : "<font color='orange'>".$LANG["message_Ignored"];
		$message .= "</font>";
	}
	$action = "action=galaxy";
	break;

	//
	case "createusergroup_success" :
	$message .= "<font color='lime'><b>".sprintf($LANG["message_GroupCreationSuccess"],$pub_info)."</b></font><br />";
	$action = "action=administration&subaction=group";
	break;

	//
	case "createusergroup_failed_groupnamelocked" :
	$message .= "<font color='red'><b>".sprintf($LANG["message_GroupCreationFailed"],$pub_info)."</b></font><br />";
	$message .= $LANG["message_NameAlreadyUsed"];
	$action = "action=administration&subaction=group";
	break;

	//
	case "createusergroup_failed_groupname" :
	$message .= "<font color='red'><b>".sprintf($LANG["message_GroupCreationFailed"],$pub_info)."</b></font><br />";
	$message .= $LANG["message_GroupNameRequiert"];
	$action = "action=administration&subaction=group";
	break;

	//
	case "createusergroup_failed_general" :
	$message .= "<font color='red'><b>".sprintf($LANG["message_GroupCreationFailed"],$pub_info)."</b></font><br />";
	$message .= $LANG["message_GroupNameIncorrect"];
	$action = "action=administration&subaction=group";
	break;

	//
	case "db_optimize" :
	list($dbSize_before, $dbSize_after) = explode("¤", $pub_info);
	$message .= "<font color='lime'><b>".$LANG["message_DBOptimizeFinished"]."</b></font><br />";
	$message .= $LANG["message_DBSpaceBeforeOptimize"]." : ".$dbSize_before."<br />";
	$message .= $LANG["message_DBSpaceAfterOptimize"]." : ".$dbSize_after."<br /><br />";
	$action = "action=administration&subaction=infoserver";
	break;

	//
	case "set_empire_failed_data" :
	$message .= "<font color='red'><b>".$LANG["message_EmpireFailed"]."</b></font>";
	$action = "action=home&subaction=empire";
	break;

	//
	default:
	redirection("index.php");
	break;
}

$action = $action != "" ? "?".$action : "";
$message .="<br /><br /><a href='index.php".$action."'>".$LANG["message_Return"]."</a>";

require_once("views/page_header_2.php");?>
<div align="center">
<table align="center">
<tr>
	<td class="c"><div align="center"><?php echo $message;?></div></td>
</tr>
</table>
</div>
<?php
require_once("views/page_tail_2.php");
?>
