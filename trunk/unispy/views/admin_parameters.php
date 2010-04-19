<?php
/***************************************************************************
*	filename	: admin_parameters.php
*	desc.		:
*	Author		: Kyser - http://www.ogsteam.fr/
*	created		: 16/12/2005
*	modified	: 22/08/2006 00:00:00
***************************************************************************/

if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}

if ($user_data["user_admin"] != 1 && $user_data["user_coadmin"] != 1) {
	redirection("index.php?action=message&id_message=forbidden&info");
}

$max_battlereport = $server_config['max_battlereport'];
$max_favorites = $server_config['max_favorites'];
$max_spyreport = $server_config['max_spyreport'];
$server_active = $server_config['server_active'] == 1 ? "checked" : "";
$session_time = $server_config['session_time'];
$max_keeplog = $server_config['max_keeplog'];
$default_skin = $server_config['default_skin'];
$debug_log = $server_config['debug_log'] == 1 ? "checked" : "";
$reason = $server_config['reason'];
$ally_protection = $server_config['ally_protection'];
$allied = $server_config['allied'];
$url_forum = $server_config['url_forum'];
$max_keeprank = $server_config['max_keeprank'];
$keeprank_criterion = $server_config['keeprank_criterion'];
$max_keepspyreport = $server_config['max_keepspyreport'];
$servername = $server_config['servername'];
$max_favorites_spy = $server_config['max_favorites_spy'];
$disable_ip_check = $server_config['disable_ip_check'] == 1 ? "checked" : "";
$language = $server_config['language'];
$language_parsing = $server_config['language_parsing'];
$timeshift = $server_config['timeshift'];
$defaultloginpage = $server_config["default_login_page"];
$color_ally_friend = $server_config["color_ally_friend"];
$color_ally_hided = $server_config["color_ally_hided"];
$nb_galaxy = $server_config["nb_galaxy"];
$nb_system = $server_config["nb_system"];
$nb_row = $server_config["nb_row"];
$uni_speed = $server_config["uni_speed"];
?>

<table width="100%">
<form method="POST" action="index.php">
<input type="hidden" name="action" value="set_serverconfig">
<input name="max_battlereport" type="hidden" size="5" value="10">
<tr>
<td class="c" colspan="2"><?php echo $LANG["adminparam_GeneralOptions"];?></td>
</tr>
<tr>
<th width="60%"><?php echo $LANG["adminparam_ServerName"];?></th>
	<th><input type="text" name="servername" size="60" value="<?php echo $servername;?>"></th>
</tr>
<tr>
<th width="60%"><?php echo $LANG["adminparam_Language"];?></th>
<th><select name="language" >
<?php 
	$langfiles = languages_info(); 
	 	foreach ($langfiles as $langfile){ 
	 	              echo '\t<option value="'.$langfile["name"].'"'; 
 	            if ($language == $langfile["name"]) echo " selected";
	 	             echo ">".$LANG[$langfile["name"]]."</option>\n"; 
	 	}        
?>
</select></th>
</tr>

<tr>
<th width="60%"><?php echo $LANG["adminparam_Language_parsing"];?></th>
<th><select name="language_parsing">
<?php 
	$langfiles = languages_info(); 
	 	foreach ($langfiles as $langfile){ 
	 	              echo '\t<option value="'.$langfile["name"].'"'; 
 	            if ($language_parsing == $langfile["name"]) echo " selected"; 
	 	             echo ">".$LANG[$langfile["name"]]."</option>\n"; 
	 	}        
?>
</select></th>
</tr>
</tr>

