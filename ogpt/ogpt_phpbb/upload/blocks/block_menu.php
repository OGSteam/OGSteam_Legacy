<?php
/*************************************************************************************
 *                            blocks_menus.php
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

 
if ( !defined('IN_PHPBB') )
{
	die("Hacking attempt");
}
$phpbb_root_path = './';

	global $db;

	$user->add_lang('portal/block_menu_lang');	
	$sql = "SELECT * FROM ". MENU_TABLE . " 
		WHERE menu_id  && menu_view != 0
		ORDER BY menu_order ASC "; 
	if (!$result1 = $db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, 'Could not query portal menus information', '', __LINE__, __FILE__, $sql);
	}

	$portal_menu = array();
	 
	while( $row1 = $db->sql_fetchrow($result1) )
	{
		$portal_menu[] = $row1;
	}	
	
	for ($i = 0; $i < count($portal_menu); $i++) 
	{ 	
		if(
		$portal_menu[$i]['menu_view'] == 1 ||
		$portal_menu[$i]['menu_view'] == 2 && $user->data['is_registered'] ||
		$portal_menu[$i]['menu_view'] == 3 && $user->data['user_rank'] == 2 ||
		$portal_menu[$i]['menu_view'] == 3 && $user->data['user_type'] == 3 ||
		$portal_menu[$i]['menu_view'] == 4 && $user->data['user_type'] == 3 )
		{
			$template->assign_block_vars('portal_menu_row', array(
				'PORTAL_MENU_NAME' => $portal_menu[$i]['menu_name'],
				'U_PORTAL_MENU_LINK' => $portal_menu[$i]['menu_url'], 				
				'PORTAL_MENU_ICON' => $portal_menu[$i]['menu_img'],
			));							
		}			
	}		
		if($user->data['user_type'] == 3) // admin only
		{
			$template->assign_vars(array(
				'U_ADMIN_LINK' => ($auth->acl_get('a_') && $user->data['is_registered']) ? append_sid("{$phpbb_root_path}adm/index.$phpEx", '', true, $user->session_id) : '',
				'ADMIN_MENU_ICON' => $portal_menu[0]['menu_img'],
			));
		}
?>