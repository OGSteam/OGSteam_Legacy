<?php
/***************************************************************************
*	filename	: help.php
*	desc.		:
*	Author		: Kyser - http://www.ogsteam.fr/
*	created		: 04/05/2006
*	modified	: 22/08/2006 00:00:00
***************************************************************************/

if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}

global $help, $LANG, $user_data;

// ======================= TOOLTIPS MENUS ========================================================

$help["tooltip_menu_admin"] = "<table width='250' >"
                            . "<tr><td class='c' colspan='2' align='center' width='200'><b>".$LANG["admin_adminsubmenus"]."</b></td></tr>"
                            . "<tr ><th ><div  align='left'>";

if ($user_data["user_admin"] == 1 || $user_data["user_coadmin"] == 1 || !isset($user_data)) {
    $help["tooltip_menu_admin"] .= "<a style='cursor:pointer' title='".$LANG["admin_GeneralInfo"]."' href='index.php?action=administration&subaction=infoserver'>".$LANG["admin_GeneralInfo"]."</a><br/>";
    $help["tooltip_menu_admin"] .= "<a style='cursor:pointer' title='".$LANG["admin_ServerParameters"]."' href='index.php?action=administration&subaction=parameter'>".$LANG["admin_ServerParameters"]."</a><br/>";
}
if ($user_data["user_admin"] == 1 || $user_data["user_coadmin"] == 1 || $user_data["management_user"] == 1 || !isset($user_data)) {
    $help["tooltip_menu_admin"] .= "<a style='cursor:pointer' title='".$LANG["admin_UserManagement"]."' href='index.php?action=administration&subaction=member'>".$LANG["admin_UserManagement"]."</a><br/>";
    $help["tooltip_menu_admin"] .= "<a style='cursor:pointer' title='".$LANG["admin_GroupManagement"]."' href='index.php?action=administration&subaction=group'>".$LANG["admin_GroupManagement"]."</a><br/>";
}
                
if ($user_data["user_admin"] == 1 || $user_data["user_coadmin"] == 1 || !isset($user_data)) {
    $help["tooltip_menu_admin"] .= "<a style='cursor:pointer' title='".$LANG["admin_Journal"]."' href='index.php?action=administration&subaction=viewer'>".$LANG["admin_Journal"]."</a><br/>";
    $help["tooltip_menu_admin"] .= "<a style='cursor:pointer' title='".$LANG["admin_Mods"]."\' href='index.php?action=administration&subaction=mod'>".$LANG["admin_Mods"]."</a><br/>";
}

$help["tooltip_menu_admin"] .= "</div></th></tr></table>";


$help["tooltip_menu_perso"] = "<table width='250'>"
                            . "<tr><td class='c' colspan='2' align='center' width='200'><b>".$LANG["home_homesubmenus"]."</b></td></tr>"
                            . "<tr ><th ><div  align='left'>";
$help["tooltip_menu_perso"] .= "<a style='cursor:pointer' title='".$LANG["home_empire"]."' href='index.php?action=home&subaction=empire'>".$LANG["home_empire"]."</a><br/>";
$help["tooltip_menu_perso"] .= "<a style='cursor:pointer' title='".$LANG["home_Simulation"]."' href='index.php?action=home&subaction=simulation'>".$LANG["home_Simulation"]."</a><br/>";
$help["tooltip_menu_perso"] .= "<a style='cursor:pointer' title='".$LANG["home_spyreports"]."' href='index.php?action=home&subaction=spy'>".$LANG["home_spyreports"]."</a><br/>";
$help["tooltip_menu_perso"] .= "<a style='cursor:pointer' title='".$LANG["home_userstats"]."' href='index.php?action=home&subaction=stat'>".$LANG["home_userstats"]."</a><br/>";
$help["tooltip_menu_perso"] .= "</div></th></tr></table>";


function help($key, $value = "", $prefixe = "") {
	global $help, $LANG, $user_data;
	


$help["galaxy_missiles"] = $LANG["galaxy_silosneedsspyreports"];

// texte bulles d'aides pour restriction / ratio limite
$help["galaxy_ratio_restrict"] = $LANG["galaxy_ratio_restrict"];
$help["search_ratio_restrict"] = $LANG["search_ratio_restrict"];



                            
//-----------------------------------------------------------------------------------------                            

$help["admin_server_status"] = $LANG["help_serverstatus"];
$help["admin_server_status_message"] = $LANG["help_servermessage"];
$help["admin_save_transaction"] = $LANG["help_savetransaction"];
$help["admin_member_manager"] = $LANG["help_membermanager"];
$help["admin_ranking_manager"] = $LANG["help_rankingmanager"];
$help["admin_check_ip"] = "".$LANG["help_checkip"]."<br />".$LANG["help_checkip1"]."";
$help["admin_session_infini"] = $LANG["help_sessioninfini"];

$help["search_strict"] = "<font color=orange>".$LANG["help_searchstrict"]."</font><br /><i>".$LANG["help_searchstrict1"]."</i><br /><font color=orange>".$LANG["help_searchstrict2"]."</font><br /><i>".$LANG["help_searchstrict3"]."</i><br /><br />=> <font color=lime>".$LANG["help_searchstrict4"]."</font>".$LANG["help_searchstrict5"]."<br />=> <font color=red>".$LANG["help_searchstrict6"]."</font>".$LANG["help_searchstrict7"]."";

$help["home_commandant"] = "".$LANG["help_homecommandant"]."";

$help["profile_skin"] = $LANG["help_profileskin"];
$help["profile_login"] = "".$LANG["help_profilelogin"]."<br />".$LANG["help_profilelogin1"]."";
$help["profile_password"] = $LANG["help_profilepassword"];
$help["profile_disable_ip_check"] = "".$LANG["help_profiledisableipcheck"]."<br /><br />";
$help["profile_disable_ip_check"] .= "".$LANG["help_profiledisableipcheck1"]."<br /><br />";
$help["profile_disable_ip_check"] .= "<i>".$LANG["help_profiledisableipcheck2"]."</i>";

$help["galaxy_phalanx"] = $LANG["help_galaxyphalanx"];	
	
	
	if (!isset($help[$key]) && !(is_null($key) && $value <> "")) {
		return;
	}

	if (isset($help[$key])) {
		$value = $help[$key];
	}
	
	$text = "<table width=\"200\">";
	$text .= "<tr><td align=\"center\" class=\"c\">".$LANG["help_help"]."</td></tr>";
	$text .= "<tr><th align=\"center\">".addslashes($value)."</th></tr>";
	$text .= "</table>";

	$text = htmlentities($text);
	$text = "this.T_WIDTH=210;this.T_TEMP=0;return escape('".$text."')";

	return "<img style=\"cursor:pointer\" src=\"".$prefixe."images/help_2.png\" onmouseover=\"".$text."\">";
}
?>