<tr>
<th width="60%"><?php echo $LANG["adminparam_timeshift"];?></th>
<th><select name="timeshift" >
<option value="-12" <?php if ($timeshift=='-12') echo "selected"; echo ">  H-12"; ?> </option>
<option value="-11" <?php if ($timeshift=='-11') echo "selected"; echo ">  H-11"; ?> </option>
<option value="-10" <?php if ($timeshift=='-10') echo "selected"; echo ">  H-10"; ?> </option>
<option value="-9" <?php if ($timeshift=='-9') echo "selected"; echo ">  H-9"; ?> </option>
<option value="-8" <?php if ($timeshift=='-8') echo "selected"; echo ">  H-8"; ?> </option>
<option value="-7" <?php if ($timeshift=='-7') echo "selected"; echo ">  H-7"; ?> </option>
<option value="-6" <?php if ($timeshift=='-6') echo "selected"; echo ">  H-6"; ?> </option>
<option value="-5" <?php if ($timeshift=='-5') echo "selected"; echo ">  H-5"; ?> </option>
<option value="-4" <?php if ($timeshift=='-4') echo "selected"; echo ">  H-4"; ?> </option>
<option value="-3" <?php if ($timeshift=='-3') echo "selected"; echo ">  H-3"; ?> </option>
<option value="-2" <?php if ($timeshift=='-2') echo "selected"; echo ">  H-2"; ?> </option>
<option value="-1" <?php if ($timeshift=='-1') echo "selected"; echo ">  H-1"; ?> </option>
<option value="0" <?php if ($timeshift=='0') echo "selected"; echo ">  H"; ?> </option>
<option value="1" <?php if ($timeshift=='1') echo "selected"; echo ">  H+1"; ?> </option>
<option value="2" <?php if ($timeshift=='2') echo "selected"; echo ">  H+2"; ?> </option>
<option value="3" <?php if ($timeshift=='3') echo "selected"; echo ">  H+3"; ?> </option>
<option value="4" <?php if ($timeshift=='4') echo "selected"; echo ">  H+4"; ?> </option>
<option value="5" <?php if ($timeshift=='5') echo "selected"; echo ">  H+5"; ?> </option>
<option value="6" <?php if ($timeshift=='6') echo "selected"; echo ">  H+6"; ?> </option>
<option value="7" <?php if ($timeshift=='7') echo "selected"; echo ">  H+7"; ?> </option>
<option value="8" <?php if ($timeshift=='8') echo "selected"; echo ">  H+8"; ?> </option>
<option value="9" <?php if ($timeshift=='9') echo "selected"; echo ">  H+9"; ?> </option>
<option value="10" <?php if ($timeshift=='10') echo "selected"; echo ">  H+10"; ?> </option>
<option value="11" <?php if ($timeshift=='11') echo "selected"; echo ">  H+11"; ?> </option>
<option value="12" <?php if ($timeshift=='12') echo "selected"; echo ">  H+12"; ?> </option>

</select></th>
</tr>
<tr>
	<th width="60%"><?php echo $LANG["adminparam_ActivateServer"];?>&nbsp;<?php echo help("admin_server_status");?></th>
	<th><input name="server_active" type="checkbox" value="1" <?php echo $server_active;?>></th>
</tr>

<tr> 
<th width="60%"><?php echo $LANG["adminparam_defaultloginpage"];?>&nbsp;<?php echo help("admin_server_defaultloginpage_message");?></th> 
<th><input type="text" name="default_login_page" size="60" value="<?php echo $defaultloginpage;?>"></th> 
</tr>
<tr>
	<th width="60%"><?php echo $LANG["adminparam_ServerDownReason"];?>&nbsp;<?php echo help("admin_server_status_message");?></th>
	<th><input type="text" name="reason" size="60" value="<?php echo $reason;?>"></th>
</tr>

