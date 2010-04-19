<?php
/*************************************************************************************
 *                            blocks_whos_on_line.php
 *                            -------------------
 *   copyright            	: sjpphpbb 
 *   website              	: http://sjpphpbb.net/phpbb3/
 *   email                	: sjpphpbb@club-internet.fr
 *************************************************************************************
 
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
	$total_files	= $config['num_files'];
	$total_attachments  = $config['num_files'];
	$user->add_lang('portal/block_whos_on_line_lang');
	
function get_db_stat($mode)
{	
	global $db, $user;
	switch( $mode )
	{
		case 'newposttotal':
			$sql = "SELECT COUNT(post_id) AS newpost_total
				FROM " . POSTS_TABLE . "
				WHERE post_time > " . $user->data['session_last_visit'];
			break;

		case 'newtopictotal':
			$sql = "SELECT COUNT(distinct p.post_id) AS newtopic_total
				FROM " . POSTS_TABLE . " p, " . TOPICS_TABLE . " t
				WHERE p.post_time > " . $user->data['session_last_visit'] . "
				AND p.post_id = t.topic_first_post_id";
			break;
	}
	
	if ( !($result = $db->sql_query($sql)) )
	{
		return false;
	}
	$row = $db->sql_fetchrow($result);
 
	switch ( $mode )
	{
		case 'newposttotal':
			return $row['newpost_total'];
			break;

		case 'newtopictotal':
			return $row['newtopic_total'];
			break;
	}
	return false;
}			
	
		$sql = 'SELECT COUNT(user_id) AS num_posters
			FROM ' . USERS_TABLE . "
			WHERE user_posts > 0
			AND user_type IN (" . USER_NORMAL . ', ' . USER_FOUNDER . ')';
				$result = $db->sql_query($sql);
				$posters_count = (int) $db->sql_fetchfield('num_posters');
				$db->sql_freeresult($result);

				$total_posters  = $posters_count;
				display_forums('', $config['load_moderators']);
				$total_posts	= $config['num_posts'];				
				$total_topics	= $config['num_topics'];
				$total_users	= $config['num_users'];
				$newest_user	= $config['newest_username'];
				$newest_uid		= $config['newest_user_id'];
				$l_total_user_s = ($total_users == 0) ? 'TOTAL_USERS_ZERO' : 'TOTAL_USERS_OTHER';
				$l_total_post_s = ($total_posts == 0) ? 'TOTAL_POSTS_ZERO' : 'TOTAL_POSTS_OTHER';
				$l_total_topic_s = ($total_topics == 0) ? 'TOTAL_TOPICS_ZERO' : 'TOTAL_TOPICS_OTHER';
				$l_total_poster_s = ($total_posters == 0) ? 'TOTAL_POSTERS_ZERO' : 'TOTAL_POSTERS_OTHER';
				$l_total_file_s		= ($total_files == 0) ? 'TOTAL_FILES_ZERO' : 'TOTAL_FILES_OTHER';
				$boarddays = (time() - $config['board_startdate']) / 86400;
				$users_per_day		= sprintf('%.2f', $total_users / $boarddays);
				$topics_per_day		= sprintf('%.2f', $total_topics / $boarddays);
				$posts_per_day		= sprintf('%.2f', $total_posts / $boarddays);
				$files_per_day		= sprintf('%.2f', $total_files / $boarddays);
				$topics_per_user	= sprintf('%.2f', $total_topics / $total_users);
				$posts_per_user		= sprintf('%.2f', $total_posts / $total_users);
				$files_per_user		= sprintf('%.2f', $total_files / $total_users);
				$posts_per_topic	= sprintf('%.2f', $total_posts / $total_topics);
				$files_per_topic	= sprintf('%.2f', $total_files / $total_topics);
				$files_per_post		= sprintf('%.2f', $total_files / $total_posts);
				$l_total_attachment_s = ($total_attachments == 0) ? 'TOTAL_ATTACHMENTS_ZERO' : 'TOTAL_ATTACHMENTS_OTHER';
				if ($users_per_day > $total_users)
				{$users_per_day = $total_users;}
				if ($topics_per_day > $total_topics)
				{$topics_per_day = $total_topics;}
				if ($posts_per_day > $total_posts)
				{$posts_per_day = $total_posts;}
				if ($files_per_day > $total_files)
				{$files_per_day = $total_files;}
				if ($topics_per_user > $total_topics)
				{$topics_per_user = $total_topics;}
				if ($posts_per_user > $total_posts)
				{$posts_per_user = $total_posts;}
				if ($files_per_user > $total_files)
				{$files_per_user = $total_files;}
				if ($posts_per_topic > $total_posts)
				{$posts_per_topic = $total_posts;}
				if ($files_per_topic > $total_files)
				{$files_per_topic = $total_files;}
				if ($files_per_post > $total_files)
				{$files_per_post = $total_files;}
				
// Grab group details for legend display
		$sql = 'SELECT group_id, group_name, group_colour, group_type
				FROM ' . GROUPS_TABLE . '
				WHERE group_legend = 1
				AND group_type <> ' . GROUP_HIDDEN . '
				ORDER BY group_name ASC';
				$result = $db->sql_query($sql);

				$legend = '';
		while ($row = $db->sql_fetchrow($result))
		{
		if ($row['group_name'] == 'BOTS')
		{
		$legend .= (($legend != '') ? ', ' : '') . '<span style="color:#' . $row['group_colour'] . '">' . $user->lang['G_BOTS'] . '</span>';
		}
	else
		{
		$legend .= (($legend != '') ? ', ' : '') . '<a style="color:#' . $row['group_colour'] . '" href="' . append_sid("{$phpbb_root_path}memberlist.$phpEx", 'mode=group&amp;g=' . $row['group_id']) . '">' . (($row['group_type'] == GROUP_SPECIAL) ? $user->lang['G_' . $row['group_name']] : $row['group_name']) . '</a>';
		}
		}
		$db->sql_freeresult($result);
		
// Assign index specific vars
	$template->assign_vars(array(
		'TOTAL_POSTS'		=> sprintf($user->lang[$l_total_post_s], $total_posts),
		'TOTAL_TOPICS'		=> sprintf($user->lang[$l_total_topic_s], $total_topics),
		'TOTAL_USERS'		=> sprintf($user->lang[$l_total_user_s], $total_users),
		'TOTAL_POSTERS'		=> sprintf($user->lang[$l_total_poster_s], $total_posters),
		'TOTAL_FILES'		=> sprintf($user->lang[$l_total_file_s], $total_files),
		'TOTAL_ATTACHMENTS'	=> sprintf($user->lang[$l_total_attachment_s], $total_attachments),
		'USERS_PER_DAY'		=> $users_per_day,
		'TOPICS_PER_DAY'	=> $topics_per_day,
		'POSTS_PER_DAY'		=> $posts_per_day,
		'FILES_PER_DAY'		=> $files_per_day,
		'TOPICS_PER_USER'	=> $topics_per_user,	
		'POSTS_PER_USER'	=> $posts_per_user,
		'FILES_PER_USER'	=> $files_per_user,
		'POSTS_PER_TOPIC'	=> $posts_per_topic,
		'FILES_PER_TOPIC'	=> $files_per_topic,
		'FILES_PER_POST'	=> $files_per_post,
		'S_NEW_POSTS'	=> get_db_stat('newposttotal'),
		'S_NEW_TOPIC'	=> get_db_stat('newtopictotal'),		
		'NEWEST_USER'	=> sprintf($user->lang['NEWEST_USER'], get_username_string('full', $config['newest_user_id'], $config['newest_username'], $config['newest_user_colour'])),		
		'LEGEND'		=> $legend)
);

?>