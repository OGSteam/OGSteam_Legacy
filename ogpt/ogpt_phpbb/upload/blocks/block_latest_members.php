<?php
/***************************************************************************
*
* @name block_latest_members.php
* @package phpBB3 Portal
* @copyright (c) sjpphpbb
* @license http://opensource.org/licenses/gpl-license.php GNU Public License 
*
 ***************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/

if (!defined('IN_PHPBB'))
{
	exit;
}
		$user->add_lang('portal/block_latest_members_lang');
		$sql = "SELECT config_value ,config_scroll, config_name
			FROM " . PORTAL_CONFIG_BLOCK_TABLE . "
			WHERE config_bloc_name = 'recent_reg' ";
	
		if( $result = $db->sql_query($sql) )
		{
			$row = $db->sql_fetchrow($result);
			$config_name = $row['config_name'];			
			$scroll = $row['config_scroll'];
			$g_count = $row['config_value'];
		}

		$sql = 'SELECT user_id, username, user_regdate, user_colour, user_country_flag
			FROM ' . USERS_TABLE . '
			WHERE user_type <> 2
			AND user_inactive_time = 0
			ORDER BY user_regdate DESC';
	
		$result = $db->sql_query_limit($sql, $g_count = $row['config_value']);

		while( ($row = $db->sql_fetchrow($result)) && ($row['username'] != '') )
			{
		$template->assign_block_vars('latest_members', array(	
			'USERNAME'		=> censor_text($row['username']),
			'USER_FLAG'		=> censor_text($row['user_country_flag']),		
			'USERNAME_COLOR'=> ($row['user_colour']) ? ' style="color:#'. $row['user_colour'] .'"' : '',
			
			'USERNAME_COLOR'=> $row['user_colour'],			
			
			'U_USERNAME'	=> append_sid("{$phpbb_root_path}memberlist.$phpEx", 'mode=viewprofile&amp;u=' . $row['user_id']),
			'JOINED'		=> $user->format_date($row['user_regdate'], $format = 'd M Y'),
		)
	);
		$template->assign_vars(array(
			'RECENT_LAST_MEMBERS_TITRE' => $config_name
			)
		);
		
}
$db->sql_freeresult($result);

?>