<tr>
<td class="c" colspan="2"><?php echo $LANG["adminparam_galaxyOption"];?></td>
</tr>
<tr>
<tr>
<th colspan="2"><div class="z"><font color="red"><?php echo $LANG["adminparam_galaxyOptionwarning"];?></font></div></th>
</tr>
<?php
if ($user_data["user_admin"] == 1) 
{
?>
<tr>
	<th width="60%"><?php echo $LANG["adminparam_unispeed"]; ?></th>
	<th><input type="text" name="uni_speed" size="3" value="<?php echo $uni_speed;?>"></th>
</tr>
<tr>
	<th width="60%"><?php echo $LANG["adminparam_nbgalaxy"];?></th>
	<th><input type="text" name="nb_galaxy" size="3" value="<?php echo $nb_galaxy;?>"></th>
</tr>
<tr>
	<th width="60%"><?php echo $LANG["adminparam_nbsystem"];?></th>
	<th><input type="text" name="nb_system" size="3" value="<?php echo $nb_system;?>"></th>
</tr>
<tr>
	<th width="60%"><?php echo $LANG["adminparam_nbrow"];?></th>
	<th><input type="text" name="nb_row" size="3" value="<?php echo $nb_row;?>"></th>
</tr>
<?php
}
else
{
?>
<tr>
	<th width="60%"><?php echo $LANG["adminparam_unispeed"];?></th>
	<th><?php echo $uni_speed;?></th>
	<input type="hidden" name="uni_speed" value="<?php echo $uni_speed;?>">
</tr>
<tr>
	<th width="60%"><?php echo $LANG["adminparam_nbgalaxy"];?></th>
	<th><?php echo $nb_galaxy;?></th>
	<input type="hidden" name="nb_galaxy" value="<?php echo $nb_galaxy;?>">
</tr>
<tr>
	<th width="60%"><?php echo $LANG["adminparam_nbsystem"];?></th>
	<th><?php echo $nb_system;?></th>
	<input type="hidden" name="nb_system" value="<?php echo $nb_system;?>">
</tr>
<tr>
	<th width="60%"><?php echo $LANG["adminparam_nbrow"];?></th>
	<th><?php echo $nb_row;?></th>
	<input type="hidden" name="nb_row" value="<?php echo $nb_row;?>">
</tr>
<?php
}
?>

<tr>
<td class="c" colspan="2"><?php echo $LANG["adminparam_MembersOptions"];?></td>
</tr>
<tr>
	<th><?php echo $LANG["adminparam_EnableDesactivateIPCheck"];?>&nbsp;<?php echo help("admin_check_ip");?></th>
	<th><input name="disable_ip_check" type="checkbox" value="1" <?php echo $disable_ip_check;?>></th>
</tr>
<tr>
<th><?php echo $LANG["adminparam_DefaultSkin"];?><br /><div class="z"><i>ex: http://80.237.203.201/download/use/epicblue/</i></div></th>
	<th><input name="default_skin" type="text" size="60" value="<?php echo $default_skin;?>"></th>
</tr>
<tr>
<th><?php echo $LANG["adminparam_MaximumFavorites"];?> <a>[0-99]</a></th>
	<th><input name="max_favorites" type="text" size="5" maxlength="2" value="<?php echo $max_favorites;?>"></th>
</tr>
<tr>
<th><?php echo $LANG["adminparam_MaximumSpyReport"];?> <a>[0-99]</a></th>
	<th><input name="max_favorites_spy" type="text" size="5" maxlength="2" value="<?php echo $max_favorites_spy;?>"></th>
</tr>
<tr>
<td class="c" colspan="2"><?php echo $LANG["adminparam_SessionsManagement"];?></td>
</tr>
<tr>
	<th><?php echo $LANG["adminparam_SessionDuration"];?> <a>[5-180 minutes]</a> <a>[0=<?php echo $LANG["adminparam_InfiniteSession"];?>&nbsp;<?php echo help("admin_session_infini");?>]</a></th>
	<th><input name="session_time" type="text" size="5" maxlength="3" value="<?php echo $session_time;?>"></th>
