<?php
/***************************************************************************
*
* @package phpBB3
* @version $Id: block_news
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

// news
//$CFG['news']			= true;  // Show news?  true = show    false = no show

if (!defined('IN_PHPBB'))
{
	exit;
}

		$sql = 'SELECT *
			FROM ' . PORTAL_NEWS_TABLE . '
			WHERE 1';
		$results = $db->sql_query($sql);

		$row = $db->sql_fetchrow($results);
		{
				$news_number = $row['news_number'];
				$news_day = $row['news_day'];
				$news_length = $row['news_length'];
				$news_forum = $row['news_forum'];
				$news_title_block = $row['news_title_block'];				
		}
				error_reporting(E_ERROR | E_WARNING | E_PARSE);	
		{
		
		while ( $row = $db->sql_fetchrow( $results ) );
}
if( (!isset($HTTP_GET_VARS['article'])) )
{
	$fetch_news  = phpbb_fetch_posts($news_forum, $news_number, $news_length, $news_day, $news_title_block, 'news');
	
	if (count($fetch_news) == 0)
	{
		$template->assign_block_vars('news_row', array(
			'S_NO_TOPICS'	=> true,
			'S_NOT_LAST'	=> false
			)
        );
	}
	else
	{
		for ($i = 0; $i < count($fetch_news); $i++)
		{
	      	if( isset($fetch_news[$i]['striped']) && $fetch_news[$i]['striped'] == true )
	      	{
				$open_bracket = '[ ';
				$close_bracket = ' ]';
				$read_full = $user->lang['READ_FULL'];
			}
			else
			{
	      	      $open_bracket = '';
	      	      $close_bracket = '';
	      	      $read_full = '';
			}
			
		switch($fetch_news[$i]['user_rank'])
		{
			case 0: $poster_image_icon = 'user.png'; break;
			case 1:	$poster_image_icon = 'founder.png'; break;
			case 2: $poster_image_icon = 'mod.png'; break;
		}	
			
			$template->assign_block_vars('news_row', array(
				'ATTACH_ICON_IMG'	=> ($fetch_news[$i]['attachment']) ? $user->img('icon_attach', $user->lang['TOTAL_ATTACHMENTS']) : '',
				'TITLE'				=>  smilies_pass($fetch_news[$i]['topic_title']),				
				'POSTER'			=> $fetch_news[$i]['username'],
				'FLAGS'				=> $fetch_news[$i]['user_country_flag'],
				'IMG_USER' 			=> $poster_image_icon,				
				'U_USER_PROFILE'	=> (($fetch_news[$i]['user_type'] == USER_NORMAL || $fetch_news[$i]['user_type'] == USER_FOUNDER) && $fetch_news[$i]['user_id'] != ANONYMOUS) ? append_sid("{$phpbb_root_path}memberlist.$phpEx", 'mode=viewprofile&amp;u=' . $fetch_news[$i]['user_id']) : '',
				'TIME'				=> $fetch_news[$i]['topic_time'],
				'TEXT'				=> $fetch_news[$i]['post_text'],
				'REPLIES'			=> $fetch_news[$i]['topic_replies'],
				'U_VIEW_COMMENTS'	=> append_sid($phpbb_root_path . 'viewtopic.' . $phpEx . '?t=' . $fetch_news[$i]['topic_id'] . '&amp;f=' . $fetch_news[$i]['forum_id']),
				'U_POST_COMMENT'	=> append_sid($phpbb_root_path . 'posting.' . $phpEx . '?mode=reply&amp;t=' . $fetch_news[$i]['topic_id'] . '&amp;f=' . $fetch_news[$i]['forum_id']),
				'U_READ_FULL'		=> append_sid($_SERVER['PHP_SELF'] . '?article=' . $i),
				'L_READ_FULL'		=> $read_full,
				'OPEN'				=> $open_bracket,
				'CLOSE'				=> $close_bracket,
				'S_NOT_LAST'		=> ($i < count($fetch_news) - 1) ? true : false,
				'S_POLL'			=> $fetch_news[$i]['poll'],
				'MINI_POST_IMG'		=> $user->img('icon_post_target', 'POST'),
				)
        	);
		}
	}

	$template->assign_vars(array(
		'TITLE_BLOCK'			=> $news_title_block		
		)
	);		

}
else if ( (!isset($HTTP_GET_VARS['article'])) )
{
	$fetch_news  = phpbb_fetch_posts($news_forum, $news_number, $news_length, $news_day, $news_title_block, 'news');

	$i = intval($HTTP_GET_VARS['article']);

	$template->assign_block_vars('news_row', array(
		'ATTACH_ICON_IMG'	=> ($fetch_news[$i]['attachment']) ? $user->img('icon_attach', $user->lang['TOTAL_ATTACHMENTS']) : '',
		'TITLE'				=> $fetch_news[$i]['topic_title'],
		'POSTER'			=> $fetch_news[$i]['username'],
		'TIME'				=> $fetch_news[$i]['topic_time'],
		'TEXT'				=> $fetch_news[$i]['post_text'],
		'REPLIES'			=> $fetch_news[$i]['topic_replies'],
		'U_VIEW_COMMENTS'	=> append_sid($phpbb_root_path . 'viewtopic.' . $phpEx . '?t=' . $fetch_news[$i]['topic_id']),
		'U_POST_COMMENT'	=> append_sid($phpbb_root_path . 'posting.' . $phpEx . '?mode=reply&amp;t=' . $fetch_news[$i]['topic_id'] . '&amp;f=' . $fetch_news[$i]['forum_id']),
		'S_POLL'			=> $fetch_news[$i]['poll']
		)
	);		
}

?>