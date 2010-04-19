<?php
/***************************************************************************
*
* $Id:block_user_information.php,v 1.146 03-2007 sjpphpbb Exp $
*
* FILENAME  : block_user_informationphp
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

$phpbb_root_path = './';


// Start session management
$user->session_begin();
$auth->acl($user->data);
$user->setup(array('memberlist', 'groups'));

global $db, $config, $user, $user_id, $avatar_img;
$user->add_lang('portal/block_user_information_lang');
$user_id = $user->data['user_id'];

$sql = "SELECT user_style, user_avatar, user_avatar_type, user_country_flag, user_colour FROM " . USERS_TABLE . " WHERE user_id = $user_id";	
if( $result = $db->sql_query($sql) )
{
	$row = $db->sql_fetchrow($result);
	$user_avatar = $row['user_avatar'];
	$user_country_flag	= $row['user_country_flag'];
	$user_style = $row['user_style'];
}
	$template->assign_vars(array(

		'AVATAR_IMAGE'       => get_user_avatar($user->data['user_avatar'], $user->data['user_avatar_type'], $user->data['user_avatar_width'], $user->data['user_avatar_height']),
		'USER_NAME'          => $user->data['username'],
		'USERNAME_FULL'	     => get_username_string('full', $user->data['user_id'], $user->data['username'], $user->data['user_colour']),
		'USER_FLAG'			=> $user->data['user_country_flag'],
		'USER_COLOR'		=> $user->data['user_colour'],		
		'READ_ARTICLE_IMG'	 => $user->img('btn_read_article', 'READ_ARTICLE'),	
		'POST_COMMENTS_IMG'	 => $user->img('btn_post_comments', 'POST_COMMENTS'),
		'VIEW_COMMENTS_IMG'	 => $user->img('btn_view_comments', 'VIEW_COMMENTS'),
		'U_INDEX'	         => "{$phpbb_root_path}index.$phpEx$SID",
		'U_PORTAL' 	         => "{$phpbb_root_path}portal.$phpEx$SID",
		'S_LOGIN_ACTION'	 => append_sid("{$phpbb_root_path}ucp.$phpEx", 'mode=login'),		
		'U_STAFF'	         => append_sid("{$phpbb_root_path}memberlist.$phpEx", '?mode=leaders'),
		'U_SEARCH_BOOKMARKS' => append_sid("{$phpbb_root_path}ucp.$phpEx", '&amp;i=main&mode=bookmarks'),
		)
	);		

if($user->data['username'] == 'Anonymous' )	
	$style = $config['default_style'];


$db->sql_freeresult($result);	
?>