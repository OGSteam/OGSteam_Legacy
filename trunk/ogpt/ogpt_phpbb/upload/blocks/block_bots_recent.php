<?php

/***************************************************************************
 *                            block_bots_recent.php
 *                            -------------------
 *   begin                : 03-2007
 *   copyright            : (C) 2007 sjpphpbb
 *   website              : http://sjpphpbb.net/phpbb3/
 *   email                : sjpphpbb@club-internet.fr
 *
 ***************************************************************************/
/***************************************************************************
*   issued from kiss portal : (C) 2005 Michael O'Toole - aka Michaelo < o2l@eircom.net >
*   website              : http://www.phpbbireland.com
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

		$show_bots_recent = TRUE;
		$sql = "SELECT config_value ,config_scroll, config_name
			FROM " . PORTAL_CONFIG_BLOCK_TABLE . "
			WHERE config_bloc_name = 'bot' ";
	
		if( $result = $db->sql_query($sql) )
		{
			$row = $db->sql_fetchrow($result);
			$config_name = $row['config_name'];			
			$scroll_bot = $row['config_scroll'];
			$g_count = $row['config_value'];
		}
		
		
	$sql = 'SELECT username, user_colour, user_lastvisit, user_country_flag
		FROM ' . USERS_TABLE . '
		WHERE user_type = ' . USER_IGNORE . ' 
		ORDER BY user_lastvisit DESC';
		$result = $db->sql_query_limit($sql, $g_count = $row['config_value']);		

	while ($row = $db->sql_fetchrow($result))
	{
		$template->assign_block_vars('bots_recent', array(
			'BOT_FLAGS'		=> $row['user_country_flag'],		
			'BOT_NAME'	=> get_username_string('full', '', $row['username'], $row['user_colour']),
			'BOTS_RECENT_VISIT_DATE' => $user->format_date($row['user_lastvisit'], 'd.m.Y, H:i'),
	));
	
		$template->assign_vars(array(
			'RECENT_LAST_BOT_TITRE' => $config_name
			)
		);		
	}
			
		$db->sql_freeresult($result);		

?>