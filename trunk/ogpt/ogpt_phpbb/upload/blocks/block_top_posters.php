<?php
/***************************************************************************
*
* $Id:block_user_information.php,v 1.146 03-2007 sjpphpbb Exp $
*
* FILENAME  : block_top_posters.php
* STARTED   : 03-2007
* COPYRIGHT : © 2007 sjpphpbb 
* WWW       : http://sjpphpbb.net/phpbb3
* LICENCE   : GPL vs2.0 [ see /docs/COPYING ]
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

		$user->add_lang('portal/block_top_posters_lang');

		$user->add_lang('portal/block_latest_members_lang');
		$sql = "SELECT config_value ,config_scroll, config_name
			FROM " . PORTAL_CONFIG_BLOCK_TABLE . "
			WHERE config_bloc_name = 'recent_poster' ";
	
		if( $result = $db->sql_query($sql) )
		{
			$row = $db->sql_fetchrow($result);
			$config_name = $row['config_name'];			
			$scroll = $row['config_scroll'];
			$g_count = $row['config_value'];
		}
		
		$sql = 'SELECT user_id, username, user_posts, user_colour, user_type , user_country_flag , user_website , user_rank
			FROM ' . USERS_TABLE . '
			WHERE user_type <> 2
			AND user_posts <> 0
			ORDER BY user_posts DESC';

			$result = $db->sql_query_limit($sql, $g_count = $row['config_value']);

while( ($row = $db->sql_fetchrow($result)) && ($row['username'] != '') )
{
	switch($row['user_rank'])
	{
		case 0: $poster_image_icon = 'user.png'; break;
		case 1:	$poster_image_icon = 'founder.png'; break;
		case 2: $poster_image_icon = 'mod.png'; break;
	}
		$url = ( $row['user_id'] ) ? '<a href=' . $row['user_website'] . '" target="_blanck">' . $row['user_website'] . '</a>' : '';	
	
	$template->assign_block_vars('top_posters', array(
		'S_SEARCH_ACTION'=> append_sid("{$phpbb_root_path}search.$phpEx", 'author_id=' . $row['user_id'] . '&amp;sr=posts'),
		'USERNAME'		=> censor_text($row['username']),
		'USER_FLAG'		=> censor_text($row['user_country_flag']),
		'USERNAME_COLOR'=> $row['user_colour'],
		'U_USERNAME'	=> append_sid("{$phpbb_root_path}memberlist.$phpEx", 'mode=viewprofile&amp;u=' . $row['user_id']),
		'POSTER_POSTS'	=> $row['user_posts'],
		'URL' 			=> $row['user_website'],
		'IMG_USER' 		=> $poster_image_icon,
		)
	);
		$template->assign_vars(array(
			'RECENT_POSTER_TITRE' => $config_name
			)
		);		
}
$db->sql_freeresult($result);
?>