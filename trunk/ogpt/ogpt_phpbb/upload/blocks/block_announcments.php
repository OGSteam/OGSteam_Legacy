<?php
/***************************************************************************
*
* @package phpBB3
* @version $Id: block_announcments
* @copyright (c) 2007 sjpphppbb.net
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

	$user->add_lang('portal/block_announcments_lang');			
		
		$sql = 'SELECT  user_rank
			FROM ' . USERS_TABLE . '
			WHERE user_id';
		if( $result = $db->sql_query($sql) )			

		$sql = 'SELECT *
			FROM ' . PORTAL_ANNOUNCMENTS_TABLE . '
			WHERE 1';
		$results = $db->sql_query($sql);

		$row = $db->sql_fetchrow($results);
		{
				$announcments_number = $row['announcments_number'];
				$announcments_day = $row['announcments_day'];
				$announcments_length = $row['announcments_length'];
				$announcments_forum = $row['announcments_forum'];		
		}
				error_reporting(E_ERROR | E_WARNING | E_PARSE);	
		{
			
		$fetch_announcments = phpbb_fetch_posts($announcments_forum, $announcments_number, $announcments_length, $announcments_day, 'announcments');

	for ($i = 0; $i < count($fetch_announcments); $i++)
		{
		
		switch($fetch_announcments[$i]['user_rank'])
		{
			case 0: $poster_image_icon = 'user.png'; break;
			case 1:	$poster_image_icon = 'founder.png'; break;
			case 2: $poster_image_icon = 'mod.png'; break;
		}		
								
		$a_fid = (intval($fetch_announcments[$i]['forum_id']));
		$template->assign_block_vars('announcments_row', array(
			'ATTACH_ICON_IMG'	=> ($fetch_announcments[$i]['attachment']) ? $user->img('icon_attach', $user->lang['TOTAL_ATTACHMENTS']) : '',
			'TITLE'				=>  smilies_pass($fetch_announcments[$i]['topic_title']),				
            'POSTER'			=> $fetch_announcments[$i]['username'],
            'FLAGS'				=> $fetch_announcments[$i]['user_country_flag'],
			'IMG_USER' 			=> $poster_image_icon,			
			'U_USER_PROFILE'	=> (($fetch_announcments[$i]['user_type'] == USER_NORMAL || $fetch_announcments[$i]['user_type'] == USER_FOUNDER) && $fetch_announcments[$i]['user_id'] != ANONYMOUS) ? append_sid("{$phpbb_root_path}memberlist.$phpEx", 'mode=viewprofile&amp;u=' . $fetch_announcments[$i]['user_id']) : '',
      		'TIME'				=> $fetch_announcments[$i]['topic_time'],
            'TEXT'				=> $fetch_announcments[$i]['post_text'],
            'REPLIES'			=> $fetch_announcments[$i]['topic_replies'],
            'U_VIEW_COMMENTS'	=> append_sid($phpbb_root_path . 'viewtopic.' . $phpEx . '?t=' . $fetch_announcments[$i]['topic_id'] . '&amp;f=' . $a_fid),
            'U_POST_COMMENT'	=> append_sid($phpbb_root_path . 'posting.' . $phpEx . '?mode=reply&amp;t=' . $fetch_announcments[$i]['topic_id'] . '&amp;f=' . $a_fid),
            'S_NOT_LAST'		=> ($i < count($fetch_announcments) - 1) ? true : false,
			'S_POLL'			=> $fetch_announcments[$i]['poll'],
			'MINI_POST_IMG'		=> $user->img('icon_post_target', 'POST'),
			)
		);
		}

	// Assign specific vars
	$template->assign_vars(array(
		'S_DISPLAY_ANNOUNCMENTS_LIST'=> (count($fetch_announcments) == 0 || isset($HTTP_GET_VARS['article'])) ? false : true)
	);
}

?>