</tr>
<tr>
<td class="c" colspan="2"><?php echo $LANG["adminparam_AllianceProtection"];?></td>
</tr>
<tr>
<th width="60%"><?php echo $LANG["adminparam_HidenAllianceList"];?><br /><div class="z"><i><?php echo $LANG["adminparam_AddComaBetweenAlliance"];?></i></div></th>
	<th><input type="text" size="60" name="ally_protection" value="<?php echo $ally_protection;?>"></th>
</tr>
<tr>
	<th width="60%"><?php echo $LANG["adminparam_color_ally_hided"];?><br /><div class="z"><i><?php echo $LANG["adminparam_color_exemple"];?></i></div></th>
	<th><input type="text" size="6" maxlength="15" name="color_ally_hided" value="<?php echo $color_ally_hided;?>"></th>
</tr>
<tr>
<th width="60%"><?php echo $LANG["adminparam_FriendlyAllianceList"];?><br /><div class="z"><i><?php echo $LANG["adminparam_AddComaBetweenAlliance"];?></i></div></th>
	<th><input type="text" size="60" name="allied" value="<?php echo $allied;?>"></th>
</tr>
<tr>
	<th width="60%"><?php echo $LANG["adminparam_color_ally_friend"];?><br /><div class="z"><i><?php echo $LANG["adminparam_color_exemple"];?></i></div></th>
	<th><input type="text" size="6" maxlength="15" name="color_ally_friend" value="<?php echo $color_ally_friend;?>"></th>
</tr>
<tr>
<td class="c" colspan="2"><?php echo $LANG["adminparam_OtherParameters"];?></td>
</tr>
<tr>
<th width="60%"><?php echo $LANG["adminparam_AllyBoardLink"];?></th>
	<th><input type="text" size="60" name="url_forum" value="<?php echo $url_forum;?>"></th>
</tr>
<tr>
<th><?php echo $LANG["adminparam_LogSQLQuery"];?>&nbsp;<?php echo help("admin_save_transaction");?><br /><div class="z"><i><?php echo $LANG["adminparam_WarnPerformance"];?></i></div></th>
	<th><input name="debug_log" type="checkbox" value="1" <?php echo $debug_log;?>></th>
</tr>
<tr>
<td class="c" colspan="2"><?php echo $LANG["adminparam_Maintenance"];?></td>
</tr>
<tr>
<th width="60%"><?php echo $LANG["adminparam_KeepRankingDuration"];?></a></th>
<th><input type="text" name="max_keeprank" maxlength="4" size="5" value="<?php echo $max_keeprank;?>">&nbsp;<select name="keeprank_criterion"><option value="quantity" <?php echo $keeprank_criterion == "quantity" ? "selected" : "";?>><?php echo $LANG["adminparam_Number"];?></option><option value="day" <?php echo $keeprank_criterion == "day" ? "selected" : "";?>><?php echo $LANG["adminparam_Days"];?></option></th>
</tr>
<tr>
<th width="60%"><?php echo $LANG["adminparam_MaximumSpyReportByPlanets"];?></a></th>
	<th><input type="text" name="max_spyreport" maxlength="4" size="5" value="<?php echo $max_spyreport;?>"></th>
</tr>
<tr>
<th width="60%"><?php echo $LANG["adminparam_KeepSpyReportDuration"];?></a></th>
	<th><input type="text" name="max_keepspyreport" maxlength="4" size="5" value="<?php echo $max_keepspyreport;?>"></th>
</tr>
<tr>
<th width="60%"><?php echo $LANG["adminparam_KeepLogfileDuration"];?></th>
	<th><input name="max_keeplog" type="text" size="5" maxlength="3" value="<?php echo $max_keeplog;?>"></th>
</tr>
<tr>
	<td>&nbsp;</td>
</tr>
<tr>
<th colspan="2"><input type="submit" value="<?php echo $LANG["adminparam_Validate"];?>">&nbsp;<input type="reset" value="<?php echo $LANG["adminparam_Reset"];?>"></th>
</tr>
</form>
</table>
