<?php

/***************************************************************************
*
* @package phpBB3
* @version $Id: recent topics ( Citation )
* @copyright (c) 2007 sjpphpbb http://sjpphpbb.net
*
****************************************************************************/
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

if ( !defined('IN_PHPBB') )
{
	die("Hacking attempt");
}

$phpbb_root_path = './';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
//portal_lang
$user->add_lang('portal/block_recent_topics_lang');
$user->session_begin(); //MOTU ?
$auth->acl($user->data); //MOTU ?

// URL PARAMETERS
define('POST_TOPIC_URL', 't');
define('POST_CAT_URL', 'c');
define('POST_FORUM_URL', 'f');
define('POST_USERS_URL', 'u');
define('POST_POST_URL', 'p');
define('POST_GROUPS_URL', 'g');


	global $user, $forum_id, $phpbb_root_path, $phpEx, $SID, $config , $template, $userdata, $config, $db, $phpEx;
	
	// get all forums //
	$sql = "SELECT * FROM ". FORUMS_TABLE . " ORDER BY forum_id";
	if (!$result1 = $db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, 'Could not query forums information', '', __LINE__, __FILE__, $sql);
	}
	
	$forum_count = 0;
	$forum_data = array();
	
	while( $row1 = $db->sql_fetchrow($result1) )
	{
		$forum_data[] = $row1;
		$forum_count++;
	}
	
	

		$sql = "SELECT config_value ,config_scroll, config_name, config_forum
		FROM " . PORTAL_CONFIG_BLOCK_TABLE . "
		WHERE config_bloc_name = 'recent_topic' ";
	
		if( $result = $db->sql_query($sql) )
		{
			$row = $db->sql_fetchrow($result);
			$config_name = $row['config_name'];
			$config_forum = $row['config_forum'];			
			$scroll_recent = $row['config_scroll'];
			$g_count_recent = $row['config_value'];
		}
		
	$except_forum_id = $config_forum ;
	for ($i = 0; $i < $forum_count; $i++)
	{
		
		if (!$auth->acl_gets('f_list', 'f_read', $forum_id))

		{
			$except_forum_id = $forum_data[$i]['forum_id'];
			$except_forum_id .= ' ';
		}
	}

	$sql = "SELECT t.topic_id, t.topic_title, t.topic_last_post_id, t.topic_views, t.topic_replies, t.forum_id, p.post_id, p.poster_id, p.post_time, u.user_id, u.username , user_country_flag , u.user_website , user_colour ,user_rank
		FROM " . TOPICS_TABLE . " AS t, " . POSTS_TABLE . " AS p, " . USERS_TABLE . " AS u
		WHERE t.forum_id NOT IN (" . $except_forum_id . ")
			AND t.topic_status <> 2
			AND p.post_id = t.topic_last_post_id
			AND p.poster_id = u.user_id
				ORDER BY p.post_id DESC
					LIMIT " . 20;
			
		if (!$result1 = $db->sql_query($sql))
		{
			message_die(GENERAL_ERROR, 'Could not query recent topics information', '', __LINE__, __FILE__, $sql);
		}
		
		$row_count = 0;
		$recent_topic_row = array();	
	
		while ($row1 = $db->sql_fetchrow($result1))
				
		{
			$recent_topic_row[] = $row1;
			$row_count ++;
		}

		($scroll_recent) ? $style_row_recent = 'config_scroll' : $style_row_recent = 'static';

		$template->assign_block_vars($style_row_recent,"");		

		// change topics to display count if there are less topics that set in ACP	
		if($g_count_recent > $row_count)
			$g_count_recent = $row_count;
			
		for ( $i = 0; $i < $g_count_recent; $i++ )
		{
			$orig_word = array();
			$replacement_word = array();
			obtain_word_list($orig_word, $replacement_word);			
			if ($recent_topic_row[$i]['user_id'] != -1)
			{		
			switch($recent_topic_row[$i]['user_rank'])
			{
			case 0: $poster_image_icon = 'user.png'; break;
			case 1:	$poster_image_icon = 'founder.png'; break;
			case 2: $poster_image_icon = 'mod.png'; break;
			}								
			
				$template->assign_block_vars($style_row_recent . '.recent_topic_row', array( 
					'U_TITLE' => append_sid("viewtopic.$phpEx?" . POST_POST_URL . '=' . $recent_topic_row[$i]['topic_last_post_id']) . '#p' .$recent_topic_row[$i]['topic_last_post_id'], 
					'L_TITLE' => smilies_pass($recent_topic_row[$i]['topic_title']), 
					'U_POSTER' => append_sid("memberlist.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=" . $recent_topic_row[$i]['user_id']), 
					'S_POSTER' => $recent_topic_row[$i]['username'],
					'TOTAL_VIEWS'	=> $recent_topic_row[$i]['topic_views'],
					'TOTAL_REPLIES'	=> $recent_topic_row[$i]['topic_replies'],					
					'FLAG' => $recent_topic_row[$i]['user_country_flag'],				
					'IMG_USER' 		=> $poster_image_icon,
					'S_COLOR'=> ($recent_topic_row[$i]['user_colour']),				
					'URL' 			=> $recent_topic_row[$i]['user_website'],
					'S_POSTTIME' => $user->format_date($recent_topic_row[$i]['post_time'])					
					) 
				); 
			} 
		}


		$template->assign_vars(array(
			'RECENT_TOPICS_TITRE' 	=> $config_name,
			'S_RECENT_TOPICS_COUNT_ASKED' 	=> $g_count_recent,
			'S_RECENT_TOPICS_COUNT_RETURNED' => $row_count,
			)
		);
?>