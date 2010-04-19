<?php
/*************************************************************************************
 *                            blocks_birthday.php
 *                            -------------------
 *   copyright            	: sjpphpbb 
 *   website              	: http://sjpphpbb.net/phpbb3/
 *   email                	: sjpphpbb@club-internet.fr
 ************************************************************************************/
/***************************************************************************
*   issued from kiss portal : (C) 2005 Michael O'Toole - aka Michaelo < o2l@eircom.net >
*   website              : http://www.phpbbireland.com
***************************************************************************/
/************************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify it under 
 *   the terms of the GNU General Public License as published by the Free Software
 *   Foundation; either version 2 of the License, or any later version.
 *
 ************************************************************************************/

 
if ( !defined('IN_PHPBB') )
{
	die("Hacking attempt");
}
$phpbb_root_path = './';

	global $db;

	$user->add_lang('portal/block_birthday_lang');
	// Generate birthday list if required ...
	$birthday_list = '';
	if ($config['load_birthdays'])
		{
		$now = getdate(time() + $user->timezone + $user->dst - date('Z'));
		$sql = 'SELECT user_id, username, user_colour, user_birthday,user_country_flag
			FROM ' . USERS_TABLE . "
			WHERE user_birthday LIKE '" . $db->sql_escape(sprintf('%2d-%2d-', $now['mday'], $now['mon'])) . "%'
			AND user_type IN (" . USER_NORMAL . ', ' . USER_FOUNDER . ')';
		$result = $db->sql_query($sql);

	while ($row = $db->sql_fetchrow($result))
		{
		$flag = '<img src="images/flags/' . $row['user_country_flag'] . '.gif" width="14"  border="0" alt="' . $row['user_country_flag'] . '" title="' . $row['user_country_flag'] . '" /> ' . $row['username'];	
		$user_colour = ($row['user_colour']) ? ' style="color:#' . $row['user_colour'] .'"' : '';
		$birthday_list .= (($birthday_list != '') ? ', ' : '')  . '<a' . $user_colour . ' href="' . append_sid("{$phpbb_root_path}memberlist.$phpEx", 'mode=viewprofile&amp;u=' . $row['user_id']) . '">' . $flag . '</a>';

		if ($age = (int) substr($row['user_birthday'], -4))
		{
			$birthday_list .= ' (' . ($now['year'] - $age) . ')';
		}
	}
	$db->sql_freeresult($result);
}
			$template->assign_vars(array(
			'BIRTHDAY_LIST'	=> $birthday_list)
    		);	

?>