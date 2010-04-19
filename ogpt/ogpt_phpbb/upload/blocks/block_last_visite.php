<?php
/*************************************************************************************
 *                            blocks_last_passage.php
 *                            -------------------
 *   copyright            	: sjpphpbb 
 *   website              	: http://sjpphpbb.net/phpbb3/
 *   email                	: sjpphpbb@club-internet.fr
 ************************************************************************************/

/************************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify it under 
 *   the terms of the GNU General Public License as published by the Free Software
 *   Foundation; either version 2 of the License, or any later version.
 *
 ************************************************************************************/


if (!defined('IN_PHPBB'))
{
	exit;
}

$user->session_begin();
$auth->acl($user->data);
$user->setup(array('memberlist', 'groups'));

$time = 60*60*48; 
$time_now = getdate();

$sql = "UPDATE `" . $table_prefix . "users`
		SET last24 = $time_now[0]
		WHERE user_id = $user_id";
		$result = $db->sql_query($sql);
		$db->sql_freeresult($result);	
		
$sql = "SELECT * FROM `" . $table_prefix . "users` 
		WHERE last24 >= ($time_now[0]-$time) AND user_id <> '-1'
		ORDER BY last24 DESC";
		$result = $db->sql_query($sql);
		$db->sql_freeresult($result);

	$retour = "<br/>";
	$last_visite = "";
		
	while ( ($row = $db->sql_fetchrow($result)))
	{
      if($row['user_type'] == 3)
	  { 	
		$last_connexion = date('d.m',$row['last24']);
		$last_connexion = $last_connexion . " à " . date('H:i:s',$row['last24']);
		$last_profil = append_sid("{$phpbb_root_path}memberlist.$phpEx", 'mode=viewprofile&amp;u=' . $row['user_id']);
		$flag = '&nbsp;<img src="images/flags/' . $row['user_country_flag'] . '.gif" width="14"  border="0" alt="' . $row['user_country_flag'] . '" title="' . $row['user_country_flag'] . '" />&nbsp;';	
        $last_visite .= "$flag<a href=memberlist.php?mode=viewprofile&u=$row[user_id] title='Dernière  connexion le $last_connexion'><font color='#$row[user_colour]'><span class='genmed2'><b>$row[username]</b></span></font></a>$retour";
	  }
      if($row['user_type'] == 0)
	  { 	
		$last_connexion = date('d.m',$row['last24']);
		$last_connexion = $last_connexion . " à " . date('H:i:s',$row['last24']);
		$flag = '&nbsp;<img src="images/flags/' . $row['user_country_flag'] . '.gif" width="14"  border="0" alt="' . $row['user_country_flag'] . '" title="' . $row['user_country_flag'] . '" />&nbsp;';	
        $last_visite .= "$flag<a href=memberlist.php?mode=viewprofile&u=$row[user_id] title='Dernière  connexion le $last_connexion'><font color='#$row[user_colour]'><span class='genmed2'><b>$row[username]</b></span></font></a>$retour";
	  }
      if($row['user_type'] == 2)
	  { 
        $last_visite .=""; 		  
	  }      
	}

$template->assign_vars(array(
	'S_CONFIG_ACTION' => append_sid("portal.$phpEx"),
	'AFFICHAGE' => $last_visite)
);

?>
