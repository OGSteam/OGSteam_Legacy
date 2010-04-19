<?php
/*************************************************************************************
 *                            block_online_friends.php
 *                            -------------------
 *   copyright            	: sjpphpbb 
 *   website              	: http://sjpphpbb.net/phpbb3/
 *   email                	: sjpphpbb@club-internet.fr
 *************************************************************************************/

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

$update_time = $config['load_online_time'] * 60;
$user->add_lang('portal/block_online_friends_lang');

	$sql = "SELECT config_value ,config_scroll, config_name
		FROM " . PORTAL_CONFIG_BLOCK_TABLE . "
		WHERE config_bloc_name = 'friends_online' ";
	
		if( $result = $db->sql_query($sql) )
		{
			$row = $db->sql_fetchrow($result);
			$config_name = $row['config_name'];			
			$scroll = $row['config_scroll'];
			$g_count = $row['config_value'];
		}			

$sql = $db->sql_build_query('SELECT_DISTINCT', array(
	'SELECT'	=> 'u.user_id, u.username , u.user_country_flag, u.user_colour, u.user_allow_viewonline, MAX(s.session_time) as online_time, MIN(s.session_viewonline) AS viewonline',
	'FROM'		=> array(
		USERS_TABLE		=> 'u',
		ZEBRA_TABLE		=> 'z'
	),

	'LEFT_JOIN'	=> array(
		array(
			'FROM'	=> array(SESSIONS_TABLE => 's'),
			'ON'	=> 's.session_user_id = z.zebra_id'
		)
	),

	'WHERE'		=> 'z.user_id = ' . $user->data['user_id'] . '
		AND z.friend = 1
		AND u.user_id = z.zebra_id',
	'GROUP_BY'	=> 'z.zebra_id, u.user_id, u.username, u.user_allow_viewonline, u.user_colour, u.user_country_flag',
	'ORDER_BY'	=> 'u.username_clean ASC',
));

$result = $db->sql_query_limit($sql, $g_count = $row['config_value']);

while ($row = $db->sql_fetchrow($result))
{
	$which = (time() - $update_time < $row['online_time'] && $row['viewonline'] && $row['user_allow_viewonline']) ? 'online' : 'offline';	
	
	$template->assign_block_vars("friends_{$which}", array(
		'USER_ID'		=> $row['user_id'],	$row['user_country_flag'],
		'USER_FLAG'		=> $row['user_country_flag'],	
		'U_PROFILE'		=> get_username_string('profile', $row['user_id'], $row['username'], $row['user_colour']),
		'USER_COLOUR'	=> get_username_string('colour', $row['user_id'], $row['username'], $row['user_colour']),
		'USERNAME'		=> get_username_string('username', $row['user_id'], $row['username'], $row['user_colour']),
		'USERNAME_FULL'	=> get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']))
	);
}

		$template->assign_vars(array(
			'BLOCK_TITRE'	=> $config_name
			)
		);

$db->sql_freeresult($result);
?>